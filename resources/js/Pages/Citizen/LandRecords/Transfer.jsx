import React from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import CitizenLayout from '@/Layouts/CitizenLayout';

export default function Transfer({ record }) {
    const { data, setData, post, processing, errors, progress } = useForm({
        buyer_name: '',
        buyer_cnic: '',
        buyer_email: '',
        transfer_reason: '',
        transfer_document: null,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('citizen.land-records.transfer.store', record.id));
    };

    return (
        <CitizenLayout>
            <Head title="Apply for Ownership Transfer" />
            
            <main className="max-w-2xl mx-auto px-4 pt-6 space-y-6 mb-24">
                <div className="flex items-center gap-4 mb-6">
                    <Link href={route('citizen.land-records.show', record.id)} className="w-10 h-10 flex items-center justify-center rounded-full bg-surface-container hover:bg-surface-container-high transition-colors text-on-surface">
                        <span className="material-symbols-outlined text-[20px]">arrow_back</span>
                    </Link>
                    <div>
                        <h1 className="text-2xl font-bold text-primary">Ownership Transfer</h1>
                        <p className="text-sm text-on-surface-variant">Record: {record.record_number}</p>
                    </div>
                </div>

                <div className="bg-white p-6 rounded-2xl shadow-sm border border-outline-variant">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        
                        <div className="space-y-4 border-b border-outline-variant pb-6">
                            <h3 className="font-h3 text-primary-container text-sm uppercase tracking-tight">Buyer / Transferee Details</h3>
                            
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input 
                                    type="text" 
                                    value={data.buyer_name}
                                    onChange={e => setData('buyer_name', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                    placeholder="Enter buyer's full name"
                                    required
                                />
                                {errors.buyer_name && <p className="text-error text-xs mt-1">{errors.buyer_name}</p>}
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">CNIC / ID Number</label>
                                    <input 
                                        type="text" 
                                        value={data.buyer_cnic}
                                        onChange={e => setData('buyer_cnic', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                        placeholder="e.g. 12345-6789012-3"
                                        required
                                    />
                                    {errors.buyer_cnic && <p className="text-error text-xs mt-1">{errors.buyer_cnic}</p>}
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input 
                                        type="email" 
                                        value={data.buyer_email}
                                        onChange={e => setData('buyer_email', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                        placeholder="buyer@example.com"
                                        required
                                    />
                                    {errors.buyer_email && <p className="text-error text-xs mt-1">{errors.buyer_email}</p>}
                                </div>
                            </div>
                        </div>

                        <div className="space-y-4 border-b border-outline-variant pb-6">
                            <h3 className="font-h3 text-primary-container text-sm uppercase tracking-tight">Transfer Details</h3>
                            
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">Reason for Transfer</label>
                                <textarea 
                                    value={data.transfer_reason}
                                    onChange={e => setData('transfer_reason', e.target.value)}
                                    rows="3"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                    placeholder="Briefly describe the reason for this transfer (e.g., Sale, Gift, Inheritance)"
                                    required
                                ></textarea>
                                {errors.transfer_reason && <p className="text-error text-xs mt-1">{errors.transfer_reason}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">Supporting Document (PDF, JPG, PNG)</label>
                                <input 
                                    type="file" 
                                    onChange={e => setData('transfer_document', e.target.files[0])}
                                    className="mt-1 block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-primary-container/10 file:text-primary
                                      hover:file:bg-primary-container/20
                                      border border-gray-300 rounded-md p-2"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    required
                                />
                                {progress && (
                                    <progress value={progress.percentage} max="100">
                                        {progress.percentage}%
                                    </progress>
                                )}
                                {errors.transfer_document && <p className="text-error text-xs mt-1">{errors.transfer_document}</p>}
                            </div>
                        </div>

                        <div className="flex justify-end gap-3 pt-4">
                            <Link 
                                href={route('citizen.land-records.show', record.id)}
                                className="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors"
                            >
                                Cancel
                            </Link>
                            <button 
                                type="submit" 
                                disabled={processing}
                                className="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium transition-colors disabled:opacity-70 disabled:cursor-not-allowed flex items-center gap-2"
                            >
                                {processing && <span className="material-symbols-outlined animate-spin text-[18px]">sync</span>}
                                Submit Transfer Request
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </CitizenLayout>
    );
}
