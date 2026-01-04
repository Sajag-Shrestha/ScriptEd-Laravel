<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Edit Rank | ScriptEd</title>
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
                                            <strong>EDIT RANK</strong>
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

                                    <form method="POST" action="{{ route('admin.ranks.update', $rank->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">

                                            <!-- Icon Upload -->
                                            <div class="col-md-6 mb-3">
                                                <label for="icon" class="form-label fw-bold">Rank Icon
                                                    (optional)</label>
                                                <input type="file" id="icon"
                                                    class="form-control @error('icon') is-invalid @enderror"
                                                    name="icon">
                                                @error('icon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                @if ($rank->icon)
                                                    <div class="mt-2">
                                                        <strong>Current Icon:</strong><br>
                                                        <img src="{{ asset($rank->icon) }}" alt="Current Icon"
                                                            width="50">
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Rank Order  -->
                                            <div class="col-md-6 mb-3">
                                                <label for="order" class="form-label fw-bold">Rank Order</label>
                                                <input type="number" id="order"
                                                    class="form-control @error('order') is-invalid @enderror"
                                                    name="order" placeholder="Enter rank order"
                                                    value="{{ old('order', $rank->order) }}">
                                                @error('order')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Rank Title -->
                                            <div class="col-md-6 mb-3">
                                                <label for="rank" class="form-label fw-bold">Rank Title</label>
                                                <input type="text" id="rank"
                                                    class="form-control @error('rank') is-invalid @enderror"
                                                    name="rank" placeholder="Enter rank title"
                                                    value="{{ old('rank', $rank->rank) }}">
                                                @error('rank')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Required XP  -->
                                            <div class="col-md-6 mb-3">
                                                <label for="req_xp" class="form-label fw-bold">XP Required</label>
                                                <input type="number" id="req_xp"
                                                    class="form-control @error('req_xp') is-invalid @enderror"
                                                    name="req_xp" placeholder="Enter required XP"
                                                    value="{{ old('req_xp', $rank->req_xp) }}">
                                                @error('req_xp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="row pt-2">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary btn-block">Update
                                                    Rank</button>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <a href="{{ route('admin.ranks.index')}}"
                                                    class="btn btn-secondary btn-block">Back</a>
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
