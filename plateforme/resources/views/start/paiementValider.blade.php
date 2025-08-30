@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    @if(session('success'))
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h3 class="card-title mb-3">Paiement réussi !</h3>
                        <p class="card-text">Merci pour votre paiement. Votre abonnement a été activé.</p>
                        <a href="{{ route('client.dashboard') }}" class="btn btn-success mt-3">Aller au tableau de bord</a>
                    @elseif(session('error'))
                        <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                        <h3 class="card-title mb-3">Paiement échoué</h3>
                        <p class="card-text">Il y a eu un problème avec votre paiement. Veuillez réessayer.</p>
                        <a href="{{ route('client.dashboard') }}" class="btn btn-danger mt-3">Retour au tableau de bord</a>
                    @else
                        <i class="fas fa-info-circle fa-3x text-info mb-3"></i>
                        <h3 class="card-title mb-3">Information</h3>
                        <p class="card-text">Statut du paiement inconnu.</p>
                        <a href="{{ route('client.dashboard') }}" class="btn btn-primary mt-3">Retour au tableau de bord</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
