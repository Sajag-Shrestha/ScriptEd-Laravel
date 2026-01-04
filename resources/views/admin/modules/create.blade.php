<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Add Module | ScriptEd</title>
</head>

<body>
    <div id="db-wrapper">
        @include('layout/navbar-vertical')
        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-4">
                <div class="py-6">
                    <div class="row mb-6 d-flex justify-content-center">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>ADD MODULE</strong>
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

                                    <form method="POST" action="{{ route('admin.modules.store') }}" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Module Name -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-bold">Module Name</label>
                                            <input type="text" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="name" placeholder="Enter module name"
                                                value="{{ old('name') }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Icon Upload -->
                                        <div class="mb-3">
                                            <label for="icon" class="form-label fw-bold">Module Icon</label>
                                            <input type="file" id="icon"
                                                class="form-control @error('icon') is-invalid @enderror"
                                                name="icon">
                                            @error('icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="row pt-2">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary btn-block">Add Module</button>
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
