@extends('layouts.app')

@section('content')
<div class="bg-light">

    @include('client.partials.navbar')

    <!-- Hero Banner -->
    <div class="container my-4">
        <section id="hero-contact">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h1 class="fw-bold">Contactez-nous facilement
                    </h1>
                    <p>Une question sur nos tests ? Un problème technique ? Besoin d’assistance pour votre abonnement ?
                        L’équipe Expohub est là pour vous répondre rapidement..</p>

                </div>
            </div>
        </section>
    </div>
    <div class="contact-container">
        <div class="row justify-center">
            <div class="col-md-6">
                <!-- Section Coordonnées directes -->
                <div class="contact-info">
                    <h2 class="section-title">Coordonnées directes</h2>

                    <div id="phone-part" class="mb-3">
                        <h5 class="fw-bold mb-2">Téléphone</h5>
                        <div class="d-flex">
                            <p class="text-white">
                                <i class="bi bi-whatsapp me-1 m-4"></i>
                                +237 6 99 00 00 00
                            </p>

                            <p class="text-white">
                                <i class="bi bi-whatsapp me-1 m-4"></i>
                                +237 6 99 00 00 00
                            </p>
                        </div>

                    </div>

                    <div id="email-part" class="mb-3">
                        <h5 class="fw-bold mb-2">Email</h5>
                        <p class="text-white">
                            <i class="bi bi-envelope-fill me-1"></i>
                            contact@expohubacademy.com
                        </p>
                        <p class="text-white">
                            <i class="bi bi-envelope-fill me-1"></i>
                            contact@expohubacademy.com
                        </p>

                    </div>

                    <div id="social-part" class="mb-3">
                        <h5 class="fw-bold mb-2">Réseaux sociaux</h5>
                        <div class="social-icons">
                            <div class="social-icon btn"><i class="bi bi-facebook text-white fs-4"></i></div>
                            <div class="social-icon btn"><i class="bi bi-linkedin text-white fs-4"></i></div>
                            <div class="social-icon btn"><i class="bi bi-instagram text-white fs-4"></i></div>
                        </div>
                    </div>

                    <div id="location-part" class="mb-3">
                        <h5 class="fw-bold mb-2">Adresse</h5>
                        <p class="text-white">
                            <i class="bi bi-geo-alt-fill me-1"></i>
                            contact@expohubacademy.com
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Section Formulaire de contact -->
                <div class="contact-form">
                    <h2 class="section-title">Formulaire de contact</h2>

                    <form method="POST" action="{{ route('envoyer.message') }}">
                        <!-- Si vous utilisez Blade -->

                        @csrf
                        <!-- Optionnel si vous utilisez Axios/Fetch avec le header 'X-CSRF-TOKEN' -->

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom*</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Numéro*</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail*</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message*</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-send">Envoyer le message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
