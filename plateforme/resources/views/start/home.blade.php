
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
                        <h1 class="fw-bold">Testez votre niveau de langue avec précision grâce à l'intelligence artificielle</h1>
                        <p>Préparez le TCF Canada, TCF Quebec, DALF, DELF ou TEF en toute confiance. Évaluez vos compétences à tout moment, en ligne.</p>
                        <button class="btn btn-primary" id="btn-commencer" data-user-id="{{ auth()->id() ?? '' }}">Commencez gratuitement</button>
                    </div>
                    <div class="col-lg-6 text-center">
                       
                    </div>
                </div>
            </section>
        </div>

        <!-- Test Modal -->
        <div class="modal fade" id="testModal" tabindex="-1" aria-labelledby="testModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="testModalLabel">Choisissez une compétence</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-6 col-md-6">
                                <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-warning start-test-btn"
                                   data-test-type="comprehension_ecrite" data-test-name="Compréhension Écrite">
                                    <img src="{{ asset('images/lecture.png') }}" width="40" class="mb-2" alt="Lecture" loading="lazy">
                                    <h6 class="mb-0">Compréhension Écrite</h6>
                                </a>
                            </div>
                            <div class="col-6 col-md-6">
                                <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-danger text-white start-test-btn"
                                   data-test-type="comprehension_orale" data-test-name="Compréhension Orale">
                                    <img src="{{ asset('images/ecoute.png') }}" width="40" class="mb-2" alt="Écoute" loading="lazy">
                                    <h6 class="mb-0">Compréhension Orale</h6>
                                </a>
                            </div>
                            <div class="col-6 col-md-6">
                                <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-primary text-white start-test-btn"
                                   data-test-type="expression_ecrite" data-test-name="Expression Écrite">
                                    <img src="{{ asset('images/ecrite.png') }}" width="40" class="mb-2" alt="Écriture" loading="lazy">
                                    <h6 class="mb-0">Expression Écrite</h6>
                                </a>
                            </div>
                            <div class="col-6 col-md-6">
                                <a href="#" class="skill-card d-block p-3 rounded text-center text-decoration-none bg-info text-white start-test-btn"
                                   data-test-type="expression_orale" data-test-name="Expression Orale">
                                    <img src="{{ asset('images/orale.png') }}" width="40" class="mb-2" alt="Orale" loading="lazy">
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
                <button class="btn btn-outline-primary type-test px-4 shadowed">TCF CANADA</button>
                <button class="btn btn-outline-primary type-test px-4 shadowed">TCF QUEBEC</button>
                <button class="btn btn-outline-primary type-test px-4 shadowed">DALF</button>
                <button class="btn btn-outline-primary type-test px-4 shadowed">DELF</button>
                <button class="btn btn-outline-primary type-test px-4 shadowed">TEF</button>
            </div>
        </div>

        <!-- AI Section -->
        <div class="container my-5 p-4 text-white gradient-bg rounded-4">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <h6 id="robot-big-title" class="fw-bold mb-3">Une technologie au service de votre réussite linguistique</h6>
                    <p class="justified-text">
                        Notre plateforme utilise les dernières avancées en intelligence artificielle pour vous offrir une évaluation précise et rapide de votre niveau en compréhension écrite, orale, et expression. Que vous prépariez un examen ou que vous souhaitiez progresser, vous êtes au bon endroit.
                    </p>
                    <a id="btn-testGratuitement" class="btn btn-light" href="#">Tester gratuitement</a>
                </div>

                <div class="col-md-7 text-center">
                    <img src="{{ asset('images/robot.png') }}" alt="AI Robot" class="img-fluid" loading="lazy">
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="container text-center">
            <h5 class="mb-4">Ce que vous pouvez faire ici</h5>
            <div class="row g-4">
                @foreach([
                    ['image' => 'evaluation.png', 'title' => 'Évaluation IA'],
                    ['image' => 'preparation.png', 'title' => 'Préparation ciblée'],
                    ['image' => 'suivi.png', 'title' => 'Suivi de progression'],
                    ['image' => 'test.png', 'title' => 'Tests adaptés'],
                    ['image' => 'historique.png', 'title' => 'Historique de vos tests'],
                    ['image' => 'resultat.png', 'title' => 'Résultats instantanés']
                ] as $feature)
                <div class="col-md-4 col-sm-6">
                    <div class="card text-white border-0 shadow feature-card">
                        <div class="card-img-container">
                            <img src="{{ asset('images/' . $feature['image']) }}" alt="{{ $feature['title'] }}" class="card-img" loading="lazy">
                        </div>
                        <div class="card-overlay">
                            <h5 class="card-title fw-bold">{{ $feature['title'] }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="#" id="btn-testGratuitement1" class="btn btn-primary mt-5">Tester gratuitement</a>
        </div>

        <!-- Testimonials -->
        <div class="container my-5 text-center mb-5">
            <h5 class="mb-4">Ils ont testé... et ils recommandent</h5>
            <div class="row justify-content-center">
                @foreach([
                    ['image' => 'homme.png', 'name' => 'Jackob'],
                    ['image' => 'femme.png', 'name' => 'Emmanuelle'],
                    ['image' => 'homme1.png', 'name' => 'Johnatan']
                ] as $testimonial)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="testimonial-card p-4">
                        <img src="{{ asset('images/' . $testimonial['image']) }}" alt="{{ $testimonial['name'] }}" class="rounded-circle mb-3" width="80" loading="lazy">
                        <h6>{{ $testimonial['name'] }}</h6>
                        <p class="text-muted">"Une plateforme exceptionnelle pour progresser rapidement en langue. Les tests sont précis et les résultats instantanés."</p>
                    </div>
                </div>
                @endforeach
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

                        fetch("{{ route('tests.verifierAcces') }}", {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erreur réseau');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                window.location.href = "{{ route('auth.connexion') }}";
                                return;
                            }

                            if (data.has_free_tests) {
                                const modal = new bootstrap.Modal(document.getElementById('testModal'));
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
                                confirmButtonText: 'OK'
                            });
                        });
                    });
                }

                // Gestion des tests
                document.querySelectorAll('.start-test-btn').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const testType = this.dataset.testType;
                        const testName = this.dataset.testName;

                        const consignes = {
                            comprehension_ecrite: `Bienvenue au test de Compréhension Écrite.\n\nDurée : 60 minutes\nNombre de questions : 30\n\nInstructions :\n1. Lisez attentivement chaque texte\n2. Répondez aux questions associées\n3. Vous ne pouvez pas revenir en arrière`,
                            comprehension_orale: `Bienvenue au test de Compréhension Orale.\n\nDurée : 45 minutes\nNombre d'extraits audio : 20\n\nInstructions :\n1. Écoutez chaque extrait une seule fois\n2. Prenez des notes si nécessaire\n3. Répondez aux questions`,
                            expression_ecrite: `Bienvenue au test d'Expression Écrite.\n\nDurée : 60 minutes\nNombre de sujets : 2\n\nInstructions :\n1. Structurez clairement vos réponses\n2. Vérifiez votre grammaire et orthographe\n3. Respectez le nombre de mots demandé`,
                            expression_orale: `Bienvenue au test d'Expression Orale.\n\nDurée : 15 minutes\nNombre de sujets : 3\n\nInstructions :\n1. Parlez clairement et distinctement\n2. Structurez vos idées\n3. Utilisez un vocabulaire varié`
                        };

                        Swal.fire({
                            title: `Consignes - ${testName}`,
                            html: `<div style="text-align:left; white-space: pre-line;">${consignes[testType]}</div>`,
                            icon: 'info',
                            confirmButtonText: 'Commencer le test',
                            showCancelButton: true,
                            cancelButtonText: 'Annuler',
                            allowOutsideClick: false,
                            width: '600px'
                        }).then(result => {
                            if (result.isConfirmed) {
                                const routes = {
                                    comprehension_ecrite: "{{ route('test.comprehension_ecrite') }}",
                                    comprehension_orale: "{{ route('test.comprehension_orale') }}",
                                    expression_ecrite: "{{ route('test.expression_ecrite') }}",
                                    expression_orale: "{{ route('test.expression_orale') }}"
                                };
                                window.location.href = routes[testType];
                            }
                        });
                    });
                });

                // Boutons supplémentaires
                ['btn-testGratuitement', 'btn-testGratuitement1'].forEach(id => {
                    const btn = document.getElementById(id);
                    if (btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            document.getElementById('btn-commencer').click();
                        });
                    }
                });
            });
        </script>

        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #224194; 0%, #764ba2 100%);
            }
            
            .feature-card {
                height: 250px;
                border-radius: 1rem;
                overflow: hidden;
                position: relative;
                transition: transform 0.3s ease;
            }
            
            .feature-card:hover {
                transform: translateY(-5px);
            }
            
            .card-img-container {
                height: 100%;
                overflow: hidden;
            }
            
            .card-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            
            .card-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(transparent, rgba(0,0,0,0.8));
                padding: 2rem 1rem 1rem;
            }
            
            .testimonial-card {
                background: #f8f9fa;
                border-radius: 1rem;
                transition: transform 0.3s ease;
            }
            
            .testimonial-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }
            
            .skill-card {
                transition: all 0.3s ease;
            }
            
            .skill-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            }
            
            .type-test {
                border-radius: 25px;
                transition: all 0.3s ease;
            }
            
            .type-test:hover {
                transform: translateY(-2px);
            }
            
            @media (max-width: 768px) {
                .feature-card {
                    height: 200px;
                }
                
                .card-overlay {
                    padding: 1rem 0.5rem 0.5rem;
                }
                
                .card-overlay h5 {
                    font-size: 1rem;
                }
            }


            /* Amélioration responsive mobile */
@media (max-width: 576px) {
    h1.fw-bold {
        font-size: 1.6rem; /* Réduction du titre */
        text-align: center;
    }

    #hero p {
        font-size: 0.95rem;
        text-align: center;
    }

    #hero .btn {
        display: block;
        width: 100%;
        margin-top: 1rem;
    }

    /* Ajuster la section AI */
    .gradient-bg .row {
        text-align: center;
    }

    .gradient-bg h6 {
        font-size: 1.2rem;
    }

    .gradient-bg p {
        font-size: 0.9rem;
    }

    /* Images témoignages */
    .testimonial-card img {
        width: 60px;
        height: 60px;
    }

    .testimonial-card p {
        font-size: 0.9rem;
    }

    /* Boutons examens */
    .type-test {
        width: 100%;
        margin: 0.4rem 0;
    }
}

/* Tablette */
@media (max-width: 768px) {
    .feature-card {
        height: 180px;
    }
    .card-overlay h5 {
        font-size: 1rem;
    }
}




        </style>

        @include('start.chatbot')
    </div>
    @endsection

