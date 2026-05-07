@extends('layouts.admin')

@section('title', 'Gestion des Guides')
@section('page_title', 'Gestion des Guides')
@section('page_subtitle', 'Validez ou refusez les demandes des guides')

@section('content')

<!-- Guides en attente de validation -->
<div class="mb-10">
    <h2 class="text-lg font-black text-white mb-4 flex items-center gap-2">
        <span class="w-3 h-3 rounded-full bg-amber-400"></span>
        En attente de validation
        <span class="bg-amber-500/10 text-amber-400 text-xs font-black px-2.5 py-1 rounded-lg">{{ $pendingGuides->count() }}</span>
    </h2>

    @if($pendingGuides->isEmpty())
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-10 text-center">
            <p class="text-4xl mb-3">✅</p>
            <p class="text-gray-400 font-bold">Aucun guide en attente de validation.</p>
        </div>
    @else
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Guide</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Email</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Inscrit le</th>
                        <th class="px-6 py-4 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($pendingGuides as $guide)
                        <tr class="hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-black">
                                        {{ substr($guide->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-white">{{ $guide->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-sm">{{ $guide->email }}</td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $guide->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.guides.verify', $guide) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black rounded-xl transition-colors">
                                            ✓ Valider
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.guides.reject', $guide) }}" method="POST"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir refuser et supprimer ce guide ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white text-xs font-black rounded-xl transition-colors border border-red-500/20 hover:border-red-600">
                                            ✕ Refuser
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Guides validés -->
<div>
    <h2 class="text-lg font-black text-white mb-4 flex items-center gap-2">
        <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
        Guides validés
        <span class="bg-emerald-500/10 text-emerald-400 text-xs font-black px-2.5 py-1 rounded-lg">{{ $verifiedGuides->count() }}</span>
    </h2>

    @if($verifiedGuides->isEmpty())
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-10 text-center">
            <p class="text-gray-400 font-bold">Aucun guide validé pour l'instant.</p>
        </div>
    @else
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Guide</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Email</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Visites</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Inscrit le</th>
                        <th class="px-6 py-4 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($verifiedGuides as $guide)
                        <tr class="hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-black">
                                        {{ substr($guide->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-white">{{ $guide->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-sm">{{ $guide->email }}</td>
                            <td class="px-6 py-4 text-gray-400 text-sm">{{ $guide->visits()->count() }} visite(s)</td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $guide->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase rounded-lg">Validé</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
