<header class="bg-[#002D62] dark:bg-slate-900 text-white font-public-sans font-bold text-lg docked full-width top-0 border-b border-white/10 shadow-sm transition-colors duration-200 fixed z-50 flex justify-between items-center w-full px-4 h-14">
    <div class="flex items-center gap-3">
        <button class="hover:bg-white/10 p-2 rounded-lg transition-colors">
            <span class="material-symbols-outlined" data-icon="menu">menu</span>
        </button>
        <a href="{{ route('dashboard') }}" class="text-white font-bold tracking-tight mr-4">Admin Portal</a>
        
        @if(auth()->check() && auth()->user()->role === 'admin')
        <nav class="hidden md:flex items-center gap-1">
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-1 rounded-lg font-label-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">Dashboard</a>
            <a href="{{ route('admin.land-records.index') }}" class="px-3 py-1 rounded-lg font-label-md transition-colors {{ request()->routeIs('admin.land-records.*') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">Land Records</a>
            <a href="{{ route('admin.taxes.index') }}" class="px-3 py-1 rounded-lg font-label-md transition-colors {{ request()->routeIs('admin.taxes.*') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">Taxes</a>
            <a href="{{ route('admin.transfers.index') }}" class="px-3 py-1 rounded-lg font-label-md transition-colors {{ request()->routeIs('admin.transfers.*') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">Transfers</a>
        </nav>
        @endif
    </div>
    <div class="flex items-center gap-4">
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="font-label-md text-white border border-white/30 px-3 py-1.5 rounded-lg hover:bg-white/10 transition-colors">
                    Logout
                </button>
            </form>
            <div class="w-8 h-8 rounded-full bg-primary-fixed-dim flex items-center justify-center overflow-hidden border border-white/20">
                <img alt="User Profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD5OD1uJVf78jLxybbn2YhRClXFzSGz4k2LO7rXiEOP8SbNMWh5hSQfsUMm5RKwnX024OSl_hu8kv-UeLsgqn6OXNH1ABrmRPjP8lT62fsj2x2Us3FyX0TGb6_MXzxBaDAK08yC9QRXZiKs8UuD711oz33-iU6yajdeYoB77RgkNJo6EanzwD27ftz1p31A-Qj9_KemtnXA-iBOuZ4yK46aYnUz0V35-fUYtIbL0q8JODNYcZh9s4vAaImAOODudEwIb9pnogccYw"/>
            </div>
        @else
            <a href="{{ route('login') }}" class="font-label-md text-white border border-white/30 px-3 py-1.5 rounded-lg hover:bg-white/10 transition-colors">
                Login
            </a>
            <a href="{{ route('register') }}" class="font-label-md text-white bg-white/10 border border-white/30 px-3 py-1.5 rounded-lg hover:bg-white/20 transition-colors">
                Register
            </a>
        @endauth
    </div>
</header>
