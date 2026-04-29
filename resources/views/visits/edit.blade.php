<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la visite — Atlas Trek</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 650px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h1 {
            color: #e67e22;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            color: #333;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
            box-sizing: border-box;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #e67e22;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-secondary {
            background: #888;
        }

        .error {
            color: #c0392b;
            font-size: 13px;
            margin-top: 4px;
        }

        .alert-errors {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        small {
            color: #888;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <h1>✏️ Modifier la visite</h1>

    {{-- Affiche les erreurs de validation --}}
    @if($errors->any())
    <div class="alert-errors">
        <strong>Corrigez les erreurs suivantes :</strong>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{--
        Pour modifier une ressource, on envoie en POST mais avec @method('PUT').
        L'URL inclut l'ID de la visite : route('visits.update', $visit->id)
        @csrf est toujours obligatoire.
    --}}
    <form action="{{ route('visits.update', $visit->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Simule une requête HTTP PUT (obligatoire pour update) --}}

        <!-- Titre -->
        <div class="form-group">
            <label for="title">Titre de la visite *</label>
            {{--
                old('title', $visit->title) :
                → Si le formulaire a été resoumis avec erreur : utilise la valeur saisie (old)
                → Sinon : utilise la valeur actuelle de la visite ($visit->title)
            --}}
            <input type="text" id="title" name="title"
                value="{{ old('title', $visit->title) }}">
            @error('title')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description *</label>
            <textarea id="description" name="description">{{ old('description', $visit->description) }}</textarea>
            @error('description')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Lieu -->
        <div class="form-group">
            <label for="location">Lieu *</label>
            <input type="text" id="location" name="location"
                value="{{ old('location', $visit->location) }}">
            @error('location')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Prix -->
        <div class="form-group">
            <label for="price">Prix (MAD) *</label>
            <input type="number" id="price" name="price"
                value="{{ old('price', $visit->price) }}"
                step="0.01" min="0">
            @error('price')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Durée -->
        <div class="form-group">
            <label for="duration">Durée (en heures) *</label>
            <input type="number" id="duration" name="duration"
                value="{{ old('duration', $visit->duration) }}"
                min="1">
            <small>Entrez le nombre d'heures</small>
            @error('duration')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Difficulté -->
        <div class="form-group">
            <label for="difficulty">Niveau de difficulté *</label>
            <select id="difficulty" name="difficulty">
                {{-- On compare la valeur actuelle pour pré-sélectionner la bonne option --}}
                <option value="facile"
                    {{ old('difficulty', $visit->difficulty) == 'facile' ? 'selected' : '' }}>
                    🟢 Facile
                </option>
                <option value="moyen"
                    {{ old('difficulty', $visit->difficulty) == 'moyen' ? 'selected' : '' }}>
                    🟡 Moyen
                </option>
                <option value="difficile"
                    {{ old('difficulty', $visit->difficulty) == 'difficile' ? 'selected' : '' }}>
                    🔴 Difficile
                </option>
            </select>
            @error('difficulty')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Max Places -->
        <div class="form-group">
            <label for="max_places">Nombre de places maximum *</label>
            <input type="number" id="max_places" name="max_places"
                value="{{ old('max_places', $visit->max_places) }}"
                min="1">
            @error('max_places')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Image :</label>
            <input type="file" name="image">
        </div>

        <!-- Boutons -->
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">💾 Mettre à jour</button>
            <a href="{{ route('guide.dashboard') }}" class="btn btn-secondary">Annuler</a>
        </div>

    </form>

</body>

</html>