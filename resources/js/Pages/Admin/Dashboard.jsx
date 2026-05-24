import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

export default function Dashboard({ total_users, total_land_records, total_tax_collected, pending_taxes_count, recent_payments }) {
    const { auth = { user: null } } = usePage().props;

    return (
        <AdminLayout>
            <Head title="Admin Dashboard" />
            
            <main className="max-w-container-max mx-auto p-4 md:p-6 space-y-6 mt-6">
                {/* Metrics Row */}
                <section className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div className="bg-white border border-outline-variant p-4 rounded-lg flex items-center gap-4 transition-all shadow-sm">
                        <div className="bg-primary-fixed w-12 h-12 flex items-center justify-center rounded-full text-primary">
                            <span className="material-symbols-outlined">group</span>
                        </div>
                        <div>
                            <p className="font-label-sm text-on-surface-variant uppercase tracking-wider">Total Citizens</p>
                            <p className="font-h3 text-primary">{total_users || 0}</p>
                        </div>
                    </div>
                    <div className="bg-white border border-outline-variant p-4 rounded-lg flex items-center gap-4 shadow-sm">
                        <div className="bg-secondary-container w-12 h-12 flex items-center justify-center rounded-full text-on-secondary-container">
                            <span className="material-symbols-outlined">payments</span>
                        </div>
                        <div>
                            <p className="font-label-sm text-on-surface-variant uppercase tracking-wider">Tax Collected</p>
                            <p className="font-h3 text-primary">${(total_tax_collected || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}</p>
                        </div>
                    </div>
                    <div className="bg-white border border-outline-variant p-4 rounded-lg flex items-center gap-4 shadow-sm">
                        <div className="bg-error-container w-12 h-12 flex items-center justify-center rounded-full text-on-error-container">
                            <span className="material-symbols-outlined">pending_actions</span>
                        </div>
                        <div>
                            <p className="font-label-sm text-on-surface-variant uppercase tracking-wider">Pending Taxes</p>
                            <p className="font-h3 text-primary">{pending_taxes_count || 0}</p>
                        </div>
                    </div>
                </section>

                {/* Main Bento Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    {/* Revenue Trends Chart */}
                    <div className="lg:col-span-8 bg-white border border-outline-variant rounded-lg p-6 flex flex-col gap-4 shadow-sm">
                        <div className="flex justify-between items-center">
                            <h2 className="font-h3 text-on-surface">Revenue Trends</h2>
                            <span className="text-label-sm text-on-surface-variant bg-surface-container px-2 py-1 rounded">Last 6 Months</span>
                        </div>
                        <div className="flex-grow min-h-[240px] relative mt-4">
                            <svg className="w-full h-full" viewBox="0 0 800 200">
                                <path d="M0,180 Q100,160 200,140 T400,100 T600,60 T800,20" fill="none" stroke="#002D62" strokeLinecap="round" strokeWidth="3"></path>
                                <path d="M0,180 Q100,160 200,140 T400,100 T600,60 T800,20 L800,200 L0,200 Z" fill="url(#grad1)" opacity="0.1"></path>
                                <defs>
                                    <linearGradient id="grad1" x1="0%" x2="0%" y1="0%" y2="100%">
                                        <stop offset="0%" style={{stopColor:'#002D62', stopOpacity:1}}></stop>
                                        <stop offset="100%" style={{stopColor:'#002D62', stopOpacity:0}}></stop>
                                    </linearGradient>
                                </defs>
                                <line stroke="#E5E7EB" strokeDasharray="4" strokeWidth="1" x1="0" x2="800" y1="50" y2="50"></line>
                                <line stroke="#E5E7EB" strokeDasharray="4" strokeWidth="1" x1="0" x2="800" y1="100" y2="100"></line>
                                <line stroke="#E5E7EB" strokeDasharray="4" strokeWidth="1" x1="0" x2="800" y1="150" y2="150"></line>
                            </svg>
                            <div className="flex justify-between mt-4 text-label-sm text-on-surface-variant">
                                <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span>
                            </div>
                        </div>
                    </div>

                    {/* Task List */}
                    <div className="lg:col-span-4 bg-white border border-outline-variant rounded-lg p-6 flex flex-col gap-4 shadow-sm">
                        <h2 className="font-h3 text-on-surface border-b border-outline-variant pb-3">Tasks</h2>
                        <div className="space-y-4">
                            <div className="flex items-center justify-between p-3 bg-surface-container-low border border-outline-variant/30 rounded-lg">
                                <div className="flex items-center gap-3">
                                    <span className="material-symbols-outlined text-primary">verified_user</span>
                                    <div>
                                        <p className="font-label-md">Verify New Records</p>
                                        <p className="text-[10px] text-on-surface-variant uppercase">Pending Actions</p>
                                    </div>
                                </div>
                                <a href={route('admin.transfers.index')} className="bg-primary text-white text-[12px] px-3 py-1 rounded-sm font-semibold hover:opacity-90 transition-opacity text-center">START</a>
                            </div>
                            <div className="flex items-center justify-between p-3 border border-outline-variant/30 rounded-lg">
                                <div className="flex items-center gap-3">
                                    <span className="material-symbols-outlined text-on-surface-variant">manage_accounts</span>
                                    <div>
                                        <p className="font-label-md">User Role Review</p>
                                        <p className="text-[10px] text-on-surface-variant uppercase">Priority High</p>
                                    </div>
                                </div>
                                <span className="material-symbols-outlined text-outline cursor-pointer">more_vert</span>
                            </div>
                        </div>
                        <a href={route('admin.transfers.index')} className="mt-auto w-full border border-primary text-primary py-2 rounded-sm font-label-md hover:bg-primary-fixed transition-colors block text-center">VIEW ALL TASKS</a>
                    </div>
                </div>

                {/* Recent Activity Table Section */}
                <section className="bg-white border border-outline-variant rounded-lg overflow-hidden shadow-sm">
                    <div className="bg-primary-container p-4">
                        <h3 className="font-h3 text-white">Recent Transactions</h3>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="bg-surface-container text-on-surface-variant font-label-md border-b border-outline-variant">
                                    <th className="p-4">Entity ID</th>
                                    <th className="p-4">Owner/Citizen</th>
                                    <th className="p-4">Status</th>
                                    <th className="p-4">Amount</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-outline-variant/50">
                                {recent_payments && recent_payments.length > 0 ? (
                                    recent_payments.map((payment, index) => (
                                        <tr key={index} className="hover:bg-surface-container-low transition-colors">
                                            <td className="p-4 font-body-sm">#{payment.receipt_number}</td>
                                            <td className="p-4 font-body-sm">{payment.citizen?.name}</td>
                                            <td className="p-4">
                                                <span className="bg-secondary-container text-on-secondary-container text-[10px] px-2 py-1 rounded-full font-bold uppercase">{payment.status}</span>
                                            </td>
                                            <td className="p-4 font-body-sm">${(payment.amount_paid || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="4" className="p-8 text-center font-body-sm italic text-on-surface-variant">No recent transactions found.</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </AdminLayout>
    );
}
