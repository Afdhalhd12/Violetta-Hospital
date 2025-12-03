@extends('templates.nav')
@section('content')
    @push('style')
        <style>
            .navbar {
                background-color: white;
                box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            }

            .card {
                border: none;
                border-radius: 0.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                transition: transform 0.2s;
            }

            .card:hover {
                transform: translateY(-5px);
            }

            .card-icon {
                font-size: 2rem;
                opacity: 0.7;
            }

            .stat-card {
                border-left: 4px solid;
            }

            .appointments-card {
                border-left-color: var(--primary);
            }

            .doctors-card {
                border-left-color: var(--success);
            }

            .staff-card {
                border-left-color: var(--warning);
            }

            .patients-card {
                border-left-color: var(--info);
            }


            .table th {
                border-top: none;
                font-weight: 600;
                color: var(--dark);
            }

            .badge-pending {
                background-color: #fff3cd;
                color: #856404;
            }

            .badge-confirmed {
                background-color: #d1ecf1;
                color: #0c5460;
            }

            .badge-completed {
                background-color: #d4edda;
                color: #155724;
            }

            .badge-cancelled {
                background-color: #f8d7da;
                color: #721c24;
            }

            .page-title {
                color: var(--secondary);
                font-weight: 600;
                margin-bottom: 1.5rem;
            }

            .btn-primary {
                background-color: var(--primary);
                border-color: var(--primary);
            }

            .btn-primary:hover {
                background-color: #2980b9;
                border-color: #2980b9;
            }

             .table-responsive {
        overflow-x: hidden !important;
    }

    .table {
        font-size: 0.85rem;
    }

    .table th,
    .table td {
        white-space: normal !important;
        word-break: break-word;
        max-width: 180px;
        vertical-align: middle;
    }

    .table img {
        width: 60px;
        border-radius: 5px;
    }


    @media (max-width: 768px) {
        .table {
            font-size: 0.75rem;
        }
        .table img {
            width: 45px;
        }
        .table th,
        .table td {
            max-width: 120px;
        }
    }

            @media (max-width: 768px) {
                .sidebar {
                    min-height: auto;
                }
            }
        </style>
    @endpush
    <div class="container-fluid">
         @if (Session::get('ok'))
            <div class="alert alert-success">{{ Session::get('ok') }}</div>
        @endif
         @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        <div class="row">
            <!-- Main Content -->
            <main class="col-12 px-md-2 mt-2">
                <!-- Recent Appointments -->
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Doctor</h5>
                               <div>
                                    <a href="{{ route('admin.doctor.export') }}" class="btn btn-success btn-sm mx-1">
                                    <i class="fas fa-file-excel me-1"></i> Export Excel

                                    <a href="{{ route('admin.doctor.trash') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-trash me-1"></i> Trash
                                </a>
                                <a href="{{ route('admin.doctor.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i> add Data
                                </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>*</th>
                                                <th>Foto</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Biaya</th>
                                                <th>Peran</th>
                                                <th>Bidang</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach(  $users as $key => $item)
                                             <tr>
                                                <td>{{ $key + 1 }}</td>
                                                @if($item->role == 'doctor')
                                                <td><img src="{{ asset('storage/' . $item->photo) }}" alt="Foto Dokter" width="100" style="border-radius: 5px"></td>
                                                @elseif($item->role == 'admin')
                                                <td><img src="{{ asset('images/images (1).png') }}" width="100" style="border-radius: 5px"></td>
                                                @endif
                                                <td>{{ $item['name'] }}</td>
                                                <td>{{ $item['email'] }}</td>
                                                <td> Rp. {{ number_format($item['doctor_fee'], 0, ',', '.') ?? '' }}</td>
                                                @if($item->role == 'admin')
                                                    <td><span class="badge badge-info">{{ ucwords($item['role']) }}</span></td>
                                                @else
                                                    <td><span class="badge badge-success">{{ ucwords($item['role']) }}</span></td>
                                                @endif
                                                    <td>{{ $item['specialization']['specialist']}}</td>

                                                    <td>
                                                    <a href="{{ route('admin.doctor.edit', $item['id']) }}" class="btn btn-sm btn-outline-primary me-1 mb-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.doctor.delete', $item['id']) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                             @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
