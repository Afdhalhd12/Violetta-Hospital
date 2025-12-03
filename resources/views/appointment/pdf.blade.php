<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti / Instruksi Pembayaran</title>

    <style>
        @page {
            margin: 20mm;
        }

        :root {
            --secondary-color: #2B2B2B;
            --light-bg: #f8f9fa;
            --border-radius: 10px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #ffffff;
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .payment-container {
            max-width: 700px;
            margin: 0 auto;
        }

        .payment-card {
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .payment-header {
            background: #AE96B0;
            color: white;
            padding: 12px 18px;
            text-align: center;
        }

        .payment-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 18px;
        }

        .payment-header p {
            margin: 4px 0 0;
            font-size: 11px;
        }

        .payment-body {
            padding: 18px;
        }

        .appointment-details {
            background-color: var(--light-bg);
            border-radius: var(--border-radius);
            padding: 14px 16px;
            margin-bottom: 18px;
        }

        .appointment-details h4 {
            font-size: 14px;
            margin: 0 0 10px;
            font-weight: 600;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e9ecef;
            font-size: 11px;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-label {
            font-weight: 500;
            color: #6c757d;
        }

        .detail-value {
            font-weight: 600;
            color: var(--secondary-color);
        }

        .total-price {
            font-size: 13px;
            color: #d00000;
        }

        .qr-section {
            text-align: center;
            padding: 14px 16px;
            background-color: #f8f9fa;
            border-radius: var(--border-radius);
            margin-bottom: 18px;
        }

        .qr-section h4 {
            font-size: 14px;
            margin: 0 0 6px;
            font-weight: 600;
        }

        .qr-section p {
            font-size: 11px;
            margin: 4px 0;
        }

        .qr-code {
            max-width: 180px;
            margin: 8px auto 6px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 6px;
            background: white;
        }

        .qr-code img {
            width: 100%;
            height: auto;
        }

        .payment-footer {
            text-align: center;
            color: #6c757d;
            font-size: 10px;
            margin-top: 10px;
        }

        .payment-footer p {
            margin: 2px 0;
        }
    </style>
</head>
<body>
<div class="payment-container">
    <div class="payment-card">
        <div class="payment-header">
            <h2>Bukti Pembayaran Online (QR)</h2>
            <p>Bukti / instruksi pembayaran janji temu</p>
        </div>

        <div class="payment-body">
            {{-- DETAIL JANJI TEMU --}}
            <div class="appointment-details">
                <h4>Detail Janji Temu</h4>

                <div class="detail-item">
                    <span class="detail-label">Nomor Invoice</span>
                    <span class="detail-value">{{ $appointment->payment->invoice_id }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Pasien</span>
                    <span class="detail-value">{{ $appointment->patient->name ?? '-' }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Dokter</span>
                    <span class="detail-value">{{ $appointment->doctor->name ?? 'Dokter' }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Tanggal</span>
                    <span class="detail-value">{{ $appointment->date }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Jam</span>
                    <span class="detail-value">{{ $appointment->time }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Total Pembayaran</span>
                    <span class="detail-value total-price">
                        Rp {{ number_format($appointment->payment->total_price, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            <div class="payment-footer">
                <p>Pembayaran Anda diproses secara aman.</p>
                <p>Harap menunjukkan bukti pembayaran saat datang ke klinik.</p>
                <p>Butuh bantuan? Hubungi <strong>1500-123</strong></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
