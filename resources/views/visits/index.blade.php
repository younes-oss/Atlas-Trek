<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Visites — Atlas Trek</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h1 {
            color: #2d6a4f;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #2d6a4f;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-danger {
            background: #c0392b;
        }

        .btn-warning {
            background: #e67e22;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f1f1f1;
            font-weight: bold;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .nav {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-facile {
            background: #d4edda;
            color: #155724;
        }

        .badge-moyen {
            background: #fff3cd;
            color: #856404;
        }

        .badge-difficile {
            background: #f8d7da;
            color: #721c24;
        }

        .empty {
            text-align: center;
            color: #888;
            padding: 40px;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <div class="nav">
        <a href="{{ route('guide.dashboard') }}" class="btn">← Dashboard Guide</a>
        <a href="{{ route('visits.create') }}" class="btn">+ Créer une visite</a>

        <form action="{{ route('logout') }}" method="POST" style="margin-left: auto;">
            @csrf
            <button type="submit" class="btn btn-danger">Se déconnecter</button>
        </form>
    </div>

    <h1>🗺️ Mes Visites</h1>

    {{-- Message de succès (affiché après create/update/delete) --}}
    @if(session('success'))
    <div class="alert-success">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Si le guide n'a aucune visite --}}
    @if($visits->isEmpty())
    <div class="empty">
        <p>Vous n'avez pas encore créé de visite.</p>
        <a href="{{ route('visits.create') }}" class="btn">Créer ma première visite</a>
    </div>
    @else
    {{-- Tableau de toutes les visites du guide --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Lieu</th>
                <th>Prix</th>
                <th>Durée</th>
                <th>Difficulté</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach parcourt chaque visite et crée une ligne --}}
            @foreach($visits as $visit)
            <tr>
                <td><img src="{{ asset('storage/' . $visit->image) }}"
                        width="200"
                        style="border-radius:10px;"></td>
                <td><strong>{{ $visit->title }}</strong></td>
                <td>📍 {{ $visit->location }}</td>
                <td>{{ number_format($visit->price, 2) }} MAD</td>
                <td>{{ $visit->duration }}h</td>
                <td>
                    {{-- Badge coloré selon la difficulté --}}
                    <span class="badge badge-{{ $visit->difficulty }}">
                        {{ ucfirst($visit->difficulty) }}
                    </span>
                </td>
                <td>
                    {{-- Bouton Modifier --}}
                    <a href="{{ route('visits.edit', $visit->id) }}" class="btn btn-warning">✏️ Modifier</a>

                    {{-- Bouton Supprimer → envoie une requête DELETE --}}
                    {{-- Les navigateurs ne supportent que GET et POST,
                                 donc on utilise @method('DELETE') pour simuler DELETE --}}
                    <form action="{{ route('visits.destroy', $visit->id) }}" method="POST"
                        style="display:inline;"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette visite ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</body>

</html>