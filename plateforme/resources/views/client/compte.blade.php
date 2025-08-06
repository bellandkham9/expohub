{{-- filepath: c:\wamp64\www\Expo\expohub\plateforme\resources\views\client\compte.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="">
        {{-- Include the client navbar --}}
        {{-- filepath: c:\wamp64\www\Expo\expohub\plateforme\resources\views\client\compte.blade.php --}}
        @if(auth()->check())
            @include('client.partials.navbar-client')
        @else
            @include('client.partials.navbar')
        @endif
        <div class="container my-5">
            <h2 class="mb-4">Mon compte</h2>
            <form action="{{ route('client.compte.update') }}" method="POST" enctype="multipart/form-data">
                {{-- route('client.compte.update') --}}
                @csrf
                {{-- @method('PUT') --}}
                <div class="row">

                    <div class="col-sm-6">
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
                <!-- Ajoute d'autres champs si besoin -->
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>


<script>
document.getElementById('drop-area').addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.background = '#f0f0f0';
});
document.getElementById('drop-area').addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.style.background = '';
});
document.getElementById('drop-area').addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.background = '';
    let files = e.dataTransfer.files;
    if(files.length) {
        document.getElementById('avatar').files = files;
        previewImage(files[0]);
    }
});
document.getElementById('avatar').addEventListener('change', function(e) {
    if(this.files.length) {
        previewImage(this.files[0]);
    }
});
function previewImage(file) {
    let reader = new FileReader();
    reader.onload = function(e) {
        let preview = document.getElementById('preview');
        preview.src = e.target.result;
        preview.style.display = 'block';
    }
    reader.readAsDataURL(file);
}
</script>    

@endsection