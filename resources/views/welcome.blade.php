<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlas Trek - Découvrez la magie de l'Atlas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .animate-fade-in {
            animation: fadeIn 1.2s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-[#F9FAFB] text-gray-900 antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Navbar Sticky -->
    <nav class="glass-nav fixed w-full top-0 z-50 border-b border-white/20 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center group cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <span class="ml-3 text-2xl font-black text-gray-900 tracking-tighter group-hover:text-emerald-600 transition-colors">Atlas Trek</span>
                </div>

                <!-- Liens & Auth -->
                <div class="flex items-center gap-8">
                    <div class="hidden md:flex items-center gap-6">
                        <a href="#tours" class="text-sm font-bold text-gray-500 hover:text-gray-900 uppercase tracking-widest relative group">
                            Destinations
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-emerald-500 transition-all group-hover:w-full"></span>
                        </a>
                        <a href="#why-us" class="text-sm font-bold text-gray-500 hover:text-gray-900 uppercase tracking-widest relative group">
                            Pourquoi nous
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-emerald-500 transition-all group-hover:w-full"></span>
                        </a>
                    </div>

                    @auth
                        <div class="flex items-center gap-4 pl-4 border-l border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-black border-2 border-white shadow-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-xs font-black uppercase tracking-widest text-emerald-600">{{ auth()->user()->role }}</p>
                                    <p class="text-sm font-bold text-gray-900 leading-tight">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <a href="{{ route('home') }}" class="bg-gray-900 hover:bg-emerald-600 text-white px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-colors shadow-lg shadow-gray-200">
                                Mon Espace
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-4 pl-4 border-l border-gray-200">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-900 hover:text-emerald-600 transition-colors">Connexion</a>
                            <a href="{{ route('register') }}" class="bg-emerald-600 hover:bg-gray-900 text-white px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-emerald-200 hover:shadow-gray-200 active:scale-95">S'inscrire</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section Moderne -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-[#F9FAFB] to-teal-50 -z-10"></div>
        <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-[800px] h-[800px] bg-emerald-400/20 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-[600px] h-[600px] bg-teal-400/20 rounded-full blur-3xl -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center animate-fade-in">
            <span class="inline-block py-1.5 px-4 rounded-full bg-emerald-100 text-emerald-700 text-xs font-black uppercase tracking-[0.2em] mb-6 shadow-sm">
                L'aventure commence ici
            </span>
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-black text-gray-900 tracking-tighter mb-8 leading-tight">
                Découvrez la majesté <br> de <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-600">l'Atlas Marocain</span>
            </h1>
            <p class="max-w-2xl mx-auto text-lg md:text-xl text-gray-500 font-medium mb-12 leading-relaxed">
                Rejoignez nos guides locaux passionnés pour des randonnées inoubliables. Des sommets enneigés du Toubkal aux vallées secrètes, vivez une expérience authentique.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#tours" class="w-full sm:w-auto bg-emerald-600 hover:bg-gray-900 text-white px-8 py-4 rounded-[2rem] font-black text-lg shadow-xl shadow-emerald-200 hover:shadow-gray-200 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                    Explorer les visites
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Section Pourquoi Nous (NOUVEAU) -->
    <div id="why-us" class="py-24 bg-white relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter mb-4">Pourquoi choisir Atlas Trek ?</h2>
                <p class="text-gray-500 text-lg">Une expérience conçue pour votre confort et votre sécurité.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Card 1 -->
                <div class="bg-[#F9FAFB] rounded-[2.5rem] p-10 border border-gray-100 hover:shadow-xl transition-shadow group">
                    <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">Guides Certifiés</h3>
                    <p class="text-gray-500 leading-relaxed">Tous nos guides sont des locaux experts de la région, certifiés pour assurer votre sécurité en montagne.</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-[#F9FAFB] rounded-[2.5rem] p-10 border border-gray-100 hover:shadow-xl transition-shadow group relative overflow-hidden">
                    <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mb-6 group-hover:bg-amber-500 group-hover:text-white transition-colors relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3 relative z-10">Expériences Uniques</h3>
                    <p class="text-gray-500 leading-relaxed relative z-10">Des itinéraires hors des sentiers battus pour découvrir l'authenticité des villages berbères.</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-[#F9FAFB] rounded-[2.5rem] p-10 border border-gray-100 hover:shadow-xl transition-shadow group">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">Réservation Facile</h3>
                    <p class="text-gray-500 leading-relaxed">Réservez votre aventure en quelques clics. Paiement sur place, annulation gratuite.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Tours -->
    <div id="tours" class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter mb-4">Destinations Populaires</h2>
                    <p class="text-gray-500 text-lg">Choisissez votre prochaine aventure.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($visits as $visit)
                    <div class="bg-white rounded-[2rem] border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full relative">
                        
                        <!-- Badge Top/Populaire -->
                        @if($loop->first)
                            <div class="absolute top-4 left-4 z-10 bg-amber-400 text-amber-950 px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest shadow-lg">
                                Top Choix
                            </div>
                        @endif

                        <div class="h-64 relative overflow-hidden">
                            @if($visit->image)
                                <img src="{{ asset('storage/' . $visit->image) }}" alt="{{ $visit->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-emerald-50 flex items-center justify-center">
                                    <svg class="h-16 w-16 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-80"></div>
                            
                            <!-- Prix flottant -->
                            <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-xl font-black text-gray-900 shadow-lg">
                                {{ number_format($visit->price, 0) }} MAD
                            </div>
                            
                            <!-- Bouton Favori -->
                            @auth
                                <form action="{{ route('favorites.toggle', $visit) }}" method="POST" class="absolute top-4 right-4 z-10">
                                    @csrf
                                    <button type="submit" class="w-10 h-10 rounded-full bg-white/80 backdrop-blur-md flex items-center justify-center hover:bg-white transition-colors shadow-lg">
                                        @if($visit->isFavoritedBy(auth()->user()))
                                            <!-- Coeur plein -->
                                            <svg class="w-6 h-6 text-red-500 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        @else
                                            <!-- Coeur vide -->
                                            <svg class="w-6 h-6 text-gray-600 hover:text-red-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                            @endauth
                        </div>

                        <div class="p-8 flex-grow flex flex-col">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-lg bg-gray-100 text-gray-600">
                                    📍 {{ Str::limit($visit->location, 15) }}
                                </span>
                                <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-lg {{ $visit->difficulty === 'facile' ? 'bg-emerald-100 text-emerald-700' : ($visit->difficulty === 'moyen' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $visit->difficulty }}
                                </span>
                            </div>

                            <h3 class="text-2xl font-black text-gray-900 mb-2 tracking-tighter leading-tight">{{ $visit->title }}</h3>
                            
                            <p class="text-gray-500 mb-6 flex-grow line-clamp-2 leading-relaxed">
                                {{ $visit->description }}
                            </p>

                            <div class="flex items-center gap-4 mt-auto pt-6 border-t border-gray-50">
                                <a href="{{ route('visits.show', $visit) }}" class="flex-grow bg-gray-900 hover:bg-emerald-600 text-white text-center py-3.5 rounded-xl font-bold transition-colors">
                                    Voir les détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Section Témoignages (NOUVEAU) -->
    @if(isset($reviews) && $reviews->count() > 0)
    <div class="py-24 bg-gray-900 text-white overflow-hidden relative">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black tracking-tighter mb-4">Ils ont vécu l'expérience</h2>
                <p class="text-gray-400 text-lg">Découvrez ce que nos voyageurs pensent d'Atlas Trek.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($reviews as $review)
                <div class="bg-gray-800 border border-gray-700 p-8 rounded-[2rem] hover:border-emerald-500/50 transition-colors">
                    <div class="flex text-amber-400 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-600' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-300 italic mb-6 leading-relaxed line-clamp-3">"{{ $review->comment }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center font-bold text-gray-300">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-white">{{ $review->user->name }}</p>
                            <p class="text-xs text-gray-500">Pour <a href="{{ route('visits.show', $review->visit) }}" class="text-emerald-400 hover:underline">{{ Str::limit($review->visit->title, 20) }}</a></p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                </div>
                <span class="text-xl font-black text-gray-900 tracking-tighter">Atlas Trek</span>
            </div>
            <p class="text-gray-400 font-medium text-sm">
                &copy; {{ date('Y') }} Atlas Trek. Tous droits réservés.
            </p>
            <div class="flex items-center gap-4">
                <a href="#" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
