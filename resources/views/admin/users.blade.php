@extends('layouts.admin')

@section('title', 'Utilisateurs')
@section('page_title', 'Gestion des Utilisateurs')
@section('page_subtitle', 'Tous les comptes inscrits sur la plateforme')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <span class="text-sm text-gray-500 font-medium">{{ $users->count() }} utilisateur(s) au total</span>
</div>

<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-800">
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Utilisateur</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Email</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Rôle</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Activité</th>
                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Inscrit le</th>
                <th class="px-6 py-4 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            @foreach($users as $user)
                <tr class="hover:bg-gray-800/40 transition-colors {{ $user->id === auth()->id() ? 'bg-emerald-900/10' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @php
                                $colorMap = ['admin' => 'red', 'guide' => 'emerald', 'voyageur' => 'blue'];
                                $color = $colorMap[$user->role] ?? 'gray';
                            @endphp
                            <div class="w-10 h-10 rounded-xl bg-{{ $color }}-500/10 text-{{ $color }}-400 flex items-center justify-center font-black shrink-0">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-white text-sm flex items-center gap-2">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="text-[9px] font-black text-emerald-500 bg-emerald-500/10 px-1.5 py-0.5 rounded">(vous)</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-sm">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase w-fit
                                {{ $user->role === 'admin' ? 'bg-red-500/10 text-red-400' :
                                   ($user->role === 'guide' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-blue-500/10 text-blue-400') }}">
                                {{ $user->role }}
                            </span>
                            @if($user->role === 'guide')
                                <span class="text-[10px] font-bold {{ $user->is_verified ? 'text-emerald-500' : 'text-amber-500' }}">
                                    {{ $user->is_verified ? '✓ Vérifié' : '⏳ En attente' }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs">
                        @if($user->role === 'guide')
                            {{ $user->visits()->count() }} visite(s)
                        @elseif($user->role === 'voyageur')
                            {{ $user->reservations()->count() }} réservation(s)
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST"
                                  onsubmit="return confirm('Supprimer définitivement « {{ addslashes($user->name) }} » et toutes ses données ?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white text-xs font-bold rounded-lg transition-colors border border-red-500/20 hover:border-red-600">
                                    🗑 Supprimer
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-700 font-bold italic">Compte actuel</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
