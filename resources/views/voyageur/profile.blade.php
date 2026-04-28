@extends('layouts.voyageur')

@section('title', 'Mon Profil')
@section('page_title', 'Mon Profil')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-32 bg-emerald-600"></div>
        <div class="px-8 pb-8">
            <div class="relative flex justify-between items-end -mt-12 mb-6">
                <div class="h-24 w-24 rounded-3xl bg-white p-1 shadow-md">
                    <div class="h-full w-full rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-3xl font-bold border border-emerald-50">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
                <button class="bg-gray-900 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-800 transition-colors">
                    Modifier le profil
                </button>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nom complet</label>
                    <p class="text-lg font-bold text-gray-900">{{ $user->name }}</p>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Adresse Email</label>
                    <p class="text-lg font-bold text-gray-900">{{ $user->email }}</p>
                </div>

                <div class="flex gap-10">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Rôle</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold capitalize">
                            {{ $user->role }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Statut</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold capitalize">
                            Actif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
