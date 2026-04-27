<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlas Trek - Explore Morocco</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white/95 backdrop-blur-md shadow-sm fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-extrabold text-emerald-600 tracking-tight">Atlas Trek</a>
                </div>
                <div class="hidden md:flex space-x-8 items-center font-medium">
                    <a href="#tours" class="text-gray-600 hover:text-emerald-600 transition duration-300">Destinations</a>
                    <a href="#tours" class="text-gray-600 hover:text-emerald-600 transition duration-300">Tours</a>
                    <a href="#" class="text-gray-600 hover:text-emerald-600 transition duration-300">About Us</a>
                    @auth
                        @if(Auth::user()->role === 'guide')
                            <a href="{{ route('guide.dashboard') }}" class="text-gray-600 hover:text-emerald-600 transition duration-300">Dashboard</a>
                        @elseif(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-emerald-600 transition duration-300">Dashboard</a>
                        @else
                            <a href="{{ url('/home') }}" class="text-gray-600 hover:text-emerald-600 transition duration-300">Dashboard</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-emerald-600 text-white px-5 py-2.5 rounded-full shadow-md hover:bg-emerald-700 hover:shadow-lg transition duration-300">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-emerald-600 transition duration-300">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-5 py-2.5 rounded-full shadow-md hover:bg-emerald-700 hover:shadow-lg transition duration-300">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-white pt-20">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1539020140153-e479b8c22e70?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Morocco Desert">
            <div class="absolute inset-0 bg-gray-900 bg-opacity-40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 md:py-56 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-6 drop-shadow-lg">
                Explore Morocco with Local Guides
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-gray-100 max-w-3xl mx-auto mb-10 drop-shadow-md">
                Discover the hidden gems of the Atlas Mountains, the vast Sahara desert, and vibrant ancient medinas with our verified local experts.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="#tours" class="w-full sm:w-auto bg-emerald-600 text-white px-8 py-4 rounded-full text-lg font-semibold shadow-lg hover:bg-emerald-500 hover:-translate-y-1 transition-all duration-300">Book a Tour</a>
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-white/10 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-full text-lg font-semibold shadow-lg hover:bg-white hover:text-gray-900 hover:-translate-y-1 transition-all duration-300">Become a Guide</a>
            </div>
        </div>
    </div>

    <!-- Tours Section -->
    <div id="tours" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Trending Tours</h2>
                <p class="text-xl text-gray-600">Experience the best of Morocco with our top-rated experiences.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @forelse($visits as $visit)
                    <!-- Dynamic Card -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden group hover:shadow-2xl transition-all duration-500 border border-gray-100 flex flex-col">
                        <div class="relative h-64 overflow-hidden">
                            @if($visit->image)
                                <img src="{{ asset('storage/' . $visit->image) }}" alt="{{ $visit->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            @else
                                <div class="w-full h-full bg-emerald-50 flex items-center justify-center">
                                    <svg class="h-16 w-16 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-bold text-emerald-600 shadow-sm">
                                {{ ucfirst($visit->difficulty) }}
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">
                                <a href="{{ route('visits.show', $visit) }}">{{ $visit->title }}</a>
                            </h3>
                            <p class="text-gray-500 text-sm mb-4 flex items-center">
                                <svg class="h-4 w-4 mr-1 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $visit->location }}
                            </p>
                            <p class="text-gray-600 mb-6 flex-grow line-clamp-3">{{ Str::limit($visit->description, 120) }}</p>
                            <div class="flex justify-between items-center pt-5 border-t border-gray-100">
                                <div>
                                    <span class="text-sm text-gray-500 block mb-0.5">Starting from</span>
                                    <span class="text-3xl font-extrabold text-emerald-600">{{ number_format($visit->price, 0) }} MAD</span>
                                </div>
                                <a href="{{ route('visits.show', $visit) }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-full font-medium hover:bg-emerald-600 transition-colors duration-300">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Placeholder cards if no visits exist -->
                    <div class="col-span-full py-12 text-center">
                        <p class="text-gray-500 italic">No visits available at the moment. Check back soon!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="md:col-span-2">
                <h4 class="text-white text-2xl font-extrabold mb-6 tracking-tight">Atlas Trek</h4>
                <p class="mb-6 max-w-sm text-gray-400 leading-relaxed">Connecting passionate travelers with authentic local experiences across the beautiful landscapes of Morocco.</p>
            </div>
            <div>
                <h4 class="text-white text-lg font-bold mb-6">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-transform">About Us</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-transform">Contact</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-transform">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-transform">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white text-lg font-bold mb-6">Newsletter</h4>
                <p class="mb-4 text-sm">Subscribe to get special offers and travel inspiration.</p>
                <div class="flex mt-2">
                    <input type="email" placeholder="Email address" class="px-4 py-3 w-full rounded-l-lg focus:outline-none text-gray-900 bg-gray-100">
                    <button class="bg-emerald-600 text-white px-5 py-3 rounded-r-lg hover:bg-emerald-500 transition-colors font-medium">Send</button>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-800 text-center text-sm flex flex-col md:flex-row justify-between items-center">
            <p>&copy; {{ date('Y') }} Atlas Trek. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-white transition-colors">Facebook</a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors">Instagram</a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors">Twitter</a>
            </div>
        </div>
    </footer>
</body>
</html>
