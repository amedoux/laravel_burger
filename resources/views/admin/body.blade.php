<h2 class="h5 no-margin-bottom">Tableau de bord</h2>
          </div>
        </div>
        <section class="no-padding-top no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-user-1"></i></div><strong>Tous les Clients</strong>
                    </div>
                    <div class="number dashtext-1">{{$total_user}}</div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-contract"></i></div><strong>Tous les Menus</strong>
                    </div>
                    <div class="number dashtext-2">{{$total_food}}</div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-paper-and-pencil"></i></div><strong>Total des Commandes</strong>
                    </div>
                    <div class="number dashtext-3">{{$total_order}}</div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Total Livré</strong>
                    </div>
                    <div class="number dashtext-4">{{$total_delivered}}</div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Statistiques journalières -->
        <section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <!-- Commandes du jour -->
              <div class="col-lg-4">
                <div class="bar-chart block">
                  <div class="title">
                    <strong class="d-block">Commandes du jour</strong>
                    <span class="d-block">{{ now()->format('d/m/Y') }}</span>
                  </div>
                  <canvas id="dailyOrdersChart"></canvas>
                </div>
              </div>

              <!-- Commandes validées -->
              <div class="col-lg-4">
                <div class="bar-chart block">
                  <div class="title">
                    <strong class="d-block">Commandes validées aujourd'hui</strong>
                    <span class="d-block">{{ now()->format('d/m/Y') }}</span>
                  </div>
                  <canvas id="validatedOrdersChart"></canvas>
                </div>
              </div>

              <!-- Recettes -->
              <div class="col-lg-4">
                <div class="bar-chart block">
                  <div class="title">
                    <strong class="d-block">Recettes du jour</strong>
                    <span class="d-block">{{ now()->format('d/m/Y') }}</span>
                  </div>
                  <canvas id="dailyRevenueChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Graphiques -->
        <section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-4">
                <div class="bar-chart block no-margin-bottom">
                  <div class="title">
                    <strong class="d-block">Commandes par statut</strong>
                    <span class="d-block">{{ now()->format('d/m/Y') }}</span>
                  </div>
                  <canvas id="barChartExample1"></canvas>
                </div>
                <div class="bar-chart block">
                  <div class="title">
                    <strong class="d-block">Produits par mois</strong>
                    <span class="d-block">Année {{ date('Y') }}</span>
                  </div>
                  <canvas id="barChartExample2"></canvas>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="line-chart block">
                  <div class="title">
                    <strong class="d-block">Évolution des commandes</strong>
                    <span class="d-block">Année {{ date('Y') }}</span>
                  </div>
                  <canvas id="lineChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Scripts pour les graphiques -->
        @push('scripts')
        <script>
          // Graphique des commandes du jour
          new Chart(document.getElementById('dailyOrdersChart'), {
            type: 'doughnut',
            data: {
              labels: ['En attente', 'En préparation', 'Prêtes'],
              datasets: [{
                data: [{{ $pending_orders }}, {{ $preparing_orders }}, {{ $ready_orders }}],
                backgroundColor: [
                  'rgba(255, 206, 86, 0.8)',  // Jaune pour en attente
                  'rgba(54, 162, 235, 0.8)',   // Bleu pour en préparation
                  'rgba(75, 192, 192, 0.8)',   // Vert clair pour prêtes
                ],
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'bottom',
                }
              }
            }
          });

          // Graphique des commandes validées
          new Chart(document.getElementById('validatedOrdersChart'), {
            type: 'doughnut',
            data: {
              labels: ['Commandes payées', 'Autres commandes'],
              datasets: [{
                data: [{{ $completed_orders }}, {{ $total_order - $completed_orders }}],
                backgroundColor: [
                  'rgba(153, 102, 255, 0.8)',
                  'rgba(201, 203, 207, 0.8)'
                ],
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'bottom',
                }
              }
            }
          });

          // Graphique des recettes du jour
          new Chart(document.getElementById('dailyRevenueChart'), {
            type: 'bar',
            data: {
              labels: ['Recettes du jour'],
              datasets: [{
                label: 'Montant en €',
                data: [{{ $daily_revenue }}],
                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    callback: function(value) {
                      return value + ' €';
                    }
                  }
                }
              },
              plugins: {
                legend: {
                  display: false
                }
              }
            }
          });

          // Graphique des commandes par statut
          new Chart(document.getElementById('barChartExample1'), {
            type: 'bar',
            data: {
              labels: ['En attente', 'En préparation', 'Prêtes', 'Payées'],
              datasets: [{
                label: 'Nombre de commandes',
                data: [
                  {{ $pending_orders }},
                  {{ $preparing_orders }},
                  {{ $ready_orders }},
                  {{ $completed_orders }}
                ],
                backgroundColor: [
                  'rgba(255, 206, 86, 0.5)',  // Jaune pour en attente
                  'rgba(54, 162, 235, 0.5)',   // Bleu pour en préparation
                  'rgba(75, 192, 192, 0.5)',   // Vert clair pour prêtes
                  'rgba(153, 102, 255, 0.5)'   // Violet pour payées
                ],
                borderColor: [
                  'rgba(255, 206, 86, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    stepSize: 1
                  }
                }
              }
            }
          });

          // Graphique des produits par mois
          new Chart(document.getElementById('barChartExample2'), {
            type: 'bar',
            data: {
              labels: {!! json_encode($monthly_products->pluck('month')->map(function($month) {
                return date('F', mktime(0, 0, 0, $month, 1));
              })) !!},
              datasets: [{
                label: 'Nombre de produits',
                data: {!! json_encode($monthly_products->pluck('count')) !!},
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgb(153, 102, 255)',
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    stepSize: 1
                  }
                }
              }
            }
          });

          // Graphique de l'évolution des commandes
          new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
              labels: {!! json_encode($monthly_orders->pluck('month')->map(function($month) {
                return date('F', mktime(0, 0, 0, $month, 1));
              })) !!},
              datasets: [{
                label: 'Nombre de commandes',
                data: {!! json_encode($monthly_orders->pluck('count')) !!},
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: false
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    stepSize: 1
                  }
                }
              }
            }
          });
        </script>
        @endpush
        