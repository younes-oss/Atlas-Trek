<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire - Atlas Trek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-white to-teal-50 min-h-screen flex items-center justify-center p-4">

    <!-- Decorative blobs -->
    <div class="fixed top-0 left-0 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="fixed bottom-0 right-0 w-96 h-96 bg-teal-400/20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <div class="w-full max-w-md relative z-10 py-8">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 group">
                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-105 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <span class="text-3xl font-black text-gray-900 tracking-tighter">Atlas Trek</span>
            </a>
            <p class="text-gray-500 mt-2 font-medium">Rejoignez l'aventure !</p>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-2xl shadow-gray-200/50 border border-white p-8 sm:p-10">
            <h2 class="text-2xl font-black text-gray-900 mb-6 text-center">Créer un compte</h2>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                        <ul class="text-sm font-medium text-red-800 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label for="name" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nom complet</label>
                    <div class="relative">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-gray-50 border-2 border-gray-100 focus:bg-white focus:border-emerald-500 focus:ring-0 outline-none transition-all font-bold text-gray-900 placeholder-gray-400"
                            placeholder="John Doe">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Adresse Email</label>
                    <div class="relative">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-gray-50 border-2 border-gray-100 focus:bg-white focus:border-emerald-500 focus:ring-0 outline-none transition-all font-bold text-gray-900 placeholder-gray-400"
                            placeholder="vous@exemple.com">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Mot de passe</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-gray-50 border-2 border-gray-100 focus:bg-white focus:border-emerald-500 focus:ring-0 outline-none transition-all font-bold text-gray-900 placeholder-gray-400"
                            placeholder="••••••••">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Confirmer mot de passe</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-gray-50 border-2 border-gray-100 focus:bg-white focus:border-emerald-500 focus:ring-0 outline-none transition-all font-bold text-gray-900 placeholder-gray-400"
                            placeholder="••••••••">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Je suis un :</label>
                    <div class="relative">
                        <select name="role" id="role" required
                            class="w-full pl-12 pr-10 py-3.5 rounded-2xl bg-gray-50 border-2 border-gray-100 focus:bg-white focus:border-emerald-500 focus:ring-0 outline-none transition-all font-bold text-gray-900 appearance-none">
                            <option value="voyageur" {{ old('role') == 'voyageur' ? 'selected' : '' }}>Voyageur - Je veux explorer</option>
                            <option value="guide" {{ old('role') == 'guide' ? 'selected' : '' }}>Guide - Je veux proposer des visites</option>
                        </select>
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-gray-900 text-white px-8 py-4 mt-2 rounded-2xl font-black tracking-wide transition-all shadow-lg shadow-emerald-200 hover:shadow-gray-200 active:scale-95 flex items-center justify-center gap-2">
                    Créer mon compte
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
            </form>
        </div>

        <p class="text-center mt-8 text-gray-500 font-medium">
            Déjà un compte ? 
            <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-gray-900 transition-colors underline decoration-2 underline-offset-4">Se connecter</a>
        </p>
    </div>

</body>
</html>
