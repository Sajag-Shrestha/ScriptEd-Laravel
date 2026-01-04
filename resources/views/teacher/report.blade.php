<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Student Report | ScriptEd</title>
</head>

<body>
    <div id="db-wrapper">
        @include('layout/navbar-vertical')
        <div id="page-content">
            @include('layout/header')

            <div class="container mt-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">User Report: {{ $user->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5 class="mb-3">User Information</h5>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                                <p><strong>Rank:</strong> {{ $user->rank->rank ?? 'Unranked' }}</p>
                                <p><strong>Time Spent:</strong> {{ $timeSpentFormatted }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Module Progress</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-white">Total Modules: {{ $totalModules }}</li>
                                <li class="list-group-item text-white">Completed: {{ $completedModules }}</li>
                                <li class="list-group-item text-white">In Progress: {{ $inProgressModules }}</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Achievements</h5>
                            @if ($achievements->count())
                                <ul class="list-group list-group-flush">
                                    @foreach ($achievements as $achievement)
                                        <li class="list-group-item">
                                            {{ $achievement->achievement->title }} - 
                                            <span class="text-muted">Earned at {{ $achievement->earned_at }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No achievements earned yet.</p>
                            @endif
                        </div>

                        <div>
                            <h5 class="mb-3">Quiz Attempts</h5>
                            @if ($quizzes->count())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle text-center">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Quiz</th>
                                                <th>Teacher</th>
                                                <th>Score</th>
                                                <th>Attempted At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quizzes as $attempt)
                                                <tr>
                                                    <td>{{ $attempt->quiz->title }}</td>
                                                    <td>{{ $attempt->quiz->teacher->name ?? 'N/A' }}</td>
                                                    <td>{{ $attempt->score }} / {{ $attempt->quiz->questions->count() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($attempt->finished_at)->format('Y-m-d g:i A') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No quiz attempts found.</p>
                            @endif
                        </div>
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
            </div> <!-- /.container -->
        </div> <!-- /#page-content -->
    </div> <!-- /#db-wrapper -->

    @include('layout/scripts')
</body>

</html>
