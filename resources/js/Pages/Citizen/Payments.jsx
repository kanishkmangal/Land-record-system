import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import CitizenLayout from '@/Layouts/CitizenLayout';

export default function Payments({ payments }) {
    return (
        <CitizenLayout>
            <Head title="My Payments" />
            
            <main className="max-w-md mx-auto px-4 pt-6 pb-12 mb-24 mt-6">
                <section>
                    <div className="flex items-center justify-between mb-4 px-1 border-b border-outline-variant pb-2">
                        <h2 className="font-h2 text-on-surface">My Payments</h2>
                    </div>
                    
                    <div className="flex flex-col gap-3">
                        {payments && payments.length > 0 ? (
                            payments.map((payment) => (
                                <div key={payment.id} className={`bg-white border border-outline-variant rounded-lg p-4 flex items-center justify-between ${payment.status === 'failed' ? 'opacity-70' : ''}`}>
                                    <div className="flex items-center gap-3">
                                        <div className={`${payment.status === 'success' ? 'bg-secondary-container text-on-secondary-container' : 'bg-error-container text-on-error-container'} w-10 h-10 rounded-full flex items-center justify-center`}>
                                            <span className="material-symbols-outlined" style={{fontVariationSettings: "'FILL' 1"}}>
                                                {payment.status === 'success' ? 'check_circle' : 'cancel'}
                                            </span>
                                        </div>
                                        <div>
                                            <p className="font-label-md text-on-surface">
                                                {new Date(payment.payment_date).toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'})}
                                            </p>
                                            <p className="text-body-sm text-outline">Receipt #{payment.receipt_number}</p>
                                            {payment.property_tax?.land_record && (
                                                <p className="text-[10px] text-primary-container mt-0.5">
                                                    Property: {payment.property_tax.land_record.record_number}
                                                </p>
                                            )}
                                        </div>
                                    </div>
                                    <div className="text-right flex flex-col items-end gap-1">
                                        <p className={`font-h3 ${payment.status === 'success' ? 'text-secondary' : 'text-error'} text-[18px]`}>
                                            ${(payment.amount_paid || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}
                                        </p>
                                        <p className={`text-[10px] uppercase font-bold ${payment.status === 'success' ? 'text-secondary' : 'text-error'} tracking-widest`}>
                                            {payment.status}
                                        </p>
                                        
                                        {payment.status === 'success' && (
                                            <Link 
                                                href={route('citizen.tax.receipt', payment.id)} 
                                                className="mt-1 text-[10px] text-primary-container font-bold hover:underline flex items-center gap-1 bg-surface-container-low px-2 py-1 rounded"
                                            >
                                                <span className="material-symbols-outlined text-[12px]">download</span> Receipt
                                            </Link>
                                        )}
                                    </div>
                                </div>
                            ))
                        ) : (
                            <div className="text-center p-8 bg-surface-container-lowest border border-outline-variant rounded-xl border-dashed">
                                <span className="material-symbols-outlined text-outline text-5xl mb-4">receipt_long</span>
                                <p className="text-on-surface-variant font-body-sm">No payment history found.</p>
                            </div>
                        )}
                    </div>
                </section>
            </main>
        </CitizenLayout>
    );
}
