{{-- filepath: c:\wamp64\www\expohub\plateforme\resources\views\auth\passwords\reset.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="mb-4 text-center">🔑 Réinitialiser le mot de passe</h3>
                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Votre email" required autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Nouveau mot de passe" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer mot de passe" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Réinitialiser</button>
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