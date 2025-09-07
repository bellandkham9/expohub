@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">

            @if(session('success') || isset($success))
                <div class="alert alert-success">
                    <h3>🎉 Paiement réussi !</h3>
                    <p>Merci, votre paiement a été validé avec succès.</p>
                </div>
            @elseif(session('error') || isset($error))
                <div class="alert alert-danger">
                    <h3>❌ Paiement échoué</h3>
                    <p>Votre paiement n’a pas été validé. Veuillez réessayer ou contacter le support.</p>
                </div>
            @else
                <div class="alert alert-info">
                    <h3>⏳ Paiement en cours...</h3>
                    <p>Nous vérifions votre paiement. Cela peut prendre quelques secondes.</p>
                </div>
            @endif

            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Retour à l’accueil</a>
        </div>
    </div>
</div>
@endsection
