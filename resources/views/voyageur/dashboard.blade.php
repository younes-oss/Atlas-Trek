@extends('layouts.voyageur')

@section('title', 'Tableau de bord')
@section('page_title', 'Tableau de bord')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
        <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Réservations</p>
            <p class="text-2xl font-extrabold text-gray-900">{{ $stats['total'] }}</p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
        <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">En attente</p>
            <p class="text-2xl font-extrabold text-gray-900">{{ $stats['pending'] }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Confirmées</p>
            <p class="text-2xl font-extrabold text-gray-900">{{ $stats['confirmed'] }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
    <!-- Recent Reservations -->
    <div>
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-extrabold text-gray-900">Dernières réservations</h3>
            <a href="{{ route('voyageur.reservations') }}" class="text-sm font-bold text-emerald-600 hover:underline">Voir tout</a>
        </div>
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="divide-y divide-gray-50">
                @forelse($recentReservations as $reservation)
                    <div class="p-5 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-2xl overflow-hidden bg-gray-100 flex-shrink-0">
                                @if($reservation->visit->image)
                                    <img src="{{ asset('storage/' . $reservation->visit->image) }}" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $reservation->visit->title }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }} • {{ $reservation->number_of_people }} pers.</p>
                            </div>
                        </div>
                        <div>
                            @if($reservation->status === 'en_attente')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-amber-100 text-amber-800">Attente</span>
                            @elseif($reservation->status === 'confirmé')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-emerald-100 text-emerald-800">Confirmé</span>
                            @else
                                <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-red-100 text-red-800">Annulé</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-gray-500 italic">Aucune réservation trouvée.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Explore Section -->
    <div>
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-extrabold text-gray-900">Explorer les visites</h3>
            <a href="{{ route('welcome') }}#tours" class="text-sm font-bold text-emerald-600 hover:underline">Voir tout</a>
        </div>
        <div class="space-y-4">
            @foreach($exploreVisits as $visit)
                <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="h-20 w-20 rounded-2xl overflow-hidden bg-gray-100 flex-shrink-0">
                         @if($visit->image)
                            <img src="{{ asset('storage/' . $visit->image) }}" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <div class="flex-grow">
                        <p class="font-bold text-gray-900 text-sm mb-0.5">{{ $visit->title }}</p>
                        <p class="text-xs text-gray-500 flex items-center gap-1">
                            <svg class="h-3 w-3 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            {{ $visit->location }}
                        </p>
                        <p class="text-sm font-extrabold text-emerald-600 mt-1">{{ number_format($visit->price, 0) }} MAD</p>
                    </div>
                    <a href="{{ route('visits.show', $visit) }}" class="bg-gray-50 p-2 rounded-xl text-gray-400 hover:text-emerald-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
