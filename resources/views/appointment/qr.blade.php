@extends('templates.nav')
   @push('style')
<style>
    :root {
        --primary-color: #AE96B0;
        --secondary-color: #2B2B2B;
        --light-bg: #f8f9fa;
        --border-radius: 10px;
    }

    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        color: #333;
    }

    .payment-container {
        max-width: 600px;
        margin: 1.5rem auto;
        padding: 0 15px;
    }

    .payment-card {
        background: white;
        border-radius: var(--border-radius);
        border: 1px solid #e0e0e0;
        overflow: hidden;
    }

    .payment-header {
        background: var(--primary-color);
        color: white;
        padding: 1rem;
        text-align: center;
    }

    .payment-header h2 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
    }

    .payment-body {
        padding: 1.3rem;
    }

    .appointment-details {
        background-color: var(--light-bg);
        border-radius: var(--border-radius);
        padding: 1rem;
        margin-bottom: 1.2rem;
    }

    .appointment-details h4 {
        font-size: 1rem;
        margin-bottom: .7rem;
        font-weight: 600;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: .5rem;
        padding-bottom: .5rem;
        border-bottom: 1px solid #e9ecef;
        font-size: .9rem;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 500;
        color: #555;
    }

    .detail-value {
        font-weight: 600;
        color: var(--secondary-color);
    }

    .total-price {
        color: #d00000;
    }

    .qr-section {
        text-align: center;
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: var(--border-radius);
        margin-bottom: 1.2rem;
    }

    .qr-code {
        max-width: 180px;
        margin: .5rem auto;
    }

    .btn-pay {
        background: var(--primary-color);
        border: none;
        color: white;
        padding: .6rem;
        width: 100%;
        font-size: 1rem;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
    }

    .payment-footer {
        text-align: center;
        font-size: .8rem;
        color: #555;
        margin-top: .8rem;
    }
</style>
@endpush

    @section('content')

    <div class="payment-container">
        <div class="payment-card">
            <div class="payment-header">
                <h2><i class="fas fa-qrcode me-2"></i>Pembayaran Online (QR)</h2>
                <p class="mb-0">Selesaikan pembayaran Anda dengan mudah</p>
            </div>

            <div class="payment-body">

                <div class="appointment-details">
                    <h4><i class="fas fa-calendar-check me-2"></i>Detail Janji Temu</h4>

                    <div class="detail-item">
                        <span class="detail-label">Dokter:</span>
                        <span class="detail-value">{{ $appointment->doctor->name ?? 'Dokter' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Tanggal:</span>
                        <span class="detail-value">{{ $appointment->date }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Jam:</span>
                        <span class="detail-value">{{ $appointment->time }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Total Pembayaran:</span>
                        <span class="detail-value total-price">Rp {{ number_format($appointment->payment->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>


                <div class="qr-section">
                    <h4><i class="fas fa-mobile-alt me-2"></i>Scan QR Code</h4>
                    <p class="text-muted mb-3">Gunakan aplikasi mobile banking atau e-wallet untuk scan QRIS berikut</p>

                    <div class="qr-code">
                        <img src="{{ Storage::url($appointment->payment->qr_path) }}" alt="QR Code" class="img-fluid">
                    </div>
                    <p>{{$appointment->payment->invoice_id}}</p>

                </div>


                <form action="{{ route('appointment.confirm', $appointment->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-pay">
                        <i class="fas fa-check-circle me-2"></i>Saya Sudah Bayar
                    </button>
                </form>

                <div class="payment-footer">
                    <a class="text-secondary" href="{{ route('appointment.payment') }}">
                        Bayar nanti
                    </a>
                    <p>
                        <i class="fas fa-shield-alt me-1"></i>Pembayaran Anda aman dan terenkripsi
                    </p>
                    <p>Butuh bantuan? Hubungi <strong>1500-123</strong></p>
                </div>
            </div>
        </div>
    </div>
    @endsection
