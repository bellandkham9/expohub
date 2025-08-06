@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center">
        <img src="{{ asset('images/error-illustration.svg') }}" alt="Erreur" class="mb-4" width="250">
        <h2 class="text-danger mb-3">Test non disponible</h2>
        <p class="fs-5">Le test <strong>{{ $test }}</strong> n'est pas encore disponible. Veuillez réessayer plus tard.</p>
        <a href="{{ route('client.dashboard') }}" class="btn btn-primary mt-4">
            <i class="fas fa-home me-2"></i> Retour à l'accueil
        </a>
    </div>
</div>
@endsection
