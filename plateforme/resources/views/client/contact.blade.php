@extends('layouts.app')

@section('content')
    <div class="bg-light">

        <!-- Header -->
        <nav class="navbar navbar-expand-lg bg-white sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="#">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
                </a>


                <!-- Menu -->
                <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
                    <ul class="navbar-nav gap-3">
                        <li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Stratégie</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Plans d'abonnements</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Nous contacter</a></li>
                    </ul>
                </div>
                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <a id="btn-commencer" class="btn" href="#">Commencez maintenant</a>
                    <a id="btn-connecter" class="btn btn-outline-primary" href="#">Se Connecter</a>
                </div>
                <!-- Burger button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>


            </div>
        </nav>


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
                                <div class="social-icon"><i class="bi bi-facebook text-white fs-4"></i></div>
                                <div class="social-icon"><i class="bi bi-linkedin text-white fs-4"></i></div>
                                <div class="social-icon"><i class="bi bi-instagram text-white fs-4"></i></div>
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

                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom*</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Numéro*</label>
                                <input type="tel" class="form-control" id="phone" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail*</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="4"></textarea>
                            </div>

                            <button id="sendmessage" type="submit" class="btn btn-send">Envoyer le message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="container mb-4  p-4 text-light">
            <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div>
                    <p class="mb-1 fw-bold">Allez à</p>
                    <ul class="list-unstyled d-flex gap-3">
                        <li><a href="#" class="text-white text-decoration-none">Accueil</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Stratégie</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Abonnements</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Contact</a></li>
                    </ul>

                    <div class="">
                        <p class="mt-2 fw-bold">Suivez nous sur : <a href=""><i
                                    class="bi bi-facebook m-2"></i></a> <a href=""><i
                                    class="bi bi-linkedin m-2"></i></a> <a href=""><i
                                    class="bi bi-instagram m-2"></i></a></p>
                    </div>


                </div>
                <div class="d-flex flex-column align-items-end text-end">
                    <div class="d-flex gap-2 mb-3">
                        <a class="btn" href="#"
                            style="background-color: #D9D9D9; border-radius: 30px; color: black;">S'inscrire</a>
                        <a class="btn" href="#"
                            style="background-color: #D9D9D9; border-radius: 30px; color: black;">Se connecter</a>
                    </div>
                    <div>
                        <small>
                            <a href="#" class="text-decoration-none text-light me-2">Conditions d'utilisation</a>
                            <a href="#" class="text-decoration-none text-light">Politique de confidentialité</a>
                        </small>
                    </div>
                </div>

            </div>
            <hr style="height: 3px; background-color: white; border: 2px solid white;" class="">
            <div class="container text-center mt-3">
                <small class="d-block">&copy; 2025 ExpoHub Academy | tout les droits réservés</small>

            </div>
        </footer>


    </div>
@endsection
