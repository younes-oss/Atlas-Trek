@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Tableau de bord')
@section('page_subtitle', 'Vue d\'ensemble de la plateforme Atlas Trek')

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    <!-- Total Utilisateurs -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 flex items-center gap-5 hover:border-gray-700 transition-colors">
        <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-400 shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Utilisateurs</p>
            <p class="text-3xl font-black text-white">{{ $stats['total_users'] }}</p>
        </div>
    </div>

    <!-- Total Visites -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 flex items-center gap-5 hover:border-gray-700 transition-colors">
        <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Visites</p>
            <p class="text-3xl font-black text-white">{{ $stats['total_visits'] }}</p>
        </div>
    </div>

    <!-- Total Réservations -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 flex items-center gap-5 hover:border-gray-700 transition-colors">
        <div class="w-14 h-14 bg-purple-500/10 rounded-2xl flex items-center justify-center text-purple-400 shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Réservations</p>
            <p class="text-3xl font-black text-white">{{ $stats['total_reservations'] }}</p>
        </div>
    </div>

    <!-- Guides en attente -->
    <div class="bg-gray-900 border {{ $stats['pending_guides'] > 0 ? 'border-amber-500/40' : 'border-gray-800' }} rounded-2xl p-6 flex items-center gap-5 hover:border-gray-700 transition-colors">
        <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-400 shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Guides en attente</p>
            <p class="text-3xl font-black {{ $stats['pending_guides'] > 0 ? 'text-amber-400' : 'text-white' }}">{{ $stats['pending_guides'] }}</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- Guides en attente -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-800 flex items-center justify-between">
            <h2 class="font-black text-white flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
                Guides en attente de validation
            </h2>
            <a href="{{ route('admin.guides') }}" class="text-xs font-bold text-gray-500 hover:text-emerald-400 transition-colors">Voir tout →</a>
        </div>
        <div class="divide-y divide-gray-800">
            @php $pending = \App\Models\User::where('role','guide')->where('is_verified',false)->latest()->take(5)->get(); @endphp
            @forelse($pending as $guide)
                <div class="px-6 py-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-black text-sm shrink-0">
                            {{ substr($guide->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-white text-sm">{{ $guide->name }}</p>
                            <p class="text-xs text-gray-500">{{ $guide->email }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <form action="{{ route('admin.guides.verify', $guide) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-lg transition-colors">✓ Valider</button>
                        </form>
                        <form action="{{ route('admin.guides.reject', $guide) }}" method="POST" onsubmit="return confirm('Supprimer ce guide ?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white text-xs font-bold rounded-lg transition-colors border border-red-500/20 hover:border-red-600">✕ Refuser</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-600 text-sm">
                    <p class="text-2xl mb-2">✅</p>
                    Aucun guide en attente
                </div>
            @endforelse
        </div>
    </div>

    <!-- Dernières réservations -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-800 flex items-center justify-between">
            <h2 class="font-black text-white flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-purple-400 inline-block"></span>
                Dernières réservations
            </h2>
            <a href="{{ route('admin.reservations') }}" class="text-xs font-bold text-gray-500 hover:text-emerald-400 transition-colors">Voir tout →</a>
        </div>
        <div class="divide-y divide-gray-800">
            @php $latestReservations = \App\Models\Reservation::with(['user','visit'])->latest()->take(5)->get(); @endphp
            @forelse($latestReservations as $res)
                <div class="px-6 py-4 flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <p class="font-bold text-white text-sm truncate">{{ $res->visit->title ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $res->user->name ?? 'N/A' }} · {{ $res->number_of_people }} pers.</p>
                    </div>
                    <span class="shrink-0 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider
                        {{ $res->status === 'confirmé' ? 'bg-emerald-500/10 text-emerald-400' :
                           ($res->status === 'annulé' ? 'bg-red-500/10 text-red-400' : 'bg-amber-500/10 text-amber-400') }}">
                        {{ $res->status }}
                    </span>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-600 text-sm">Aucune réservation</div>
            @endforelse
        </div>
    </div>
</div>

@endsection
