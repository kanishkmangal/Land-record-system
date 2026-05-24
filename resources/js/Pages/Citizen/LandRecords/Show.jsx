import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import CitizenLayout from '@/Layouts/CitizenLayout';

export default function Show({ record, latest_tax, pending_transfer }) {
    const { auth } = usePage().props;

    return (
        <CitizenLayout>
            <Head title={`Record ${record.record_number}`} />
            
            <main className="max-w-md mx-auto px-4 pt-md space-y-md mb-24 mt-6">
                {/* Quick Status Indicator */}
                <div className={`flex items-center justify-between py-xs px-sm ${record.status === 'active' ? 'bg-secondary-container/30 border-secondary-container' : 'bg-error-container/30 border-error-container'} border rounded-lg`}>
                    <div className="flex items-center gap-2">
                        <span className={`material-symbols-outlined ${record.status === 'active' ? 'text-secondary' : 'text-error'}`} style={{fontVariationSettings: "'FILL' 1"}}>
                            {record.status === 'active' ? 'verified_user' : 'warning'}
                        </span>
                        <span className={`font-label-md ${record.status === 'active' ? 'text-on-secondary-container' : 'text-on-error-container'}`}>
                            {record.status.charAt(0).toUpperCase() + record.status.slice(1)} Record
                        </span>
                    </div>
                    <span className="font-label-sm text-on-surface-variant">
                        Last updated: {new Date(record.updated_at).toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'})}
                    </span>
                </div>

                {/* Section: Owner Details */}
                <section className="space-y-sm">
                    <div className="flex items-center gap-2 pb-xs border-b border-outline-variant">
                        <span className="material-symbols-outlined text-primary-container">person</span>
                        <h2 className="font-h3 text-primary-container uppercase tracking-tight text-sm">Owner Details</h2>
                    </div>
                    <div className="grid grid-cols-1 gap-y-4 pt-base">
                        <div>
                            <p className="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Primary Owner Name</p>
                            <p className="font-body-lg font-semibold text-primary">{auth.user.name}</p>
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <p className="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Record ID</p>
                                <p className="font-body-md font-medium">{record.record_number}</p>
                            </div>
                            <div>
                                <p className="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Registry Status</p>
                                <span className="inline-flex items-center px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant text-[10px] font-bold">
                                    {record.status.toUpperCase()}
                                </span>
                            </div>
                        </div>
                        <div>
                            <p className="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Property Address</p>
                            <p className="font-body-md leading-relaxed">{record.location}, {record.district}, {record.state}</p>
                        </div>
                    </div>
                </section>

                {/* Section: Property Info */}
                <section className="space-y-sm pt-4">
                    <div className="flex items-center gap-2 pb-xs border-b border-outline-variant">
                        <span className="material-symbols-outlined text-primary-container">location_on</span>
                        <h2 className="font-h3 text-primary-container uppercase tracking-tight text-sm">Property Info</h2>
                    </div>
                    <div className="grid grid-cols-2 gap-4 pt-base">
                        <div className="bg-white p-4 border border-outline-variant rounded-lg col-span-2 shadow-sm">
                            <p className="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px] mb-1">Land Area</p>
                            <div className="flex items-baseline gap-2">
                                <span className="text-h2 text-primary">{(record.area_sqft || 0).toLocaleString()}</span>
                                <span className="font-body-sm text-on-surface-variant">Square Feet</span>
                            </div>
                        </div>
                        <div className="bg-white p-4 border border-outline-variant rounded-lg shadow-sm">
                            <p className="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px] mb-1">Land Type</p>
                            <p className="font-body-md font-semibold text-primary">{record.land_type.charAt(0).toUpperCase() + record.land_type.slice(1)}</p>
                        </div>
                        <div className="bg-white p-4 border border-outline-variant rounded-lg shadow-sm">
                            <p className="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px] mb-1">Survey / Plot No.</p>
                            <p className="font-body-md font-semibold text-primary">{record.survey_number} / {record.plot_number}</p>
                        </div>
                    </div>
                </section>

                {/* Section: Tax Summary */}
                <section className="space-y-sm pt-4">
                    <div className="flex items-center gap-2 pb-xs border-b border-outline-variant">
                        <span className="material-symbols-outlined text-primary-container">payments</span>
                        <h2 className="font-h3 text-primary-container uppercase tracking-tight text-sm">Tax Summary</h2>
                    </div>
                    {latest_tax ? (
                        <div className="grid grid-cols-5 gap-3 pt-base">
                            <div className={`col-span-3 ${latest_tax.status === 'pending' ? 'bg-primary-container' : 'bg-secondary'} text-white p-4 rounded-lg flex flex-col justify-between shadow-md`}>
                                <div>
                                    <p className="font-label-sm text-white/70 uppercase tracking-widest text-[10px] mb-2">{latest_tax.status === 'pending' ? 'Current Due' : 'Balance'}</p>
                                    <p className="font-h2">${(latest_tax.total_amount || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}</p>
                                    <p className="text-[10px] mt-2 opacity-80">Financial Year: {latest_tax.financial_year}</p>
                                </div>
                                {latest_tax.status === 'pending' && (
                                    <Link 
                                        href={route('citizen.tax.process', latest_tax.id)} 
                                        method="post"
                                        as="button"
                                        className="mt-3 w-full bg-white text-primary-container text-center font-label-sm py-1.5 rounded-lg hover:bg-surface-container transition-colors shadow-sm block"
                                    >
                                        Pay Tax Now
                                    </Link>
                                )}
                            </div>
                            <div className="col-span-2 bg-surface-container-high p-4 rounded-lg flex flex-col justify-between shadow-sm">
                                <div>
                                    <p className="font-label-sm text-on-surface-variant uppercase tracking-widest text-[10px] mb-1">Status</p>
                                    <p className="font-label-md text-primary">{latest_tax.status.toUpperCase()}</p>
                                </div>
                                <p className="text-[10px] text-on-surface-variant">Due: {new Date(latest_tax.due_date).toLocaleDateString()}</p>
                            </div>
                        </div>
                    ) : (
                        <div className="pt-base">
                            <p className="font-body-sm text-on-surface-variant italic">No tax records found for this property.</p>
                        </div>
                    )}
                </section>

                {/* Bottom Actions */}
                <div className="pt-lg flex flex-col gap-3 pb-12">
                    {record.document_path && (
                        <a 
                            href={`/storage/${record.document_path}`} 
                            target="_blank" 
                            className="w-full h-11 bg-primary-container text-white font-label-md flex items-center justify-center gap-2 rounded-lg hover:bg-primary transition-colors shadow-md"
                        >
                            <span className="material-symbols-outlined text-[20px]">download</span>
                            Download Digital Title Deed
                        </a>
                    )}
                    
                    {pending_transfer ? (
                        <div className="w-full bg-surface-container border border-outline-variant text-on-surface p-4 rounded-lg shadow-sm">
                            <div className="flex items-center gap-2 mb-2">
                                <span className="material-symbols-outlined text-primary-container">info</span>
                                <span className="font-label-md font-bold text-primary-container">Transfer Request Pending</span>
                            </div>
                            <p className="text-sm text-on-surface-variant">
                                You have already submitted a transfer request for this property which is currently pending review.
                            </p>
                        </div>
                    ) : latest_tax && latest_tax.status === 'pending' ? (
                        <div className="w-full bg-error-container/20 border border-error-container/50 text-on-surface p-4 rounded-lg shadow-sm">
                            <div className="flex items-center gap-2 mb-2">
                                <span className="material-symbols-outlined text-error text-[20px]">warning</span>
                                <span className="font-label-md font-bold text-error">Clear Dues to Transfer</span>
                            </div>
                            <p className="text-sm text-on-surface-variant mb-3">
                                Ownership transfer is disabled because there are pending tax dues on this property. Please pay the tax first.
                            </p>
                            <button disabled className="w-full h-11 bg-surface-container-high text-on-surface-variant/50 font-label-md flex items-center justify-center gap-2 rounded-lg cursor-not-allowed border border-outline-variant/30">
                                <span className="material-symbols-outlined text-[20px]">swap_horiz</span>
                                Apply for Ownership Transfer
                            </button>
                        </div>
                    ) : (
                        <Link 
                            href={route('citizen.land-records.transfer', record.id)} 
                            className="w-full h-11 bg-secondary text-white font-label-md flex items-center justify-center gap-2 rounded-lg hover:bg-secondary/90 transition-colors shadow-md"
                        >
                            <span className="material-symbols-outlined text-[20px]">swap_horiz</span>
                            Apply for Ownership Transfer
                        </Link>
                    )}

                    <button 
                        onClick={() => window.print()} 
                        className="w-full h-11 border border-primary-container text-primary-container font-label-md flex items-center justify-center gap-2 rounded-lg hover:bg-primary-container/5 transition-colors shadow-sm bg-white"
                    >
                        <span className="material-symbols-outlined text-[20px]">print</span>
                        Print Record Statement
                    </button>
                </div>
            </main>
        </CitizenLayout>
    );
}
