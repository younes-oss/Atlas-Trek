<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Voyageur</title>
</head>
<body>
    <h1>Bienvenue voyageur</h1>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Se déconnecter</button>
    </form>
</body>
</html>
