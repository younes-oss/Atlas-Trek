<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guide</title>
</head>
<body>
    <h1>Bienvenue les guides</h1>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Se déconnecter</button>
    </form>
</body>
</html>
