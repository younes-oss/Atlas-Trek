<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guide - Atlas Trek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="text-2xl font-bold text-emerald-600 tracking-tight">Atlas Trek</a>
                    <span class="ml-3 text-xs bg-emerald-100 text-emerald-800 py-1 px-2.5 rounded-full font-semibold uppercase tracking-wide hidden sm:inline-block">Guide Portal</span>
                </div>
                <div class="flex items-center space-x-6">
                    <span class="text-sm font-medium text-gray-700 hidden sm:inline-block">Bonjour, {{ Auth::user()->name ?? 'Guide' }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-gray-500 hover:text-red-600 transition flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard</h1>
                <p class="text-gray-500 mt-2 text-lg">Gérez vos visites et suivez vos réservations.</p>
            </div>
            <a href="{{ route('visits.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Nouvelle visite
            </a>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Stat 1 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Total Visites</h3>
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-gray-900">{{ $visits->count() }}</div>
            </div>
            
            <!-- Stat 2 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Réservations</h3>
                    <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-end gap-3">
                    <div class="text-3xl font-extrabold text-gray-900">0</div>
                    <div class="mb-1 text-sm font-medium text-emerald-600 flex items-center bg-emerald-50 px-2 py-0.5 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                        </svg>
                        <span>0%</span>
                    </div>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Revenus</h3>
                    <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-gray-900">0€</div>
            </div>

            <!-- Stat 4 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Avis</h3>
                    <div class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-end gap-2">
                    <div class="text-3xl font-extrabold text-gray-900">0.0<span class="text-lg text-gray-400 font-medium">/5</span></div>
                    <div class="mb-1 text-sm font-medium text-gray-500">(0 avis)</div>
                </div>
            </div>
        </div>

        <!-- Two Columns Layout -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <!-- Left Col: Mes visites -->
            <div class="xl:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Mes visites</h2>
                    <a href="#" class="text-emerald-600 hover:text-emerald-700 text-sm font-semibold transition-colors">Voir tout &rarr;</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($visits as $visit)
                        <!-- Visite Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all duration-300">
                            <div class="h-56 overflow-hidden relative">
                                @if($visit->image)
                                    <img src="{{ asset('storage/' . $visit->image) }}" alt="{{ $visit->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-emerald-600 shadow-sm">
                                    {{ ucfirst($visit->difficulty) }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-xl text-gray-900 mb-1">{{ $visit->title }}</h3>
                                <p class="text-gray-500 text-sm mb-3 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $visit->location }}
                                </p>
                                <p class="text-2xl font-extrabold text-gray-900 mb-5">{{ number_format($visit->price, 2) }}€<span class="text-sm font-medium text-gray-500"> / pers</span></p>
                                <div class="flex gap-3">
                                    <a href="{{ route('visits.edit', $visit) }}" class="flex-1 bg-white border border-gray-200 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all text-center">Modifier</a>
                                    <form action="{{ route('visits.destroy', $visit) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette visite ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-50 text-red-600 px-4 py-2.5 rounded-xl hover:bg-red-100 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center bg-white rounded-2xl border-2 border-dashed border-gray-200">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune visite</h3>
                            <p class="mt-1 text-sm text-gray-500">Commencez par créer votre première proposition de visite.</p>
                            <div class="mt-6">
                                <a href="{{ route('visits.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Nouvelle visite
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Col: Réservations récentes -->
            <div class="xl:col-span-1">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-6 tracking-tight">Réservations récentes</h2>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <ul class="divide-y divide-gray-100">
                        <li class="p-8 text-center text-gray-500">
                            <p class="text-sm">Aucune réservation pour le moment.</p>
                        </li>
                    </ul>
                    <div class="bg-gray-50 px-5 py-4 border-t border-gray-100">
                        <a href="#" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 w-full text-center block transition-colors">Voir toutes les réservations</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
