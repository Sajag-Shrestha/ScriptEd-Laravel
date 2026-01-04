<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>View Modules | ScriptEd</title>
</head>

<body>

    <div id="db-wrapper">
        @include('layout/navbar-vertical')

        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-2">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <!-- Page Heading -->
                        <ul class="nav nav-line-bottom d-flex justify-content-center mb-4">
                            <li class="nav-item">
                                <div class="nav-link active">
                                    <strong>ALL MODULES</strong>
                                </div>
                            </li>
                        </ul>

                        <!-- Module Grid -->
                        <div class="row">
                            @foreach ($modules as $module)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body text-center">

                                            <!-- Module Icon -->
                                            <a href="{{ asset($module->icon) }}" data-fancybox="images" data-caption="{{ $module->name }}">
                                                <div class="d-flex justify-content-center align-items-center mb-3" style="height: 120px; overflow: hidden;">
                                                    <img src="{{ asset($module->icon) }}" alt="{{ $module->name }} icon" style="max-height: 100%; 
                                                    max-width: 100%; object-fit: contain;">
                                                </div>
                                                
                                            </a>

                                            <!-- Module Name -->
                                            <h5 class="card-title mb-3 fs-4">{{ $module->name }}</h5>

                                            <!-- Number of Courses -->
                                            <p class="card-text">
                                                <strong>Courses:</strong> {{ $module->courses_count }}
                                            </p>

                                            <a href="{{ route('student.module-detail', $module->id) }}" class="btn btn-primary">View Module</a>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('layout/scripts')
</body>

</html>
