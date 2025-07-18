@extends('layouts.app')

@section('content')
<div class="">

     @include('client.partials.navbar')
   
    <!-- Hero Banner -->
    <div class="container my-4">
        <section id="">
            <div class="container">
                <!-- En-tête -->
                <div class="header-section mt-4 text-center mx-auto" style="max-width: 700px;">
                    <h2 class="mb-3 fw-bold">Choisissez votre formule d'entraînement et testez-vous en conditions
                        réelles</h2>
                    <p class="lead">Accédez à des tests interactifs et corrigés automatiquement pour préparer
                        efficacement votre certification (TCF, DELF, TEF, etc.)</p>

                    <!-- Toggle Langue -->
                    <div class="d-flex justify-content-center align-items-center gap-3 mt-3">
                        <span id="label-left" class="fw-medium">2 Semaine</span>

                        <div class="form-check form-switch">
                            <input class="form-check-input custom-toggle" type="checkbox" id="toggleSwitch">
                        </div>

                        <span id="label-right" class="fw-medium">1 mois</span>
                    </div>
                </div>


                <!-- Pricing 2 - Bootstrap Brain Component -->
                <section class="bsb-pricing-2 bg-light py-5 py-xl-8 mr-5 ml-5 p-3">
                    <div class="container">
                        <div class="row gx-4 gy-5 justify-content-center">
                            <div class="col-12 col-lg-4">
                                <div class="card shadow border-0 h-100">
                                    <div class="card-body p-4">
                                        <h2 class="h4 mb-2">TCF CANADA</h2>
                                        <p class="mb-4">Évaluez vos compétences pour l'immigration au Canada.
                                            Compréhension orale, écrite et expression</p>
                                        <ul class=" list-group-flush mb-4">
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span style="font-weight: bold">Nombres de teste</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Simulations</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </li>
                                        </ul>
                                        <h6 class="display-6 fw-bold mb-0">5000 Frs</h6>
                                        <div id="s_abonner" href="#!" style="border: 3px solid #224194; border-radius: 15px; width: 100%; font-size: 24px; font-weight: bold;" class="btn mt-4 p-3">S’abonner</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 mt-4">
                                <div class="card shadow border-0 h-100">
                                    <div class="card-body p-4">
                                        <h2 class="h4 mb-2">TCF QUEBEC</h2>
                                        <p class="mb-4">Préparation ciblée pour la demande de sélection au Québec.
                                        </p>
                                        <ul class=" list-group-flush mb-4">
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span style="font-weight: bold">Nombres de teste</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Simulations</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </li>
                                        </ul>
                                        <h6 class="display-6 fw-bold mb-0">5000 Frs</h6>
                                        <div id="s_abonner" href="#!" style="border: 3px solid #224194; border-radius: 15px; width: 100%; font-size: 24px; font-weight: bold;" class="btn mt-4 p-3">S’abonner</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="card shadow border-0 h-100">
                                    <div class="card-body p-4">
                                        <h2 class="h4 mb-2">TEF</h2>
                                        <p class="mb-4">Préparation au Test d'Évaluation de Français pour
                                            immigration, études ou travail.</p>
                                        <ul class=" list-group-flush mb-4">
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span style="font-weight: bold">Nombres de teste</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Simulations</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </li>
                                        </ul>
                                        <h6 class="display-6 fw-bold mb-0">5000 Frs</h6>
                                        <div id="s_abonner" href="#!" style="border: 3px solid #224194; border-radius: 15px; width: 100%; font-size: 24px; font-weight: bold;" class="btn mt-4 p-3">S’abonner</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="card shadow border-0 h-100">
                                    <div class="card-body p-4">
                                        <h2 class="h4 mb-2">TCF CANADA</h2>
                                        <p class="mb-4">Évaluez vos compétences pour l'immigration au Canada.
                                            Compréhension orale, écrite et expression</p>
                                        <ul class=" list-group-flush mb-4">
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span style="font-weight: bold">Nombres de teste</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Simulations</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </li>
                                        </ul>
                                        <h6 class="display-6 fw-bold mb-0">5000 Frs</h6>
                                        <div id="s_abonner" href="#!" style="border: 3px solid #224194; border-radius: 15px; width: 100%; font-size: 24px; font-weight: bold;" class="btn mt-4 p-3">S’abonner</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="card shadow border-0 h-100">
                                    <div class="card-body p-4">
                                        <h2 class="h4 mb-2">TCF QUEBEC</h2>
                                        <p class="mb-4">Préparation ciblée pour la demande de sélection au Québec.
                                        </p>
                                        <ul class=" list-group-flush mb-4">
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span style="font-weight: bold">Nombres de teste</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Simulations</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </li>
                                            <li class="list-group-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: rgb(167, 161, 161)" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                </svg>
                                                <span>Corrections IA</span>
                                            </li>
                                        </ul>
                                        <h6 class="display-6 fw-bold mb-0">5000 Frs</h6>
                                        <div id="s_abonner" href="#!" style="border: 3px solid #224194; border-radius: 15px; width: 100%; font-size: 24px; font-weight: bold;" class="btn mt-4 p-3">S’abonner</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                </section>
            </div>

        </section>
    </div>
</div>

<script>
    const toggle = document.getElementById("toggleSwitch");

    toggle.addEventListener("change", () => {
        if (toggle.checked) {
            console.log("Anglais sélectionné");
        } else {
            console.log("Français sélectionné");
        }
    });

</script>
@endsection
