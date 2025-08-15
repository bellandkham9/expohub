@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-primary">
        📚 Entraîner l'IA - Compréhension Écrite
    </h2>

    {{-- Messages Flash avec SweetAlert2 --}}
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès 🎉',
                    html: `{!! session('success') !!}`,
                    showConfirmButton: true,
                    confirmButtonText: "Voir les questions",
                }).then((result) => {
                    if (result.isConfirmed) {
                        let questions = {!! json_encode(session('generated_questions') ?? []) !!};
                        if (questions.length > 0) {
                            let htmlContent = '<ul style="text-align:left;">';
                            questions.forEach((q, i) => {
                                htmlContent += `<li><b>Q${i+1}:</b> ${q.question}</li>`;
                            });
                            htmlContent += '</ul>';
                            Swal.fire({
                                title: "Questions générées",
                                html: htmlContent,
                                width: 800,
                            });
                        }
                    }
                });
            });
        </script>
    @elseif(session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur 😢',
                    html: `{!! session('error') !!}`,
                });
            });
        </script>
    @endif

    {{-- Formulaire --}}
    <div class="card shadow-lg border-0 p-4 mb-4">
        <form method="POST" action="{{ route('admin.comprehension_ecrite.generate') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Nombre de nouvelles questions à générer</label>
                <input type="number" name="nb_questions" class="form-control" value="5" min="1" max="20" required>
            </div>
            <button class="btn btn-primary w-100" id="btnGenerate">
                🚀 Générer
            </button>
        </form>
    </div>

    {{-- Dernières questions --}}
    <h4 class="mt-5">📜 Dernières questions existantes</h4>
    <div class="list-group shadow-sm">
        @foreach($questions as $q)
            <div class="list-group-item">
                <h6 class="fw-bold">{{ $q->question }}</h6>
                <p class="text-muted small">{{ $q->situation }}</p>
            </div>
        @endforeach
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Loader bouton --}}
<script>
    document.getElementById('btnGenerate').addEventListener('click', function() {
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Génération en cours...';
    });
</script>
@endsection
