<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Forgot Password | ScriptEd</title>
</head>

<body>
    <!-- container -->
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center g-0 min-vh-100">
            <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
                <!-- Card -->
                <div class="card smooth-shadow-md">
                    <!-- Card body -->
                    <div class="card-body p-6">
                        <div class="mb-4">
                            <a href="{{ route('user.login') }}"><img src="../assets/images/brand/logo/logo-primary.png" width="150"
                                    class="mb-2" alt=""></a>
                            <p class="mb-6">Forgot your password? Enter your email address, and we'll send you a password reset link.</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" name="email"
                                    placeholder="Email address here" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Email Password Reset Link</button>
                            </div>

                            <!-- Back to Login -->
                            <div class="d-md-flex justify-content-between my-4">
                                <div>
                                    <a href="{{ route('user.login') }}" class="fs-5">Back to Login</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @include('layout.scripts')
</body>

</html>