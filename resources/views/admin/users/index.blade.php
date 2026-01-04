<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Create Course | ScriptEd</title>
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
                                            <strong>MANAGE USERS</strong>
                                        </div>
                                    </li>
                                </ul>

                                <!-- Display Success Message -->
                                @if (session('success'))
                                    <div class="alert alert-success text-center">
                                        {{ session('success') }}
                                        <meta http-equiv="refresh" content="2;url={{ route('admin.users.index') }}">
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
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Role</th>
                                                        <th scope="col">Last Login</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $user)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->role }}</td>
                                                            <td>
                                                                {{ $user->last_login ? $user->last_login->setTimezone('Asia/Kathmandu')->format('Y-m-d g:i A') : 'Not Logged In Yet' }}
                                                            </td>

                                                            <td>
                                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                                    class="btn btn-primary btn-sm"><i
                                                                        class="bi bi-pencil-square"></i></a>
                                                                <form
                                                                    action="{{ route('admin.users.delete', $user->id) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Are you sure you want to delete this user?');"><i
                                                                            class="bi bi-trash-fill"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
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
