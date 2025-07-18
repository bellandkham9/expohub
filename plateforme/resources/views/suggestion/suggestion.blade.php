@extends('layouts.app')

@section('content')
    <div class="m-4">

       @include('client.partials.navbar')
   
        <!-- Hero Banner -->
        <div class="container my-4">

            <div class="container py-4">
                <!-- Search bar -->
                <div class="mb-4 position-relative">
                    <input type="text" class="form-control search-bar" placeholder="🔍 Chercher...">
                </div>

                <!-- Navigation tabs -->
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item"><a class="nav-link active" href="#">Touts</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Vidéos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Exercices</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Recommandations</a></li>
                </ul>

                <!-- Section title -->
                <h6 class="section-title">Astuces écrites</h6>

                <div class="overflow-y-auto" style="max-height: 400px;">
                    <!-- Tips grid -->
                    <div class="row g-3 m-2">
                        <!-- Tip Card -->
                        <div class="col-md-4">
                            <div class="card card-tip p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-tip me-2">💡 Digital Marketing</span>
                                </div>
                                <p class="tip-text mb-0">
                                    Sed porttitor lectus nibh. Curabitur non nulla sit amet nisl tempus convallis quis ac
                                    lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Nulla porttitor
                                    accumsan tincidunt. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                    Curabitur aliquet quam id dui posuere blandit.
                                </p>
                            </div>
                        </div>

                        <!-- Duplicate more cards as needed -->
                        <div class="col-md-4">
                            <div class="card card-tip p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-tip me-2">💡 Digital Marketing</span>
                                </div>
                                <p class="tip-text mb-0">
                                    Sed porttitor lectus nibh. Curabitur non nulla sit amet nisl tempus convallis quis ac
                                    lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Nulla porttitor
                                    accumsan tincidunt. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                    Curabitur aliquet quam id dui posuere blandit.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-tip p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-tip me-2">💡 Digital Marketing</span>
                                </div>
                                <p class="tip-text mb-0">
                                    Sed porttitor lectus nibh. Curabitur non nulla sit amet nisl tempus convallis quis ac
                                    lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Nulla porttitor
                                    accumsan tincidunt. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                    Curabitur aliquet quam id dui posuere blandit.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 m-2">
                        <!-- Tip Card -->
                        <div class="col-md-4">
                            <div class="card card-tip p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-tip me-2">💡 Digital Marketing</span>
                                </div>
                                <p class="tip-text mb-0">
                                    Sed porttitor lectus nibh. Curabitur non nulla sit amet nisl tempus convallis quis ac
                                    lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Nulla porttitor
                                    accumsan tincidunt. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                    Curabitur aliquet quam id dui posuere blandit.
                                </p>
                            </div>
                        </div>

                        <!-- Duplicate more cards as needed -->
                        <div class="col-md-4">
                            <div class="card card-tip p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-tip me-2">💡 Digital Marketing</span>
                                </div>
                                <p class="tip-text mb-0">
                                    Sed porttitor lectus nibh. Curabitur non nulla sit amet nisl tempus convallis quis ac
                                    lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Nulla porttitor
                                    accumsan tincidunt. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                    Curabitur aliquet quam id dui posuere blandit.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-tip p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-tip me-2">💡 Digital Marketing</span>
                                </div>
                                <p class="tip-text mb-0">
                                    Sed porttitor lectus nibh. Curabitur non nulla sit amet nisl tempus convallis quis ac
                                    lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Nulla porttitor
                                    accumsan tincidunt. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                    Curabitur aliquet quam id dui posuere blandit.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Another Section title if needed -->
                <h6 class="section-title">📺 Astuces vidéo</h6>
                <!-- ... more cards below -->
                <section class="py-5 bg-light">
                    <div class="container">

                        <div class="row g-4">
                            <!-- Vidéo 1 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Video"
                                            allowfullscreen></iframe>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Introduction au TCF</h5>
                                        <p class="card-text">Découvrez les bases du test TCF pour bien démarrer.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Vidéo 2 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="https://www.youtube.com/embed/YOUTUBE_ID" title="Video"
                                            allowfullscreen></iframe>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Préparation au DELF</h5>
                                        <p class="card-text">Stratégies et conseils pour réussir le DELF.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Vidéo 3 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="ratio ratio-16x9">
                                        <video controls>
                                            <source src="videos/demo.mp4" type="video/mp4">
                                            Votre navigateur ne supporte pas la lecture vidéo.
                                        </video>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Correction automatique par IA</h5>
                                        <p class="card-text">Comment notre plateforme analyse vos réponses en temps réel.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

        </div>
    </div>
@endsection
