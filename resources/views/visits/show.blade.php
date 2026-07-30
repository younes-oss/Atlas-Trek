<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $visit->title }} - Atlas Trek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #FAFAFA; }
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
        .text-shadow { text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        .prose p { margin-bottom: 1.2rem; line-height: 1.8; color: #4B5563; font-size: 1.1rem; }
    </style>
</head>
<body class="text-gray-900 antialiased selection:bg-emerald-500 selection:text-white">

    <!-- 1. NAVIGATION -->
    <nav class="fixed w-full z-50 glass border-b border-white/20 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-20 items-center">
                <a href="/" class="text-2xl font-black text-emerald-700 tracking-tighter flex items-center gap-3 hover:scale-105 transition-transform">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                    Atlas Trek
                </a>
                <div class="flex items-center gap-6">
                    <a href="/" class="hidden md:block text-gray-600 font-bold hover:text-emerald-600 transition-colors uppercase tracking-widest text-xs">Découvrir</a>
                    @auth
                        <a href="{{ route('home') }}" class="bg-gray-900 text-white px-6 py-3 rounded-full text-xs font-bold uppercase tracking-widest hover:bg-emerald-600 hover:shadow-lg transition-all">Mon Espace</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-900 font-bold text-sm hover:text-emerald-600 transition-colors">Connexion</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. HERO SECTION IMMERSIVE -->
    <header class="relative w-full h-[70vh] min-h-[600px] flex items-end pb-8 pt-32">
        <div class="absolute inset-0 z-0 bg-gray-900">
            @if($visit->image)
                <img src="{{ asset('storage/' . $visit->image) }}" alt="{{ $visit->title }}" class="w-full h-full object-cover object-center">
            @else
                <div class="w-full h-full bg-gradient-to-br from-emerald-600 to-gray-900"></div>
            @endif
            <!-- Overlay sombre léger pour garantir l'immersion et la lisibilité -->
            <div class="absolute inset-0 bg-black/40"></div>
            <!-- Gradient subtil en bas pour lier l'image avec le contenu -->
            <div class="absolute "></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
            <div class="max-w-4xl">
                <!-- Badges Hero -->
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="bg-emerald-500/90 backdrop-blur-sm text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-lg">
                        Niveau {{ $visit->difficulty }}
                    </span>
                    <span class="bg-white/20 backdrop-blur-md text-white px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest border border-white/30 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                        {{ $visit->location }}
                    </span>
                    @php $remaining = $visit->availablePlaces(); @endphp
                    @if($remaining > 0 && $remaining <= 3)
                        <span class="bg-red-500/90 backdrop-blur-sm text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>
                            Plus que {{ $remaining }} places
                        </span>
                    @endif
                </div>

                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-tight mb-3 text-shadow">
                    {{ $visit->title }}
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-200 font-medium max-w-2xl text-shadow mb-6 leading-relaxed">
                    Une aventure de {{ $visit->duration }} heures conçue par votre guide local {{ $visit->user->name }}.
                </p>
                
                @if($visit->reviews()->count() > 0)
                    <div class="flex items-center gap-3 bg-black/30 backdrop-blur-md w-max px-5 py-2.5 rounded-full border border-white/10">
                        <div class="flex text-amber-400">
                            @php $avg = round($visit->reviews()->avg('rating')); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $avg ? 'fill-current' : 'text-white/20' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-white font-bold">{{ number_format($visit->reviews()->avg('rating'), 1) }}</span>
                        <span class="text-white/60 text-sm font-medium">({{ $visit->reviews()->count() }} avis)</span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Favori -->
        @auth
            <form action="{{ route('favorites.toggle', $visit) }}" method="POST" class="absolute top-28 right-6 md:right-10 z-10">
                @csrf
                <button type="submit" class="w-14 h-14 rounded-full bg-black/20 backdrop-blur-md flex items-center justify-center hover:bg-black/40 transition-all shadow-xl border border-white/20 group">
                    @if($visit->isFavoritedBy(auth()->user()))
                        <svg class="w-7 h-7 text-red-500 fill-current drop-shadow-md group-hover:scale-110 transition-transform" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    @else
                        <svg class="w-7 h-7 text-white group-hover:text-red-400 group-hover:scale-110 transition-all drop-shadow-md" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                    @endif
                </button>
            </form>
        @endauth
    </header>

    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <!-- 3. CONTENU PRINCIPAL (Left Column) -->
            <div class="lg:col-span-7 xl:col-span-8 space-y-20">
                
                <!-- Messages de retour -->
                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-6 rounded-2xl">
                        <p class="font-bold text-emerald-900">{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-2xl">
                        <p class="font-bold text-red-900">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- A. Infos Rapides (Compactes) -->
                <div class="flex flex-wrap items-center gap-y-6 gap-x-10 pb-10 border-b border-gray-200">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Durée totale</p>
                            <p class="font-black text-gray-900">{{ $visit->duration }} heures</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Niveau</p>
                            <p class="font-black text-gray-900 capitalize">{{ $visit->difficulty }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Taille du groupe</p>
                            <p class="font-black text-gray-900">Max {{ $visit->max_places }} pers.</p>
                        </div>
                    </div>
                </div>

                <!-- B. Introduction Immersive (Storytelling) -->
                <section>
                    <h2 class="text-3xl font-black tracking-tighter mb-6 text-gray-900">L'expérience qui vous attend</h2>
                    <div class="prose max-w-none">
                        <p class="text-xl font-medium text-emerald-800 mb-6 leading-relaxed">
                            Laissez le quotidien derrière vous et plongez au cœur d'une aventure inoubliable à {{ $visit->location }}. Préparez-vous à découvrir des paysages à couper le souffle, guidé par la passion et l'expertise locale.
                        </p>
                        {!! nl2br(e($visit->description)) !!}
                    </div>
                </section>

                <!-- C. Expérience Détaillée (Storytelling Alterné) -->
                @if($visit->logement || $visit->transport || $visit->repas)
                <section class="space-y-12">
                    
                    @if($visit->logement)
                    <div class="flex flex-col md:flex-row gap-8 items-center group">
                        <div class="w-full md:w-1/2 rounded-3xl overflow-hidden shadow-lg h-64 relative bg-gray-100">
                            @if($visit->logement_img)
                                <img src="{{ asset('storage/' . $visit->logement_img) }}" alt="Hébergement" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Hébergement générique" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @endif
                        </div>
                        <div class="w-full md:w-1/2 space-y-4">
                            <div class="flex items-center gap-3 text-emerald-600 mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                <span class="font-black uppercase tracking-widest text-xs">Où allez-vous dormir ?</span>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tighter">Votre hébergement</h3>
                            <p class="text-emerald-700 font-bold uppercase tracking-widest text-sm mb-2">{{ $visit->logement }}</p>
                            @if($visit->logement_desc)
                                <p class="text-gray-600 leading-relaxed text-lg font-medium">{{ $visit->logement_desc }}</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($visit->repas)
                    <div class="flex flex-col md:flex-row-reverse gap-8 items-center group">
                        <div class="w-full md:w-1/2 rounded-3xl overflow-hidden shadow-lg h-64 relative bg-gray-100">
                            @if($visit->repas_img)
                                <img src="{{ asset('storage/' . $visit->repas_img) }}" alt="Repas" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <img src="https://images.unsplash.com/photo-1541518763669-27fef04b14ea?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Repas générique" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @endif
                        </div>
                        <div class="w-full md:w-1/2 space-y-4">
                            <div class="flex items-center gap-3 text-amber-500 mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" /></svg>
                                <span class="font-black uppercase tracking-widest text-xs">Saveurs locales</span>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tighter">La restauration</h3>
                            <p class="text-amber-600 font-bold uppercase tracking-widest text-sm mb-2">{{ $visit->repas }}</p>
                            @if($visit->repas_desc)
                                <p class="text-gray-600 leading-relaxed text-lg font-medium">{{ $visit->repas_desc }}</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($visit->transport)
                    <div class="flex flex-col md:flex-row gap-8 items-center group">
                        <div class="w-full md:w-1/2 rounded-3xl overflow-hidden shadow-lg h-64 relative bg-gray-100">
                            @if($visit->transport_img)
                                <img src="{{ asset('storage/' . $visit->transport_img) }}" alt="Transport" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <img src="https://images.unsplash.com/photo-1533604100676-e414c330f81d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Transport générique" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @endif
                        </div>
                        <div class="w-full md:w-1/2 space-y-4">
                            <div class="flex items-center gap-3 text-blue-500 mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                                <span class="font-black uppercase tracking-widest text-xs">En mouvement</span>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tighter">Le transport</h3>
                            <p class="text-blue-600 font-bold uppercase tracking-widest text-sm mb-2">{{ $visit->transport }}</p>
                            @if($visit->transport_desc)
                                <p class="text-gray-600 leading-relaxed text-lg font-medium">{{ $visit->transport_desc }}</p>
                            @endif
                        </div>
                    </div>
                    @endif

                </section>
                @endif

                <!-- D. Timeline du Programme -->
                @if($visit->programme && is_array($visit->programme) && count($visit->programme) > 0)
                <section>
                    <h2 class="text-3xl font-black tracking-tighter mb-10 text-gray-900">Votre programme jour par jour</h2>
                    <div class="relative border-l-4 border-emerald-100 ml-4 space-y-12">
                        @foreach($visit->programme as $index => $etape)
                            <div class="relative pl-8">
                                <!-- Point sur la timeline -->
                                <div class="absolute -left-3.5 top-1 w-6 h-6 bg-emerald-500 rounded-full border-4 border-white shadow-sm"></div>
                                
                                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                    <span class="text-emerald-600 font-black uppercase tracking-widest text-xs mb-2 block">Jour {{ $index + 1 }}</span>
                                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $etape['titre'] ?? 'Étape' }}</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ $etape['description'] ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- E. Galerie d'images -->
                @if($visit->gallery && is_array($visit->gallery) && count($visit->gallery) > 0)
                <section>
                    <h2 class="text-3xl font-black tracking-tighter mb-8 text-gray-900">Aperçu de l'aventure</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($visit->gallery as $imagePath)
                            <div class="aspect-square rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                                <img src="{{ asset('storage/' . $imagePath) }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                            </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- Rencontrer le guide -->
                <section class="bg-gray-900 rounded-[3rem] p-10 md:p-12 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500 rounded-full blur-[100px] opacity-20 -mr-20 -mt-20"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                        <div class="w-28 h-28 shrink-0 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center text-4xl font-black shadow-xl border-4 border-gray-800">
                            {{ substr($visit->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-emerald-400 font-black uppercase tracking-widest text-xs mb-2">Conçu et guidé par</p>
                            <h3 class="text-3xl font-black tracking-tighter mb-4">{{ $visit->user->name }}</h3>
                            <p class="text-gray-400 text-lg leading-relaxed max-w-xl">
                                Rejoignez-moi pour vivre cette expérience unique. Mon objectif est de vous faire découvrir l'authenticité de notre région en toute sécurité.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Reviews -->
                @if($visit->reviews()->count() > 0)
                <section>
                    <h2 class="text-3xl font-black tracking-tighter mb-8 text-gray-900">Ce que disent les voyageurs</h2>
                    <div class="space-y-6">
                        @foreach($visit->reviews as $review)
                            <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center font-black text-gray-400 text-lg">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $review->user->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $review->created_at->format('M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 leading-relaxed text-lg">"{{ $review->comment }}"</p>
                            </div>
                        @endforeach
                    </div>
                </section>
                @endif

            </div>

            <!-- 4. SIDEBAR : RÉSERVATION STICKY (Right Column) -->
            <div class="lg:col-span-5 xl:col-span-4 relative">
                @php
                    $isFull = $remaining <= 0;
                @endphp
                
                <div class="sticky top-28 bg-white rounded-[2.5rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] border border-gray-100 p-8 md:p-10">
                    <div class="mb-8 border-b border-gray-100 pb-8">
                        <div class="flex items-end gap-2 mb-2">
                            <span class="text-5xl font-black text-gray-900 tracking-tighter">{{ number_format($visit->price, 0) }}</span>
                            <span class="text-xl font-bold text-gray-400 mb-1">MAD</span>
                            <span class="text-sm font-medium text-gray-400 mb-2 ml-1">/ personne</span>
                        </div>
                        
                        @if($isFull)
                            <div class="mt-4 inline-flex items-center gap-2 bg-red-50 text-red-600 px-4 py-2 rounded-xl text-sm font-bold">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                Complet
                            </div>
                        @else
                            <p class="text-emerald-600 font-bold mt-2 flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                Places disponibles
                            </p>
                        @endif
                    </div>

                    @error('reservation')
                        <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-2xl text-sm font-bold border border-red-100">
                            {{ $message }}
                        </div>
                    @enderror

                    <form action="{{ route('visits.reserve', $visit) }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="p-1 rounded-2xl border-2 border-gray-100 bg-gray-50 focus-within:border-emerald-500 focus-within:bg-white transition-colors">
                            <div class="px-4 py-2 border-b border-gray-200/50">
                                <label class="block text-[10px] font-black text-gray-900 uppercase tracking-widest mb-1">Date</label>
                                <p class="font-bold text-gray-600">
                                    {{ $visit->date_depart ? $visit->date_depart->format('d M Y') : 'À définir' }}
                                </p>
                            </div>
                            <div class="px-4 py-2">
                                <label for="number_of_people" class="block text-[10px] font-black text-gray-900 uppercase tracking-widest mb-1">Voyageurs</label>
                                <select id="number_of_people" name="number_of_people" required {{ $isFull ? 'disabled' : '' }}
                                    class="w-full bg-transparent font-bold text-gray-900 outline-none cursor-pointer {{ $isFull ? 'opacity-50' : '' }}">
                                    @for($i = 1; $i <= min($visit->max_places, max(1, $remaining)); $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'voyageurs' : 'voyageur' }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <button type="submit" {{ $isFull ? 'disabled' : '' }}
                            class="w-full bg-emerald-600 hover:bg-gray-900 text-white px-8 py-5 rounded-2xl font-black text-lg shadow-xl shadow-emerald-600/20 hover:shadow-gray-900/20 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 {{ $isFull ? 'opacity-50 cursor-not-allowed bg-gray-300 shadow-none hover:transform-none hover:bg-gray-300' : '' }}">
                            {{ $isFull ? 'Toutes les places sont réservées' : 'Réserver cette expérience' }}
                        </button>
                        
                        @if(!$isFull)
                            <p class="text-center text-xs text-gray-400 font-medium">Vous ne serez débité qu'après confirmation du guide.</p>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer Space -->
    <div class="h-20"></div>

</body>
</html>
