<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Bienvenue Admin</h1>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Se déconnecter</button>
    </form>
</body>
</html>
