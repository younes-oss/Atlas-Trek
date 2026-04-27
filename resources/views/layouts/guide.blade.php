<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Atlas Trek Guide</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-emerald-900 text-white hidden lg:flex flex-col sticky top-0 h-screen">
            <div class="p-6">
                <a href="{{ route('welcome') }}" class="text-2xl font-bold text-white tracking-tight">Atlas Trek</a>
                <p class="text-emerald-400 text-xs font-bold uppercase tracking-widest mt-1">Guide Portal</p>
            </div>
            
            <nav class="flex-grow mt-6 px-4 space-y-2">
                <a href="{{ route('guide.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('guide.dashboard') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('guide.reservations') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('guide.reservations') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium">Réservations</span>
                </a>
                <a href="{{ route('visits.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-emerald-100 hover:bg-emerald-800">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-medium">Nouvelle visite</span>
                </a>
            </nav>

            <div class="p-6 border-t border-emerald-800">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-10 w-10 rounded-full bg-emerald-700 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-emerald-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 justify-center px-4 py-2 bg-emerald-800 hover:bg-red-600 transition-colors rounded-lg text-sm font-bold">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-white border-b border-gray-200 p-4 flex justify-between items-center sticky top-0 z-50">
                <span class="text-xl font-bold text-emerald-600">Atlas Trek</span>
                <button class="p-2 text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </header>

            <div class="p-4 md:p-10">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm animate-pulse">
                        <p class="text-emerald-800 font-medium text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>
