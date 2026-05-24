<nav class="fixed bottom-0 left-0 w-full flex justify-around items-center h-16 bg-white dark:bg-slate-900 z-50 border-t border-gray-200 dark:border-slate-800 shadow-[0_-2px_10px_rgba(0,0,0,0.05)] font-public-sans text-[11px] font-medium">
    @if(auth()->check() && auth()->user()->role == 'admin')
        <a class="flex flex-col items-center justify-center text-[#002D62] dark:text-blue-400 font-bold scale-95 active:scale-90 transition-transform" href="{{ route('admin.dashboard') }}">
            <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a class="flex flex-col items-center justify-center text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800 transition-all" href="{{ route('admin.land-records.index') }}">
            <span class="material-symbols-outlined" data-icon="description">description</span>
            <span>Records</span>
        </a>
        <a class="flex flex-col items-center justify-center text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800 transition-all" href="{{ route('admin.taxes.index') }}">
            <span class="material-symbols-outlined" data-icon="payments">payments</span>
            <span>Tax & Bills</span>
        </a>
        <a class="flex flex-col items-center justify-center text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800 transition-all" href="{{ route('admin.transfers.index') }}">
            <span class="material-symbols-outlined" data-icon="swap_horiz">swap_horiz</span>
            <span>Transfers</span>
        </a>
    @else
        <a class="flex flex-col items-center justify-center text-[#002D62] dark:text-blue-400 font-bold scale-95 active:scale-90 transition-transform" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a class="flex flex-col items-center justify-center text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800 transition-all" href="{{ route('citizen.land-records.index') }}">
            <span class="material-symbols-outlined" data-icon="description">description</span>
            <span>Records</span>
        </a>
        <a class="flex flex-col items-center justify-center text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800 transition-all" href="{{ route('citizen.payments') }}">
            <span class="material-symbols-outlined" data-icon="payments">payments</span>
            <span>Payments</span>
        </a>
        <a class="flex flex-col items-center justify-center text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800 transition-all" href="{{ route('profile.edit') }}">
            <span class="material-symbols-outlined" data-icon="person">person</span>
            <span>Profile</span>
        </a>
    @endif
</nav>
