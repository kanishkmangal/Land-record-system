<footer class="bg-[#F5F7F9] dark:bg-slate-950 text-gray-600 dark:text-slate-400 font-public-sans text-[10px] uppercase tracking-wider w-full pb-20 border-t border-gray-200 dark:border-slate-900 flat no shadows w-full p-6 flex flex-col items-center gap-4">
    <div class="flex gap-6 mb-2">
        <a class="no-underline hover:text-[#002D62] dark:hover:text-white opacity-80 hover:opacity-100 transition-colors" href="{{ route('privacy') }}">Privacy</a>
        <a class="no-underline hover:text-[#002D62] dark:hover:text-white opacity-80 hover:opacity-100 transition-colors" href="{{ route('security') }}">Security</a>
        <a class="no-underline hover:text-[#002D62] dark:hover:text-white opacity-80 hover:opacity-100 transition-colors" href="{{ route('terms') }}">Terms</a>
    </div>
    <p class="text-center">© {{ date('Y') }} Government Land Dept.</p>
    <div class="flex items-center gap-2 mt-2 opacity-50">
        <span class="material-symbols-outlined text-sm" data-icon="account_balance">account_balance</span>
        <span>Official State Resource</span>
    </div>
</footer>
