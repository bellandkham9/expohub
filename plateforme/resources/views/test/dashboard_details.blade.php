@extends('layouts.app')

@section('content')
    <div class="m-4">

         @include('client.partials.navbar-client')

        <!-- Hero Banner -->
        <div class="container my-4">
            <section id="">
                <div class="row justify-between align-items-start g-4">

                    <div class="col-lg-9">

                        <!-- Section Tests Disponibles -->
                        <section class="container mb-5">

                            <div class="mt-3">
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
                                <a href="#" class="btn-show-more" style="color: black">Tout les réponses <i
                                        class="fas fa-chevron-down"></i></a>
                            </div>
                            <div class="row g-4 justify-content-center align-items-center mt-2 mb-1">

                                <!-- Première carte de résultat -->
                                <div class="col-12  col-md-10 col-lg-6">
                                    <div class="result-card astuce p-4 h-100 text-justify">
                                        <p class="text-justify justify-evenly">Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Integer interdum quam eu sem lobortis, et dignissim nunc
                                            rhoncus. Curabitur finibus, dolor nec vestibulum consectetur, arcu diam
                                            vestibulum nisl, sit amet imperdiet magna nulla sed magna. Donec fermentum
                                            aliquam ligula in lobortis.</p>

                                    </div>
                                </div>

                                <!-- Deuxième carte de résultat -->
                                <div class="col-12  col-md-10 col-lg-6">
                                    <div class="p-4 h-100 text-justify">
                                        <div class="row justify-between">
                                            <div class="col-10">
                                                <p style="font-weight: bold">Question ?</p>

                                            </div>
                                            <div class="col-2">
                                                <div
                                                    style="background-color: #0DF840; color: white;font-weight: bold; padding: 8px; justify-content: center; align-items: center;">
                                                    <span>+3</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p style="color: #0DF840"><span style="color: black; font-weight: bold;">Votre
                                                réponse :</span> Lorem ipsum dolor sit amet, consectetur</p>
                                        <p><span style="color: black; font-weight: bold;">Votre réponse :</span> Lorem ipsum
                                            dolor sit amet, consectetur</p>

                                    </div>
                                </div>
                            </div>
                                 <div class="row g-4 justify-content-center align-items-center mt-2 mb-1">

                                <!-- Première carte de résultat -->
                                <div class="col-12  col-md-10 col-lg-6">
                                    <div class="result-card astuce p-4 h-100 text-justify">
                                        <p class="text-justify justify-evenly">Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Integer interdum quam eu sem lobortis, et dignissim nunc
                                            rhoncus. Curabitur finibus, dolor nec vestibulum consectetur, arcu diam
                                            vestibulum nisl, sit amet imperdiet magna nulla sed magna. Donec fermentum
                                            aliquam ligula in lobortis.</p>

                                    </div>
                                </div>

                                <!-- Deuxième carte de résultat -->
                                <div class="col-12  col-md-10 col-lg-6">
                                    <div class="p-4 h-100 text-justify">
                                        <div class="row justify-between">
                                            <div class="col-10">
                                                <p style="font-weight: bold">Question ?</p>

                                            </div>
                                            <div class="col-2">
                                                <div
                                                    style="background-color: #FF3B30; color: white;font-weight: bold; padding: 8px; justify-content: center; align-items: center;">
                                                    <span>+3</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p style="color: #FF3B30"><span style="color: black; font-weight: bold;">Votre
                                                réponse :</span> Lorem ipsum dolor sit amet, consectetur</p>
                                        <p><span style="color: black; font-weight: bold;">Votre réponse :</span> Lorem ipsum
                                            dolor sit amet, consectetur</p>

                                    </div>
                                </div>
                            </div>
                                 <div class="row g-4 justify-content-center align-items-center mt-2 mb-1">

                                <!-- Première carte de résultat -->
                                <div class="col-12  col-md-10 col-lg-6">
                                    <div class="result-card astuce p-4 h-100 text-justify">
                                        <p class="text-justify justify-evenly">Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Integer interdum quam eu sem lobortis, et dignissim nunc
                                            rhoncus. Curabitur finibus, dolor nec vestibulum consectetur, arcu diam
                                            vestibulum nisl, sit amet imperdiet magna nulla sed magna. Donec fermentum
                                            aliquam ligula in lobortis.</p>

                                    </div>
                                </div>

                                <!-- Deuxième carte de résultat -->
                                <div class="col-12  col-md-10 col-lg-6">
                                    <div class="p-4 h-100 text-justify">
                                        <div class="row justify-between">
                                            <div class="col-10">
                                                <p style="font-weight: bold">Question ?</p>

                                            </div>
                                            <div class="col-2">
                                                <div
                                                    style="background-color: #0DF840; color: white;font-weight: bold; padding: 8px; justify-content: center; align-items: center;">
                                                    <span>+3</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p style="color: #0DF840"><span style="color: black; font-weight: bold;">Votre
                                                réponse :</span> Lorem ipsum dolor sit amet, consectetur</p>
                                        <p><span style="color: black; font-weight: bold;">Votre réponse :</span> Lorem ipsum
                                            dolor sit amet, consectetur</p>

                                    </div>
                                </div>
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
    </div>
@endsection
