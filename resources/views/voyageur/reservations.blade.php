@extends('layouts.voyageur')

@section('title', 'Mes réservations')
@section('page_title', 'Mes réservations')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-widest">
                    <th class="px-8 py-5">Visite</th>
                    <th class="px-8 py-5">Date</th>
                    <th class="px-8 py-5">Personnes</th>
                    <th class="px-8 py-5">Prix total</th>
                    <th class="px-8 py-5">Statut</th>
                    <th class="px-8 py-5">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($reservations as $reservation)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-14 w-14 rounded-2xl overflow-hidden bg-gray-100 flex-shrink-0 border border-gray-100">
                                    @if($reservation->visit->image)
                                        <img src="{{ asset('storage/' . $reservation->visit->image) }}" class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $reservation->visit->title }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $reservation->visit->location }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm font-medium text-gray-600">
                            {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}
                        </td>
                        <td class="px-8 py-6 text-sm font-bold text-gray-900">
                            {{ $reservation->number_of_people }}
                        </td>
                        <td class="px-8 py-6 text-sm font-extrabold text-emerald-600">
                            {{ number_format($reservation->visit->price * $reservation->number_of_people, 0) }} MAD
                        </td>
                        <td class="px-8 py-6">
                            @if($reservation->status === 'en_attente')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-amber-100 text-amber-800 tracking-wider">En attente</span>
                            @elseif($reservation->status === 'confirmé')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-emerald-100 text-emerald-800 tracking-wider">Confirmé</span>
                            @else
                                <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-red-100 text-red-800 tracking-wider">Annulé</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <a href="{{ route('visits.show', $reservation->visit) }}" class="text-gray-400 hover:text-emerald-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-gray-500 italic">Vous n'avez pas encore de réservations.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
