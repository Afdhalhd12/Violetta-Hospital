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

            /* Card */
            .dashboard-card {
                background-color: white;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                padding: 25px;
                margin-bottom: 25px;
                transition: transform 0.3s ease;
            }

            .dashboard-card:hover {
                transform: translateY(-5px);
            }

            /* Table */
            .appointment-table {
                width: 100%;
                border-collapse: collapse;
            }

            .appointment-table th {
                background-color: var(--primary-color);
                color: white;
                padding: 12px 15px;
                text-align: left;
            }

            .appointment-table td {
                padding: 12px 15px;
                border-bottom: 1px solid #e1e1e1;
            }

            .appointment-table tr:hover {
                background-color: #f9f7fa;
            }

            /* Status Badges */
            .status-badge {
                padding: 5px 10px;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
            }

            .status-pending {
                background-color: #fff3cd;
                color: #856404;
            }

            .status-confirmed {
                background-color: #d1ecf1;
                color: #0c5460;
            }

            .status-completed {
                background-color: #d4edda;
                color: #155724;
            }

            .status-cancelled {
                background-color: #f8d7da;
                color: #721c24;
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

            .section-dd {
                position: relative;
                margin-bottom: 20px;
                font-weight: 700;
                color: var(--secondary-color);
            }

            .section-dd:after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 0;
                width: 60px;
                height: 3px;
            }

            /* Buttons */
            .action-btn {
                padding: 5px 10px;
                border-radius: 5px;
                font-size: 0.85rem;
                margin-right: 5px;
            }

            .btn-update {
                background-color: var(--primary-color);
                color: white;
                border: none;
            }

            .btn-update:hover {
                background-color: #9a80a0;
            }

            /* Modal */
            .modal-content {
                border-radius: 15px;
                border: none;
            }

            .modal-header {
                background-color: var(--primary-color);
                color: white;
                border-radius: 15px 15px 0 0;
            }

            .modal-footer {
                border-top: 1px solid #e1e1e1;
            }

            /* Form */
            .form-control,
            .form-select {
                border-radius: 10px;
                padding: 12px 15px;
                border: 1px solid #e1e1e1;
                margin-bottom: 15px;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.25rem rgba(174, 150, 176, 0.25);
            }

            /* Patient Info */
            .patient-info {
                background-color: #f9f7fa;
                border-radius: 10px;
                padding: 15px;
                margin-bottom: 15px;
            }

            .info-label {
                font-weight: 600;
                color: var(--secondary-color);
            }

            .info-value {
                color: #555;
            }

            .modal-detail-list {
                list-style: none;
                padding: 0;
                margin: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .modal-detail-list li {
                padding: 12px 16px;
                border-bottom: 1px solid #eaeaea;
                display: flex;
                align-items: flex-start;
                transition: background-color 0.2s ease;
            }

            .modal-detail-list li:last-child {
                border-bottom: none;
            }

            .modal-detail-list li:hover {
                background-color: #f9f9f9;
            }

            .modal-detail-list li::before {
                content: "•";
                color: #4a6ee0;
                font-weight: bold;
                margin-right: 10px;
                font-size: 18px;
            }

            /* Header untuk setiap item */
            .modal-detail-list li strong {
                display: inline-block;
                min-width: 120px;
                color: #333;
                font-weight: 600;
            }

            /* Value untuk setiap item */
            .modal-detail-list li span {
                color: #555;
                flex: 1;
            }

            /* Style khusus untuk status */
            .status-badge {
                display: inline-block;
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                text-transform: capitalize;
            }

            .status-confirmed {
                background-color: #e6f7ee;
                color: #0a7c42;
            }

            .status-pending {
                background-color: #fff8e6;
                color: #b3870f;
            }

            .status-cancelled {
                background-color: #ffe6e6;
                color: #c53030;
            }

            /* Style untuk judul modal */
            .modal-title {
                color: #2c3e50;
                font-weight: 600;
            }

            /* Style untuk konten sinopsis/notes */
            .notes-content {
                background-color: #f8f9fa;
                border-left: 3px solid #4a6ee0;
                padding: 12px;
                border-radius: 4px;
                margin-top: 8px;
                font-style: italic;
            }
        </style>
    @endpush
    <div class="container my-4">
        <!-- Hero Section -->
        <div class="dashboard-hero">
            <div>
                <h1 class="display-5 fw-bold mb-3">Payment</h1>
                <p class="lead">See your appointment history</p>
            </div>
        </div>

        <!-- Appointment List -->
        <div class="dashboard-card">
            <div class="d-flex justify-content-between mb-4">
                <div class="">
                <a href="{{ route('appointment.detail') }}" class="section-dd">History Appointment</a>
                    <a href="{{ route('appointment.payment') }}" class="section-title ms-3">Payment</a>
                </div>
                </div>
            <div class="table-responsive">
                <table class="appointment-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Doctor Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status Pembayaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $key => $apt)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $apt->doctor->name }}</td>
                                <td>{{ $apt->date->format('d M Y') }}</td>
                                <td>{{ $apt->time->format('H:i') }}</td>
                                <td>
                                    <span
                                        class="status-badge
                                        @if ($apt->payment->payment_status == 'pending') status-pending
                                        @elseif($apt->payment->payment_status == 'confirmed') status-confirmed
                                        @endif">
                                        {{ ucfirst($apt->payment->payment_status) }}
                                    </span>
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('appointment.qr', $apt->id) }}" class="btn btn-primary mb-3">
                                        <i class="fa-solid fa-money-check me-1"></i> Bayar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-light" id="exampleModalLabel">Detail</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalDetailBody">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function showModal(apt) {
            // Tentukan kelas status berdasarkan nilai status
            let statusClass = "status-badge ";
            switch (apt.status.toLowerCase()) {
                case "paid":
                    statusClass += "status-paid";
                    break;
                case "pending":
                    statusClass += "status-pending";
                    break;
            }
        }
    </script>
@endpush
