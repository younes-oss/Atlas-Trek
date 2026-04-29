<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $visit->title }} - Atlas Trek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .prose p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }
    </style>
</head>
<body class="bg-[#F9FAFB] text-gray-900">
    <!-- Navbar -->
    <nav class="glass-nav border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-black text-emerald-600 tracking-tighter flex items-center gap-2">
                        <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        Atlas Trek
                    </a>
                </div>
                <div class="flex space-x-8 items-center">
                    <a href="/" class="text-gray-500 font-semibold hover:text-emerald-600 transition-all text-sm uppercase tracking-widest">Accueil</a>
                    @auth
                        <a href="{{ route('home') }}" class="bg-gray-900 text-white px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-gray-200">Mon Espace</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-900 font-bold text-sm">Connexion</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Hero Section -->
        <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl mb-12 group">
            <div class="h-[500px] w-full">
                @if($visit->image)
                    <img src="{{ asset('storage/' . $visit->image) }}" alt="{{ $visit->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center">
                        <svg class="h-32 w-32 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
            </div>
            
            <div class="absolute bottom-10 left-10 right-10">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="bg-emerald-500 text-white px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-[0.2em] shadow-lg shadow-emerald-500/30">
                        {{ $visit->difficulty }}
                    </span>
                    <span class="bg-white/20 backdrop-blur-md text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest border border-white/20">
                        {{ $visit->location }}
                    </span>
                </div>
                <h1 class="text-5xl md:text-6xl font-black text-white tracking-tighter">{{ $visit->title }}</h1>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <!-- Details Column -->
            <div class="lg:col-span-8">
                @if(session('success'))
                    <div class="mb-10 bg-emerald-50 border-l-8 border-emerald-500 p-6 rounded-2xl shadow-sm animate-bounce">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-lg font-bold text-emerald-900">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Key Info Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm text-center">
                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-[10px] uppercase font-black text-gray-400 tracking-widest">Durée</p>
                        <p class="font-extrabold text-gray-900">{{ $visit->duration }}h</p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm text-center">
                        <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                        </div>
                        <p class="text-[10px] uppercase font-black text-gray-400 tracking-widest">Lieu</p>
                        <p class="font-extrabold text-gray-900 truncate px-2">{{ $visit->location }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm text-center">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-[10px] uppercase font-black text-gray-400 tracking-widest">Difficulté</p>
                        <p class="font-extrabold text-gray-900">{{ ucfirst($visit->difficulty) }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm text-center">
                        <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <p class="text-[10px] uppercase font-black text-gray-400 tracking-widest">Groupe</p>
                        <p class="font-extrabold text-gray-900">Max {{ $visit->max_places }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-12">
                    <h2 class="text-3xl font-black text-gray-900 mb-8 tracking-tighter">À propos de cette visite</h2>
                    <div class="prose prose-emerald max-w-none text-gray-600 text-lg leading-relaxed">
                        {!! nl2br(e($visit->description)) !!}
                    </div>
                </div>

                <!-- Guide Section -->
                <div class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-sm flex flex-col md:flex-row items-center gap-8">
                    <div class="relative">
                        <div class="h-24 w-24 rounded-[2rem] bg-emerald-600 flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-emerald-200">
                            {{ substr($visit->user->name, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-emerald-500 text-white p-1.5 rounded-full border-4 border-white">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-emerald-600 font-black uppercase tracking-widest text-[10px] mb-1">Votre guide local</p>
                        <h3 class="text-3xl font-black text-gray-900 tracking-tighter mb-2">{{ $visit->user->name }}</h3>
                        <p class="text-gray-500 font-medium max-w-md leading-relaxed">Expert local passionné par les montagnes de l'Atlas. Prêt à vous faire découvrir les secrets les mieux gardés de notre région.</p>
                    </div>
                </div>
            </div>

            <!-- Booking Column -->
            <div class="lg:col-span-4">
                @php
                    $totalReserved = $visit->reservations()->where('status', 'confirmé')->sum('number_of_people');
                    $remainingPlaces = $visit->max_places - $totalReserved;
                    $isFull = $remainingPlaces <= 0;
                @endphp

                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200 border border-gray-100 p-10 sticky top-28">
                    <div class="mb-6 text-center">
                        @if($isFull)
                            <span class="inline-block px-4 py-1.5 rounded-full bg-red-100 text-red-600 text-[10px] font-black uppercase tracking-widest mb-4">Complet</span>
                        @else
                            <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-black uppercase tracking-widest mb-4">Disponible : {{ $remainingPlaces }} places</span>
                        @endif

                        <p class="text-gray-400 font-bold uppercase tracking-widest text-xs mb-2">Prix par personne</p>
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-5xl font-black text-emerald-600 tracking-tighter">{{ number_format($visit->price, 0) }}</span>
                            <span class="text-2xl font-black text-gray-900 uppercase">MAD</span>
                        </div>
                    </div>

                    <form action="{{ route('visits.reserve', $visit) }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Date de l'aventure</label>
                                <div class="relative">
                                    <input type="date" id="date" name="date" required min="{{ date('Y-m-d') }}" {{ $isFull ? 'disabled' : '' }}
                                        class="w-full pl-12 pr-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-0 outline-none transition-all font-bold text-gray-900 {{ $isFull ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                @error('date')
                                    <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="number_of_people" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Nombre d'explorateurs</label>
                                <div class="relative">
                                    <select id="number_of_people" name="number_of_people" required {{ $isFull ? 'disabled' : '' }}
                                        class="w-full pl-12 pr-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-0 outline-none transition-all appearance-none font-bold text-gray-900 {{ $isFull ? 'opacity-50 cursor-not-allowed' : '' }}">
                                        @for($i = 1; $i <= min($visit->max_places, $remainingPlaces); $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}</option>
                                        @endfor
                                    </select>
                                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                                @error('number_of_people')
                                    <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" {{ $isFull ? 'disabled' : '' }}
                            class="w-full bg-emerald-600 hover:bg-gray-900 text-white px-8 py-5 rounded-[2rem] font-black text-lg shadow-xl shadow-emerald-200 hover:shadow-gray-200 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 {{ $isFull ? 'opacity-50 cursor-not-allowed bg-gray-400' : '' }}">
                            {{ $isFull ? 'Complet' : 'Réserver maintenant' }}
                            @if(!$isFull)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            @endif
                        </button>
                    </form>

                    <div class="mt-8 pt-8 border-t border-gray-50 flex items-center justify-center gap-6">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mb-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">Paiement sécurisé</span>
                        </div>
                        <div class="flex flex-col items-center text-center">
                            <div class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mb-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">Annulation gratuite</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer Space -->
    <div class="h-20"></div>
</body>
</html>
