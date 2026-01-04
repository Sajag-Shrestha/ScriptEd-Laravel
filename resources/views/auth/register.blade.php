<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Register Page | ScriptEd</title>
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
                            <p class="mb-6">Please enter your user information.</p>

                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <meta http-equiv="refresh" content="3">
                        @endif

                        <!-- Form -->
                        <form method="POST" action="{{ route('auth.register') }}">
                            @csrf
                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" class="form-control" name="name"
                                    placeholder="Name" required="">
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" name="email"
                                    placeholder="Email address here" required="">
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="**************" required="">
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="confirm-password" class="form-label">Confirm
                                    Password</label>
                                <input type="password" id="confirm-password" class="form-control"
                                    name="password_confirmation" placeholder="**************" required="">
                            </div>

                            <div class="mt-5">
                                <!-- Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>

                                <div class="d-md-flex justify-content-center my-4">
                                    <div class="mb-2 mb-md-0">
                                        <a href="{{ route('user.login') }}" class="fs-5">Already
                                            member? Login </a>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <a href="{{ route('redirect.google')}}" class="btn btn-light">
                                        <i class="bi bi-google"></i> &nbsp;Sign up with Google
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @include('layout/scripts')
</body>

</html>
