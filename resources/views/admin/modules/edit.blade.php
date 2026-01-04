<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Edit Module | ScriptEd</title>
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
                    <div class="row mb-6">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>EDIT MODULE</strong>
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
                                    <form method="POST" action="{{ route('admin.modules.update', $module->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Module Name -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-bold">Module Name</label>
                                            <input type="text" id="name" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Module Name"
                                                value="{{ old('name', $module->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Icon Upload -->
                                        <div class="mb-3">
                                            <label for="icon" class="form-label fw-bold">Icon (optional)</label>
                                            <input type="file" id="icon" name="icon"
                                                class="form-control @error('icon') is-invalid @enderror">
                                            @error('icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            @if ($module->icon)
                                                <div class="mt-2">
                                                    <strong>Current Icon:</strong><br>
                                                    <img src="{{ asset($module->icon) }}" alt="Current Icon" width="50">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Buttons -->
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary btn-block">Update Module</button>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <button type="reset" class="btn btn-secondary btn-block">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div> <!-- card-body -->
                            </div> <!-- card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout/scripts')
</body>

</html>
