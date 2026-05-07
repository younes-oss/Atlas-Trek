@extends('layouts.admin')

@section('title', 'Réservations')
@section('page_title', 'Gestion des Réservations')
@section('page_subtitle', 'Toutes les réservations de la plateforme')

@section('content')

<!-- Filtre par statut -->
<div class="mb-6 flex items-center gap-3 flex-wrap">
    @php $statuses = ['all' => 'Toutes', 'en_attente' => 'En attente', 'confirmé' => 'Confirmées', 'annulé' => 'Annulées']; @endphp
    @foreach($statuses as $key => $label)
        <a href="{{ route('admin.reservations', $key !== 'all' ? ['status' => $key] : []) }}"
           class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all
               {{ (request('status') === $key || (!request('status') && $key === 'all'))
                  ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900'
                  : 'bg-gray-900 border border-gray-800 text-gray-500 hover:border-gray-600 hover:text-gray-300' }}">
            {{ $label }}
        </a>
    @endforeach
    <span class="ml-auto text-sm text-gray-500 font-medium">{{ $reservations->count() }} résultat(s)</span>
</div>

<!-- Table -->
<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-800">
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Voyageur</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Visite</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Date</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Personnes</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Créée le</th>
                <th class="px-6 py-4 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest">Statut</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            @forelse($reservations as $res)
                <tr class="hover:bg-gray-800/40 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center font-black text-sm shrink-0">
                                {{ substr($res->user->name ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-white text-sm">{{ $res->user->name ?? 'Inconnu' }}</p>
                                <p class="text-xs text-gray-500">{{ $res->user->email ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-white text-sm max-w-[180px] truncate">{{ $res->visit->title ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">Guide : {{ $res->visit->user->name ?? 'N/A' }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-sm">
                        {{ \Carbon\Carbon::parse($res->date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-sm font-bold">{{ $res->number_of_people }} pers.</td>
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $res->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider
                            {{ $res->status === 'confirmé' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' :
                               ($res->status === 'annulé' ? 'bg-red-500/10 text-red-400 border border-red-500/20' :
                                'bg-amber-500/10 text-amber-400 border border-amber-500/20') }}">
                            {{ $res->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-600 font-bold">Aucune réservation trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
