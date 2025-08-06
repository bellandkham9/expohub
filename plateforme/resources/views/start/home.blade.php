@extends('layouts.app')

@section('content')
    <div class="">

        @if(auth()->check())
            @include('client.partials.navbar-client')
        @else
            @include('client.partials.navbar')
        @endif
   
        <!-- Hero Banner -->
        <div class="container my-4">
            <section id="hero">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <h1 class="fw-bold">Testez votre niveau de langue avec précision grâce à l'intelligence artificielle
                        </h1>
                        <p>Préparez le TCF Canada, TCF Quebec, DALF, DELF ou TEF en toute confiance. Évaluez vos compétences
                            à tout moment, en ligne.</p>
                        <a id="btn-commencer" class="btn " href="#">Commencez gratuitement</a>
                    </div>
                </div>
            </section>
        </div>

        <!-- Exam Cards -->
        <div class="text-center my-5">
            <h5 class="mb-4">Préparez-vous dès maintenant au :</h5>
            <div class="d-flex justify-content-center flex-wrap gap-3">
                <button class="btn  type-test px-4 shadowed">TCF CANADA</button>
                <button class="btn  type-test px-4 shadowed">TCF QUEBEC</button>
                <button class="btn  type-test px-4 shadowed">DALF</button>
                <button class="btn  type-test px-4 shadowed">DELF</button>
                <button class="btn  type-test px-4 shadowed">TEF</button>
            </div>
        </div>

        <!-- AI Section -->
        <div class="container my-5 p-4 text-white gradient-bg">
            <div class="row align-items-center">
                <div class="col-md-5"
                    style="background-image: url('images/animation.png'); background-size: cover; background-position: center; background-repeat: no-repeat; z-index: ;">
                    <h6 id="robot-big-title">Une technologie au service de votre réussite linguistique</h6>
                    <p class="justified-text">
                        Notre plateforme utilise les dernières avancées en intelligence artificielle pour vous offrir une
                        évaluation précise et rapide de votre niveau en compréhension écrite, orale, et expression. Que vous
                        prépariez un examen ou que vous souhaitiez progresser, vous êtes au bon endroit.
                    </p>
                    <a id="btn-testGratuitement" class="btn btn-light" href="#">Tester gratuitement</a>
                </div>

                <div class="col-md-7 text-center">
                    <img src="{{ asset('images/robot.png') }}" alt="AI Robot" class="img-fluid">
                </div>
            </div>
        </div>


        <!-- Features -->
        <div class="container text-center">
            <h5 class="mb-4">Ce que vous pouvez faire ici</h5>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-white border-0 shadow"
                        style="height: 250px; background-image: url('{{ asset('images/evaluation.png') }}'); background-size: cover; background-position: center; border-radius: 1rem;">
                        <div class="card-body d-flex align-items-end justify-content-start p-4"
                            style="background-color: rgba(0,0,0,0.3); border-radius: 1rem;">
                            <h5 class="card-title fw-bold text-center mb-0">Évaluation IA</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white border-0 shadow"
                        style="height: 250px; background-image: url('{{ asset('images/preparation.png') }}'); background-size: cover; background-position: center; border-radius: 1rem;">
                        <div class="card-body d-flex align-items-end justify-content-start p-4"
                            style="background-color: rgba(0,0,0,0.3); border-radius: 1rem;">
                            <h5 class="card-title fw-bold text-center mb-0">Préparation ciblée</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white border-0 shadow"
                        style="height: 250px; background-image: url('{{ asset('images/suivi.png') }}'); background-size: cover; background-position: center; border-radius: 1rem;">
                        <div class="card-body d-flex align-items-end justify-content-start p-4"
                            style="background-color: rgba(0,0,0,0.3); border-radius: 1rem;">
                            <h5 class="card-title fw-bold text-center mb-0">Suivi de progression</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white border-0 shadow"
                        style="height: 250px; background-image: url('{{ asset('images/test.png') }}'); background-size: cover; background-position: center; border-radius: 1rem;">
                        <div class="card-body d-flex align-items-end justify-content-start p-4"
                            style="background-color: rgba(0,0,0,0.3); border-radius: 1rem;">
                            <h5 class="card-title fw-bold text-center mb-0">Tests adaptés </h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white border-0 shadow"
                        style="height: 250px; background-image: url('{{ asset('images/historique.png') }}'); background-size: cover; background-position: center; border-radius: 1rem;">
                        <div class="card-body d-flex align-items-end justify-content-start p-4"
                            style="background-color: rgba(0,0,0,0.3); border-radius: 1rem;">
                            <h5 class="card-title fw-bold text-center mb-0">Historique de vos tests</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white border-0 shadow"
                        style="height: 250px; background-image: url('{{ asset('images/resultat.png') }}'); background-size: cover; background-position: center; border-radius: 1rem;">
                        <div class="card-body d-flex align-items-end justify-content-start p-4"
                            style="background-color: rgba(0,0,0,0.3); border-radius: 1rem;">
                            <h5 class="card-title fw-bold text-center mb-0"> Résultats instantanés</h5>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" id="btn-testGratuitement1" class="btn btn-primary mt-6">Tester gratuitement</a>
        </div>

        <!-- Testimonials -->
        <div class="container my-5 text-center mb-5">
            <h5>Ils ont testé... et ils recommandent</h5>
            <div class="row mt-4 justify-content-between">
                <div class="col-md-3 testimonial-card text-center justify-center">
                    <img src="{{ asset('images/homme.png') }}" alt="Jackob" class="rounded-circle mb-3"
                        width="80">
                    <h6>Jackob</h6>
                    <p class="text-muted">Lorem ipsum is simply dummy text of the printing and typesetting industry...</p>
                </div>
                <div class="col-md-3 testimonial-card text-center">
                    <img src="{{ asset('images/femme.png') }}"alt="Emmanuelle" class="rounded-circle mb-3"
                        width="80">
                    <h6>Emmanuelle</h6>
                    <p class="text-muted">Lorem ipsum is simply dummy text of the printing and typesetting industry...</p>
                </div>
                <div class="col-md-3 testimonial-card text-center">
                    <img src="{{ asset('images/homme1.png') }}" alt="Johnatan" class="rounded-circle mb-3"
                        width="80">
                    <h6>Johnatan</h6>
                    <p class="text-muted">Lorem ipsum is simply dummy text of the printing and typesetting industry...</p>
                </div>
            </div>

        </div>

    </div>
@endsection
