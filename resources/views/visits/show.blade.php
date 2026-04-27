<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $visit->title }} - Atlas Trek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-extrabold text-emerald-600 tracking-tight">Atlas Trek</a>
                </div>
                <div class="flex space-x-4 items-center font-medium">
                    <a href="/" class="text-gray-600 hover:text-emerald-600 transition">Accueil</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Details Column -->
            <div class="lg:col-span-2">
                @if(session('success'))
                    <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm">
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                @endif

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-96 w-full relative">
                        @if($visit->image)
                            <img src="{{ asset('storage/' . $visit->image) }}" alt="{{ $visit->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-emerald-50 flex items-center justify-center">
                                <svg class="h-24 w-24 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/95 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-bold text-emerald-600 shadow-md">
                                {{ ucfirst($visit->difficulty) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-8 md:p-12">
                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <span class="flex items-center text-gray-500 text-sm font-medium bg-gray-100 px-3 py-1 rounded-full">
                                <svg class="h-4 w-4 mr-1.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $visit->duration }} heures
                            </span>
                            <span class="flex items-center text-gray-500 text-sm font-medium bg-gray-100 px-3 py-1 rounded-full">
                                <svg class="h-4 w-4 mr-1.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                {{ $visit->location }}
                            </span>
                        </div>

                        <h1 class="text-4xl font-extrabold text-gray-900 mb-6 tracking-tight">{{ $visit->title }}</h1>
                        
                        <div class="prose prose-emerald max-w-none text-gray-600 leading-relaxed text-lg">
                            {!! nl2br(e($visit->description)) !!}
                        </div>
                        
                        <div class="mt-12 pt-8 border-t border-gray-100 flex items-center gap-4">
                            <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xl">
                                {{ substr($visit->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Guide Local</p>
                                <p class="text-gray-900 font-bold">{{ $visit->user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Column -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sticky top-24">
                    <div class="mb-8">
                        <p class="text-gray-500 font-medium mb-1">Prix par personne</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold text-emerald-600">{{ number_format($visit->price, 0) }}</span>
                            <span class="text-xl font-bold text-gray-900">MAD</span>
                        </div>
                    </div>

                    <form action="{{ route('visits.reserve', $visit) }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="date" class="block text-sm font-bold text-gray-700 mb-2">Date de visite</label>
                            <input type="date" id="date" name="date" required min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="number_of_people" class="block text-sm font-bold text-gray-700 mb-2">Nombre de personnes</label>
                            <select id="number_of_people" name="number_of_people" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all appearance-none bg-white">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}</option>
                                @endfor
                            </select>
                            @error('number_of_people')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-4 rounded-2xl font-bold text-lg shadow-lg hover:shadow-emerald-200 transition-all transform hover:-translate-y-1">
                            Réserver maintenant
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-gray-500 font-medium italic">
                        Aucun paiement requis pour le moment.
                    </p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
