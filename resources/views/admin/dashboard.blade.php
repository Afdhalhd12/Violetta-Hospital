@extends('templates.nav')
@section('content')
    @push('style')
        <style>
            :root {
                --primary-color: #AE96B0;
                --secondary-color: #2B2B2B;
                --light-bg: #f9f7fa;
            }

            .dashboard-hero {
                background: linear-gradient(rgba(174, 150, 176, 0.8), rgba(174, 150, 176, 0.8)),
                    url('https://images.pexels.com/photos/40568/medical-appointment-doctor-healthcare-40568.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
                background-size: cover;
                background-position: center;
                min-height: 30vh;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                color: white;
                margin-bottom: 30px;
            }

            .dashboard-card {
                background-color: white;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                padding: 25px;
                margin-bottom: 25px;
                transition: transform 0.3s ease;
                height: 100%;
            }

            .dashboard-card:hover {
                transform: translateY(-5px);
            }

            .section-title {
                position: relative;
                margin-bottom: 20px;
                font-weight: 700;
                color: var(--secondary-color);
            }

            .section-title:after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 0;
                width: 60px;
                height: 3px;
                background-color: var(--primary-color);
            }

            .chart-container {
                height: 300px;
                position: relative;
            }

            .month-badge {
                background: linear-gradient(135deg, var(--primary-color), #9a80a0);
                color: white;
                padding: 8px 20px;
                border-radius: 20px;
                display: inline-block;
                margin-bottom: 15px;
                font-weight: 600;
                font-size: 0.95rem;
            }
        </style>
    @endpush

    <div class="container my-4">
        <!-- Hero Section -->
        <div class="dashboard-hero">
            <div>
                <h1 class="display-5 fw-bold mb-3">Appointment Analytics Dashboard</h1>
                <p class="lead">Visualize and analyze appointment data with interactive charts</p>
            </div>
        </div>

        <div class="row">
            <!-- Bar Chart -->
            <div class="col-lg-6 mb-4">
                <div class="dashboard-card">
                    <h5 class="section-title">Monthly Appointment Schedule</h5>
                    <div class="month-badge">{{ now()->format('F Y') }}</div>
                    <div class="chart-container">
                        <canvas id="chartBar"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-lg-6 mb-4">
                <div class="dashboard-card">
                    <h5 class="section-title">Appointments by Specialization</h5>
                    <div class="month-badge">{{ now()->format('F Y') }}</div>
                    <div class="chart-container">
                        <canvas id="chartPie"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let labelBar = [];
        let dataBar = [];


        $(function() {
            $.ajax({
                url: "{{ route('admin.doctor.tickets.chart') }}",
                method: "GET",
                success: function(response) {
                    console.log(response)
                    labelBar = response.labels;
                    dataBar = response.data;
                    chartBar();
                },
                error: function(err) {
                    alert('Gagal mengambil data untuk chart bar');
                }
            });
        });

        $.ajax({
                url: "{{ route('admin.doctor.specialization.chart') }}",
                method: "GET",
                success: function(response) {
                    console.log(response)
                    labelPie = response.labels;
                    dataPie = response.data;
                    chartPie();
                },
                error: function(err) {
                    alert('Gagal mengambil data untuk chart bar');
                }
            });

        const ctx = document.getElementById('chartBar');

        function chartBar() {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelBar,
                    datasets: [{
                        label: 'Jumlah Jadwal Pertemuan',
                        data: dataBar,
                        backgroundColor: '#AE96B0',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        let ctx2 = document.getElementById('chartPie')

        function chartPie() {
            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: labelPie,
                    datasets: [{
                        label: 'Data Jadwal Pertemuan Berdasarkan Spesialis',
                        data: dataPie,
                        backgroundColor: [
                            '#AE96B0',
                            '#9a80a0',
                            '#8a6d8f',
                            '#7a5a7f',
                            '#6a486f'  
                        ],
                        hoverOffset: 4
                    }]
                },
            });
        }
    </script>
@endpush
