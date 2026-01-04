<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Manage Quizzes | ScriptEd</title>
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
                                            <strong>MANAGE QUIZZES</strong>
                                        </div>
                                    </li>
                                </ul>

                                <!-- Display Success Message -->
                                @if (session('success'))
                                    <div class="alert alert-success text-center">
                                        {{ session('success') }}
                                        <meta http-equiv="refresh" content="2">
                                    </div>
                                @endif

                                <!-- Tab content -->
                                <div class="tab-content p-4" id="pills-tabContent-bordered-table">
                                    <div class="tab-pane tab-example-design fade show active"
                                        id="pills-bordered-table-design" role="tabpanel"
                                        aria-labelledby="pills-bordered-table-design-tab">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-responsive table-bordered text-center align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th>Total Questions</th>
                                                        <th>Total Attempts</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($quizzes as $quiz)
                                                        <tr>
                                                            <th>{{ $loop->iteration }}</th>
                                                            <td>{{ $quiz->title }}</td>
                                                            <td>{{ $quiz->questions_count }}</td>
                                                            <td>{{ $quiz->attempts->count() }}</td>
                                                            <td>
                                                                <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="btn btn-primary btn-sm">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>
                                                               
                                                                <form action="{{ route('teacher.quizzes.delete', $quiz->id) }}" method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this quiz and all its questions?')">
                                                                        <i class="bi bi-trash-fill"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @if ($quizzes->isEmpty())
                                                        <tr><td colspan="5">No quizzes found.</td></tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
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
    @include('layout/scripts')
</body>

</html>
