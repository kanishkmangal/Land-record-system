import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function AdminLayout({ children }) {
    const { auth = { user: null } } = usePage().props;
    const [isSidebarOpen, setIsSidebarOpen] = useState(false);

    const toggleSidebar = () => setIsSidebarOpen(!isSidebarOpen);

    const navLinks = [
        { name: 'Dashboard', href: route('admin.dashboard'), icon: 'dashboard', active: route().current('admin.dashboard') },
        { name: 'Land Records', href: route('admin.land-records.index'), icon: 'domain', active: route().current('admin.land-records.*') },
        { name: 'Taxes', href: route('admin.taxes.index'), icon: 'payments', active: route().current('admin.taxes.*') },
        { name: 'Transfers', href: route('admin.transfers.index'), icon: 'swap_horiz', active: route().current('admin.transfers.*') },
    ];

    return (
        <div className="bg-surface text-on-surface min-h-screen">
            {/* Navbar */}
            <header className="bg-[#002D62] dark:bg-slate-900 text-white font-public-sans font-bold text-lg fixed top-0 left-0 right-0 z-50 flex justify-between items-center w-full px-4 h-14 border-b border-white/10 shadow-sm transition-colors duration-200">
                <div className="flex items-center gap-3">
                    <button onClick={toggleSidebar} className="hover:bg-white/10 p-2 rounded-lg transition-colors">
                        <span className="material-symbols-outlined">menu</span>
                    </button>
                    <Link href={route('dashboard')} className="text-white font-bold tracking-tight mr-4">Admin Portal</Link>
                    
                    <nav className="hidden md:flex items-center gap-1">
                        {navLinks.map((link) => (
                            <Link 
                                key={link.name}
                                href={link.href} 
                                className={`px-3 py-1 rounded-lg font-label-md transition-colors ${link.active ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white'}`}
                            >
                                {link.name}
                            </Link>
                        ))}
                    </nav>
                </div>
                <div className="flex items-center gap-4">
                    {auth.user ? (
                        <>
                            <Link 
                                href={route('logout')} 
                                method="post" 
                                as="button" 
                                className="hidden sm:block font-label-md text-white border border-white/30 px-3 py-1.5 rounded-lg hover:bg-white/10 transition-colors"
                            >
                                Logout
                            </Link>
                            <div className="w-8 h-8 rounded-full bg-primary-fixed-dim flex items-center justify-center overflow-hidden border border-white/20">
                                <img alt="User Profile" className="w-full h-full object-cover" src="https://ui-avatars.com/api/?name=Admin&background=random"/>
                            </div>
                        </>
                    ) : (
                        <Link href={route('login')} className="font-label-md text-white border border-white/30 px-3 py-1.5 rounded-lg hover:bg-white/10 transition-colors">
                            Login
                        </Link>
                    )}
                </div>
            </header>

            {/* Sidebar Overlay */}
            {isSidebarOpen && (
                <div 
                    className="fixed inset-0 bg-black/50 z-[60] transition-opacity"
                    onClick={toggleSidebar}
                ></div>
            )}

            {/* Sidebar */}
            <aside className={`fixed top-0 left-0 bottom-0 w-64 bg-white dark:bg-slate-900 z-[70] transform transition-transform duration-300 ease-in-out shadow-2xl ${isSidebarOpen ? 'translate-x-0' : '-translate-x-full'}`}>
                <div className="bg-[#002D62] p-4 text-white flex justify-between items-center h-14">
                    <span className="font-bold">Admin Menu</span>
                    <button onClick={toggleSidebar} className="hover:bg-white/10 p-1 rounded">
                        <span className="material-symbols-outlined">close</span>
                    </button>
                </div>
                <nav className="p-4 space-y-2">
                    {navLinks.map((link) => (
                        <Link 
                            key={link.name}
                            href={link.href} 
                            onClick={() => setIsSidebarOpen(false)}
                            className={`flex items-center gap-3 p-3 rounded-xl font-label-md transition-all ${link.active ? 'bg-primary-container text-white shadow-md' : 'text-on-surface-variant hover:bg-surface-container-low'}`}
                        >
                            <span className="material-symbols-outlined">{link.icon}</span>
                            {link.name}
                        </Link>
                    ))}
                    <div className="pt-4 mt-4 border-t border-outline-variant">
                        <Link 
                            href={route('logout')} 
                            method="post" 
                            as="button" 
                            className="flex items-center gap-3 p-3 w-full rounded-xl font-label-md text-error hover:bg-error-container/10 transition-all"
                        >
                            <span className="material-symbols-outlined">logout</span>
                            Logout
                        </Link>
                    </div>
                </nav>
            </aside>

            {/* Desktop Side Nav (Visible on Desktop, hidden on Mobile) */}
            <div className="flex min-h-screen">
                <main className="flex-1 pt-14 pb-20">
                    {children}
                </main>
            </div>

            {/* Bottom Nav (Mobile Only) */}
            <nav className="fixed bottom-0 left-0 right-0 bg-white dark:bg-slate-900 border-t border-outline-variant h-16 flex justify-around items-center px-2 z-50 md:hidden shadow-[0_-2px_10px_rgba(0,0,0,0.05)]">
                {navLinks.map((link) => (
                    <Link 
                        key={link.name}
                        href={link.href} 
                        className={`flex flex-col items-center gap-1 transition-all ${link.active ? 'text-primary-container scale-105' : 'text-on-surface-variant opacity-70 hover:opacity-100'}`}
                    >
                        <span className="material-symbols-outlined">{link.icon}</span>
                        <span className="text-[10px] font-bold uppercase">{link.name.split(' ')[0]}</span>
                    </Link>
                ))}
            </nav>
        </div>
    );
}
