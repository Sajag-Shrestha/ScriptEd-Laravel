<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Email Verification | ScriptEd</title>
</head>

<body>
    <!-- container -->
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center g-0
           min-vh-100">
            <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
                <!-- Card -->
                <div class="card smooth-shadow-md">
                    <!-- Card body -->
                    <div class="card-body p-6">
                        <div class="mb-4">
                            <a href="{{ route('user.login') }}"><img src="../assets/images/brand/logo/logo-primary.png"
                                    width="150" class="mb-2" alt=""></a>
                            <p class="mb-6">Please verify your email address.</p>
                        </div>

                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <div class="text-center">
                            <h3 class="mb-4">A verification email has been sent to your inbox.</h3>
                            <p class="mb-6">If you didn’t receive the email, please check your spam folder or request
                                a new verification link.</p>

                            <!-- Resend Button -->
                            <form method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary mb-4">Resend Verification Email</button>
                            </form>

                            <!-- Back to Login Link -->
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="text-decoration-none">
                                Back to Login
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    @include('layout.scripts')
</body>

</html>
