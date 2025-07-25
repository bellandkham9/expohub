@extends('layouts.app')

@section('content')
    <div class="m-4">

        @include('client.partials.navbar-client')
   
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
    <div class="row g-4 justify-content-center">
        <!-- Carte TCF CANADA 1 -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="test-card text-center h-100 p-4">
                <div class="test-icon mb-3">
                    <i class="fas fa-globe-americas fa-3x text-primary"></i>
                </div>
                <h3 class="test-title h5 mb-3">TCF CANADA</h3>
                <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                <button class="btn btn-primary btn-test">
                    <i class="fas fa-play-circle me-2"></i> Passer le test
                </button>
            </div>
        </div>

        <!-- Carte TCF QUEBEC 1 -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="test-card text-center h-100 p-4">
                <div class="test-icon mb-3">
                    <i class="fas fa-map-marked-alt fa-3x text-primary"></i>
                </div>
                <h3 class="test-title h5 mb-3">TCF QUEBEC</h3>
                <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                <button class="btn btn-primary btn-test">
                    <i class="fas fa-play-circle me-2"></i> Passer le test
                </button>
            </div>
        </div>

        <!-- Carte TCF CANADA 2 -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="test-card text-center h-100 p-4">
                <div class="test-icon mb-3">
                    <i class="fas fa-globe-americas fa-3x text-primary"></i>
                </div>
                <h3 class="test-title h5 mb-3">TCF CANADA</h3>
                <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                <button class="btn btn-primary btn-test">
                    <i class="fas fa-play-circle me-2"></i> Passer le test
                </button>
            </div>
        </div>

        <!-- Carte TCF QUEBEC 2 -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="test-card text-center h-100 p-4">
                <div class="test-icon mb-3">
                    <i class="fas fa-map-marked-alt fa-3x text-primary"></i>
                </div>
                <h3 class="test-title h5 mb-3">TCF QUEBEC</h3>
                <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                <button class="btn btn-primary btn-test">
                    <i class="fas fa-play-circle me-2"></i> Passer le test
                </button>
            </div>
        </div>

        <!-- Carte TCF CANADA 3 -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="test-card text-center h-100 p-4">
                <div class="test-icon mb-3">
                    <i class="fas fa-globe-americas fa-3x text-primary"></i>
                </div>
                <h3 class="test-title h5 mb-3">TCF CANADA</h3>
                <p class="mb-4 text-muted">Une petite description ici pour parler du test!</p>
                <button class="btn btn-primary btn-test">
                    <i class="fas fa-play-circle me-2"></i> Passer le test
                </button>
            </div>
        </div>
    </div>
</section>


                    </div>
                    <div class="col-lg-3">
                        <div class="card text-center p-3 rounded-4 shadow-sm" style="background-color: #ebe9e9;">
                            <div class="d-flex justify-center align-items-center gap-2">
                                <img src="{{ asset('images/beautiful-woman.png') }}" alt="Emmanuelle" class="rounded-circle"
                                    style="width: 50px; height: 50px; object-fit: cover;">
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

    </div>
@endsection
