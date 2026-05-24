import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import CitizenLayout from '@/Layouts/CitizenLayout';

export default function Receipt({ payment }) {
    return (
        <CitizenLayout>
            <Head title="Payment Receipt" />
            
            <main className="max-w-md mx-auto px-4 pt-8 pb-12 mb-24 mt-6">
                <div className="bg-white border border-outline-variant rounded-xl shadow-md overflow-hidden">
                    {/* Header */}
                    <div className="bg-secondary-container p-6 flex flex-col items-center justify-center text-center">
                        <div className="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-3 shadow-sm">
                            <span className="material-symbols-outlined text-secondary text-4xl" style={{fontVariationSettings: "'FILL' 1"}}>check_circle</span>
                        </div>
                        <h2 className="font-h2 text-on-secondary-container">Payment Successful</h2>
                        <p className="font-body-sm text-on-secondary-container/80 mt-1">Thank you for your tax payment.</p>
                    </div>

                    {/* Receipt Details */}
                    <div className="p-6 space-y-5">
                        <div className="flex justify-between items-center border-b border-outline-variant pb-3">
                            <span className="font-label-md text-on-surface-variant">Amount Paid</span>
                            <span className="font-h2 text-primary">${(payment.amount_paid || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                        </div>

                        <div className="grid grid-cols-2 gap-y-4 text-sm">
                            <div>
                                <span className="block font-label-sm text-on-surface-variant uppercase text-[10px] tracking-widest mb-1">Receipt No.</span>
                                <span className="font-body-md font-semibold">{payment.receipt_number}</span>
                            </div>
                            <div>
                                <span className="block font-label-sm text-on-surface-variant uppercase text-[10px] tracking-widest mb-1">Transaction ID</span>
                                <span className="font-body-md font-semibold">{payment.transaction_id}</span>
                            </div>
                            <div>
                                <span className="block font-label-sm text-on-surface-variant uppercase text-[10px] tracking-widest mb-1">Date</span>
                                <span className="font-body-md font-semibold">{new Date(payment.payment_date).toLocaleDateString()}</span>
                            </div>
                            <div>
                                <span className="block font-label-sm text-on-surface-variant uppercase text-[10px] tracking-widest mb-1">Payment Method</span>
                                <span className="font-body-md font-semibold uppercase">{payment.payment_method}</span>
                            </div>
                        </div>

                        <div className="pt-4 flex flex-col gap-3">
                            <button onClick={() => window.print()} className="w-full h-11 bg-primary text-white font-label-md flex items-center justify-center gap-2 rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
                                <span className="material-symbols-outlined text-[20px]">print</span>
                                Print Receipt
                            </button>
                            <Link href={route('citizen.dashboard')} className="w-full h-11 border border-primary-container text-primary-container font-label-md flex items-center justify-center gap-2 rounded-lg hover:bg-surface-container transition-colors text-center">
                                Back to Dashboard
                            </Link>
                        </div>
                    </div>
                </div>
            </main>
        </CitizenLayout>
    );
}
