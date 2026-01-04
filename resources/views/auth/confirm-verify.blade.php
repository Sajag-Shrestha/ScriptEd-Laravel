<!DOCTYPE html>
<html lang="en">

<head>
    @include("layout.head")
    <title>Email Verified | ScriptEd</title>
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
                        <div class="text-center">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    Email verification failed.
                                </div>
                            @endif

                            <a href="{{route('student.dashboard')}}" class="btn btn-primary mt-4">Go to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    @include("layout.scripts")
</body>

</html>