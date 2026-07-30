<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une visite - Atlas Trek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('guide.dashboard') }}" class="text-2xl font-bold text-emerald-600 tracking-tight">Atlas Trek</a>
                    <span class="ml-3 text-xs bg-emerald-100 text-emerald-800 py-1 px-2.5 rounded-full font-semibold uppercase tracking-wide">Guide Portal</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <a href="{{ route('guide.dashboard') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold flex items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour au dashboard
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">➕ Créer une nouvelle visite</h1>
            <p class="text-gray-500 mt-2">Remplissez les détails ci-dessous pour proposer une nouvelle expérience aux voyageurs.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('visits.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Titre -->
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Titre de la visite *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                        placeholder="Ex: Trek dans le Haut Atlas">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description *</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                        placeholder="Décrivez la visite en détail...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Lieu -->
                    <div>
                        <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Lieu *</label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                            placeholder="Ex: Toubkal, Marrakech">
                        @error('location')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prix -->
                    <div>
                        <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Prix (MAD) *</label>
                        <div class="relative">
                            <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none pr-12"
                                placeholder="Ex: 350.00">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400 font-bold">
                                MAD
                            </div>
                        </div>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Durée -->
                    <div>
                        <label for="duration" class="block text-sm font-bold text-gray-700 mb-2">Durée (en heures) *</label>
                        <input type="number" id="duration" name="duration" value="{{ old('duration') }}" min="1"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                            placeholder="Ex: 8">
                        @error('duration')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Difficulté -->
                    <div>
                        <label for="difficulty" class="block text-sm font-bold text-gray-700 mb-2">Niveau de difficulté *</label>
                        <select id="difficulty" name="difficulty" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none appearance-none bg-white">
                            <option value="">-- Niveau --</option>
                            <option value="facile" {{ old('difficulty') == 'facile' ? 'selected' : '' }}>🟢 Facile</option>
                            <option value="moyen" {{ old('difficulty') == 'moyen' ? 'selected' : '' }}>🟡 Moyen</option>
                            <option value="difficile" {{ old('difficulty') == 'difficile' ? 'selected' : '' }}>🔴 Difficile</option>
                        </select>
                        @error('difficulty')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Places -->
                    <div>
                        <label for="max_places" class="block text-sm font-bold text-gray-700 mb-2">Nombre de places maximum *</label>
                        <input type="number" id="max_places" name="max_places" value="{{ old('max_places', 1) }}" min="1"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                            placeholder="Ex: 10">
                        @error('max_places')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Image de couverture *</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl hover:border-emerald-500 transition-colors cursor-pointer group relative">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-emerald-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-bold text-emerald-600 hover:text-emerald-500">
                                    <span>Télécharger un fichier</span>
                                    <input id="image" name="image" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG jusqu'à 2MB</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ═══ Détails du séjour ═══ -->
                <div class="border-t border-gray-100 pt-6 mt-2">
                    <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                        <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        Détails du séjour
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Logement -->
                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-4">
                            <h4 class="font-black text-emerald-600 uppercase tracking-widest text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                Logement
                            </h4>
                            <div>
                                <label for="logement" class="block text-xs font-bold text-gray-700 mb-1">Type (ex: Gîte, Bivouac...)</label>
                                <input type="text" id="logement" name="logement" value="{{ old('logement') }}"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm">
                                @error('logement') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="logement_desc" class="block text-xs font-bold text-gray-700 mb-1">Description</label>
                                <textarea id="logement_desc" name="logement_desc" rows="2"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm">{{ old('logement_desc') }}</textarea>
                                @error('logement_desc') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="logement_img" class="block text-xs font-bold text-gray-700 mb-1">Image illustrative</label>
                                <input type="file" id="logement_img" name="logement_img" class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                @error('logement_img') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Transport -->
                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-4">
                            <h4 class="font-black text-blue-600 uppercase tracking-widest text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                                Transport
                            </h4>
                            <div>
                                <label for="transport" class="block text-xs font-bold text-gray-700 mb-1">Moyen (ex: 4x4, Minibus...)</label>
                                <input type="text" id="transport" name="transport" value="{{ old('transport') }}"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                                @error('transport') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="transport_desc" class="block text-xs font-bold text-gray-700 mb-1">Description</label>
                                <textarea id="transport_desc" name="transport_desc" rows="2"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none text-sm">{{ old('transport_desc') }}</textarea>
                                @error('transport_desc') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="transport_img" class="block text-xs font-bold text-gray-700 mb-1">Image illustrative</label>
                                <input type="file" id="transport_img" name="transport_img" class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('transport_img') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Repas -->
                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-4">
                            <h4 class="font-black text-amber-600 uppercase tracking-widest text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" /></svg>
                                Repas
                            </h4>
                            <div>
                                <label for="repas" class="block text-xs font-bold text-gray-700 mb-1">Type (ex: Pension complète...)</label>
                                <input type="text" id="repas" name="repas" value="{{ old('repas') }}"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none text-sm">
                                @error('repas') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="repas_desc" class="block text-xs font-bold text-gray-700 mb-1">Description</label>
                                <textarea id="repas_desc" name="repas_desc" rows="2"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none text-sm">{{ old('repas_desc') }}</textarea>
                                @error('repas_desc') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="repas_img" class="block text-xs font-bold text-gray-700 mb-1">Image illustrative</label>
                                <input type="file" id="repas_img" name="repas_img" class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                                @error('repas_img') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══ Dates de la visite ═══ -->
                <div class="border-t border-gray-100 pt-6 mt-6">
                    <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                        <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        Planification
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date de départ -->
                        <div>
                            <label for="date_depart" class="block text-sm font-bold text-gray-700 mb-2">Date de départ *</label>
                            <input type="datetime-local" id="date_depart" name="date_depart" value="{{ old('date_depart') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            @error('date_depart')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date de fin (optionnel) -->
                        <div>
                            <label for="date_fin" class="block text-sm font-bold text-gray-700 mb-2">Date de fin <span class="text-gray-400 font-normal">(optionnel)</span></label>
                            <input type="datetime-local" id="date_fin" name="date_fin" value="{{ old('date_fin') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            @error('date_fin')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date limite de réservation -->
                        <div class="md:col-span-2">
                            <label for="date_limite_reservation" class="block text-sm font-bold text-gray-700 mb-2">Date limite de réservation *</label>
                            <input type="datetime-local" id="date_limite_reservation" name="date_limite_reservation" value="{{ old('date_limite_reservation') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            <p class="text-xs text-gray-400 mt-1">Les réservations seront automatiquement fermées après cette date.</p>
                            @error('date_limite_reservation')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3.5 rounded-xl font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        💾 Enregistrer la visite
                    </button>
                    <a href="{{ route('guide.dashboard') }}" class="flex-none bg-white border border-gray-200 text-gray-700 px-6 py-3.5 rounded-xl font-bold hover:bg-gray-50 transition-all">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>