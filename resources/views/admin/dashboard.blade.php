<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Dashboard | ScriptEd</title>
</head>

<body>
    <div id="db-wrapper">
        <!-- navbar vertical -->
        @include('layout.navbar-vertical')
        <!-- Page content -->
        <div id="page-content">
            @include('layout.header')
            <!-- Container fluid -->
            <div class="bg-custom pt-10 pb-21"></div>
            <div class="container-fluid mt-n22 px-6">
                <div class="row">
                    <!-- Page header -->
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <!-- card body -->
                            <a href="{{ route('admin.courses.index') }}">
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Courses</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                            <i class="bi bi-book fs-4"></i>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div class="pb-4">
                                        <h1 class="fw-bold">{{ $courseCount }}</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <!-- card body -->
                            <a href="{{ route('admin.modules.index') }}">
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Modules</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                            <i class="bi bi-terminal fs-4"></i>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div class="pb-4">
                                        <h1 class="fw-bold">{{ $moduleCount }}</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <a href="{{ route('admin.users.index') }}">
                                <!-- card body -->
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Users</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                            <i class="bi bi-people fs-4"></i>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div class="pb-4">
                                        <h1 class="fw-bold">{{ $userCount }}</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <a href="{{ route('admin.achievements.index')}}">
                                <!-- card body -->
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Achievements</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                            <i class="bi bi-trophy fs-4"></i>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div class="pb-4">
                                        <h1 class="fw-bold">{{ $achievementCount }}</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- row  -->
                <div class="row mt-6">
                    <div class="col-md-12 col-12">
                        <!-- card  -->
                        <div class="card">
                            <!-- card header  -->
                            <div class="card-header border-bottom-0 py-4">
                                <h4 class="mb-0 fw-bold">Recently Added Courses</h4>
                            </div>
                            <!-- table  -->
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0">
                                        <thead class="table-head">
                                            <tr>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Source</th>
                                                <th>URL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($courses as $course)
                                                <tr>
                                                    <td class="align-middle">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <div class="icon-shape icon-md border rounded-1 p-2">
                                                                    <a href="{{ asset($course->module->icon) }}"
                                                                        data-fancybox="images"
                                                                        data-caption="{{ $course->module->title }}">
                                                                        <img src="{{ asset($course->module->icon) }}"
                                                                            alt="{{ $course->module->programming_language }} icon"
                                                                            class="img-fluid">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="ms-3 lh-1">
                                                                <h5 class="mb-1">
                                                                    <a href="{{ route('admin.courses.view', $course->id) }}"
                                                                        class="text-inherit">
                                                                        {{ $course->title }}
                                                                    </a>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">{{ $course->type }}</td>
                                                    <td class="align-middle">{{ $course->source }}</td>
                                                    <td class="align-middle">{{ $course->url }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- card footer  -->
                                <div class="card-footer text-center">
                                    <a href="{{ route('admin.courses.index') }}">View All Courses</a>
                                </div>
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
