@extends('layouts.guide')

@section('title', 'Gestion des réservations')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Gestion des réservations</h1>
    <p class="text-gray-500 mt-2 text-lg">Consultez et gérez les demandes de vos clients.</p>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-widest">Voyageur</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-widest">Visite</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-widest">Date</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-widest">Personnes</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-widest">Statut</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($reservations as $reservation)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold">
                                    {{ substr($reservation->user->name, 0, 1) }}
                                </div>
                                <div class="font-bold text-gray-900">{{ $reservation->user->name }}</div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-gray-900 font-medium">{{ $reservation->visit->title }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">{{ $reservation->visit->location }}</div>
                        </td>
                        <td class="px-8 py-6 text-gray-600 font-medium">
                            {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}
                        </td>
                        <td class="px-8 py-6 text-gray-600 font-bold">
                            {{ $reservation->number_of_people }}
                        </td>
                        <td class="px-8 py-6">
                            @if($reservation->status === 'en_attente')
                                <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 uppercase tracking-wider">En attente</span>
                            @elseif($reservation->status === 'confirmé')
                                <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 uppercase tracking-wider">Confirmé</span>
                            @else
                                <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-red-100 text-red-800 uppercase tracking-wider">Annulé</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            @if($reservation->status === 'en_attente')
                                <div class="flex justify-center gap-2">
                                    <form action="{{ route('guide.reservations.update', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="confirmé">
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition-all">Confirmer</button>
                                    </form>
                                    <form action="{{ route('guide.reservations.update', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="annulé">
                                        <button type="submit" class="bg-white border border-red-200 text-red-600 hover:bg-red-50 px-4 py-2 rounded-xl text-xs font-bold transition-all">Annuler</button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center text-xs text-gray-400 italic">Aucune action</div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-gray-400 italic">
                            Aucune réservation trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
