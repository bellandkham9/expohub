@extends('layouts.app')

@section('content')
<div class="bg-light">

    @if(auth()->check())
        @include('client.partials.navbar-client')
    @else
        @include('client.partials.navbar')
    @endif

    <div class="container my-4">
        <section id="hero-contact">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-6">
                    <h1 class="fw-bold">Contactez-nous facilement</h1>
                    <p>Une question sur nos tests ? Un problème technique ? Besoin d’assistance pour votre abonnement ? L’équipe Expohub est là pour vous répondre rapidement.</p>
                </div>
            </div>
        </section>
    </div>

    <div class="container py-5">
        <div class="row g-5 justify-content-center">
            <div class="col-12 col-md-10 col-lg-6">
                <div>
                    <h2 class="section-title">Coordonnées directes</h2>
                    <div id="phone-part" class="mb-3">
                        <h5 class="fw-bold mb-2">Téléphone</h5>
                        <div class="d-flex flex-column flex-md-row">
                            <p class="text-white me-md-4">
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
                            <a href="https://www.facebook.com/immigrationforus?mibextid=ZbWKwL"><i class="bi bi-facebook m-2"></i></a>
                            <a href="https://youtube.com/@exponentielimmigration?si=TpZ2KjA7mdJYpay2"><i class="bi bi-youtube m-2"></i></a>
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
            <div class="col-12 col-md-10 col-lg-6">
                <div class="contact-form bg-white p-4 rounded shadow-sm">
                    <h2 class="section-title">Formulaire de contact</h2>
                    <form method="POST" action="{{ route('envoyer.message') }}">
                        @csrf
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
                        <button style="border-radius: 30px; background-color: #224194; color: white;" type="submit" class="btn btn-send">Envoyer le message</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                 <div id="map" style="height: 400px; width: 100%; border-radius: 10px; margin-top: 30px;"></div>
            </div>
        </div>
    </div>
</div>
@include('start.chatbot')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map =  L.map('map').setView([4.0511, 9.7679], 13);// Coordonnées de Yaoundé par exemple
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([4.054442717762744, 9.734434536687301]).addTo(map)
            .bindPopup("Nous sommes ici !")
            .openPopup();
    });
</script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<style>
    /* Pas de modifications CSS pour préserver votre design existant */
</style>
@endsection