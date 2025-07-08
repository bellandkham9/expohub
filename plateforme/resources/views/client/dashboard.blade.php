@extends('layouts.app')

@section('content')
    <div class="m-4">

        <!-- Header -->
        <nav class="navbar navbar-expand-lg bg-white  sticky-top">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand fw-bold text-primary" href="#">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
                </a>

                <!-- Burger button (mobile) -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu & right side -->
                <div class="collapse navbar-collapse justify-content-between" id="mainNavbar">
                    <!-- Centred menu -->
                    <ul class="navbar-nav mx-auto gap-4">
                        <li class="nav-item"><a class="nav-link" href="#">Tableau de bord</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Test</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Historique</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Stratégie</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Nous contactez</a></li>
                    </ul>

                    <!-- Droite : notif + avatar -->
                    <div class="d-flex align-items-center gap-3">
                        <i class="btn bi bi-bell" style="font-size: 1.3rem;"></i>
                        <img src="{{ asset('images/beautiful-woman.png') }}" alt="Profil" class="rounded-circle"
                            style="width: 35px; height: 35px; object-fit: cover;">
                        <i class="btn bi bi-caret-down-fill"></i>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Banner -->
        <div class="container my-4">
            <section id="">
                <div class="row justify-between align-items-start g-4">

                    <div class="col-lg-9">
                        <!-- Section Hero -->
                        <section class="hero-section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8  text-start">
                                        <h2>Nulla quis lorem ut libero malesuada feugiat.</h2>
                                        <p>Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Curabitur
                                            aliquet quam id dui posuere blandit. Quisque velit nisi, pretium ut lacinia in,
                                            elementum id enim. Nulla quis lorem ut libero malesuada feugiat.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Section Tests Disponibles -->
                        <section class="container mb-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="test-card text-center">
                                        <h3 class="test-title">TCF CANADA</h3>
                                        <p>Une petite description ici pour parler du test!</p>
                                        <button class="btn btn-test">Passer le test</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="test-card text-center">
                                        <h3 class="test-title">TCF QUEBEC</h3>
                                        <p>Une petite description ici pour parler du test!</p>
                                        <button class="btn btn-test">Passer le test</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="container m-6">

                                    <div class="text-start mt-3">
                                        <a href="#" class="btn-show-more" style="color: black">Aficher tout les test
                                            <i class="fas fa-chevron-down"></i></a>
                                    </div>

                                </div>
                                <div class="" style="max-height: 70vh; overflow-y: auto;">
                                    <ul class="">
                                        <li>
                                            <div class="container my-3">
                                                <div class="border rounded shadow-sm p-3">
                                                    <div class="d-flex flex-column flex-md-row justify-content-between">
                                                        <div>
                                                            <h6 class="fw-bold mb-1">TCF CANADA, expression écrit</h6>
                                                        </div>
                                                        <div class="text-md-end text-muted small">
                                                            <div><strong>60 min</strong></div>
                                                            <div>11 Déc 2025</div>
                                                        </div>
                                                    </div>
                                                    <hr class="my-2">
                                                    <div class="row g-2 mb-3">

                                                        <div class="col-md-8">
                                                            <div class="row g-2 mb-3">
                                                                <div class="col-md-5">
                                                                    <strong>Résultats :</strong> 600
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <strong>Réponses exactes :</strong> 65 / 78
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">

                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="row g-2 mb-3">
                                                                <div class="col-4 col-md-5">
                                                                    <strong>Niveau :</strong> C2
                                                                </div>
                                                                <div class="col-8 col-md-7">
                                                                    <strong>Réponses fausses :</strong> 13 / 78
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div
                                                                class="d-flex flex-column flex-md-row justify-content-end gap-2">
                                                                <a href="#" class="btn "
                                                                    style="border: 2px solid #224194;">Plus de
                                                                    détails</a>
                                                                <a href="#" class="btn "
                                                                    style="background-color:  #224194; color: white;">Refaire
                                                                    le
                                                                    test</a>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                        </li>
                                        <li>
                                            <div class="container my-3">
                                                <div class="border rounded shadow-sm p-3">
                                                    <div class="d-flex flex-column flex-md-row justify-content-between">
                                                        <div>
                                                            <h6 class="fw-bold mb-1">TCF CANADA, expression écrit</h6>
                                                        </div>
                                                        <div class="text-md-end text-muted small">
                                                            <div><strong>60 min</strong></div>
                                                            <div>11 Déc 2025</div>
                                                        </div>
                                                    </div>
                                                    <hr class="my-2">
                                                    <div class="row g-2 mb-3">

                                                        <div class="col-md-8">
                                                            <div class="row g-2 mb-3">
                                                                <div class="col-md-5">
                                                                    <strong>Résultats :</strong> 600
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <strong>Réponses exactes :</strong> 65 / 78
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">

                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="row g-2 mb-3">
                                                                <div class="col-4 col-md-5">
                                                                    <strong>Niveau :</strong> C2
                                                                </div>
                                                                <div class="col-8 col-md-7">
                                                                    <strong>Réponses fausses :</strong> 13 / 78
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div
                                                                class="d-flex flex-column flex-md-row justify-content-end gap-2">
                                                                <a href="#" class="btn "
                                                                    style="border: 2px solid #224194;">Plus de
                                                                    détails</a>
                                                                <a href="#" class="btn "
                                                                    style="background-color:  #224194; color: white;">Refaire
                                                                    le
                                                                    test</a>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </section>

                        <section class="container mb-5">

                            <div class="text-start mt-3">
                                <a href="#" class="btn-show-more" style="color: black">Afficher vos résultats <i
                                        class="fas fa-chevron-down"></i></a>
                            </div>
                            <div class="row g-4 justify-content-center mt-2 mb-1">

                                <!-- Première carte de résultat -->
                                <div class="col-12  col-md-10 col-lg-6">
                                    <div class="result-card astuce p-4 h-100 text-justify">
                                        <p class="text-justify justify-evenly">Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Integer interdum quam eu sem lobortis, et dignissim nunc
                                            rhoncus. Curabitur finibus, dolor nec vestibulum consectetur, arcu diam
                                            vestibulum nisl, sit amet imperdiet magna nulla sed magna. Donec fermentum
                                            aliquam ligula in lobortis. Morbi aliquam, massa in vestibulum eleifend, nibh
                                            lacus bibendum mi, at commodo metus sem ut enim. Duis mauris magna, ornare ut
                                            viverra at, sollicitudin at turpis. Praesent v</p>

                                    </div>
                                </div>

                                <!-- Deuxième carte de résultat -->
                                <div class="col-12  col-md-10 col-lg-6">
                                    <div class="result-card astuce p-4 h-100 text-justify">
                                        <p class="text-justify justify-evenly">Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Integer interdum quam eu sem lobortis, et dignissim nunc
                                            rhoncus. Curabitur finibus, dolor nec vestibulum consectetur, arcu diam
                                            vestibulum nisl, sit amet imperdiet magna nulla sed magna. Donec fermentum
                                            aliquam ligula in lobortis. Morbi aliquam, massa in vestibulum eleifend, nibh
                                            lacus bibendum mi, at commodo metus sem ut enim. Duis mauris magna, ornare ut
                                            viverra at, sollicitudin at turpis. Praesent v</p>

                                    </div>
                                </div>
                            </div>

                            <div class="text-start mt-3">
                                <a href="#" class="btn-show-more" style="color: black">Afficher plus de stratégies
                                    <i class="fas fa-chevron-down"></i></a>
                            </div>
                        </section>

                    </div>
                    <div class="col-lg-3">
                        <div class="card text-center p-3 rounded-4 shadow-sm" style="background-color: #ebe9e9;">
                            <div class="d-flex justify-center align-items-center gap-2">
                                <img src="{{ asset('images/beautiful-woman.png') }}" alt="Emmanuelle"
                                    class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                <h6 class="fw-bold mb-0">Emmanuelle</h6>
                            </div>

                            <hr class="my-2">
                            <p class="fw-semibold text-start ms-2 mb-2">Niveau de langue</p>

                            <div class="d-grid gap-2" style="grid-template-columns: repeat(2, 1fr); display: grid; ">
                                <div class=" p-2 rounded shadow-sm fw-semibold">TCF CANADA<br><span
                                        class="fw-normal">A1</span></div>
                                <div class="p-2 rounded shadow-sm fw-semibold">TCF QUEBEC<br><span
                                        class="fw-normal">A1</span></div>
                                <div class=" p-2 rounded shadow-sm fw-semibold">TEF<br><span class="fw-normal">A1</span>
                                </div>
                                <div class=" p-2 rounded shadow-sm fw-semibold">DELF<br><span class="fw-normal">A1</span>
                                </div>
                                <div class=" p-2 rounded shadow-sm fw-semibold" style="grid-column: span 2;">
                                    DALF<br><span class="fw-normal">A1</span></div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
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
                                    class="bi bi-facebook m-2"></i></a>
                            <a href=""><i class="bi bi-linkedin m-2"></i></a> <a href=""><i
                                    class="bi bi-instagram m-2"></i></a>
                        </p>
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
