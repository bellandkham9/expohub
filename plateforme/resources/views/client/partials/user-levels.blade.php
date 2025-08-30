<div class="col-12 col-md-6 col-lg-12">
    <h6 class="fw-bold mb-3">Vos niveaux par test</h6>
    <div class="d-flex flex-wrap justify-content-center gap-2">
        @foreach ($testTypes1 as $testType)
            @php
                $modalId = 'modal_' . $testType->id;
                $key = $testType->examen;
                $skills = [
                    'Compréhension écrite' => 'comprehension_ecrite_level',
                    'Expression écrite' => 'expression_ecrite_level',
                    'Compréhension orale' => 'comprehension_orale_level',
                    'Expression orale' => 'expression_orale_level',
                ];
                $niveaux = $userLevels[$key] ?? null;
            @endphp

            <button type="button" class="btn btn-level {{ $testType->paye ? 'btn-outline-primary' : 'btn-secondary' }} {{ $testType->paye ? '' : 'disabled' }}"
                    @if($testType->paye) data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" @endif>
                @if(!$testType->paye)
                    <i class="fas fa-lock me-1"></i>
                @endif
                {{ strtoupper($key) }}
            </button>

            <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Niveaux pour {{ strtoupper($key) }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            @if($niveaux)
                                <div class="row g-2">
                                    @foreach($skills as $label => $champ)
                                        @php
                                            $level = $niveaux[$champ] ?? 'Non défini';
                                            $color = match($level) {
                                                'C2', 'C1', 'B2' => 'success',
                                                'B1', 'A2', 'A1' => 'warning',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <div class="col-6">
                                            <div class="p-2 bg-light rounded text-center">
                                                <small class="d-block text-muted">{{ $label }}</small>
                                                <strong class="text-{{ $color }}">{{ $level }}</strong>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">Aucun niveau enregistré pour ce test.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>