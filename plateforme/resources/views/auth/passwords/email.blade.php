{{-- filepath: c:\wamp64\www\expohub\plateforme\resources\views\auth\passwords\email.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h1 class="mb-4 text-center">Mot de passe oublié</h1>
                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Votre email" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Envoyer le lien de réinitialisation</button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('auth.connexion') }}">← Retour à la connexion</a>
            </div>
        </div>
    </div>
</div>
@endsection