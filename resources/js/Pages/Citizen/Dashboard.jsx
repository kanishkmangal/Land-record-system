import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import CitizenLayout from '@/Layouts/CitizenLayout';

export default function Dashboard({ properties_count, pending_tax, next_due_date, recent_activities }) {
    const { auth = { user: null } } = usePage().props;

    return (
        <CitizenLayout>
            <Head title="Citizen Dashboard" />
            
            <main className="px-4 max-w-container-max mx-auto space-y-md mt-6">
                {/* Welcome Section */}
                <section className="mb-gutter">
                    <h2 className="font-h3 text-h3 text-primary-container">Welcome, {auth.user.name}</h2>
                    <p className="font-body-sm text-body-sm text-on-surface-variant">Review your land holdings and pending obligations.</p>
                </section>

                {/* Bento Grid Overview Cards */}
                <div className="grid grid-cols-2 gap-4">
                    {/* Properties Owned */}
                    <div className="col-span-2 bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex flex-col justify-between h-32">
                        <div className="flex justify-between items-start">
                            <span className="material-symbols-outlined text-primary-container">domain</span>
                            <span className="bg-secondary-container text-on-secondary-container text-xs px-2 py-1 rounded-full font-bold">Verified</span>
                        </div>
                        <div>
                            <p className="font-label-sm text-on-surface-variant">Properties Owned</p>
                            <h3 className="font-h3 text-h3 text-primary-container">{properties_count || 0}</h3>
                        </div>
                    </div>
                    {/* Pending Tax */}
                    <div className="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex flex-col justify-between h-40">
                        <span className="material-symbols-outlined text-error">account_balance_wallet</span>
                        <div>
                            <p className="font-label-sm text-on-surface-variant">Pending Tax</p>
                            <h3 className="font-h3 text-h3 text-error">${(pending_tax || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}</h3>
                        </div>
                    </div>
                    {/* Next Due Date */}
                    <div className="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex flex-col justify-between h-40">
                        <span className="material-symbols-outlined text-primary-container">event</span>
                        <div>
                            <p className="font-label-sm text-on-surface-variant">Next Due Date</p>
                            <h3 className="font-h3 text-h3 text-primary-container">{next_due_date || 'N/A'}</h3>
                        </div>
                    </div>
                </div>

                {/* Quick Actions Grid */}
                <section className="space-y-sm">
                    <h3 className="font-label-md text-label-md text-on-surface uppercase tracking-wider">Quick Actions</h3>
                    <div className="grid grid-cols-2 gap-3">
                        <Link href={route('citizen.land-records.index')} className="flex items-center gap-3 bg-primary-container text-white p-3 rounded-lg hover:bg-primary transition-all">
                            <span className="material-symbols-outlined">payments</span>
                            <span className="font-label-sm">Pay Taxes</span>
                        </Link>
                        <Link href={route('citizen.land-records.index')} className="flex items-center gap-3 border border-primary-container text-primary-container p-3 rounded-lg hover:bg-surface-container-low transition-all">
                            <span className="material-symbols-outlined">search</span>
                            <span className="font-label-sm">Title Search</span>
                        </Link>
                    </div>
                </section>

                {/* Recent Activity */}
                <section className="space-y-sm pb-lg">
                    <div className="flex justify-between items-center">
                        <h3 className="font-label-md text-label-md text-on-surface uppercase tracking-wider">Recent Activity</h3>
                        <button className="text-primary-container font-label-sm">View All</button>
                    </div>
                    <div className="space-y-3">
                        {recent_activities && recent_activities.length > 0 ? (
                            recent_activities.map((activity, index) => (
                                <div key={index} className="bg-white border border-outline-variant rounded-lg p-4 flex gap-4">
                                    <div className="w-10 h-10 rounded bg-secondary-container flex items-center justify-center shrink-0">
                                        <span className="material-symbols-outlined text-on-secondary-container">check_circle</span>
                                    </div>
                                    <div className="flex-1">
                                        <div className="flex justify-between">
                                            <h4 className="font-label-md text-primary-container">{activity.title}</h4>
                                            <span className="font-label-sm text-on-surface-variant">{activity.date}</span>
                                        </div>
                                        <p className="font-body-sm text-on-surface-variant mt-1">{activity.description}</p>
                                    </div>
                                </div>
                            ))
                        ) : (
                            <div className="bg-surface-container-low border border-dashed border-outline-variant rounded-lg p-8 flex items-center justify-center opacity-70">
                                <p className="font-body-sm italic text-on-surface-variant">No recent activity found.</p>
                            </div>
                        )}
                    </div>
                </section>
            </main>
        </CitizenLayout>
    );
}
