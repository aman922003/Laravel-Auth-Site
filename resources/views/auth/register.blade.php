<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Register - Company Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
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

<body class="index-page">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Register</h3>

                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                @error('password')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Profile Photo</label>
                                <input type="file" name="profile_photo" class="form-control" accept="image/*">
                                @error('profile_photo')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100">Register</button>

                            <div class="mt-3 text-center">
                                <span>Already have an account? <a href="{{ route('login') }}">Login</a></span>
                            </div>
                        </form>

                        <!-- Divider with "or" text -->
                        <div class="position-relative my-4">
                            <hr>
                            <div class="position-absolute top-50 start-50 translate-middle bg-white px-2">or</div>
                        </div>

                        <!-- Google Login Button -->
                        <a href="{{ route('redirect-google') }}"
                            class="btn btn-outline-dark w-100 d-flex align-items-center justify-content-center gap-2"
                            style="border-radius: 4px; padding: 8px 12px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" class="me-2">
                                <path fill="#4285F4"
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853"
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05"
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                <path fill="#EA4335"
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                            </svg>
                            <span>Continue with Google</span>
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Client-side Validation -->
    <script>
        $(document).ready(function () {
            $('form').on('submit', function (event) {
                let isValid = true;
                $('.error').remove();

                const name = $('#name').val();
                if (name.trim() === '') {
                    isValid = false;
                    $('#name').after('<small class="error text-danger">Full Name is required.</small>');
                }

                const email = $('#email').val();
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email.trim() === '' || !emailPattern.test(email)) {
                    isValid = false;
                    $('#email').after('<small class="error text-danger">Valid Email is required.</small>');
                }

                const password = $('#password').val();
                if (password.length < 6) {
                    isValid = false;
                    $('#password').after('<small class="error text-danger">Password must be at least 6 characters long.</small>');
                }

                const passwordConfirmation = $('#password_confirmation').val();
                if (password !== passwordConfirmation) {
                    isValid = false;
                    $('#password_confirmation').after('<small class="error text-danger">Passwords do not match.</small>');
                }

                const fileInput = $('input[name="profile_photo"]')[0];
                if (fileInput.files.length === 0) {
                    isValid = false;
                    $(fileInput).after('<small class="error text-danger">Profile photo is required.</small>');
                } else {
                    const file = fileInput.files[0];
                    const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    const maxSize = 2 * 1024 * 1024;

                    if (!validImageTypes.includes(file.type)) {
                        isValid = false;
                        $(fileInput).after('<small class="error text-danger">Only JPG, JPEG, or PNG images are allowed.</small>');
                    } else if (file.size > maxSize) {
                        isValid = false;
                        $(fileInput).after('<small class="error text-danger">Image must be less than 2MB.</small>');
                    }
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>
