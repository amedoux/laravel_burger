@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Statistiques</h1>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Commandes en attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pending_orders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Commandes en préparation</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $preparing_orders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Commandes prêtes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ready_orders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Commandes payées</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completed_orders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Commandes mensuelles</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produits par catégorie</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4">
                        <canvas id="productsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recettes journalières -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recettes journalières</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Nombre de commandes</th>
                                    <th>Montant total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ now()->format('d/m/Y') }}</td>
                                    <td>{{ $completed_orders }}</td>
                                    <td>{{ number_format($daily_revenue, 2) }} €</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Données pour le graphique des commandes
    const ordersData = {
        labels: {!! json_encode($monthly_orders->pluck('month')) !!},
        datasets: [{
            label: 'Commandes',
            data: {!! json_encode($monthly_orders->pluck('count')) !!},
            borderColor: 'rgb(78, 115, 223)',
            tension: 0.1
        }]
    };

    // Données pour le graphique des produits
    const productsData = {
        labels: {!! json_encode($monthly_products->pluck('month')) !!},
        datasets: [{
            data: {!! json_encode($monthly_products->pluck('count')) !!},
            backgroundColor: [
                'rgb(78, 115, 223)',
                'rgb(28, 200, 138)',
                'rgb(246, 194, 62)',
                'rgb(231, 74, 59)',
                'rgb(133, 135, 150)'
            ]
        }]
    };

    // Configuration des graphiques
    const ordersConfig = {
        type: 'line',
        data: ordersData,
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    };

    const productsConfig = {
        type: 'doughnut',
        data: productsData,
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    };

    // Initialisation des graphiques
    new Chart(document.getElementById('ordersChart'), ordersConfig);
    new Chart(document.getElementById('productsChart'), productsConfig);
</script>
@endpush
@endsection 