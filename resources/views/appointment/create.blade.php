@extends('templates.nav')
@section('content')
    @push('style')
        <style>
            /* CSS kamu tetap utuh */
            :root {
                --primary-color: #AE96B0;
                --secondary-color: #2B2B2B;
                --light-bg: #f9f7fa;
            }

            .btn-color {
                background-color: var(--primary-color);
                color: white;
                border: none;
                padding: 10px 25px;
                border-radius: 30px;
                font-weight: 600;
            }

            .btn-color:hover {
                background-color: #9a80a0;
            }

            .text-color {
                color: var(--primary-color);
            }

            .appointment-hero {
                background: linear-gradient(rgba(174, 150, 176, 0.8), rgba(174, 150, 176, 0.8)), url('https://images.pexels.com/photos/40568/medical-appointment-doctor-healthcare-40568.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
                background-size: cover;
                background-position: center;
                min-height: 40vh;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 40px;
                text-align: center;
                color: white;
            }

            .appointment-card {
                background-color: white;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                padding: 30px;
                margin-bottom: 30px;
                transition: transform 0.3s ease;
            }

            .appointment-card:hover {
                transform: translateY(-5px);
            }

            .form-control,
            .form-select {
                border-radius: 10px;
                padding: 12px 15px;
                border: 1px solid #e1e1e1;
                margin-bottom: 20px;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.25rem rgba(174, 150, 176, 0.25);
            }

            .time-slot {
                display: inline-block;
                background-color: white;
                padding: 10px 15px;
                border-radius: 10px;
                margin: 5px;
                cursor: pointer;
                border: 1px solid #e1e1e1;
                transition: all 0.3s ease;
            }

            .time-slot:hover {
                background-color: var(--primary-color);
                color: white;
            }

            .section-title {
                position: relative;
                margin-bottom: 30px;
                font-weight: 700;
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

            .feature-item {
                display: flex;
                align-items: center;
                margin-bottom: 15px;
            }
        </style>
    @endpush

    <div class="container my-5">
        <!-- Hero Section -->
        <div class="appointment-hero text-center text-white">
            <div>
                <h1 class="display-4 fw-bold mb-3">Book Your Appointment</h1>
                <p class="lead">Schedule your visit with our specialists and receive the best care possible</p>
            </div>
        </div>

        <div class="row">
            <!-- Appointment Form -->
            <div class="col-lg-8">
                <div class="appointment-card">
                    <h3 class="section-title">Make an Appointment</h3>

                    @if (session('ok'))
                        <div class="alert alert-success">{{ session('ok') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('appointment.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" name="name"
                                        value="{{ old('name', Auth::user()->name) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', Auth::user()->email) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="doctor" class="form-label">Select Doctor</label>
                                    <select class="form-select" id="doctor" name="doctor_id">
                                        <option value="">Choose a doctor</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }} -
                                                {{ ucfirst($doctor->specialization->specialist ?? 'No Specialization') }} -
                                                Rp {{ number_format($doctor->doctor_fee, 0, ',', '.') ?? 'Rp. 0' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appointmentDate" class="form-label">Appointment Date</label>
                                    <input type="date" class="form-control" id="appointmentDate" name="date"
                                        value="{{ old('date') }}">
                                    @error('date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="time" class="form-label">Preferred Time</label>
                                    <input type="time" class="form-control" id="time" name="time"
                                        value="{{ old('time') }}">
                                    @error('time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Additional Message (Optional)</label>
                            <textarea class="form-control" id="message" name="notes" rows="4">{{ old('notes') }}</textarea>
                            @error('notes')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <input type="hidden" name="status" value="pending">

                        <button type="submit" class="btn btn-color btn-lg">
                            Book Appointment
                        </button>

                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="appointment-card">
                    <h4 class="section-title">Why Choose Violetta Hospital</h4>
                    <div class="feature-list">
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-color me-3"></i>
                            <span>Experienced Specialists</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-color me-3"></i>
                            <span>Advanced Medical Technology</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-color me-3"></i>
                            <span>Personalized Patient Care</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-color me-3"></i>
                            <span>Comfortable Environment</span>
                        </div>
                    </div>
                </div>

                <div class="appointment-card">
                    <h4 class="section-title">Contact Information</h4>
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt text-color me-3"></i>
                        <span>123 Health Street, Medical City</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-phone text-color me-3"></i>
                        <span>(123) 456-7890</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-envelope text-color me-3"></i>
                        <span>info@violettahospital.com</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-clock text-color me-3"></i>
                        <span>Mon - Fri: 8:00 AM - 8:00 PM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
