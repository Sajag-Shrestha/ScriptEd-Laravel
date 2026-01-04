<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Add User | ScriptEd</title>
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
                    <!-- Card -->
                    <div class="row mb-6 d-flex justify-content-center">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>ADD USER</strong>
                                        </div>
                                    </li>
                                </ul>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <meta http-equiv="refresh" content="3">
                                    @endif

                                    <!-- Form -->
                                    <form method="POST" action="{{ route('admin.users.store') }}">
                                        @csrf
                                        <!-- Name -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-bold">Name</label>
                                            <input type="text" id="name"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                placeholder="Name">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label fw-bold">Email</label>
                                            <input type="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                placeholder="Email address here">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- Role -->
                                        <div class="mb-3">
                                            <label for="role" class="form-label fw-bold">Role</label>
                                            <select class="form-select @error('role') is-invalid @enderror"
                                                name="role" id="role">
                                                <option value="" disabled selected>Choose your role</option>
                                                <option value="Student">Student</option>
                                                <option value="Teacher">Teacher</option>
                                                <option value="Admin">Admin</option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label for="password" class="form-label fw-bold">Password</label>
                                            <input type="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" placeholder="**************">
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- Checkbox -->
                                        <div class="mb-5">

                                        </div>
                                        <div>
                                            <!-- Button -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-primary btn-block">Add
                                                        User</button>
                                                </div>
                                                <div class="col-md-6 d-flex justify-content-end">
                                                    <button type="reset"
                                                        class="btn btn-secondary btn-block">Reset</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        @include('layout/scripts')

</body>

</html>
