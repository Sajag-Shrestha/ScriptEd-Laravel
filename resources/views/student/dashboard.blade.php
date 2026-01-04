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
                    <div class="col-xl-4 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- heading -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h4 class="mb-0">Modules</h4>
                                    </div>
                                    <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                        <i class="bi bi-book fs-4"></i>
                                    </div>
                                </div>
                                <!-- project number -->
                                <a href="{{ route('student.modules')}}">
                                    <h1 class="fw-bold">{{ $totalCourses }}</h1>
                                    <p class="mb-0 text-light"><span
                                            class="text-light me-2">{{ $completedCourses }}</span>Completed</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- heading -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h4 class="mb-0">Affiliations</h4>
                                    </div>
                                    <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                        <i class="bi bi-people fs-4"></i>
                                    </div>
                                </div>
                                <!-- project number -->
                                <div>
                                    <h1 class="fw-bold">{{ $connections }}</h1>
                                    <p class="mb-0"><span class="text-light me-2"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- heading -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h4 class="mb-0">Time Spent</h4>
                                    </div>
                                    <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                        <i class="bi bi-clock fs-4"></i>
                                    </div>
                                </div>
                                <!-- project number -->
                                <div>
                                    <h1 class="fw-bold">{{ $timeSpentFormatted }}</h1>
                                    <p class="mb-0">
                                        <span class="me-2">

                                        </span>
                                    </p>
                                </div>
                            </div>
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
                                <h4 class="mb-0">Current Progress</h4>
                            </div>
                            <!-- table  -->
                            <div class="table-responsive">
                                <table class="table text-nowrap mb-0">
                                    <thead class="table-head">
                                        <tr>
                                            <th>Module</th>
                                            <th>Time Spent</th>
                                            <th>Type</th>
                                            <th>Source</th>
                                            <th>Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($inProgressCourses as $item)
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <div class="icon-shape icon-md border p-1 rounded-1">
                                                                <img src="{{ asset($item->module->icon) }}"
                                                                    alt="{{ $item->module->name }}" class="img-icon">
                                                            </div>
                                                        </div>
                                                        <div class="ms-3 lh-1">
                                                            <h5 class="fw-bold mb-1">
                                                                <a href="{{ route('library.show', $item->module->id) }}"
                                                                    class="text-inherit">{{ $item->module->name }}</a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">{{ gmdate('H:i:s', $item->time_spent) }}</td>
                                                <td class="align-middle">
                                                    @if ($item->module->courses->isNotEmpty())
                                                        {{ $item->module->courses->first()->type }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($item->module->courses->isNotEmpty())
                                                        {{ $item->module->courses->first()->source }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="align-middle text-light">
                                                    <div class="float-start me-3">{{ $item->progress }}%</div>
                                                    <div class="mt-2">
                                                        <div class="progress" style="height: 5px;">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $item->progress }}%"
                                                                aria-valuenow="{{ $item->progress }}" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No courses in progress</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- card footer  -->
                            <div class="card-footer text-center">
                                <a href="{{ route('library.show') }}">View All Projects</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- row  -->
                <div class="row my-6">
                    <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-6 mb-xl-0">
                        <!-- card  -->
                        <div class="card h-100">
                            <!-- card body  -->
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="mb-0">Performance Stats</h4>
                                    </div>
                                    <!-- dropdown  -->
                                    <div class="dropdown dropstart">
                                        <a class="text-muted text-primary-hover" href="#" role="button"
                                            id="dropdownTask" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="icon-xxs" data-feather="more-vertical"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- chart  -->
                                <div class="mb-8">
                                    <div id="performanceChart"></div>
                                </div>
                                <!-- icon with content  -->
                                <div class="d-flex align-items-center justify-content-around">
                                    <div class="text-center">
                                        <i class="icon-sm text-success" data-feather="check-circle"></i>
                                        <h1 class="mt-3 fw-bold mb-1">{{ $completedPercentage }}%</h1>
                                        <p>Completed</p>
                                    </div>
                                    <div class="text-center">
                                        <i class="icon-sm text-warning" data-feather="trending-up"></i>
                                        <h1 class="mt-3 fw-bold mb-1">{{ $inProgressPercentage }}%</h1>
                                        <p>In-Progress</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- card  -->
                    <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                        <div class="card h-100">
                            <!-- card header  -->
                            <div class="card-header border-bottom-0 py-4">
                                <h4 class="mb-0">Quizzes</h4>
                            </div>
                            <!-- table  -->
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead class="table-head">
                                        <tr>
                                            <th>Title</th>
                                            <th>Created By</th>
                                            <th>Last Attempt</th>
                                            <th>Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($quizzes as $quiz)
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-3 lh-1">
                                                            <a href="{{ route('student.quizList')}}">
                                                                <h5 class="fw-bold mb-1">{{ $quiz->title }}</h5>
                                                                <p class="mb-0 text-muted">
                                                                    {{ $quiz->description ?? 'No description' }}</p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">{{ $quiz->teacher->name ?? 'N/A' }}</td>
                                                <td class="align-middle">
                                                    {{ $quiz->last_attempt ? \Carbon\Carbon::parse($quiz->last_attempt)->format('d F, Y') : 'Not Yet Attempted' }}
                                                </td>
                                                <td class="align-middle">
                                                    @if (!is_null($quiz->score))
                                                        {{ $quiz->score }} / {{ $quiz->questions_count }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No quizzes found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @include('layout.scripts')
    <script>
        // Performance chart initialization
        if (document.getElementById('performanceChart')) {
            // Chart options
            const options = {
                chart: {
                    height: 280,
                    type: 'donut',
                },
                series: [{{ $completedPercentage }}, {{ $inProgressPercentage }}],
                labels: ['Completed', 'In Progress'],
                colors: ['#1e6551', '#ffc107'],
                legend: {
                    show: false
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                }
            };

            // Initialize chart
            const chart = new ApexCharts(
                document.getElementById('performanceChart'),
                options
            );
            chart.render();
        }
    </script>


</body>

</html>
