    <!DOCTYPE html>
    <html lang="en">

    <head>
        {{-- Meta Tags --}}
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Post Details</title>

        {{-- Favicons --}}
        <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

        {{-- Google Fonts --}}
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Raleway:wght@300;400;600;700&family=Nunito:wght@300;400;600;700&display=swap"
            rel="stylesheet">

        {{-- Vendor CSS --}}
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

        {{-- Main CSS --}}
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    </head>

    <body class="blog-details-page">
        {{-- Header Section --}}
        <header id="header" class="header d-flex align-items-center sticky-top">
            <div class="container position-relative d-flex align-items-center">
                <a href="index.html" class="logo d-flex align-items-center me-auto">
                    <h1 class="sitename">Company</h1><span>.</span>
                </a>

                {{-- Navigation --}}
                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="{{ url('/') }}" class="active">Home</a></li>
                        <li class="dropdown">
                            <a href="about.html"><span>About</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="team.html">Team</a></li>
                                <li><a href="testimonials.html">Testimonials</a></li>
                                <li class="dropdown">
                                    <a href="#"><span>Deep Dropdown</span> <i
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

                        {{-- Authentication Links --}}
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

                {{-- Social Links --}}
                <div class="header-social-links">
                    <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="main">
            {{-- Page Title --}}
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

            <div class="container">
                <div class="row">
                    {{-- Main Content Column --}}
                    <div class="col-lg-8">
                        {{-- Blog Details Section --}}
                        <section id="blog-details" class="blog-details section">
                            <div class="container">
                                <article class="article">
                                    <div class="post-img">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                                            class="card-img-top" style="object-fit: cover; height: 220px;">
                                    </div>

                                    <h2 class="title">{{ $post->title }}</h2>

                                    {{-- Post Meta --}}
                                    <div class="meta-top">
                                        <ul>
                                            <li class="d-flex align-items-center">
                                                <i class="bi bi-person"></i>
                                                <a href="#">{{$post->user->name}}</a>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="bi bi-clock"></i>
                                                <a href="#">
                                                    <time datetime="2020-01-01">{{$post->created_at}}</time>
                                                </a>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="bi bi-chat-dots"></i>
                                                <a href="#">{{ $post->comments_count ?? $post->comments()->count() }}
                                                    Comments</a>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="bi bi-heart"></i>
                                                <a href="#">{{ $post->likes_count ?? $post->likes()->count() }}
                                                    Likes</a>
                                            </li>

                                        </ul>
                                    </div>

                                    {{-- Post Content --}}
                                    <div class="content">
                                        {{$post->content}}
                                    </div>

                                    {{-- Post Actions --}}
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <div class="d-flex align-items-center">
                                            <!-- Like Button -->
                                            <form action="{{ route('posts.toggleLike', $post->id) }}" method="POST"
                                                class="me-2">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-primary like-btn"
                                                    data-post-id="{{ $post->id }}">
                                                    <i
                                                        class="bi bi-heart-fill {{ $post->isLikedBy(auth()->user()) ? 'text-danger' : '' }}"></i>
                                                    <span class="like-count">{{ $post->likes()->count() }}</span>
                                                </button>
                                            </form>

                                            <!-- Comment Button -->
                                            <a href="#comment-form"
                                                class="btn btn-sm btn-outline-primary hover-fill me-2">
                                                <i class="bi bi-chat-left-text me-2"></i>
                                                {{ $post->comments_count ?? $post->comments()->count() }}
                                            </a>
                                        </div>


                                        @can('update', $post)
                                        <!-- Buttons (Edit & Delete with Icons) -->
                                        <div class="d-flex ms-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('posts.edit', $post->id) }}"
                                                class="btn btn-sm btn-outline-success hover-fill me-2">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger hover-fill">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endcan
                                    </div>
                                </article>
                            </div>
                        </section>
                        <!-- Review and Rating Section -->
                        <section id="review-section" class="section py-5 bg-light">
                            <div class="container">
                                <!-- Review Form -->
                                <div class="card mb-5 shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Write a Review</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('reviews.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <input name="name" type="text" class="form-control"
                                                        placeholder="Your Name*"
                                                        value="{{ auth()->check() ? auth()->user()->name : '' }}"
                                                        {{ auth()->check() ? 'readonly' : '' }} required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input name="email" type="email" class="form-control"
                                                        placeholder="Your Email*"
                                                        value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                                        {{ auth()->check() ? 'readonly' : '' }} required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label d-block">Your Rating*</label>
                                                <div class="rating-stars">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" id="rating-{{ $i }}" name="rating"
                                                        value="{{ $i }}" required>
                                                    <label for="rating-{{ $i }}"
                                                        title="{{ $i }} star{{ $i > 1 ? 's' : '' }}">★</label>
                                                    @endfor
                                                </div>
                                            </div>


                                            <div class="mb-3">
                                                <input name="title" type="text" class="form-control"
                                                    placeholder="Review Title*" required>
                                            </div>

                                            <div class="mb-3">
                                                <textarea name="body" class="form-control" rows="4"
                                                    placeholder="Your Review*" required></textarea>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Submit Review</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Review List -->
                                <div class="card shadow rounded-4">
                                    <div class="card-header bg-info text-white rounded-top-4">
                                        <h5 class="mb-0">Customer Reviews ({{ $post->reviews->count() }})</h5>
                                    </div>

                                    <div class="card-body">
                                        @forelse ($post->reviews->sortByDesc('created_at') as $review)
                                        <div class="border-bottom pb-4 mb-4" id="review-{{ $review->id }}">
                                            <div
                                                class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                <div>
                                                    <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                                                    <small
                                                        class="text-muted ms-2">{{ $review->created_at->diffForHumans() }}</small>
                                                </div>
                                                <div class="stars">
                                                    @for ($i = 1; $i <= 5; $i++) <span
                                                        class="{{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}">
                                                        ★</span>
                                                        @endfor
                                                </div>
                                                @if(auth()->check() && (auth()->id() === $review->user_id ||
                                                auth()->user()->isAdmin()))
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        onclick="toggleEdit({{ $review->id }})">Edit</button>
                                                    <form action="{{ route('reviews.destroy', $review->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger">Delete</button>
                                                    </form>
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Display Mode -->
                                            <div id="display-review-{{ $review->id }}" class="mt-3">
                                                <h6 class="fw-semibold">{{ $review->title }}</h6>
                                                <p class="text-muted mb-0">{{ $review->body }}</p>
                                            </div>

                                            <!-- Edit Mode (Hidden by Default) -->
                                            <form id="edit-form-{{ $review->id }}" class="d-none mt-3"
                                                action="{{ route('reviews.update', $review->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <input type="text" name="title" class="form-control mb-2"
                                                    value="{{ $review->title }}" required>

                                                <textarea name="body" class="form-control mb-2" rows="3"
                                                    required>{{ $review->body }}</textarea>

                                                <div class="mb-2">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" id="rating-{{ $review->id }}-{{ $i }}"
                                                        name="rating" value="{{ $i }}"
                                                        {{ $review->rating == $i ? 'checked' : '' }} required
                                                        style="display:none;">
                                                    <label for="rating-{{ $review->id }}-{{ $i }}"
                                                        style="font-size:1.5rem; cursor:pointer; color: {{ $review->rating >= $i ? '#ffc107' : '#ddd' }};">★</label>
                                                    @endfor
                                                </div>

                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        onclick="toggleEdit({{ $review->id }}, true)">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                        @empty
                                        <p class="text-muted mb-0">No reviews yet. Be the first to review!</p>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Toggle Edit Script -->
                                <script>
                                function toggleEdit(id, cancel = false) {
                                    const displayDiv = document.getElementById(`display-review-${id}`);
                                    const editForm = document.getElementById(`edit-form-${id}`);
                                    if (cancel) {
                                        editForm.classList.add('d-none');
                                        displayDiv.style.display = 'block';
                                    } else {
                                        editForm.classList.remove('d-none');
                                        displayDiv.style.display = 'none';
                                    }
                                }
                                </script>
                        </section>
                        {{-- Post Comments Section --}}
                        <section id="post-comments" class="post-comments section py-5 bg-light">
                            <div class="container">
                                <h4 class="mb-4">
                                    {{ $post->comments->count() }}
                                    Comment{{ $post->comments->count() !== 1 ? 's' : '' }}
                                </h4>

                                @foreach($post->comments->where('parent_id', null) as $comment)
                                <div class="card mb-4 border-start border-4 border-dark bg-white shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong class="text-primary">{{ $comment->user->name }}</strong>
                                                <small
                                                    class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div>
                                                @can('update', $comment)
                                                <a href="{{ route('comments.edit', $comment) }}"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    Edit
                                                </a>
                                                @endcan
                                                <button class="btn btn-sm btn-outline-primary ms-1"
                                                    onclick="toggleReply({{ $comment->id }})">
                                                    Reply
                                                </button>
                                            </div>
                                        </div>

                                        <p class="mt-3 mb-2">{{ $comment->content }}</p>

                                        {{-- Reply Form --}}
                                        <form method="POST" action="{{ route('posts.comment', $post->id) }}"
                                            class="reply-form mt-3 d-none" id="reply-form-{{ $comment->id }}">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <textarea name="content" class="form-control mb-2" rows="2"
                                                placeholder="Write your reply..." required></textarea>
                                            <button type="submit" class="btn btn-sm btn-success">Post Reply</button>
                                        </form>

                                        {{-- Child Replies --}}
                                        @foreach($comment->replies as $reply)
                                        <div
                                            class="card mt-3 ms-4 border-start border-3 border-info bg-light shadow-sm">
                                            <div class="card-body py-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong class="text-info">{{ $reply->user->name }}</strong>
                                                        <small
                                                            class="text-muted ms-2">{{ $reply->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    @can('update', $reply)
                                                    <a href="{{ route('comments.edit', $reply) }}"
                                                        class="btn btn-sm btn-outline-secondary">Edit</a>
                                                    @endcan
                                                </div>
                                                <p class="mt-2 mb-0">{{ $reply->content }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </section>

                        <script>
                        function toggleReply(commentId) {
                            const form = document.getElementById('reply-form-' + commentId);
                            form.classList.toggle('d-none');
                        }
                        </script>

                        {{-- Comment Form Section --}}
                        <section id="comment-form" class="comment-form section">
                            <div class="container">
                                <form action="{{ route('posts.comment', $post->id) }}" method="post">
                                    @csrf
                                    <h4>Post Comment</h4>
                                    <p>Your email address will not be published. Required fields are marked *</p>

                                    {{-- Hidden post_id field --}}
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input name="name" type="text" class="form-control" placeholder="Your Name*"
                                                value="{{ auth()->check() ? auth()->user()->name : '' }}"
                                                {{ auth()->check() ? 'readonly' : '' }}>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input name="email" type="email" class="form-control"
                                                placeholder="Your Email*"
                                                value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                                {{ auth()->check() ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group">
                                            <textarea name="content" class="form-control" placeholder="Your Comment*"
                                                required></textarea>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Post Comment</button>
                                    </div>
                                </form>
                            </div>
                        </section>

                    </div>

                    {{-- Sidebar Column --}}
                    <div class="col-lg-4 sidebar">
                        <div class="widgets-container">
                            {{-- Author Widget --}}
                            <div class="blog-author-widget widget-item">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="assets/img/blog/blog-author.jpg" class="rounded-circle flex-shrink-0"
                                        alt="">
                                    <h4>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</h4>
                                    <div class="social-links">
                                        <a href="https://x.com/#"><i class="bi bi-twitter-x"></i></a>
                                        <a href="https://facebook.com/#"><i class="bi bi-facebook"></i></a>
                                        <a href="https://instagram.com/#"><i class="bi bi-instagram"></i></a>
                                        <a href="https://linkedin.com/#"><i class="bi bi-linkedin"></i></a>
                                    </div>
                                    <p>
                                        Itaque quidem optio quia voluptatibus dolorem dolor. Modi eum sed possimus
                                        accusantium. Quas repellat voluptatem officia numquam sint aspernatur voluptas.
                                        Esse
                                        et accusantium ut unde voluptas.
                                    </p>
                                </div>
                            </div>

                            {{-- Search Widget --}}
                            <div class="search-widget widget-item">
                                <h3 class="widget-title">Search</h3>
                                <form action="">
                                    <input type="text">
                                    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                                </form>
                            </div>

                            <div class="recent-posts-widget widget-item">
                                <h3 class="widget-title">Recent Posts</h3>
                                @foreach ($recentPosts as $recent)
                                <div class="post-item">
                                    <h4>
                                        <a href="{{ route('posts.show', $recent->id) }}">
                                            {{ $recent->title }}
                                        </a>
                                    </h4>
                                    <time datetime="{{ $recent->created_at->toDateString() }}">
                                        {{ $recent->created_at->format('M j, Y') }}
                                    </time>
                                </div>
                                @endforeach
                            </div>
                            {{-- Tags Widget --}}
                            <div class="tags-widget widget-item">
                                <h3 class="widget-title">Tags</h3>
                                <ul>
                                    <li><a href="#">App</a></li>
                                    <li><a href="#">IT</a></li>
                                    <li><a href="#">Business</a></li>
                                    <li><a href="#">Mac</a></li>
                                    <li><a href="#">Design</a></li>
                                    <li><a href="#">Office</a></li>
                                    <li><a href="#">Creative</a></li>
                                    <li><a href="#">Studio</a></li>
                                    <li><a href="#">Smart</a></li>
                                    <li><a href="#">Tips</a></li>
                                    <li><a href="#">Marketing</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        {{-- Footer Section --}}
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
        </footer>

        {{-- Scroll Top Button --}}
        <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
            <i class="bi bi-arrow-up-short"></i>
        </a>

        {{-- Preloader --}}
        <div id="preloader"></div>

        {{-- Vendor JS --}}
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
        <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
        <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function() {
            $('.like-btn').on('click', function(e) {
                e.preventDefault();
                const button = $(this);
                const postId = button.data('post-id');
                const form = button.closest('form');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        // Update like count
                        button.find('.like-count').text(response.likes_count);

                        // Toggle heart color
                        const heartIcon = button.find('i.bi-heart-fill');
                        if (response.liked) {
                            heartIcon.addClass('text-danger');
                        } else {
                            heartIcon.removeClass('text-danger');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            window.location.href = '/login';
                        }
                    }
                });
            });
        });
        </script>
    </body>

    </html>