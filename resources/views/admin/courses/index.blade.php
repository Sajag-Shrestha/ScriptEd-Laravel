<!DOCTYPE html>
<html lang="en">

@php

    $filterModuleId = $moduleId ?? null;

    $allCourses = [];
    foreach ($modules as $module) {
        foreach ($module->courses as $course) {
            $allCourses[] = [
                'id' => $course->id,
                'title' => $course->title,
                'module_name' => $module->name,
                'module_id' => $module->id,
                'source' => $course->source,
                'url' => $course->url,
                'order' => $course->order,
            ];
        }
    }

    $perPage = 10;
    $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
    $total = count($allCourses);
    $totalPages = ceil($total / $perPage);
    $start = ($page - 1) * $perPage;
    $pagedCourses = array_slice($allCourses, $start, $perPage);
@endphp

<head>
    @include('layout/head')
    <title>Add Course | ScriptEd</title>
</head>

<body>

    <div id="db-wrapper">
        <!-- navbar vertical -->
        @include('layout/navbar-vertical')
        <!-- page content -->
        <div id="page-content">
            @include('layout/header')
            <!-- Container fluid -->
            <div class="container-fluid px-6 py-4">
                <div class="py-6">
                    <!-- Table -->
                    <div class="row mb-6">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <!-- Card -->
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>MANAGE COURSES</strong>
                                        </div>
                                    </li>
                                </ul>

                                <!-- Display Success Message -->
                                @if (session('success'))
                                    <div class="alert alert-success text-center">
                                        {{ session('success') }}
                                        <meta http-equiv="refresh" content="2;url={{ route('admin.courses.index') }}">
                                    </div>
                                @endif

                                <!-- Tab content -->
                                <div class="tab-content p-4" id="pills-tabContent-bordered-table">
                                    <div class="tab-pane tab-example-design fade show active"
                                        id="pills-bordered-table-design" role="tabpanel"
                                        aria-labelledby="pills-bordered-table-design-tab">
                                        <!-- Module Filter Dropdown -->
                                        <div class="mb-3 d-flex justify-content-end">
                                            <select id="moduleFilter" class="form-select w-auto">
                                                <option value="all" {{ $filterModuleId === null ? 'selected' : '' }}>
                                                    Show All Modules</option>
                                                @foreach ($modules as $moduleOption)
                                                    <option value="{{ $moduleOption->id }}"
                                                        {{ $filterModuleId == $moduleOption->id ? 'selected' : '' }}>
                                                        {{ $moduleOption->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <!-- Course Table -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center align-middle"
                                                id="coursesTable">
                                                <thead>
                                                    <tr>
                                                        <th id="orderHeader">Order</th>
                                                        <th>Course Title</th>
                                                        <th>Module</th>
                                                        <th>Source</th>
                                                        <th>URL</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="courseTableBody">
                                                    @foreach ($pagedCourses as $index => $course)
                                                        <tr class="course-row module-{{ $course['module_id'] }}"
                                                            data-order="{{ $course['order'] }}">
                                                            <td class="order-cell"
                                                                data-index="{{ $start + $index + 1 }}">
                                                                {{ $start + $index + 1 }}</td>
                                                            <td>{{ $course['title'] }}</td>
                                                            <td>{{ $course['module_name'] }}</td>
                                                            <td>{{ $course['source'] }}</td>
                                                            <td>{{ $course['url'] }}</td>
                                                            <td class="d-flex gap-1">
                                                                <a href="{{ route('admin.courses.view', $course['id']) }}"
                                                                    class="btn btn-success btn-sm">
                                                                    <i class="bi bi-eye-fill"></i>
                                                                </a>
                                                                <a href="{{ route('admin.courses.edit', $course['id']) }}"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>
                                                                <form
                                                                    action="{{ route('admin.courses.delete', $course['id']) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Are you sure you want to delete this course?');">
                                                                        <i class="bi bi-trash-fill"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
                                        @for ($i = 1; $i <= $totalPages; $i++)
                                            <a href="?page={{ $i }}"
                                                class="btn btn-sm mx-1 {{ $i == $page ? 'btn-primary' : 'btn-outline-primary' }}">
                                                {{ $i }}
                                            </a>
                                        @endfor

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.getElementById('moduleFilter').addEventListener('change', function() {
            const moduleId = this.value;
            const url = new URL(window.location.href);
            if (moduleId === 'all') {
                url.searchParams.delete('module');
            } else {
                url.searchParams.set('module', moduleId);
            }
            url.searchParams.set('page', 1); // Reset to page 1
            window.location.href = url.toString();
        });
    </script>




    @include('layout/scripts')
</body>

</html>
