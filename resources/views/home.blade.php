@extends('templates.nav')
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success w-100">{{ Session::get('success') }}
            <b>Selamat Datang, {{ Auth::user()->name }}</b>
        </div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-danger w-100">{{ Session::get('error') }}
        </div>
    @endif
    @if (Session::get('logout'))
        <div class="alert alert-warning w-100">{{ Session::get('logout') }}</div>
    @endif
    <div class="mx-auto container mb-3">
        <div data-aos="zoom-in"
            style="background-image: url('{{ asset('images/bg-2.jpg') }}'); background-size: cover; background-position: center; min-height: 50vh; overflow: hidden; border-radius: 20px;">
            <div class="row position-relative" style="margin-left: 30px; z-index: 2;">
                <div class="col-md-12 text-left text-light" style="max-width: 700px; margin-top: 20px;">
                    <h1 class="fw-bold" style="color: #AE96B0; font-size: 100px;">Violetta</h1>
                    <h1 class="fw-bold" style="color: #2B2B2B; font-size: 90px;">Hospital</h1>
                    <p class="mt-4" style="font-size: 18px; color: #2B2B2B; max-width: 400px;">
                        Violetta Hospital always provides the best care for its patients, supported by experienced
                        specialists
                        and the latest healthcare technology.
                    </p>
                </div>
                <div class="d-grid gap-2 d-md-block mt-3 mb-3">
                    <a href="#" type="button" class="btn btn-color">
                        Consultation</a>
                </div>
            </div>
        </div>

        <div class="mt-4 ">
            <div class="row">
                <div class="col-4">
                    <div class="feature-card white">
                        <h5>Pharmacy</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        <img src="{{ asset('images/capUngu.png') }}" class="mx-auto d-block" style="width: 100px; ">
                    </div>
                </div>

                <div class="col-4">
                    <div class="feature-card white">
                        <h5>Room</h5>
                        <p>Comfortable rooms and holistic treatment for every patient.</p>
                        <img src="{{ asset('images/palaUngu.png') }}" class="mx-auto d-block" style="width: 100px; ">
                    </div>
                </div>

                <div class="col-4">
                    <div class="feature-card white">
                        <h5>Medicines</h5>
                        <p>Fast and reliable emergency services anytime you need them.</p>
                        <img src="{{ asset('images/hatiPink.png') }}" class="mx-auto d-block" style="width: 100px; ">
                    </div>
                </div>
            </div>
        </div>


        <div class="mt-5 mb-5 wahana" style="min-height:50vh; max-width: 90%;">
            <div class="d-flex align-items-start">
                <div class="me-5">
                    <img src="{{ asset('images/hospitall.jpg') }}" class="rounded" alt="..." style="height: 300px">
                </div>
                <div style="text-align: justify;">
                    <h1 class="m-0 fw-bold" id="about">About Us</h1>
                    <p class="mt-3" style="max-width: 600px;">Our hospital is a modern healthcare center committed to
                        providing safe, comfortable, and patient focused services. Supported by professional medical staff
                        and
                        complete facilities, we are dedicated to delivering the best care from prevention to treatment to
                        protect the health and well-being of you and your family.</p>
                </div>
            </div>
        </div>


        <div>
            <h3 class="fw-bold mb-4">Our professional <br> doctor</h3>


            <!-- Doctors -->
            <div class="row g-4">
                @forelse ($users as $item)
                    <div class="col-md-3 col-sm-6">
                        <div class="doctor-card" style="max-height: 350px;">
                            <img src="{{ asset('storage/' . $item->photo) }}" alt="Doctor" class="img-fluid"
                                style="max-height: 225px">
                            <h5>{{ $item->name }}</h5>
                            <p>{{ $item->specialization->specialist ?? '-' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        No doctors found for this specialization.
                    </div>
                @endforelse
            </div>

        </div>

        {{-- section --}}
        <section id="about" class="py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="https://images.pexels.com/photos/356040/pexels-photo-356040.jpeg?auto=compress&cs=tinysrgb&w=800"
                        alt="Hospital Building" class="img-fluid rounded-3 shadow-lg">
                </div>
                <div class="col-lg-6">
                    <div class="about-content">
                        <h2 class="section-title">Why Choose Violetta Hospital</h2>
                        <p class="lead text-muted mb-4">
                            With over 15 years of experience in healthcare, Violetta Hospital is committed to delivering the
                            best medical services supported by advanced technology and a team of dedicated professionals.
                        </p>

                        <div class="feature-list">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-color me-3 "></i>
                                <span>Advanced Medical Technology</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-color me-3"></i>
                                <span>Experienced Medical Team</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-color me-3"></i>
                                <span>24/7 Healthcare Services</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-color me-3"></i>
                                <span>Modern & Comfortable Facilities</span>
                            </div>
                        </div>
                        @if (Auth::check())
                            <a href="{{ route('appointment.create') }}" class="btn btn-primary btn-lg mt-4 text-bg">
                                <i class="fas fa-calendar-plus me-2"></i>make an appointment now
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-4 text-bg">
                                <i class="fas fa-calendar-plus me-2"></i>make an appointment now
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
@endsection
