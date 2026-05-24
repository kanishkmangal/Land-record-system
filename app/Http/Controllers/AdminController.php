<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LandRecord;
use App\Models\PropertyTax;
use App\Models\Payment;
use App\Models\LandTransferRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total_users = User::where('role', 'citizen')->count();
        $total_land_records = LandRecord::count();
        $total_tax_collected = Payment::where('status', 'success')->sum('amount_paid');
        $pending_taxes_count = PropertyTax::where('status', 'pending')->count();

        // Recent transactions
        $recent_payments = Payment::with(['citizen', 'propertyTax.landRecord'])
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'total_users' => $total_users,
            'total_land_records' => $total_land_records,
            'total_tax_collected' => $total_tax_collected,
            'pending_taxes_count' => $pending_taxes_count,
            'recent_payments' => $recent_payments
        ]);
    }

    public function indexLandRecords(Request $request)
    {
        $query = LandRecord::with('owner')->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('record_number', 'like', '%' . $search . '%')
                  ->orWhere('plot_number', 'like', '%' . $search . '%')
                  ->orWhereHas('owner', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        }

        $records = $query->paginate(10)->withQueryString();
        return Inertia::render('Admin/LandRecords/Index', [
            'records' => $records
        ]);
    }

    public function createLandRecord()
    {
        $users = User::where('role', 'citizen')->get();
        return Inertia::render('Admin/LandRecords/Create', [
            'users' => $users
        ]);
    }

    public function storeLandRecord(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'record_number' => 'required|string|unique:land_records',
            'plot_number' => 'required|string',
            'survey_number' => 'required|string',
            'area_sqft' => 'required|numeric',
            'land_type' => 'required|string',
            'location' => 'required|string',
            'district' => 'required|string',
            'state' => 'required|string',
            'status' => 'required|string',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $documentPath = $request->file('document')->store('land_documents', 'public');
        
        $validated['document_path'] = $documentPath;
        unset($validated['document']);

        $landRecord = LandRecord::create($validated);

        $taxAmount = $this->calculateTaxAmount($landRecord->land_type, $landRecord->area_sqft);

        // Auto-generate initial tax
        PropertyTax::create([
            'land_record_id' => $landRecord->id,
            'financial_year' => date('Y') . '-' . (date('Y') + 1),
            'base_amount' => $taxAmount,
            'penalty_amount' => 0.00,
            'total_amount' => $taxAmount,
            'due_date' => now()->addDays(30)->format('Y-m-d'),
            'status' => 'pending'
        ]);

        return redirect()->route('admin.land-records.index')->with('success', 'Land record created successfully and initial tax generated.');
    }

    public function editLandRecord($id)
    {
        $record = LandRecord::findOrFail($id);
        $users = User::where('role', 'citizen')->get();
        return Inertia::render('Admin/LandRecords/Edit', [
            'record' => $record,
            'users' => $users
        ]);
    }

    public function updateLandRecord(Request $request, $id)
    {
        $record = LandRecord::findOrFail($id);
        
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'plot_number' => 'required|string',
            'survey_number' => 'required|string',
            'area_sqft' => 'required|numeric',
            'land_type' => 'required|string',
            'location' => 'required|string',
            'district' => 'required|string',
            'state' => 'required|string',
            'status' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('document')) {
            if ($record->document_path) {
                Storage::disk('public')->delete($record->document_path);
            }
            $validated['document_path'] = $request->file('document')->store('land_documents', 'public');
        }
        unset($validated['document']);

        $record->update($validated);

        return redirect()->route('admin.land-records.index')->with('success', 'Land record updated successfully.');
    }

    public function destroyLandRecord($id)
    {
        $record = LandRecord::findOrFail($id);
        
        if ($record->document_path) {
            Storage::disk('public')->delete($record->document_path);
        }
        
        $record->delete();

        return redirect()->route('admin.land-records.index')->with('success', 'Land record deleted successfully.');
    }

    public function exportLandRecords()
    {
        $response = new StreamedResponse(function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Record Number', 'Owner Name', 'Owner Email', 'Plot Number', 'Survey Number', 'Area (SqFt)', 'Land Type', 'Location', 'District', 'State', 'Status', 'Registered Date']);

            LandRecord::with('owner')->chunk(100, function($records) use($handle) {
                foreach($records as $record) {
                    fputcsv($handle, [
                        $record->record_number,
                        $record->owner->name ?? 'N/A',
                        $record->owner->email ?? 'N/A',
                        $record->plot_number,
                        $record->survey_number,
                        $record->area_sqft,
                        ucfirst($record->land_type),
                        $record->location,
                        $record->district,
                        $record->state,
                        ucfirst($record->status),
                        $record->created_at->format('Y-m-d')
                    ]);
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="land_records_export_' . date('Ymd_His') . '.csv"');

        return $response;
    }

    public function indexTaxes(Request $request)
    {
        $query = PropertyTax::with('landRecord.owner')->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('financial_year', 'like', '%' . $search . '%')
                  ->orWhereHas('landRecord', function($q) use ($search) {
                      $q->where('record_number', 'like', '%' . $search . '%');
                  });
        }

        $taxes = $query->paginate(15)->withQueryString();
        return view('admin.taxes.index', compact('taxes'));
    }

    public function createTaxGeneration()
    {
        return view('admin.taxes.generate');
    }

    public function storeTaxGeneration(Request $request)
    {
        $request->validate([
            'financial_year' => 'required|string',
            'penalty_amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        $activeRecords = LandRecord::where('status', 'active')->get();
        $generatedCount = 0;

        foreach ($activeRecords as $record) {
            $taxAmount = $this->calculateTaxAmount($record->land_type, $record->area_sqft);

            // Only create if tax for this year doesn't already exist for this record
            $tax = PropertyTax::firstOrCreate(
                [
                    'land_record_id' => $record->id,
                    'financial_year' => $request->financial_year
                ],
                [
                    'base_amount' => $taxAmount,
                    'penalty_amount' => $request->penalty_amount,
                    'total_amount' => $taxAmount + $request->penalty_amount,
                    'due_date' => $request->due_date,
                    'status' => 'pending'
                ]
            );

            if ($tax->wasRecentlyCreated) {
                $generatedCount++;
            }
        }

        return redirect()->route('admin.taxes.index')->with('success', "Successfully generated $generatedCount new tax bills for FY {$request->financial_year}.");
    }

    public function exportTaxes()
    {
        $response = new StreamedResponse(function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tax ID', 'Property Record', 'Owner Name', 'Financial Year', 'Base Amount', 'Penalty Amount', 'Total Amount', 'Due Date', 'Status']);

            PropertyTax::with(['landRecord.owner'])->chunk(100, function($taxes) use($handle) {
                foreach($taxes as $tax) {
                    fputcsv($handle, [
                        $tax->id,
                        $tax->landRecord->record_number ?? 'N/A',
                        $tax->landRecord->owner->name ?? 'N/A',
                        $tax->financial_year,
                        $tax->base_amount,
                        $tax->penalty_amount,
                        $tax->total_amount,
                        $tax->due_date,
                        strtoupper($tax->status)
                    ]);
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="property_taxes_export_' . date('Ymd_His') . '.csv"');

        return $response;
    }

    public function indexTransfers(Request $request)
    {
        $query = LandTransferRequest::with(['landRecord', 'fromOwner', 'toOwner'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('landRecord', function($q) use ($search) {
                      $q->where('record_number', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('toOwner', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        }

        $transfers = $query->paginate(15)->withQueryString();
            
        return view('admin.transfers.index', compact('transfers'));
    }

    public function approveTransfer($id)
    {
        $transfer = LandTransferRequest::findOrFail($id);
        
        if ($transfer->status !== 'pending') {
            return back()->withErrors('Only pending requests can be approved.');
        }

        // Update the land record ownership
        $landRecord = $transfer->landRecord;
        $landRecord->update([
            'owner_id' => $transfer->to_owner_id,
            'status' => 'active'
        ]);

        // Mark request as approved
        $transfer->update([
            'status' => 'approved',
            'transfer_date' => now(),
            'approved_by' => auth()->id()
        ]);

        $taxAmount = $this->calculateTaxAmount($landRecord->land_type, $landRecord->area_sqft);

        // Generate a transfer tax / initial tax for the new owner
        PropertyTax::create([
            'land_record_id' => $landRecord->id,
            'financial_year' => date('Y') . '-' . (date('Y') + 1),
            'base_amount' => $taxAmount,
            'penalty_amount' => 0.00,
            'total_amount' => $taxAmount,
            'due_date' => now()->addDays(30)->format('Y-m-d'),
            'status' => 'pending'
        ]);

        return redirect()->route('admin.transfers.index')->with('success', 'Transfer request approved successfully. Ownership updated and transfer tax generated.');
    }

    public function rejectTransfer(Request $request, $id)
    {
        $transfer = LandTransferRequest::findOrFail($id);
        
        if ($transfer->status !== 'pending') {
            return back()->withErrors('Only pending requests can be rejected.');
        }

        $transfer->update([
            'status' => 'rejected',
            'remarks' => $transfer->remarks . ' | Rejection Reason: ' . $request->input('rejection_reason', 'Did not meet requirements.'),
            'approved_by' => auth()->id()
        ]);

        return redirect()->route('admin.transfers.index')->with('success', 'Transfer request rejected.');
    }

    private function calculateTaxAmount($landType, $areaSqft)
    {
        $rate = 0;
        switch (strtolower($landType)) {
            case 'residential':
                $rate = 80;
                break;
            case 'commercial':
                $rate = 90;
                break;
            case 'agricultural':
                $rate = 50;
                break;
            case 'industrial':
                $rate = 120;
                break;
            default:
                $rate = 0;
        }
        return ($areaSqft / 100) * $rate;
    }
}
