import React from 'react';
import { Link, Head } from '@inertiajs/react';

export default function About({ auth = { user: null } }) {
    return (
        <div className="bg-surface text-on-surface min-h-screen font-sans">
            <Head title="About Us - Land Records Portal" />
            
            {/* Navbar */}
            <header className="bg-[#002D62] text-white p-4 flex justify-between items-center shadow-lg">
                <div className="flex items-center gap-2">
                    <span className="material-symbols-outlined">domain</span>
                    <h1 className="text-xl font-bold font-h3">Land Records Portal</h1>
                </div>
                <nav className="flex gap-4">
                    <Link href="/" className="hover:underline mt-2">Home</Link>
                    {auth.user ? (
                        <Link href={route('dashboard')} className="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition-all">Dashboard</Link>
                    ) : (
                        <>
                            <Link href={route('login')} className="hover:underline mt-2">Login</Link>
                            <Link href={route('register')} className="bg-white text-[#002D62] px-4 py-2 rounded-lg font-bold hover:bg-gray-100 transition-all">Register</Link>
                        </>
                    )}
                </nav>
            </header>

            {/* About Section */}
            <main className="max-w-7xl mx-auto px-4 py-16">
                <section className="space-y-6 text-center">
                    <h2 className="text-5xl font-h1 text-primary tracking-tight">About <span className="text-primary-container">Land Records Portal</span></h2>
                    <p className="text-lg text-on-surface-variant max-w-3xl mx-auto font-body-lg">
                        The Land Records Portal is a modernized digital platform designed to bring transparency, security, and efficiency to land management. 
                        Our goal is to make it easy for citizens to manage their land records, pay property taxes securely, and request ownership transfers without the hassle of traditional paperwork.
                    </p>
                </section>

                <section className="mt-16 space-y-8">
                    <div className="bg-white p-8 rounded-2xl border border-outline-variant shadow-sm">
                        <h3 className="text-2xl font-h3 mb-4 text-[#002D62]">Our Mission</h3>
                        <p className="text-on-surface-variant font-body-md leading-relaxed">
                            To empower citizens with digital access to their land assets, ensuring records are accurate, tamper-proof, and accessible at any time. We aim to bridge the gap between technology and governance to provide a seamless user experience.
                        </p>
                    </div>

                    <div className="bg-white p-8 rounded-2xl border border-outline-variant shadow-sm">
                        <h3 className="text-2xl font-h3 mb-4 text-[#002D62]">Key Capabilities</h3>
                        <ul className="list-disc list-inside text-on-surface-variant font-body-md space-y-2">
                            <li>Instant access to verified digital land records.</li>
                            <li>Secure online property tax payments with downloadable receipts.</li>
                            <li>Transparent and trackable land ownership transfer requests.</li>
                            <li>Role-based access ensuring data security and privacy.</li>
                        </ul>
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
