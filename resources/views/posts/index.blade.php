<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Create Post</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Raleway:wght@300;400;600;700&family=Nunito:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="blog-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <h1 class="sitename">Company</h1><span>.</span>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/') }}" class="active">Home</a></li>
                    <li class="dropdown"><a href="about.html"><span>About</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="team.html">Team</a></li>
                            <li><a href="testimonials.html">Testimonials</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                        class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="#">Deep Dropdown 1</a></li>
                                    <li><a href="#">Deep Dropdown 2</a></li>
                                    <li><a href="#">Deep Dropdown 3</a></li>
                                    <li><a href="#">Deep Dropdown 4</a></li>
                                    <li><a href="#">Deep Dropdown 5</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="portfolio.html">Portfolio</a></li>
                    <li><a href="pricing.html">Pricing</a></li>
                    <li><a href="{{ route('posts.index') }}">Blog</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    @auth
                    <li><a href="#">Hello, {{ Auth::user()->name }}</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link"
                                style="padding: 0; border: none;">Logout</button>
                        </form>
                    </li>
                    @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <div class="header-social-links">
                <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>

        </div>
    </header>

    <main class="main">
        <div class="page-title accent-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Blog</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="current">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>

        <section id="blog-posts" class="blog-posts section">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <h2 class="mb-0">My Posts</h2>
                    <a href="{{ route('posts.create') }}" class="btn btn-success">Create New Post</a>
                </div>

                <div class="row gy-4">
                    @forelse ($posts as $post)
                    <div class="col-lg-4">
                        <article class="card h-100 shadow-sm border-0">
                            <!-- Image -->
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="card-img-top"
                                    style="object-fit: cover; height: 220px;">
                                <span
                                    class="position-absolute top-0 start-0 bg-dark text-white px-2 py-1 small m-2 rounded">
                                    {{ $post->created_at->format('F d') }}
                                </span>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column">
                                <!-- Title -->
                                <h5 class="card-title">{{ Str::limit($post->title, 60) }}</h5>

                                <!-- Author & Category -->
                                <div class="mb-2 text-muted small d-flex justify-content-between flex-wrap">
                                    <span><i class="bi bi-person text-success me-1"></i>
                                        {{ $post->user->name ?? 'Unknown' }}</span>
                                </div>

                                <!-- Content Excerpt -->
                                <p class="card-text mb-3">{{ Str::limit($post->content, 100) }}</p>

                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div class="d-flex align-items-center">

                                    </div>
                                    <!-- Buttons (Edit & Delete with Icons) -->
                                    <div class="d-flex ms-2">
                                        <!-- Edit Button (Green Logo) -->
                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            class="btn btn-sm btn-outline-success hover-fill me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Delete Button (Red) -->
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger hover-fill">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Horizontal Line after Delete Button -->
                                <hr class="my-3">

                                <!-- Read More Button -->
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary w-100">
                                    Read More <i class="bi bi-arrow-right ms-1"></i>
                                </a>

                                <!-- Horizontal Line after Read More Button -->
                                <hr class="my-3">
                            </div>
                        </article>
                    </div>

                    @empty
                    <p>No blog posts available.</p>
                    @endforelse
                </div>
                <!-- Pagination (if needed) -->
                @if ($posts->hasPages())
                <nav aria-label="Posts pagination" class="mt-4">
                    <ul class="pagination justify-content-center flex-wrap">
                        {!! $posts->onEachSide(1)->links('pagination::bootstrap-4') !!}
                    </ul>
                </nav>
                @endif
            </div>
        </section>
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer dark-background">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                        <span class="sitename">Company</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>A108 Adam Street</p>
                        <p>New York, NY 535022</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                        <p><strong>Email:</strong> <span>info@example.com</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="#">Web Design</a></li>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Product Management</a></li>
                        <li><a href="#">Marketing</a></li>
                        <li><a href="#">Graphic Design</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12 footer-newsletter">
                    <h4>Our Newsletter</h4>
                    <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
                    <form action="forms/newsletter.php" method="post" class="php-email-form">
                        <div class="newsletter-form"><input type="email" name="email"><input type="submit"
                                value="Subscribe"></div>
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container text-center mt-4">
            <p>&copy; <strong class="sitename">Company</strong>. All Rights Reserved</p>
            <div class="credits">
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> |
                Distributed by <a href="https://themewagon.com">ThemeWagon</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>