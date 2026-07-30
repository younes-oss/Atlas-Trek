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

        <!-- ═══ Détails du séjour ═══ -->
        <div class="form-group" style="border-top: 1px solid #eee; padding-top: 18px; margin-top: 10px;">
            <label style="color: #e67e22; font-size: 14px;">🏕️ Détails du séjour</label>
        </div>

        <!-- Logement -->
        <div class="form-group" style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
            <label style="color: #27ae60; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">🏡 Logement</label>
            <div style="margin-bottom: 10px;">
                <label for="logement" style="font-size: 13px;">Type (ex: Bivouac)</label>
                <input type="text" id="logement" name="logement" value="{{ old('logement', $visit->logement) }}">
                @error('logement') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div style="margin-bottom: 10px;">
                <label for="logement_desc" style="font-size: 13px;">Description détaillée</label>
                <textarea id="logement_desc" name="logement_desc" style="height: 70px;">{{ old('logement_desc', $visit->logement_desc) }}</textarea>
                @error('logement_desc') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div>
                <label for="logement_img" style="font-size: 13px;">Nouvelle image (optionnel)</label>
                <input type="file" id="logement_img" name="logement_img">
                @error('logement_img') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Transport -->
        <div class="form-group" style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
            <label style="color: #2980b9; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">🚙 Transport</label>
            <div style="margin-bottom: 10px;">
                <label for="transport" style="font-size: 13px;">Type (ex: Minibus)</label>
                <input type="text" id="transport" name="transport" value="{{ old('transport', $visit->transport) }}">
                @error('transport') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div style="margin-bottom: 10px;">
                <label for="transport_desc" style="font-size: 13px;">Description détaillée</label>
                <textarea id="transport_desc" name="transport_desc" style="height: 70px;">{{ old('transport_desc', $visit->transport_desc) }}</textarea>
                @error('transport_desc') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div>
                <label for="transport_img" style="font-size: 13px;">Nouvelle image (optionnel)</label>
                <input type="file" id="transport_img" name="transport_img">
                @error('transport_img') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Repas -->
        <div class="form-group" style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
            <label style="color: #f39c12; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">🍽️ Repas</label>
            <div style="margin-bottom: 10px;">
                <label for="repas" style="font-size: 13px;">Type (ex: Pension complète)</label>
                <input type="text" id="repas" name="repas" value="{{ old('repas', $visit->repas) }}">
                @error('repas') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div style="margin-bottom: 10px;">
                <label for="repas_desc" style="font-size: 13px;">Description détaillée</label>
                <textarea id="repas_desc" name="repas_desc" style="height: 70px;">{{ old('repas_desc', $visit->repas_desc) }}</textarea>
                @error('repas_desc') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div>
                <label for="repas_img" style="font-size: 13px;">Nouvelle image (optionnel)</label>
                <input type="file" id="repas_img" name="repas_img">
                @error('repas_img') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- ═══ Dates de la visite ═══ -->
        <div class="form-group" style="border-top: 1px solid #eee; padding-top: 18px; margin-top: 10px;">
            <label style="color: #e67e22; font-size: 14px;">📅 Planification</label>
        </div>

        <div class="form-group">
            <label for="date_depart">Date de départ *</label>
            <input type="datetime-local" id="date_depart" name="date_depart"
                value="{{ old('date_depart', $visit->date_depart ? $visit->date_depart->format('Y-m-d\TH:i') : '') }}">
            @error('date_depart')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_fin">Date de fin <small>(optionnel)</small></label>
            <input type="datetime-local" id="date_fin" name="date_fin"
                value="{{ old('date_fin', $visit->date_fin ? $visit->date_fin->format('Y-m-d\TH:i') : '') }}">
            @error('date_fin')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_limite_reservation">Date limite de réservation *</label>
            <input type="datetime-local" id="date_limite_reservation" name="date_limite_reservation"
                value="{{ old('date_limite_reservation', $visit->date_limite_reservation ? $visit->date_limite_reservation->format('Y-m-d\TH:i') : '') }}">
            <small>Les réservations seront fermées après cette date.</small>
            @error('date_limite_reservation')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Boutons -->
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">💾 Mettre à jour</button>
            <a href="{{ route('guide.dashboard') }}" class="btn btn-secondary">Annuler</a>
        </div>

    </form>

</body>

</html>