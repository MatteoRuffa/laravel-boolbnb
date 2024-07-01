<!-- resources/views/partials/dashboard-card/contability.blade.php -->

<div class="card mb-3">
    <div class="card-header">Contability</div>
    <div class="card-body">
        <canvas id="contabilityChart" width="400" height="200"></canvas>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('contabilityChart').getContext('2d');
        // Codice per il grafico di contabilità (da implementare)
    });
</script>
@endpush
