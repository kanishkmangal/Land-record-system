import React, { useState, useEffect } from 'react';
import { Head, Link, usePage, router } from '@inertiajs/react';
import CitizenLayout from '@/Layouts/CitizenLayout';

export default function Index({ records, filters }) {
    const { auth } = usePage().props;
    const [search, setSearch] = useState(filters?.search || '');

    useEffect(() => {
        const timeout = setTimeout(() => {
            router.get(
                route('citizen.land-records.index'),
                { search },
                { preserveState: true, replace: true }
            );
        }, 300);
        return () => clearTimeout(timeout);
    }, [search]);

    const statusColors = {
        active: 'bg-secondary-container text-on-secondary-container',
        transferred: 'bg-surface-container-highest text-on-surface-variant',
        disputed: 'bg-error-container text-on-error-container',
    };

    const statusIcons = {
        active: 'check_circle',
        transferred: 'swap_horiz',
        disputed: 'warning',
    };

    return (
        <CitizenLayout>
            <Head title="My Land Records" />
            
            <main className="max-w-container-max mx-auto px-4 py-md mb-24 mt-6">
                {/* Search Section */}
                <section className="mb-gutter">
                    <div className="flex flex-col gap-base">
                        <label className="font-label-md text-on-surface-variant ml-1">Search My Property Records</label>
                        <div className="relative group">
                            <span className="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary-container">search</span>
                            <input 
                                className="w-full h-[48px] pl-12 pr-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:ring-2 focus:ring-primary-container focus:border-primary-container outline-none font-body-md transition-all shadow-sm" 
                                placeholder="Search by Record ID, Plot, or Survey Number" 
                                type="text"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                            />
                        </div>
                    </div>
                </section>

                {/* Quick Filters */}
                <section className="mb-gutter overflow-x-auto pb-2 -mx-4 px-4 scrollbar-hide">
                    <div className="flex gap-sm">
                        <button className="flex items-center gap-xs px-4 py-2 bg-primary-container text-white rounded-full font-label-md whitespace-nowrap shadow-sm">
                            <span className="material-symbols-outlined text-[18px]">tune</span>
                            All Records
                        </button>
                        <button className="flex items-center gap-xs px-4 py-2 bg-white border border-outline-variant text-on-surface-variant rounded-full font-label-md whitespace-nowrap hover:bg-surface-container-low transition-colors">
                            Verified
                        </button>
                        <button className="flex items-center gap-xs px-4 py-2 bg-white border border-outline-variant text-on-surface-variant rounded-full font-label-md whitespace-nowrap hover:bg-surface-container-low transition-colors">
                            Pending
                        </button>
                    </div>
                </section>

                {/* Records Grid */}
                <div className="flex flex-col gap-sm">
                    <div className="flex justify-between items-end mb-2 px-1">
                        <h2 className="font-h3 text-primary">Found {records.data.length} Records</h2>
                        <span className="font-label-sm text-outline">Updated just now</span>
                    </div>

                    {records.data.length > 0 ? (
                        records.data.map((record) => (
                            <article key={record.id} className="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                                <div className="flex justify-between items-start mb-base">
                                    <div>
                                        <p className="font-label-sm text-outline uppercase tracking-wider mb-xs">Record Number</p>
                                        <h3 className="font-h3 text-primary">{record.record_number}</h3>
                                    </div>
                                    <span className={`px-3 py-1 ${statusColors[record.status] || 'bg-surface-container'} rounded-full font-label-sm flex items-center gap-1`}>
                                        <span className="material-symbols-outlined text-[14px]" style={{fontVariationSettings: "'FILL' 1"}}>
                                            {statusIcons[record.status] || 'info'}
                                        </span>
                                        {record.status.charAt(0).toUpperCase() + record.status.slice(1)}
                                    </span>
                                </div>
                                <div className="grid grid-cols-2 gap-md py-base border-y border-outline-variant/30 my-base">
                                    <div>
                                        <p className="font-label-sm text-outline">Plot Number</p>
                                        <p className="font-body-md font-semibold text-on-surface">{record.plot_number}</p>
                                    </div>
                                    <div>
                                        <p className="font-label-sm text-outline">Location</p>
                                        <p className="font-body-md font-semibold text-on-surface">{record.location}, {record.district}</p>
                                    </div>
                                </div>
                                <div className="flex items-center justify-between mt-sm">
                                    <div className="flex items-center gap-2 text-outline">
                                        <span className="material-symbols-outlined text-[20px]">calendar_today</span>
                                        <span className="font-label-sm">Registered: {new Date(record.created_at).toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'})}</span>
                                    </div>
                                    <Link 
                                        href={route('citizen.land-records.show', record.id)} 
                                        className="bg-primary-container text-white px-5 py-2.5 rounded-lg font-label-md hover:opacity-90 transition-opacity active:scale-95 inline-block text-center"
                                    >
                                        View Details
                                    </Link>
                                </div>
                            </article>
                        ))
                    ) : (
                        <div className="bg-white border border-dashed border-outline-variant rounded-xl p-12 text-center">
                            <span className="material-symbols-outlined text-outline text-5xl mb-4">description_off</span>
                            <p className="font-body-md text-on-surface-variant">No land records found associated with your account.</p>
                            <button className="mt-4 text-primary-container font-label-md hover:underline">Contact Registry Office</button>
                        </div>
                    )}
                </div>

                {/* Simple Pagination */}
                {records.links && records.links.length > 3 && (
                    <div className="mt-lg flex justify-center gap-2">
                        {records.links.map((link, i) => (
                            <Link
                                key={i}
                                href={link.url || '#'}
                                className={`px-4 py-2 rounded-lg ${link.active ? 'bg-primary-container text-white' : 'bg-white border border-outline-variant text-on-surface-variant'} ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ))}
                    </div>
                )}
            </main>
        </CitizenLayout>
    );
}
