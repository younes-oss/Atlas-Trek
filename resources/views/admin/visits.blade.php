@extends('layouts.admin')

@section('title', 'Gestion des Visites')
@section('page_title', 'Gestion des Visites')
@section('page_subtitle', 'Toutes les visites publiées sur la plateforme')

@section('content')

<!-- Filtre par guide -->
<div class="mb-6">
    <form action="{{ route('admin.visits') }}" method="GET" class="flex items-center gap-4">
        <select name="guide_id" onchange="this.form.submit()"
            class="bg-gray-900 border border-gray-700 text-gray-300 text-sm rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring-0 outline-none appearance-none">
            <option value="">— Tous les guides —</option>
            @foreach($guides as $guide)
                <option value="{{ $guide->id }}" {{ request('guide_id') == $guide->id ? 'selected' : '' }}>
                    {{ $guide->name }}
                </option>
            @endforeach
        </select>
        @if(request('guide_id'))
            <a href="{{ route('admin.visits') }}" class="text-xs font-bold text-gray-500 hover:text-white transition-colors">✕ Réinitialiser</a>
        @endif
        <span class="ml-auto text-sm text-gray-500 font-medium">{{ $visits->count() }} visite(s) trouvée(s)</span>
    </form>
</div>

<!-- Table -->
<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-800">
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Visite</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Guide</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Lieu</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Prix</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Places</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Difficulté</th>
                <th class="px-6 py-4 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            @forelse($visits as $visit)
                <tr class="hover:bg-gray-800/40 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($visit->image)
                                <img src="{{ asset('storage/' . $visit->image) }}" class="w-12 h-12 rounded-xl object-cover shrink-0">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-gray-800 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/></svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-bold text-white text-sm truncate max-w-[200px]">{{ $visit->title }}</p>
                                <p class="text-xs text-gray-500">{{ $visit->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-400">{{ $visit->user->name ?? 'Inconnu' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-400">{{ $visit->location }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-emerald-400">{{ number_format($visit->price, 0) }} MAD</td>
                    <td class="px-6 py-4 text-sm text-gray-400">{{ $visit->max_places }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase
                            {{ $visit->difficulty === 'facile' ? 'bg-emerald-500/10 text-emerald-400' :
                               ($visit->difficulty === 'moyen' ? 'bg-amber-500/10 text-amber-400' : 'bg-red-500/10 text-red-400') }}">
                            {{ $visit->difficulty }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('visits.show', $visit) }}" target="_blank"
                               class="px-3 py-1.5 bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white text-xs font-bold rounded-lg transition-colors">
                                👁 Voir
                            </a>
                            <form action="{{ route('admin.visits.delete', $visit) }}" method="POST"
                                  onsubmit="return confirm('Supprimer la visite « {{ addslashes($visit->title) }} » ?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white text-xs font-bold rounded-lg transition-colors border border-red-500/20 hover:border-red-600">
                                    🗑 Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-600 font-bold">Aucune visite trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
