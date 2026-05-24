<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandRecord;
use App\Models\PropertyTax;
use App\Models\Payment;
use App\Models\LandTransferRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

class CitizenController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Fetch real data counts
        $properties_count = LandRecord::where('owner_id', $user->id)->count();
        $pending_tax = PropertyTax::whereHas('landRecord', function($query) use ($user) {
            $query->where('owner_id', $user->id);
        })->where('status', 'pending')->sum('total_amount');
        
        $next_due_date = PropertyTax::whereHas('landRecord', function($query) use ($user) {
            $query->where('owner_id', $user->id);
        })->where('status', 'pending')->orderBy('due_date', 'asc')->value('due_date');

        // Dummy recent activities for now
        $recent_activities = []; 

        return Inertia::render('Citizen/Dashboard', [
            'properties_count' => $properties_count,
            'pending_tax' => $pending_tax,
            'next_due_date' => $next_due_date,
            'recent_activities' => $recent_activities
        ]);
    }

    public function landRecords(Request $request)
    {
        $user = Auth::user();
        $query = LandRecord::where('owner_id', $user->id)->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('record_number', 'like', '%' . $search . '%')
                  ->orWhere('plot_number', 'like', '%' . $search . '%')
                  ->orWhere('survey_number', 'like', '%' . $search . '%');
            });
        }

        $records = $query->paginate(10)->withQueryString();

        return Inertia::render('Citizen/LandRecords/Index', [
            'records' => $records,
            'filters' => $request->only('search')
        ]);
    }

    public function showLandRecord($id)
    {
        $user = Auth::user();
        $record = LandRecord::where('owner_id', $user->id)->with('propertyTaxes')->findOrFail($id);
        $latest_tax = $record->propertyTaxes()->latest()->first();
        $pending_transfer = LandTransferRequest::where('land_record_id', $record->id)
                                ->where('status', 'pending')
                                ->first();
        
        return Inertia::render('Citizen/LandRecords/Show', [
            'record' => $record,
            'latest_tax' => $latest_tax,
            'pending_transfer' => $pending_transfer
        ]);
    }

    public function showTaxPayment($id)
    {
        $user = Auth::user();
        $tax = PropertyTax::whereHas('landRecord', function($q) use ($user) {
            $q->where('owner_id', $user->id);
        })->findOrFail($id);

        $payments = Payment::where('property_tax_id', $tax->id)->latest()->get();

        return Inertia::render('Citizen/Tax/Payment', [
            'tax' => $tax,
            'payments' => $payments
        ]);
    }

    public function processTaxPayment(Request $request, $id)
    {
        $user = Auth::user();
        $tax = PropertyTax::whereHas('landRecord', function($q) use ($user) {
            $q->where('owner_id', $user->id);
        })->findOrFail($id);

        if ($tax->status === 'paid') {
            return redirect()->back()->with('error', 'Tax is already paid.');
        }

        // Dummy processing logic
        $payment = Payment::create([
            'property_tax_id' => $tax->id,
            'citizen_id' => $user->id,
            'amount_paid' => $tax->total_amount,
            'payment_method' => 'online',
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'payment_date' => now(),
            'receipt_number' => 'RCPT-' . strtoupper(uniqid()),
            'status' => 'success',
        ]);

        $tax->update(['status' => 'paid']);

        return redirect()->route('citizen.tax.receipt', $payment->id)->with('success', 'Payment successful.');
    }

    public function downloadReceipt($id)
    {
        $user = Auth::user();
        $payment = Payment::where('citizen_id', $user->id)->findOrFail($id);
        
        return Inertia::render('Citizen/Tax/Receipt', [
            'payment' => $payment
        ]);
    }

    public function payments()
    {
        $user = Auth::user();
        $payments = Payment::where('citizen_id', $user->id)
            ->with('propertyTax.landRecord')
            ->latest()
            ->get();
            
        return Inertia::render('Citizen/Payments', [
            'payments' => $payments
        ]);
    }

    public function createTransferRequest($id)
    {
        $user = Auth::user();
        $record = LandRecord::where('owner_id', $user->id)->findOrFail($id);
        
        if ($record->propertyTaxes()->where('status', 'pending')->exists()) {
            return redirect()->route('citizen.land-records.show', $id)
                ->with('error', 'You must pay all pending taxes before transferring this property.');
        }

        return Inertia::render('Citizen/LandRecords/Transfer', [
            'record' => $record
        ]);
    }


    public function storeTransferRequest(Request $request, $id)
    {
        $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_cnic' => 'required|string|max:20',
            'buyer_email' => 'required|email|max:255',
            'transfer_reason' => 'required|string',
            'transfer_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $user = Auth::user();
        $record = LandRecord::where('owner_id', $user->id)->findOrFail($id);

        if ($record->propertyTaxes()->where('status', 'pending')->exists()) {
            return redirect()->route('citizen.land-records.show', $id)
                ->with('error', 'You must pay all pending taxes before transferring this property.');
        }

        // Find or create a dummy user for the transferee so the foreign key constraint passes
        $transferee = User::firstOrCreate(
            ['email' => $request->buyer_email],
            [
                'name' => $request->buyer_name,
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'citizen',
                'phone' => '0000000000',
                'address' => 'Pending Address'
            ]
        );

        $documentPath = $request->file('transfer_document')->store('transfers', 'public');

        LandTransferRequest::create([
            'land_record_id' => $record->id,
            'from_owner_id' => $user->id,
            'to_owner_id' => $transferee->id,
            'status' => 'pending',
            'remarks' => $request->transfer_reason . ' (CNIC: ' . $request->buyer_cnic . ')',
            'document_path' => $documentPath,
        ]);

        return redirect()->route('citizen.land-records.show', $record->id)
            ->with('success', 'Land transfer application submitted successfully.');
    }
}
