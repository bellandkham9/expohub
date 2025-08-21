{{-- filepath: c:\wamp64\www\Expo\expohub\plateforme\resources\views\client\compte.blade.php --}}
@extends('layouts.app')
<style>
.custom-box {
    width: 50%;  /* Desktop */
}

@media (max-width: 992px) {  /* Tablette */
    .custom-box {
        width: 100%;
    }
}

@media (max-width: 576px) {  /* Mobile */
    .custom-box {
        width: 100%;
    }
}
</style>
@section('content')
    <div class="">
        {{-- Inclusion de la barre de navigation du client --}}
        @if(auth()->check())
            @include('client.partials.navbar-client')
        @else
            @include('client.partials.navbar')
        @endif
        <div class=" my-5 custom-box mx-auto p-4 rounded-3 shadow">
            <h2 class="mb-4">Mon compte</h2>
            <form action="{{ route('client.compte.update') }}" method="POST" enctype="multipart/form-data">
                {{-- Utilisez @csrf pour protéger le formulaire contre les failles CSRF --}}
                @csrf
                {{-- Si vous utilisez une méthode HTTP comme PUT ou PATCH, utilisez @method('PUT') --}}
                
                {{-- Formulaire de mise à jour du compte --}}
                <div class="row">
                    <div class="col-sm-6">
                        {{-- Champs de mise à jour des informations --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="Password" name="password" value="{{ auth()->user()->phone }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau Mot de passe</label>
                            <input type="password" class="form-control" id="Password" name="password" value="">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Répeter le nouveau Mot de passe</label>
                            <input type="password" class="form-control" id="Password" name="password" value="">
                        </div>
                    </div>   
                    <div class="col-sm-6">
                        {{-- Champ pour l'avatar --}}
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Photo de profil</label>
                            <div id="drop-area" style="border:2px dashed #ccc; border-radius:10px; padding:20px; text-align:center;">
                                <input type="file" id="avatar" name="avatar" accept="image/*" style="display:none;">
                                <p>Glissez-déposez votre image ici ou 
                                    <button type="button" onclick="document.getElementById('avatar').click()" class="btn btn-link p-0 m-0 align-baseline">sélectionnez</button>
                                </p>
                                <img id="preview" src="{{ auth()->user()->avatar_url ?? '' }}" alt="Aperçu" style="max-width:100%; max-height:150px; display:{{ auth()->user()->avatar_url ? 'block' : 'none' }};">
                            </div>
                            <div class="form-text">Formats acceptés : JPG, PNG, GIF. Taille maximale : 2 Mo.</div>
                        </div>
                    </div> 
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
            
            {{-- Section de suppression de compte --}}
            <div class="mt-5">
                <h3 class="mb-3">Zone de danger</h3>
                {{-- Le bouton déclenche l'ouverture de la modale de confirmation --}}
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    Supprimer mon compte
                </button>
            </div>
        </div>
    </div>

    {{-- Modale de confirmation de suppression de compte --}}
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.</p>
                    {{-- Formulaire de suppression avec méthode POST --}}
                    <form id="delete-form" action="{{ route('client.compte.destroy') }}" method="POST">
                        @csrf
                        {{-- Laravel convertira cette requête POST en une requête DELETE --}}
                        @method('DELETE')
                        <div class="mb-3">
                            <label for="password" class="form-label">Entrez votre mot de passe pour confirmer</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" form="delete-form" class="btn btn-danger">Je confirme la suppression</button>
                </div>
            </div>
        </div>
    </div>

@endsection