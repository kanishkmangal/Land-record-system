import React from 'react';
import { Head, Link, useForm, usePage, router } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

export default function Edit({ record, users }) {
    const { data, setData, post, processing, errors } = useForm({
        _method: 'PUT',
        owner_id: record.owner_id || '',
        record_number: record.record_number,
        land_type: record.land_type,
        plot_number: record.plot_number,
        survey_number: record.survey_number,
        area_sqft: record.area_sqft,
        status: record.status,
        location: record.location,
        district: record.district,
        state: record.state,
        document: null,
    });

    const submit = (e) => {
        e.preventDefault();
        // Since we have a file upload, we use post with _method: 'PUT' for multipart compatibility
        post(route('admin.land-records.update', record.id));
    };

    return (
        <AdminLayout>
            <Head title={`Edit Record ${record.record_number}`} />
            
            <main className="max-w-xl mx-auto p-4 md:p-6 space-y-6 mb-24 mt-6">
                <section className="border-b border-outline-variant pb-4">
                    <h2 className="font-h2 text-h2 text-primary">Edit Land Record</h2>
                    <p className="font-body-sm text-on-surface-variant">Update the details for {record.record_number}</p>
                </section>

                <section className="bg-white border border-outline-variant rounded-xl p-6 shadow-sm">
                    <form onSubmit={submit} className="space-y-4">
                        <div className="grid grid-cols-2 gap-4">
                            <div className="col-span-2">
                                <label className="block font-label-md text-on-surface-variant mb-1">Owner (Citizen)</label>
                                <select 
                                    value={data.owner_id}
                                    onChange={e => setData('owner_id', e.target.value)}
                                    required 
                                    className="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md bg-white"
                                >
                                    <option value="" disabled>Select an owner...</option>
                                    {users.map(user => (
                                        <option key={user.id} value={user.id}>{user.name} ({user.email})</option>
                                    ))}
                                </select>
                                {errors.owner_id && <div className="text-error text-xs mt-1">{errors.owner_id}</div>}
                            </div>

                            <div>
                                <label className="block font-label-md text-on-surface-variant mb-1">Record Number</label>
                                <input 
                                    value={data.record_number}
                                    readOnly
                                    className="w-full h-11 px-4 rounded-lg border border-outline-variant bg-surface-container-low text-on-surface-variant outline-none font-body-md" 
                                    type="text"
                                />
                            </div>

                            <div>
                                <label className="block font-label-md text-on-surface-variant mb-1">Land Type</label>
                                <select 
                                    value={data.land_type}
                                    onChange={e => setData('land_type', e.target.value)}
                                    required 
                                    className="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md bg-white"
                                >
                                    <option value="residential">Residential</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="agricultural">Agricultural</option>
                                    <option value="industrial">Industrial</option>
                                </select>
                                {errors.land_type && <div className="text-error text-xs mt-1">{errors.land_type}</div>}
                            </div>

                            <div>
                                <label className="block font-label-md text-on-surface-variant mb-1">Plot Number</label>
                                <input 
                                    value={data.plot_number}
                                    onChange={e => setData('plot_number', e.target.value)}
                                    required 
                                    className="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" 
                                    type="text"
                                />
                                {errors.plot_number && <div className="text-error text-xs mt-1">{errors.plot_number}</div>}
                            </div>

                            <div>
                                <label className="block font-label-md text-on-surface-variant mb-1">Survey Number</label>
                                <input 
                                    value={data.survey_number}
                                    onChange={e => setData('survey_number', e.target.value)}
                                    required 
                                    className="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" 
                                    type="text"
                                />
                                {errors.survey_number && <div className="text-error text-xs mt-1">{errors.survey_number}</div>}
                            </div>

                            <div>
                                <label className="block font-label-md text-on-surface-variant mb-1">Area (SqFt)</label>
                                <input 
                                    value={data.area_sqft}
                                    onChange={e => setData('area_sqft', e.target.value)}
                                    required 
                                    className="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" 
                                    type="number" 
                                    step="0.01"
                                />
                                {errors.area_sqft && <div className="text-error text-xs mt-1">{errors.area_sqft}</div>}
                            </div>

                            <div>
                                <label className="block font-label-md text-on-surface-variant mb-1">Status</label>
                                <select 
                                    value={data.status}
                                    onChange={e => setData('status', e.target.value)}
                                    required 
                                    className="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md bg-white"
                                >
                                    <option value="active">Active</option>
                                    <option value="transferred">Transferred</option>
                                    <option value="disputed">Disputed</option>
                                </select>
                                {errors.status && <div className="text-error text-xs mt-1">{errors.status}</div>}
                            </div>

                            <div className="col-span-2">
                                <label className="block font-label-md text-on-surface-variant mb-1">Location Address</label>
                                <input 
                                    value={data.location}
                                    onChange={e => setData('location', e.target.value)}
                                    required 
                                    className="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" 
                                    type="text"
                                />
                                {errors.location && <div className="text-error text-xs mt-1">{errors.location}</div>}
                            </div>

                            <div>
                                <label className="block font-label-md text-on-surface-variant mb-1">District</label>
                                <input 
                                    value={data.district}
                                    onChange={e => setData('district', e.target.value)}
                                    required 
                                    className="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" 
                                    type="text"
                                />
                                {errors.district && <div className="text-error text-xs mt-1">{errors.district}</div>}
                            </div>

                            <div>
                                <label className="block font-label-md text-on-surface-variant mb-1">State</label>
                                <input 
                                    value={data.state}
                                    onChange={e => setData('state', e.target.value)}
                                    required 
                                    className="w-full h-11 px-4 rounded-lg border border-outline-variant focus:border-2 focus:border-primary-container outline-none transition-all font-body-md" 
                                    type="text"
                                />
                                {errors.state && <div className="text-error text-xs mt-1">{errors.state}</div>}
                            </div>

                            <div className="col-span-2 mt-2">
                                <label className="block font-label-md text-on-surface-variant mb-1">Update Title Deed Document (Optional)</label>
                                {record.document_path && (
                                    <div className="mb-2 p-2 bg-surface-container-low rounded flex items-center gap-2 text-label-sm">
                                        <span className="material-symbols-outlined text-primary text-[16px]">draft</span>
                                        Current file: <a href={`/storage/${record.document_path}`} target="_blank" className="text-primary hover:underline">View Document</a>
                                    </div>
                                )}
                                <input 
                                    onChange={e => setData('document', e.target.files[0])}
                                    type="file" 
                                    className="w-full px-4 py-3 rounded-lg border border-outline-variant border-dashed focus:border-primary-container outline-none transition-all font-body-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-container file:text-white hover:file:bg-primary"
                                />
                                {errors.document && <div className="text-error text-xs mt-1">{errors.document}</div>}
                            </div>
                        </div>

                        <div className="mt-8 flex items-center justify-end gap-3 pt-4 border-t border-outline-variant">
                            <Link 
                                href={route('admin.land-records.index')} 
                                className="px-5 py-2.5 rounded-lg font-label-md text-on-surface-variant hover:bg-surface-container-low transition-colors"
                            >
                                Cancel
                            </Link>
                            <button 
                                type="submit" 
                                disabled={processing}
                                className="bg-primary text-white px-6 py-2.5 rounded-lg font-label-md hover:opacity-90 active:scale-95 transition-all shadow-md"
                            >
                                {processing ? 'Updating...' : 'Update Record'}
                            </button>
                        </div>
                    </form>
                </section>
            </main>
        </AdminLayout>
    );
}
