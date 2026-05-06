@extends('layouts.voyageur')

@section('title', 'Mes Favoris')
@section('page_title', 'Mes Favoris ❤️')

@section('content')
<div class="mb-8">
    <p class="text-gray-500 font-medium text-lg">Retrouvez ici toutes vos aventures préférées.</p>
</div>

@if(session('success'))
    <div class="mb-10 bg-emerald-50 border-l-8 border-emerald-500 p-6 rounded-2xl shadow-sm">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <p class="text-lg font-bold text-emerald-900">{{ session('success') }}</p>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
    @forelse($favorites as $visit)
        <div class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
            <div class="h-48 rounded-[2rem] overflow-hidden mb-6 relative">
                @if($visit->image)
                    <img src="{{ asset('storage/' . $visit->image) }}" alt="{{ $visit->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                        <svg class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                    <span class="bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-xl font-black text-gray-900 text-sm shadow-sm">
                        {{ number_format($visit->price, 0) }} MAD
                    </span>
                    <form action="{{ route('favorites.toggle', $visit) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-full bg-white/90 backdrop-blur-md flex items-center justify-center hover:bg-red-50 hover:text-red-600 transition-colors shadow-sm group">
                            <svg class="w-5 h-5 text-red-500 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="flex-grow flex flex-col">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-lg bg-gray-50 text-gray-500">
                        📍 {{ Str::limit($visit->location, 15) }}
                    </span>
                </div>
                <h3 class="text-xl font-black text-gray-900 tracking-tighter mb-4 line-clamp-1">{{ $visit->title }}</h3>
                
                <div class="mt-auto">
                    <a href="{{ route('visits.show', $visit) }}" class="block w-full bg-gray-50 hover:bg-emerald-600 text-gray-900 hover:text-white text-center py-4 rounded-[1.5rem] font-bold transition-colors">
                        Voir les détails
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white border border-gray-100 rounded-[2.5rem] p-12 text-center shadow-sm">
            <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 text-red-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mb-2">Aucun favori pour le moment</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Vous n'avez pas encore ajouté de visites à vos favoris. Parcourez nos offres et ajoutez celles qui vous plaisent !</p>
            <a href="{{ route('welcome') }}#tours" class="inline-block bg-emerald-600 text-white font-bold px-8 py-4 rounded-full shadow-lg shadow-emerald-200 hover:bg-gray-900 hover:shadow-gray-200 transition-all active:scale-95">
                Explorer les visites
            </a>
        </div>
    @endforelse
</div>
@endsection
