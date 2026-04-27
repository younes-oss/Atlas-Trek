@extends('layouts.guide')

@section('title', 'Dashboard')

@section('content')
<div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard</h1>
        <p class="text-gray-500 mt-2 text-lg">Gérez vos visites et suivez vos performances.</p>
    </div>
    <a href="{{ route('visits.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Nouvelle visite
    </a>
</div>

<!-- Stats Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <!-- Stat 1 -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-widest">Total Visites</h3>
            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="text-3xl font-extrabold text-gray-900">{{ $stats['total_visits'] }}</div>
    </div>
    
    <!-- Stat 2 -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-widest">Réservations</h3>
            <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
        <div class="text-3xl font-extrabold text-gray-900">{{ $stats['total_reservations'] }}</div>
    </div>

    <!-- Stat 3 -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-widest">En attente</h3>
            <div class="p-2.5 bg-amber-50 text-amber-600 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="text-3xl font-extrabold text-amber-600">{{ $stats['pending_reservations'] }}</div>
    </div>

    <!-- Stat 4 -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-widest">Confirmées</h3>
            <div class="p-2.5 bg-purple-50 text-purple-600 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="text-3xl font-extrabold text-emerald-600">{{ $stats['confirmed_reservations'] }}</div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Left Col: Mes visites -->
    <div class="xl:col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Mes visites</h2>
            <a href="#" class="text-emerald-600 hover:text-emerald-700 font-bold transition-colors">Voir tout</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($visits as $visit)
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="h-48 overflow-hidden relative">
                        @if($visit->image)
                            <img src="{{ asset('storage/' . $visit->image) }}" alt="{{ $visit->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center italic text-gray-400">Aucune image</div>
                        @endif
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-emerald-600 shadow-sm">
                            {{ ucfirst($visit->difficulty) }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-1 truncate">{{ $visit->title }}</h3>
                        <p class="text-2xl font-extrabold text-gray-900 mb-5">{{ number_format($visit->price, 0) }} MAD</p>
                        <div class="flex gap-2">
                            <a href="{{ route('visits.edit', $visit) }}" class="flex-1 bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-100 transition-all text-center">Modifier</a>
                            <form action="{{ route('visits.destroy', $visit) }}" method="POST" onsubmit="return confirm('Supprimer cette visite ?')">
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
                <div class="col-span-full py-12 text-center bg-white rounded-3xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-500">Vous n'avez pas encore de visites.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Right Col: Réservations récentes -->
    <div class="xl:col-span-1">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-6 tracking-tight">Récent</h2>
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="divide-y divide-gray-100">
                @forelse($recentReservations as $reservation)
                    <div class="p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div class="flex gap-3">
                                <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xs">
                                    {{ substr($reservation->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $reservation->user->name }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mt-0.5">{{ $reservation->visit->title }}</p>
                                </div>
                            </div>
                            @if($reservation->status === 'en_attente')
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-amber-100 text-amber-800 uppercase">En attente</span>
                            @elseif($reservation->status === 'confirmé')
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-emerald-100 text-emerald-800 uppercase">Confirmé</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-red-100 text-red-800 uppercase">Annulé</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-gray-400 italic text-sm">Aucune réservation.</div>
                @endforelse
            </div>
            <div class="bg-gray-50 px-5 py-4 border-t border-gray-100 text-center">
                <a href="{{ route('guide.reservations') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 uppercase tracking-widest">Voir tout</a>
            </div>
        </div>
    </div>
</div>
@endsection
