<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Affiliated Students | ScriptEd</title>
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
                                            <strong>MY STUDENTS</strong>
                                        </div>
                                    </li>
                                </ul>

                                <div class="tab-content p-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center align-middle">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Last Login</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($students as $student)
                                                    <tr>
                                                        <th>{{ $loop->iteration }}</th>
                                                        <td>{{ $student->name }}</td>
                                                        <td>{{ $student->email }}</td>
                                                        <td>
                                                            {{ $student->last_login ? $student->last_login->setTimezone('Asia/Kathmandu')->format('Y-m-d g:i A') : 'Not Logged In Yet' }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('teacher.report', $student->id) }}"
                                                               class="btn btn-info btn-sm">
                                                               <i class="bi bi-eye-fill"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="5">No affiliated students found.</td></tr>
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
