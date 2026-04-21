<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>S'inscrire - Atlas Trek</title>
</head>
<body>
    <h2>Créer un compte Atlas Trek</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/register') }}" method="POST">
        @csrf

        <div>
            <label>Nom complet :</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <br>

        <div>
            <label>Adresse Email :</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <br>

        <div>
            <label>Mot de passe :</label><br>
            <input type="password" name="password" required>
        </div>
        <br>

        <div>
            <label>Confirmer le mot de passe :</label><br>
            <input type="password" name="password_confirmation" required>
        </div>
        <br>

        <div>
            <label>Je suis un :</label><br>
            <select name="role" required>
                <!-- On empêche de choisir admin ici ! -->
                <option value="voyageur">Voyageur</option>
                <option value="guide">Guide</option>
            </select>
        </div>
        <br>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
