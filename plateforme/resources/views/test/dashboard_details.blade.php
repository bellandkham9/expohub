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
                                                        <h6 class="fw-bold mb-1">{{$titre}}</h6>
                                                    </div>
                                                    <div class="text-md-end text-muted small">
                                                        <div><strong>60 min</strong></div>
                                                        <div>{{ now()->format('d M Y') }}</div>
                                                    </div>
                                                </div>

                                                <hr class="my-2">

                                                <div class="row g-2 mb-3">
                                                    <div class="col-md-8">
                                                        <div class="row g-2 mb-3">
                                                            <div class="col-md-5">
                                                                <strong>Résultat :</strong> {{ $totalPoints }}
                                                            </div>
                                                           <div class="col-md-7">
                                                            <strong>Réponses exactes :</strong>
                                                            @if(isset($bonnesReponses) && isset($mauvaisesReponses) && 
                                                                !is_null($bonnesReponses) && !is_null($mauvaisesReponses))
                                                                {{ $bonnesReponses }} / {{ $bonnesReponses + $mauvaisesReponses }}
                                                            @else
                                                                <span class="text-muted">Données non disponibles</span>
                                                            @endif
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        {{-- Peut contenir autre chose plus tard --}}
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="row g-2 mb-3">
                                                            <div class="col-4 col-md-5">
                                                                <strong>Niveau :</strong> {{ $niveau }}
                                                            </div>
                                                            <div class="col-8 col-md-7">
                                                                <strong>Réponses fausses :</strong> {{ $mauvaisesReponses }} / {{ $bonnesReponses + $mauvaisesReponses }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <a href="{{ route($route) }}" class="btn" style="background-color:  #224194; color: white;">
                                                            Refaire le test
                                                        </a>

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

                        <div class="text-start mt-1">
                            <a href="#" class="btn-show-more" style="color: black">Toutes les réponses <i class="fas fa-chevron-down"></i></a>
                        </div>

                        @foreach ($reponses as $reponse)
                        <div class="row g-4 justify-content-center align-items-center mt-1 mb-3">

                            {{-- Colonne gauche : la situation --}}
                            <div class="col-12 col-md-10 col-lg-6" style="height: 20vh">
                                <div class="result-card astuce p-4 h-100 text-justify rounded shadow-sm">
                                    @if(Str::endsWith($reponse->situation, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                    <img src="{{ asset('storage/' . $reponse->situation) }}" alt="situation" class="img-fluid rounded" style="max-height: 100%; object-fit: contain;">
                                    @else
                                    <p class="text-justify">{{ $reponse->situation }}</p>
                                    @endif
                                </div>
                            </div>


                            {{-- Colonne droite : la question et réponses --}}
                            <div class="col-12 col-md-10 col-lg-6" style="height: 20vh">
                                <div class="p-2  text-justify rounded">
                                    <div class="row justify-between align-items-center mb-2">
                                        <div class="col-10">
                                            <p class="fw-bold">Question {{ $reponse->numero ?? $reponse->question_id }}:</p>

                                            @if(\Illuminate\Support\Str::endsWith($reponse->question, '.mp3'))
                                            <audio controls class="mt-2 w-100">
                                                <source src="{{ asset('storage/audio_questions/' . $reponse->question) }}" type="audio/mpeg">
                                                Votre navigateur ne supporte pas l'élément audio.
                                            </audio>
                                            @else
                                            <p>{{ $reponse->question }}</p>
                                            @endif
                                        </div>

                                        <div class="col-2 text-center">
                                            <div style="background-color: {{ $reponse->is_correct ? '#0DF840' : '#FF3B30' }};
                                    color: white; font-weight: bold; padding: 4px; border-radius: 5px;">
                                                <span>{{ $reponse->is_correct ? '+3' : '+0' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <p>
                                        <span style="color: {{ $reponse->is_correct ? '#0DF840' : '#FF3B30' }}" class="fw-bold ">Votre réponse :</span> {{ $reponse->reponse_utilisateur }}
                                        <span> </span>
                                        <span style="color: {{ $reponse->is_correct ? '#0DF840' : '#0DF840' }}" class="fw-bold">Bonne réponse :</span> {{ $reponse->bonne_reponse }}
                                    </p>

                                </div>
                            </div>

                        </div>
                        @endforeach

                    </section>


                </div>
                <div class="col-lg-3">
                    <div class="card text-center p-3 rounded-4 shadow-sm" style="background-color: #ebe9e9;">
                        <div class="d-flex justify-center align-items-center gap-2">
                            <img src="{{ asset('images/beautiful-woman.png') }}" alt="Emmanuelle" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            <h6 class="fw-bold mb-0">Emmanuelle</h6>
                        </div>

                        <hr class="my-2">
                        <p class="fw-semibold text-start ms-2 mb-2">Niveau de langue</p>

                        <div class="d-grid gap-2" style="grid-template-columns: repeat(2, 1fr); display: grid; ">
                            <div class=" p-2 rounded shadow-sm fw-semibold">TCF CANADA<br><span class="fw-normal">A1</span></div>
                            <div class="p-2 rounded shadow-sm fw-semibold">TCF QUEBEC<br><span class="fw-normal">A1</span></div>
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
