import React from 'react';
import { Link, Head } from '@inertiajs/react';

export default function Welcome({ auth = { user: null } }) {
    return (
        <div className="bg-surface text-on-surface min-h-screen font-sans">
            <Head title="Welcome to Land Records Portal" />
            
            {/* Navbar */}
            <header className="bg-[#002D62] text-white p-4 flex justify-between items-center shadow-lg">
                <div className="flex items-center gap-2">
                    <span className="material-symbols-outlined">domain</span>
                    <h1 className="text-xl font-bold font-h3">Land Records Portal</h1>
                </div>
                <nav className="flex gap-4">
                    {auth.user ? (
                        <Link href={route('dashboard')} className="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition-all">Dashboard</Link>
                    ) : (
                        <>
                            <Link href={route('login')} className="hover:underline">Login</Link>
                            <Link href={route('register')} className="bg-white text-[#002D62] px-4 py-2 rounded-lg font-bold hover:bg-gray-100 transition-all">Register</Link>
                        </>
                    )}
                </nav>
            </header>

            {/* Hero Section */}
            <main className="max-w-7xl mx-auto px-4 py-16 text-center">
                <section className="space-y-6">
                    <h2 className="text-5xl font-h1 text-primary tracking-tight">Secure & Transparent <br/><span className="text-primary-container">Land Management</span></h2>
                    <p className="text-lg text-on-surface-variant max-w-2xl mx-auto font-body-lg">
                        Easily manage land records, pay property taxes, and initiate ownership transfers with our modern digital platform.
                    </p>
                    <div className="flex justify-center gap-4 mt-8">
                        <Link href={route('register')} className="bg-primary-container text-white px-8 py-3 rounded-xl text-lg font-bold hover:shadow-xl transition-all active:scale-95">Get Started</Link>
                        <Link href="/about" className="border border-primary-container text-primary-container px-8 py-3 rounded-xl text-lg font-bold hover:bg-surface-container-low transition-all">Learn More</Link>
                    </div>
                </section>

                {/* Features */}
                <section className="grid grid-cols-1 md:grid-cols-3 gap-8 mt-24">
                    <div className="bg-white p-8 rounded-2xl border border-outline-variant shadow-sm hover:shadow-md transition-all">
                        <div className="w-12 h-12 bg-primary-fixed rounded-full flex items-center justify-center text-primary mb-4 mx-auto">
                            <span className="material-symbols-outlined">verified_user</span>
                        </div>
                        <h3 className="text-xl font-h3 mb-2">Verified Records</h3>
                        <p className="text-on-surface-variant font-body-sm">Access your digitally signed and verified land ownership documents anytime.</p>
                    </div>
                    <div className="bg-white p-8 rounded-2xl border border-outline-variant shadow-sm hover:shadow-md transition-all">
                        <div className="w-12 h-12 bg-secondary-container rounded-full flex items-center justify-center text-on-secondary-container mb-4 mx-auto">
                            <span className="material-symbols-outlined">payments</span>
                        </div>
                        <h3 className="text-xl font-h3 mb-2">Tax Payments</h3>
                        <p className="text-on-surface-variant font-body-sm">Pay property taxes online and download instant receipts for your records.</p>
                    </div>
                    <div className="bg-white p-8 rounded-2xl border border-outline-variant shadow-sm hover:shadow-md transition-all">
                        <div className="w-12 h-12 bg-error-container rounded-full flex items-center justify-center text-on-error-container mb-4 mx-auto">
                            <span className="material-symbols-outlined">swap_horiz</span>
                        </div>
                        <h3 className="text-xl font-h3 mb-2">Easy Transfer</h3>
                        <p className="text-on-surface-variant font-body-sm">Initiate and track land ownership transfer requests with full transparency.</p>
                    </div>
                </section>
            </main>

            {/* Footer */}
            <footer className="bg-surface-container border-t border-outline-variant py-12 mt-24">
                <div className="max-w-7xl mx-auto px-4 text-center text-on-surface-variant">
                    <p className="font-label-md">© 2026 Land Records Portal. All rights reserved.</p>
                </div>
            </footer>
        </div>
    );
}
