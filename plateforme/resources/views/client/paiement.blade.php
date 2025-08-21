{{-- @extends('layouts.app')

@section('content')
<div class="">

     @if (auth()->check())
            @include('client.partials.navbar-client')
        @else
            @include('client.partials.navbar')
        @endif
   
    <!-- Hero Banner -->
    <div class="container my-4">
        <section id="">
            <div class="container">
                <!-- En-tête -->
                <div class="header-section mt-4 text-center mx-auto" style="max-width: 700px;">
                    <h2 class="mb-3 fw-bold">Choisissez votre formule d'entraînement et testez-vous en conditions
                        réelles</h2>
                    <p class="lead">Accédez à des tests interactifs et corrigés automatiquement pour préparer
                        efficacement votre certification (TCF, DELF, TEF, etc.)</p>

                    <!-- Toggle Langue -->
                    <div class="d-flex justify-content-center align-items-center gap-3 mt-3">
                        <span id="label-left" class="fw-medium">2 Semaine</span>

                        <div class="form-check form-switch">
                            <input class="form-check-input custom-toggle" type="checkbox" id="toggleSwitch">
                        </div>

                        <span id="label-right" class="fw-medium">1 mois</span>
                    </div>
                </div>


                <!-- Pricing 2 - Bootstrap Brain Component -->
                <section class="bsb-pricing-2 bg-light py-5 py-xl-8 mr-5 ml-5 p-3">
                    <div class="container">
                        <div class="row gx-4 gy-5 justify-content-center">
                            @foreach ($abonnements as $abonnement)
                                <div class="col-12 col-lg-4">
                                    <div class="card shadow border-0 h-100">
                                        <div class="card-body p-4">
                                            <h2 class="h4 mb-2">{{ $abonnement->nom_du_plan }}</h2>
                                            <p class="mb-4">Évaluez vos compétences pour l'immigration au Canada.</p>

                                            <ul class=" list-group-flush mb-4">
                                                <!-- Icônes et avantages -->
                                                <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span style="font-weight: bold">Nombres de teste</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Simulations</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </ul>

                                            <h6 class="display-6 fw-bold mb-0">{{ $abonnement->prix }} Frs</h6>

                                            <!-- Bouton pour ouvrir le modal -->
                                            <div type="button" id="s_abonner" href="#!" style="border: 3px solid #224194; border-radius: 15px; width: 100%; font-size: 24px; font-weight: bold;" class="btn mt-4 p-3" data-bs-toggle="modal" data-bs-target="#modalAbonnement{{ $abonnement->id }}">
                                                S’abonner
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MODAL pour cet abonnement -->
                                <div class="modal fade" id="modalAbonnement{{ $abonnement->id }}" tabindex="-1" aria-labelledby="abonnementLabel{{ $abonnement->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content shadow-lg">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="abonnementLabel{{ $abonnement->id }}">Méthodes de paiement</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row gx-4 gy-5 justify-content-center" style="color: #224194; font-weight: bold; font-size: 16px;">

                                            <div class="card shadow border-0 col-6" alt="Paiement" style="border: 3px solid #224194; text-align: center; border-radius: 15px; padding: 10px;">
                                                <form action="{{ route('paiement.process', ['abonnement' => $abonnement->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="paiement-link" style="all: unset; cursor: pointer; display: block; width: 100%; height: 100%;">
                                                        <img src="{{ asset('images/card.png') }}" style="width: 50px; height: 50px;">
                                                        <img src="{{ asset('images/phone.png') }}" style="width: 50px; height: 50px;">
                                                        <p>Paiement par Mobile Money ou Carte Bancaire</p>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="card shadow border-0 col-6" alt="Paiement" style="border: 3px solid #224194; text-align: center; border-radius: 15px; padding: 10px;">
                                                <a href="https://wa.me/NUMERO?text=Bonjour%2C%20je%20souhaite%20avoir%20plus%20d'informations%20sur%20le%20paiement" target="_blank" class="whatsapp-link">
                                                    <img src="{{ asset('images/western-union.png') }}"  style="width: 50px; height: 50px;">
                                                    <p>Autres services Western Union, etc ...</p>
                                                </a>
                                            </div>
<style>
    .whatsapp-link {
        color: #224194;
        background-color: transparent;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: color 0.2s;
    }
    .whatsapp-link p,
    .whatsapp-link img {
        transition: color 0.2s, filter 0.2s;
    }
    .whatsapp-link:hover,
    .whatsapp-link:focus {
        color: #fff !important;
    }
    .whatsapp-link:hover p,
    .whatsapp-link:hover img {
        color: #fff !important;
        filter: brightness(0) invert(1);
    }

    .paiement-link {
        color: #224194;
        background-color: transparent;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: color 0.2s;
    }
    .paiement-link p,
    .paiement-link img {
        transition: color 0.2s, filter 0.2s;
    }
    .paiement-link:hover,
    .paiement-link:focus {
        color: #fff !important;
    }
    .paiement-link:hover p,
    .paiement-link:hover img {
        color: #fff !important;
        filter: brightness(0) invert(1);
    }
</style>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                        </div>
                </section>
            </div>

        </section>
    </div>
</div>

<script>
    const toggle = document.getElementById("toggleSwitch");

    toggle.addEventListener("change", () => {
        if (toggle.checked) {
            console.log("Anglais sélectionné");
        } else {
            console.log("Français sélectionné");
        }
    });

</script>
@endsection
 --}}

@extends('layouts.app')

@section('content')
    <div class="">
        @if (auth()->check())
            @include('client.partials.navbar-client')
        @else
            @include('client.partials.navbar')
        @endif

        {{-- Styles et animations --}}
        <style>
            #main-content {
                width: 70%;
                margin: 0 auto;

            }

            .pricing-card {
                border-radius: 15px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .pricing-card:hover {
                transform: translateY(-5px) scale(1.02);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            .subscribe-btn {
                border: 2px solid #224194;
                border-radius: 12px;
                background-color: #fff;
                color: #224194;
                transition: all 0.3s ease;
                font-size: 14px;
            }

            .subscribe-btn:hover {
                background-color: #224194;
                color: #fff;
                transform: scale(1.05);
                box-shadow: 0 6px 15px rgba(34, 65, 148, 0.4);
            }

            .card {
                box-shadow: 2px 2px 2px 2px gainsboro;
            }

            h1 {
                font-size: 32px;
            }


            @media (max-width: 992px) {

                /* Tablette */
                h1 {
                    font-size: 18px;
                }

                #main-content {
                    width: 100%;
                }
            }

            @media (max-width: 576px) {

                /* Mobile */
                h1 {
                    font-size: 18px;
                }

                #main-content {
                    width: 100%;
                }
            }
        </style>

        <!-- Section Abonnements -->
        <div class="container my-3">
            <section id="">
                <!-- En-tête -->
                <div class="header-section text-center mx-auto mb-3" style="max-width: 700px;">
                    <h1 class="fw-bold mb-2">
                        Choisissez votre formule d'entraînement et testez-vous en conditions réelles
                    </h1>
                    <p class="text-muted" style="font-size: 14px;">
                        Accédez à des tests interactifs et corrigés automatiquement pour préparer efficacement votre
                        certification (TCF, DELF, TEF, etc.)
                    </p>

                    <!-- Toggle Langue -->
                    <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                        <span id="label-left" style="font-size: 13px;">2 Semaines</span>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input custom-toggle" type="checkbox" id="toggleSwitch">
                        </div>
                        <span id="label-right" style="font-size: 13px;">1 Mois</span>
                    </div>
                </div>

                <!-- Cards abonnements -->
                <section class="bsb-pricing  p-2">
                    <div class="container-fluid">
                        <div id="main-content" class="row g-3 justify-content-center">
                            @foreach ($abonnements as $abonnement)
                                <div class="col-12 col-md-4 mb-3">
                                    <div class="card pricing-card shadow-2xl border-0 h-100 text-center p-3">
                                        <div class="card-body d-flex flex-column">
                                            <!-- Nom du pack -->
                                            <h5 class="fw-bold mb-1" style="font-size: 16px;">{{ $abonnement->nom_du_plan }}
                                                :<span>{{ $abonnement->examen }}</span>
                                            </h5>
                                            <p class="mb-2 text-muted" style="font-size: 13px;">
                                                {{ $abonnement->description }}.</p>

                                            <!-- Avantages -->
                                            <ul class="list-unstyled text-start mb-3" style="font-size: 13px;">
                                                <li class="mb-1"><i
                                                        class="bi bi-check-circle-fill text-success me-2"></i><b>Nombres de
                                                        tests</b></li>
                                                <li class="mb-1"><i
                                                        class="bi bi-check-circle text-secondary me-2"></i>Simulations</li>
                                                <li class="mb-1"><i
                                                        class="bi bi-check-circle text-secondary me-2"></i>Corrections IA
                                                </li>
                                            </ul>

                                            <!-- Prix -->
                                            <h6 class="fw-bold mb-3" style="font-size: 18px;">{{ $abonnement->prix }} Frs
                                            </h6>

                                            <!-- Bouton -->
                                            <button type="button" class="btn subscribe-btn mt-auto fw-bold py-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalAbonnement{{ $abonnement->id }}">
                                                S’abonner
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- MODAL -->
                                <div class="modal fade" id="modalAbonnement{{ $abonnement->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content shadow-lg">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Méthodes de paiement</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3 text-center">
                                                    <!-- Paiement direct -->
                                                    <div class="col-6">
                                                        <form
                                                            action="{{ route('paiement.process', ['abonnement' => $abonnement->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="paiement-link w-100 border p-2 rounded">
                                                                <img src="{{ asset('images/card.png') }}" width="40">
                                                                <img src="{{ asset('images/phone.png') }}" width="40">
                                                                <p style="font-size: 12px;">Mobile Money / Carte</p>
                                                            </button>
                                                        </form>
                                                    </div>

                                                    <!-- Autres moyens -->
                                                    <div class="col-6">
                                                        <a href="https://wa.me/NUMERO?text=Bonjour%2C%20je%20souhaite%20avoir%20plus%20d'informations%20sur%20le%20paiement"
                                                            target="_blank"
                                                            class="whatsapp-link w-100 border p-2 rounded d-block">
                                                            <img src="{{ asset('images/western-union.png') }}"
                                                                width="40">
                                                            <p style="font-size: 12px;">Western Union, etc.</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </section>
        </div>
    </div>

    <style>
        .whatsapp-link:hover,
        .paiement-link:hover {
            background-color: #224194 !important;
            color: #fff !important;
        }

        .whatsapp-link:hover img,
        .paiement-link:hover img {
            filter: brightness(0) invert(1);
        }
    </style>

    <script>
        document.getElementById("toggleSwitch").addEventListener("change", (e) => {
            console.log(e.target.checked ? "1 mois sélectionné" : "2 semaines sélectionné");
        });
    </script>
@endsection
