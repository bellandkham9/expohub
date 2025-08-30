
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
                    {{-- <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                        <span id="label-left" style="font-size: 13px;">2 Semaines</span>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input custom-toggle" type="checkbox" id="toggleSwitch">
                        </div>
                        <span id="label-right" style="font-size: 13px;">1 Mois</span>
                    </div> --}}
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
                                                        class="bi bi-check-circle-fill text-success me-2"></i>Nombres de
                                                        jours <b>{{ $abonnement->duree }}</b></li>
                                                <li class="mb-1"><i
                                                        class="bi bi-check-circle text-secondary me-2"></i>Simulations</li>
                                                <li class="mb-1"><i
                                                        class="bi bi-check-circle text-secondary me-2"></i>Corrections IA
                                                </li>
                                            </ul>

                                            <!-- Prix -->
                                            <h6 class="fw-bold mb-3" style="font-size: 18px;">{{ $abonnement->prix }} $
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
@include('start.chatbot')
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
