import React from 'react';
import { Head, Link, usePage, router } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

export default function Index({ records = { data: [], links: [] } }) {
    const { flash = {}, auth = {} } = usePage().props;

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this record?')) {
            router.delete(route('admin.land-records.destroy', id));
        }
    };

    return (
        <AdminLayout>
            <Head title="Land Records Management" />
            
            <main className="max-w-container-max mx-auto p-4 md:p-6 space-y-6 mb-24 mt-6">
                {/* Header & Action */}
                <section className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-outline-variant pb-4">
                    <div>
                        <h2 className="font-h2 text-h2 text-primary">Land Records Management</h2>
                        <p className="font-body-sm text-on-surface-variant">Manage all registered properties and land records.</p>
                    </div>
                    <div className="flex items-center gap-3">
                        <a 
                            href={route('admin.land-records.export')} 
                            className="flex items-center gap-2 border border-outline-variant bg-white text-on-surface-variant px-4 py-2.5 rounded-lg font-label-md hover:bg-surface-container-low transition-all shadow-sm"
                        >
                            <span className="material-symbols-outlined text-[18px]">download</span>
                            Export CSV
                        </a>
                        <Link 
                            href={route('admin.land-records.create')} 
                            className="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-lg font-label-md hover:opacity-90 active:scale-95 transition-all shadow-md"
                        >
                            <span className="material-symbols-outlined text-[20px]">add</span>
                            Create New Record
                        </Link>
                    </div>
                </section>

                {/* Success Messages */}
                {flash.success && (
                    <div className="bg-secondary-container text-on-secondary-container p-4 rounded-lg font-body-sm flex items-center gap-2 animate-pulse">
                        <span className="material-symbols-outlined text-sm">check_circle</span>
                        {flash.success}
                    </div>
                )}

                {/* Search */}
                <section className="flex flex-col gap-3 md:flex-row md:items-center">
                    <form 
                        onSubmit={(e) => {
                            e.preventDefault();
                            const search = e.target.search.value;
                            router.get(route('admin.land-records.index'), { search }, { preserveState: true });
                        }} 
                        className="relative flex-grow flex items-center gap-2"
                    >
                        <div className="relative flex-grow">
                            <span className="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                            <input 
                                name="search" 
                                defaultValue={new URLSearchParams(window.location.search).get('search') || ''}
                                className="w-full pl-10 pr-4 py-2 bg-white border border-outline-variant rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all shadow-sm" 
                                placeholder="Search by Record ID, Plot Number, or Owner Name" 
                                type="text"
                            />
                        </div>
                        <button type="submit" className="bg-surface-container-high border border-outline-variant text-on-surface px-4 py-2 rounded-lg font-label-md hover:bg-surface-container-highest transition-colors">
                            Search
                        </button>
                        {new URLSearchParams(window.location.search).get('search') && (
                            <Link href={route('admin.land-records.index')} className="text-error hover:underline font-label-sm px-2">Clear</Link>
                        )}
                    </form>
                </section>

                {/* Records Table */}
                <section className="bg-white border border-outline-variant rounded-lg overflow-hidden shadow-sm">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse min-w-[800px]">
                            <thead>
                                <tr className="bg-surface-container text-on-surface-variant font-label-md border-b border-outline-variant">
                                    <th className="p-4">Record ID</th>
                                    <th className="p-4">Owner Name</th>
                                    <th className="p-4">Plot / Survey</th>
                                    <th className="p-4">Type</th>
                                    <th className="p-4">Status</th>
                                    <th className="p-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-outline-variant/50">
                                {records.data.length > 0 ? (
                                    records.data.map((record) => (
                                        <tr key={record.id} className="hover:bg-surface-container-low transition-colors">
                                            <td className="p-4 font-body-md text-primary font-bold">{record.record_number}</td>
                                            <td className="p-4 font-body-sm">{record.owner?.name || 'N/A'}</td>
                                            <td className="p-4 font-body-sm">{record.plot_number} / {record.survey_number}</td>
                                            <td className="p-4 font-body-sm capitalize">{record.land_type}</td>
                                            <td className="p-4">
                                                <span className={`${record.status === 'active' ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-highest text-on-surface-variant'} text-[10px] px-2 py-1 rounded-full font-bold uppercase`}>
                                                    {record.status}
                                                </span>
                                            </td>
                                            <td className="p-4 flex gap-2 justify-end">
                                                {record.document_path && (
                                                    <a 
                                                        href={`/storage/${record.document_path}`} 
                                                        target="_blank" 
                                                        className="p-2 text-primary-container hover:bg-primary-container/10 rounded-lg transition-colors" 
                                                        title="View Document"
                                                    >
                                                        <span className="material-symbols-outlined text-[20px]">description</span>
                                                    </a>
                                                )}
                                                <Link 
                                                    href={route('admin.land-records.edit', record.id)} 
                                                    className="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" 
                                                    title="Edit"
                                                >
                                                    <span className="material-symbols-outlined text-[20px]">edit</span>
                                                </Link>
                                                <button 
                                                    onClick={() => handleDelete(record.id)}
                                                    className="p-2 text-error hover:bg-error/10 rounded-lg transition-colors" 
                                                    title="Delete"
                                                >
                                                    <span className="material-symbols-outlined text-[20px]">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="6" className="p-8 text-center font-body-sm italic text-on-surface-variant">No land records found.</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </section>
                
                {/* Pagination */}
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
        </AdminLayout>
    );
}
