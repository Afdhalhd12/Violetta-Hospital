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

            @media (max-width: 768px) {
                .sidebar {
                    min-height: auto;
                }
            }
        </style>
    @endpush
    <div class="container-fluid">
         @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
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
                                <h5 class="mb-0">Specializations</h5>
                                <a href="{{ route('admin.specialization.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-arrow-left me-1"></i>Go Back
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Specialists</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach(  $specialists as $key => $item)
                                             <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item['specialist'] }}</td>
                                                <td>{{ $item['description'] }}</td>
                                                <td class="d-flex gap-2">

                                                    <form action="{{ route('admin.specialization.restore', $item['id']) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-sm btn-outline-success">
                                                            <i class="fas fa-recycle"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.specialization.delete_permanent', $item['id']) }}" method="POST">
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
