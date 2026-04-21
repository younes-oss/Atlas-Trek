<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Atlas Trek</title>
</head>
<body>
    <h2>Se connecter à Atlas Trek</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire de connexion -->
    <form action="{{ url('/login') }}" method="POST">
        <!-- CRITIQUE: Toujours ajouter @csrf dans un formulaire POST (Sécurité Laravel) -->
        @csrf

        <div>
            <label for="email">Adresse Email :</label><br>
            <!-- value=old('email') permet de garder le texte si la page recharge après une erreur -->
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>
        <br>

        <div>
            <label for="password">Mot de passe :</label><br>
            <input type="password" name="password" id="password" required>
        </div>
        <br>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
