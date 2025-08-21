@extends('layouts.app')

@section('content')
    <div class="">
        @if (auth()->check())
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
                        <button class="btn" id="btn-commencer" data-user-id="{{ auth()->id() ?? '' }}">Commencez
                            gratuitement</button>
                    </div>
                </div>
            </section>
        </div>

        <!-- Test Modal -->

        <div class="modal fade" id="matiereModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Choisissez une compétence</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <a href="{{ route('test.comprehension_ecrite') }}"
                                    class="card h-100 text-decoration-none text-center p-3 border-0 shadow-sm"
                                    style="background-color: #F8B70D;">
                                    <img src="{{ asset('images/lecture.png') }}" width="40" class="mb-2 mx-auto">
                                    <h6 class="mb-0">Compréhension Écrite</h6>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('test.comprehension_orale') }}"
                                    class="card h-100 text-decoration-none text-center p-3 border-0 shadow-sm"
                                    style="background-color: #FF3B30;">
                                    <img src="{{ asset('images/ecoute.png') }}" width="40" class="mb-2 mx-auto">
                                    <h6 class="mb-0">Compréhension Orale</h6>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('test.expression_ecrite') }}"
                                    class="card h-100 text-decoration-none text-center p-3 border-0 shadow-sm"
                                    style="background-color: #224194;">
                                    <img src="{{ asset('images/ecrite.png') }}" width="40" class="mb-2 mx-auto">
                                    <h6 class="mb-0">Expression Écrite</h6>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('test.expression_orale') }}"
                                    class="card h-100 text-decoration-none text-center p-3 border-0 shadow-sm"
                                    style="background-color: #249DB8;">
                                    <img src="{{ asset('images/orale.png') }}" width="40" class="mb-2 mx-auto">
                                    <h6 class="mb-0">Expression Orale</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    <img src="{{ asset('images/femme.png') }}" alt="Emmanuelle" class="rounded-circle mb-3"
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btnCommencer = document.getElementById('btn-commencer');


                 if (btnCommencer) {
                    btnCommencer.addEventListener('click', function(e) {
                        e.preventDefault();
                        const userId = this.getAttribute('data-user-id');

                        if (!userId) {
                            window.location.href = "{{ route('auth.connexion') }}";
                            return;
                        }

                        fetch("{{ route('tests.verifierAcces') }}")
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                window.location.href = "{{ route('auth.connexion') }}";
                                return;
                            }

                            if (data.has_free_tests) {
                                const modal = new bootstrap.Modal(document.getElementById('matiereModal'));
                                modal.show();
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Vos tests gratuits sont terminés!',
                                    html: 'Vous avez utilisé tous vos tests gratuits. Pour continuer, veuillez souscrire à un abonnement.',
                                    showConfirmButton: true,
                                    confirmButtonText: "Voir les abonnements",
                                    showCancelButton: true,
                                    cancelButtonText: "Fermer",
                                    customClass: {
                                        confirmButton: 'btn btn-warning px-4 py-2',
                                        cancelButton: 'btn btn-outline-secondary px-4 py-2'
                                    },
                                    buttonsStyling: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "{{ route('client.paiement') }}";
                                    }
                                });
                            }
                        })

                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Une erreur est survenue lors de la vérification de vos tests gratuits.',
                                confirmButtonText: 'OK',
                                background: '#f8f9fa'
                            });
                        });

});
                }


                // Gestion des clics sur les tests
     /*            document.querySelectorAll('.start-test-btn').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const testType = this.getAttribute('data-test-type');
                        window.location.href = `/test/${testType}`;
                    });
                }); */
            });
        </script>

        @include('start.chatbot')
    @endsection
