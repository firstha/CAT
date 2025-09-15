@php
    $landing = \App\Models\LandingPage::first();
    $features = \App\Models\LandingPageFeature::all();
    $highlights = \App\Models\LandingPageHighlight::first();
    $appShowcases = \App\Models\AppShowcase::orderBy('order')->get();
    $memberLevels = App\Models\MemberLevel::with('benefits')->get();
    $allBenefits = App\Models\MemberBenefit::all();
    $galleries = \App\Models\Gallery::orderBy('order')->get();
@endphp

<!DOCTYPE html>
<html lang="id" translate="no">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Membantu casis POLRI, TNI, CPNS dan Kedinasan dalam berlatih agar lebih siap menghadapi tes yang sebenarnya"/>
        <meta name="author" content="{{ $setting->app_name ?? '' }}" />
        <title>Home</title>
        <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png" />
        <link href="{{ asset('assets/landing-page/theme_1/css/styles.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/landing-page/theme_1/css/aos.css') }}" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        
        <link href="{{ asset('assets/landing-page/theme_2/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/landing-page/theme_2/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        
        <script data-search-pseudo-elements="" defer="" src="{{ asset('assets/landing-page/theme_1/js/all.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/landing-page/theme_1/js/feather.min.js') }}" crossorigin="anonymous"></script>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-248878270-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-248878270-1');
        </script>

        <style>
            /* Custom styles untuk galeri slider */
            .gallery-section {
                padding: 60px 0;
                overflow: hidden;
            }

            .swiper {
                width: 100%;
                height: 100%;
                padding: 20px 0;
            }

            .swiper-slide {
                text-align: center;
                font-size: 18px;
                background: #fff;
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }

            .swiper-slide:hover {
                transform: translateY(-5px);
            }

            .swiper-slide img {
                display: block;
                width: 100%;
                height: 250px;
                object-fit: cover;
            }

            .swiper-button-next, 
            .swiper-button-prev {
                color: #007bff;
                background: rgba(255, 255, 255, 0.8);
                width: 40px;
                height: 40px;
                border-radius: 50%;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            }

            .swiper-button-next:after, 
            .swiper-button-prev:after {
                font-size: 20px;
                font-weight: bold;
            }

            .swiper-pagination-bullet {
                width: 12px;
                height: 12px;
                background: #007bff;
                opacity: 0.5;
            }

            .swiper-pagination-bullet-active {
                opacity: 1;
            }

            .blue-theme {
                color: #007bff;
            }
            
            .blue-bg {
                background-color: #007bff;
                color: white;
            }

            @media (max-width: 768px) {
                .swiper-slide img {
                    height: 200px;
                }
                
                .swiper-button-next, 
                .swiper-button-prev {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <div id="layoutDefault">
            <div id="layoutDefault_content">
                <main>
                    <!-- Navbar-->
                    <nav class="navbar navbar-marketing navbar-expand-lg bg-white navbar-light">
                        <div class="container px-5">
                            <a class="navbar-brand text-primary" href="{{ url('/') }}">{{ $setting->app_name ?? '' }}</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto me-lg-5">
                                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                                </ul>
                                <a class="btn fw-500 ms-lg-4 btn-outline-primary" href="{{ route('login') }}">
                                    Login
                                </a>
                                <a class="btn fw-500 ms-lg-4 btn-primary" href="{{ route('register') }}">
                                    Daftar
                                    <i class="ms-2" data-feather="arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </nav>
                    <!-- Page Header-->
                    <header class="page-header-ui page-header-ui-light bg-white">

                        <div style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;">
                            <canvas id="nodes"></canvas>
                        </div>
                        <div class="page-header-ui-content" style="position:relative; left: 0px; top: 0px; width: 100%; height: 100%;">
                            <div class="container px-5">
                                <div class="row gx-5 justify-content-center">
                                    <div class="col-xl-8 col-lg-10 text-center mb-4" data-aos="fade">
                                        <h1 class="page-header-ui-title text-white">{{ $landing->hero_title ?? 'Judul Default' }}</h1>
                                        <p class="page-header-ui-text text-white">{{ $landing->hero_description ?? 'Deskripsi default' }}</p>
                                        <a class="btn btn-primary fw-500 me-2" href="{{ route('login') }}">Mulai Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <section class="bg-light pb-10 pt-1">
                        <div class="container px-5">
                            <div class="device-laptop text-gray-200 mt-n10" data-aos="fade-up">
                                <svg class="device-container" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="83.911 298.53 426.962 243.838"><path d="M474.843 516.208V309.886c0-6.418-4.938-11.355-11.354-11.355H131.791c-6.417 0-11.354 4.938-11.354 11.355v206.816H83.911v13.326c4.938 7.896 31.098 12.34 40.969 12.34h345.024c10.366 0 36.526-4.936 40.969-12.34v-13.326h-36.03v-.494zM134.26 313.341h326.762v203.361H134.26V313.341z"></path></svg>
                                <img class="device-screenshot" src="{{ asset('assets/landing-page/theme_1/image_tenant/'.$setting->app_name.'/image.png') }}" />
                            </div>
                        </div>
                    </section>
                    <section class="bg-white py-10">
                        <div class="container px-5">
                            <div class="row gx-5 text-center">
                                <div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                                    <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4"><i data-feather="layers"></i></div>
                                    <h3>{{ $highlights->title1 }}</h3>
                                    <p class="mb-0">{{ $highlights->description1 }}</p>
                                </div>
                                <div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                                    <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4"><i data-feather="smartphone"></i></div>
                                    <h3>{{ $highlights->title2 }}</h3>
                                    <p class="mb-0">{{ $highlights->description2 }}</p>
                                </div>
                                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                                    <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4"><i data-feather="code"></i></div>
                                    <h3>{{ $highlights->title3 }}</h3>
                                    <p class="mb-0">{{ $highlights->description3 }} {{ $setting->app_name ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="bg-light py-10">
                        <div class="container px-5">
                            <div class="row gx-5 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="text-center">
                                        <div class="text-xs text-uppercase-expanded text-primary mb-2">Feature Aplikasi</div>
                                        <h2 class="mb-5">Kami memiliki solusi sederhana untuk masalah yang kompleks</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row gx-5">
                                @foreach ($features as $feature)
                                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up">
                                    <a class="card text-center text-decoration-none h-100 lift">
                                        <div class="card-body py-5">
                                            <div class="icon-stack icon-stack-lg bg-green-soft text-green mb-4"><i data-feather="layers"></i></div>
                                            <h5>{{ $feature->title }}</h5>
                                            <p class="card-text small">{{ $feature->description }}</p>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <section class="bg-white py-10">
                        <div class="container px-5">
                            <div class="row gx-5 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="text-center">
                                        <div class="text-xs text-uppercase-expanded text-primary mb-2">Gambaran Aplikasi</div>
                                        <h2 class="mb-5">Gambaran Aplikasi CAT {{ $setting->app_name ?? '' }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($appShowcases as $showcase)
                                <div class="col-lg-6 col-md-12" data-aos="fade-up">
                                    <div class="card">
                                        <img src="{{ $showcase->thumbnail_url }}" class="card-img-top" alt="{{ $setting->app_name }}"/>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $showcase->title }}</h5>
                                            <p class="card-text">
                                                {{ $showcase->description }}
                                            </p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!-- ======= Gallery Section ======= -->
                    <section id="gallery" class="gallery-section bg-white">
    <div class="container px-5" data-aos="fade-up">
        <div class="section-header text-center">
            <h2 class="blue-theme">GALERI</h2>
            <p>Dokumentasi Aktivitas Try Out & Belajar Online</p>
        </div>
    </div>

    <div class="container px-5 mt-4" data-aos="fade-up" data-aos-delay="100">
        <!-- Slider main container -->
        <div class="swiper gallerySwiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                @foreach ($galleries as $gallery)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="Galeri Kegiatan">
                    </div>
                @endforeach
            </div><br>

            <!-- Navigation buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

                    <!-- End Gallery Section -->

                    <section class="bg-light pt-10">
                        <div class="container px-5">
                            <div class="text-center mb-5">
                                <h2>Kategori Member</h2>
                                <p class="lead">Berikut kategori member yang ada di {{ $setting->app_name ?? '' }}</p>
                                <p>Detail Harga Akan Muncul Ketika Anda Login</p>
                            </div>
                            <div class="row gx-5 z-1">
                                @foreach($memberLevels as $level)
                                    <div class="col-lg-4 mb-5 mb-lg-n10" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                        <div class="card pricing h-100">
                                            <div class="card-body p-5">
                                                <div class="text-center">
                                                    <h2>
                                                        <div class="badge {{ $loop->index == 0 ? 'bg-danger' : ($loop->index == 1 ? 'bg-primary' : 'bg-warning') }} text-white rounded-pill badge-marketing">
                                                            {{ $level->name }}
                                                        </div>
                                                    </h2>
                                                </div>
                                                <br>
                                                <ul class="fa-ul pricing-list">
                                                    @foreach($allBenefits as $benefit)
                                                        <li class="pricing-list-item">
                                                            <span class="fa-li">
                                                                @if($level->benefits->contains($benefit))
                                                                    <i class="far fa-check-circle text-teal"></i>
                                                                @else
                                                                    <i class="far fa-circle text-gray-200"></i>
                                                                @endif
                                                            </span>
                                                            <span class="text-dark">{{ $benefit->name }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="svg-border-rounded text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor">
                                <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
                            </svg>
                        </div>
                    </section>
                    <section class="bg-dark pb-10 pt-15">
                        <div class="container px-5">
                            <div class="row gx-5 mb-10 mt-5">
                                <div class="col-lg-6 mb-5">
                                    <div class="d-flex h-100">
                                        <div class="icon-stack flex-shrink-0 bg-teal text-white"><i class="fas fa-question"></i></div>
                                        <div class="ms-4">
                                            <h5 class="text-white">Apa itu platform {{ $setting->app_name ?? '' }} ?</h5>
                                            <p class="text-white-50">{{ $setting->app_name ?? '' }} merupakan sistem CAT yang bertujuan Membantu casis POLRI, TNI, CPNS dan Kedinasan dalam berlatih agar lebih siap menghadapi tes yang sebenarnya</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-5">
                                    <div class="d-flex h-100">
                                        <div class="icon-stack flex-shrink-0 bg-teal text-white"><i class="fas fa-question"></i></div>
                                        <div class="ms-4">
                                            <h5 class="text-white">Apa yang saya dapatkan ketika bergabung ?</h5>
                                            <p class="text-white-50">Anda akan mendapatkan informasi mengenai soal-soal terupdate, serta penilaian yang sesuai dengan tes aslinya, sehingga anda akan lebih siap dan percaya diri untuk mengikuti tes pada peminatan yang anda pilih.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-5 mb-lg-0">
                                    <div class="d-flex h-100">
                                        <div class="icon-stack flex-shrink-0 bg-teal text-white"><i class="fas fa-question"></i></div>
                                        <div class="ms-4">
                                            <h5 class="text-white">Apakah saya akan mendapatkan informasi terbaru ?</h5>
                                            <p class="text-white-50">Ya, anda akan mendapatkan informasi ketika anda join di group Whatsapp kami. silakan hubungi admin, dan admin akan mengundang anda secara khusus untuk bergabung dengan siswa lainnya di {{ $setting->app_name ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex h-100">
                                        <div class="icon-stack flex-shrink-0 bg-teal text-white"><i class="fas fa-question"></i></div>
                                        <div class="ms-4">
                                            <h5 class="text-white">Apakah saya dapat mengakses fitur {{ $setting->app_name ?? '' }} kapan saja ?</h5>
                                            <p class="text-white-50">Ya, anda dapat mengakses semua fitur di {{ $setting->app_name ?? '' }} selama akun anda aktif и member anda belum expired. Cek secara berkala status member anda, jangan sampai terlewat dan anda kehilangan informasi mengenai soal terupdate.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gx-5 justify-content-center text-center">
                                    <h2 class="text-white">Dapatkan Segera Token Member dan Mari Menghemat Waktu.</h2>
                                    <p class="lead text-white-50 mb-5">Hematlah waktu anda dengan mengikuti pelajaran yang ada di {{ $setting->app_name ?? '' }}, anda tidak perlu mencari modul dan soal karena di {{ $setting->app_name ?? '' }} soal dan modul sudah tersedia sesuai dengan kisi-kisi.</p>
                                    <a class="btn btn-success fw-500" href="{{ route('login') }}">Mulai Sekarang</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="bg-img-cover overlay overlay-primary overlay-80 pt-15" style="background-image: url('https://source.unsplash.com/e3OUQGT9bWU/1400x900')">
                        <!-- Spacer for the image section-->
                        <div style="height: 35vh"></div>
                        <div class="svg-border-rounded text-white">
                            <!-- Rounded SVG Border-->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
                        </div>
                    </section>
                    <section class="bg-white pb-10">
                        <div class="container px-5">
                            <div class="row gx-5 mb-5">
                                <div class="col-lg-6 mt-n10 mb-5 mb-lg-0 z-1">
                                    <a class="card text-decoration-none h-100 lift">
                                        <div class="card-body py-5">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-stack icon-stack-xl bg-primary text-white flex-shrink-0"><i data-feather="edit-3"></i></div>
                                                <div class="ms-4">
                                                    <h5 class="text-primary">Belajar lebih cerdas, bukan lebih keras</h5>
                                                    <p class="card-text text-gray-600">Pelajari lebih lanjut tentang bagaimana platform kami dapat menghemat waktu dan tenaga Anda dalam belajar.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-6 mt-0 mt-lg-n10 z-1">
                                    <a class="card text-decoration-none h-100 lift">
                                        <div class="card-body py-5">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-stack icon-stack-xl bg-secondary text-white flex-shrink-0"><i data-feather="code"></i></div>
                                                <div class="ms-4">
                                                    <h5 class="text-secondary">Dibuat semudah mungkin</h5>
                                                    <p class="card-text text-gray-600">Kami membuat platform selain untuk membantu, tentu juga membuat anda nyaman.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row gx-5 align-items-center">
                                <div class="col-lg-12 text-center">
                                    <h4>Dapat Informasi Terbaru</h4>
                                    <p class="lead text-gray-500 mb-0">Tetap terhubung dengan pembaruan dan fitur terbaru yang ditambahkan ke aplikasi kami!</p>
                                    <br>
                                    <a target="_blank" href="https://wa.me/{{ $setting->whatsapp_number }}?text={{ urlencode('Hallo, Admin. saya ingin bergabung dengan '.$setting->app_name.' ....') }}" class="btn btn-success">Hubungi Admin</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
            <div id="layoutDefault_footer">
                <footer class="footer pt-10 pb-5 mt-auto bg-dark footer-dark">
                    <div class="container px-5">
                        <div class="row gx-5 align-items-center">
                            <div class="col-md-6 small">© 2022 {{ $setting->app_name ?? '' }}</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="{{ asset('assets/landing-page/theme_1/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/landing-page/theme_1/js/scripts.js') }}"></script>
        <script src="{{ asset('assets/landing-page/theme_1/js/aos.js') }}"></script>
        
        <script src="{{ asset('assets/landing-page/theme_2/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/landing-page/theme_2/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        
        <script>
            AOS.init({
                disable: 'mobile',
                duration: 600,
                once: true,
            });
            
            document.addEventListener('DOMContentLoaded', function() {
                const lightbox = GLightbox({
                    selector: '.gallery-lightbox'
                });
                
                var gallerySwiper = new Swiper(".gallerySwiper", {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    centeredSlides: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 30,
                        },
                    },
                });
            });
        </script>

        <script type="text/javascript" src="{{ asset('assets/landing-page/theme_1/js/nodes.js') }}"></script>
        <script type="text/javascript">
            var nodesjs = new NodesJs({
                id: 'nodes',
                width: window.innerWidth,
                height: window.innerHeight,
                particleSize: 3,
                lineSize: 1,
                particleColor: [255, 255, 255, 0.3],
                lineColor: [255, 255, 255],
                backgroundFrom: [10, 25, 100],
                backgroundTo: [25, 50, 150],
                backgroundDuration: 4000,
                nobg: false,
                number: window.hasOwnProperty('orientation') ? 30: 100,
                speed: 20
            });
        </script>

        <script type="text/javascript">
            window.onresize = function () {
                nodesjs.setWidth(window.innerWidth);
                nodesjs.setHeight(window.innerHeight);
            };
        </script>

        <script defer src="{{ asset('assets/landing-page/theme_1/js/vaafb692b2aea4879b33c060e79fe94621666317369993.js') }}" integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA==" data-cf-beacon='{"rayId":"7632a878ecd1898e","token":"6e2c2575ac8f44ed824cef7899ba8463","version":"2022.10.3","si":100}' crossorigin="anonymous"></script>
    </body>
</html>
