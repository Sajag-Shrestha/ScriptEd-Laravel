<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Teacher Dashboard | ScriptEd</title>
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
                                        <h4 class="mb-0">Quizzes</h4>
                                    </div>
                                    <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                        <i class="bi bi-journal-text fs-4"></i>
                                    </div>
                                </div>
                                <!-- quiz number -->
                                <a href="{{ route('teacher.quizzes.index')}}">
                                    <h1 class="fw-bold">{{ $totalQuizzes }}</h1>
                                    <p class="mb-0 text-white"><span class="text-light me-2">{{ $totalAttempts }}</span>Attempts</p>
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
                                        <h4 class="mb-0">Students</h4>
                                    </div>
                                    <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                        <i class="bi bi-people fs-4"></i>
                                    </div>
                                </div>
                                <!-- project number -->
                                <a href="{{ route('teacher.tracking')}}">
                                    <h1 class="fw-bold">{{ $totalStudents }}</h1>
                                    <p class="mb-0"><span class="text-light me-2"></span></p>
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

                <!-- row -->
                <div class="row my-6">
                    <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-6 mb-xl-0">
                        <!-- card -->
                        <div class="card h-100">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="mb-0">Quiz Performance</h4>
                                    </div>
                                    <!-- dropdown -->
                                    <div class="dropdown dropstart">
                                        <a class="text-muted text-primary-hover" href="#" role="button"
                                            id="dropdownTask" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="icon-xxs" data-feather="more-vertical"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- chart -->
                                <div class="mb-8">
                                    <div id="performanceChart"></div>
                                </div>
                                <!-- icon with content -->
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

                    <!-- card -->
                    <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                        <div class="card h-100">
                            <!-- card header -->
                            <div class="card-header border-bottom-0 py-4">
                                <h4 class="mb-0">Recent Quizzes</h4>
                            </div>
                            <!-- table -->
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead class="table-head">
                                        <tr>
                                            <th>Title</th>
                                            <th>Created</th>
                                            <th>Attempts</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentQuizzes as $quiz)
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-3 lh-1">
                                                            <h5 class="fw-bold mb-1">{{ $quiz->title }}</h5>
                                                            <p class="mb-0">{{ $quiz->description ?? 'No description' }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">{{ $quiz->created_at->format('d F, Y') }}</td>
                                                <td class="align-middle">{{ $quiz->attempts_count }}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>
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
                colors: ['#1d6b51', '#ffab00'],
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