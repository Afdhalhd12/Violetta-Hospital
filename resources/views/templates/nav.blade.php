<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Violetta</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- CDN CSS Datatables --}}
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css" rel="stylesheet">
    @stack('style')
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2c3e50;
            --success: #27ae60;
            --info: #17a2b8;
            --warning: #f39c12;
            --danger: #e74c3c;
            --light: #ecf0f1;
            --dark: #34495e;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-container {
            display: flex;
            flex: 1;
        }

        .bg-white {
            background-color: #AE96B0 !important;
        }

        .sidebar {
            min-height: calc(100vh - 76px);
            background: linear-gradient(180deg, #9d7da0 0%, #8a6d8e 100%);
            color: white;
            width: 250px;
            flex-shrink: 0;
            transition: all 0.3s ease;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
            border-top-right-radius: 12px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.25rem;
            position: relative;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            margin-right: 0.6rem;
            width: 20px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.2);
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25);
            color: #fff;
        }

        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: #fff;
            border-radius: 0 4px 4px 0;
        }

        .sidebar img {
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .sidebar hr {
            border-color: rgba(255, 255, 255, 0.2);
        }


        .content-area {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .btn-color {
            background-color: #AE96B0;
            color: white;
            border-radius: 20px;
        }

        .btn-color:hover {
            background-color: #9a83a0;
            color: white;
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .sidebar {
                min-height: auto;
                width: 100%;
            }

        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50" height="50">
                <span class="m-2" style="color: #AE96B0;">Violetta Hospital</span>
            </a>

            <button data-mdb-collapse-init class="navbar-toggler" type="button" data-mdb-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <!-- Menu navigasi utama -->
                <div class="navbar-nav">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                    @else
                        <a class="nav-link" aria-current="page" href="{{ route('home') }}"><i class="fas fa-home"></i>
                            Home</a>
                        <a class="nav-link" href="{{ route('home') }}#about"><i class="fas fa-info-circle"></i> About
                            Us</a>
                        @if (Auth::check())
                            <a class="nav-link" href="{{ route('appointment.detail') }}"><i
                                    class="fa-solid fa-calendar-week"></i>
                                Appointment</a>
                        @else
                            <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-calendar-week"></i>
                                Appointment</a>
                        @endif
                    @endif
                </div>

                <!-- Tombol login/logout di sebelah kanan -->
                <div class="ms-auto d-flex gap-2">
                    @if (Auth::check())
                        @if (Auth::check() && Auth::user()->role == 'user')
                            <a href="{{ route('appointment.detail') }}" type="button" class="btn btn-color"><i
                                    class="fa-solid fa-user"></i>
                                Appointment history</a>
                        @elseif (Auth::check() && Auth::user()->role == 'admin')
                            <a href="{{ route('admin.doctor.index') }}" type="button" class="btn btn-color"><i
                                    class="fa-solid fa-user"></i>
                                Dashboard Admin</a>
                        @elseif (Auth::check() && Auth::user()->role == 'doctor')
                            <a href="{{ route('dokter.dashboard.index') }}" type="button" class="btn btn-color"><i
                                    class="fa-solid fa-user"></i>
                                Dashboard Doctor</a>
                        @endif

                        <a href="{{ route('logout') }}" type="button" class="btn btn-danger"
                            style="border-radius: 20px">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
                    @else
                        <a href="{{ route('login') }}" type="button" class="btn btn-color">
                            <i class="fa-solid fa-right-to-bracket"></i> Login
                        </a>
                        <a href="{{ route('signup') }}" type="button" class="btn btn-color">
                            <i class="fa-solid fa-user-plus"></i> Sign Up
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </nav>

    <div class="main-container">
        <!-- Sidebar hanya ditampilkan untuk admin -->
        @if (Auth::check() && Auth::user()->role == 'admin')
            <div class="sidebar d-flex flex-column p-3">
                <!-- Header Sidebar -->
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50"
                        class="rounded-circle mb-2 shadow-sm">
                    <h6 class="fw-bold mb-0">Admin Panel</h6>
                    <small>{{ Auth::user()->name }}</small>
                </div>

                <hr class="border-light opacity-50">

                <!-- Navigation -->
                <ul class="nav flex-column">
                    <li class="nav-item text-uppercase text-white-50 small mt-2 mb-1 px-3">Management</li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.doctor.index') ? 'active' : '' }}"
                            href="{{ route('admin.doctor.index') }}">
                            <i class="fas fa-user-md"></i> Doctor
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.specialization.*') ? 'active' : '' }}"
                            href="{{ route('admin.specialization.index') }}">
                            <i class="fa-solid fa-notes-medical"></i> Specialists
                        </a>
                    </li>

                    <li class="nav-item text-uppercase text-white-50 small mt-3 mb-1 px-3">General</li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.doctor.dashboard') || request()->routeIs('admin.doctor.tickets.chart') ? 'active' : '' }}"
                            href="{{ route('admin.doctor.dashboard') }}">
                            <i class="fas fa-chart-bar"></i> Statistic
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">
                            <i class="fas fa-chart-line"></i> Reports
                        </a>
                    </li>
                </ul>
                <!-- Footer Sidebar -->
                <div class="mt-auto text-center small text-light p-3">
                    <hr class="border-light opacity-50">
                    <em>"Caring with compassion."</em>

                    <div class="mt-3">
                        <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white mx-2"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        @endif


        <!-- Area konten utama -->
        <main class="content-area">
            @yield('content')
        </main>
    </div>

    <footer class="bg-white text-white py-5 mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Violetta Hospital</h5>
                    <p class="text-light" style="text-align: justify">Violetta Hospital always provides the best care
                        for its patients, supported by experienced specialists
                        and the latest healthcare technology.</p>
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="{{ route('home') }}#about" class="text-light text-decoration-none">About Us</a>
                        </li>
                        <li><a href="{{ route('home') }}#service"
                                class="text-light text-decoration-none">Services</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Info Contact</h6>
                    <p class="text-light mb-1"><i class="fas fa-map-marker-alt me-2"></i>345 Faulconer Drive, Suite 4
                    </p>
                    <p class="text-light mb-1"><i class="fas fa-phone me-2"></i>(123) 456-7890</p>
                    <p class="text-light"><i class="fas fa-envelope me-2"></i>example@gmail.com</p>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3"> Services</h6>
                    <ul class="text-light mb-3 text-decoration-none">
                        <li>Medicines</li>
                        <li>Pharmacy</li>
                        <li>Room</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-light mb-0">&copy;Copyright © 2025 • Lift Media Inc.</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    {{-- CDN JS DATATABLES --}}
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <!-- MDB UI Kit JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
    {{-- ChartJS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')

</body>

</html>
