<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Available Quizzes | ScriptEd</title>
</head>

<body>
    <div id="db-wrapper">
        @include('layout/navbar-vertical')
        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-4">
                <div class="py-6">
                    <div class="row mb-6">
                        <div class="col-xl-12">
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>AVAILABLE QUIZZES</strong>
                                        </div>
                                    </li>
                                </ul>

                                @if (session('success'))
                                    <div class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="tab-content p-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center align-middle">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Teacher</th>
                                                    <th>Questions</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($quizzes as $quiz)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $quiz->title }}</td>
                                                        <td>{{ $quiz->teacher->name }}</td>
                                                        <td>{{ $quiz->questions_count }}</td>
                                                        <td>
                                                            @if($quiz->attempted)
                                                                <span class="badge bg-success">Completed</span>
                                                            @else
                                                                <span class="badge bg-warning">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                                @if($quiz->attempted)
                                                                    <span class="text-success fw-bold">Scored: {{ $quiz->score }}/{{ $quiz->questions_count }}</span>
                                                                @else
                                                                    <a href="{{ route('student.quizAttempt', $quiz->id) }}" class="btn btn-primary btn-sm">
                                                                        Attempt Quiz
                                                                    </a>
                                                                @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="6">No quizzes available.</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- tab-content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout/scripts')
</body>
</html>
