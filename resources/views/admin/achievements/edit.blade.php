<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Edit Achievement | ScriptEd</title>
</head>

<body>
    <div id="db-wrapper">
        @include('layout/navbar-vertical')
        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-4">
                <div class="py-6">
                    <div class="row mb-6 d-flex justify-content-center">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>EDIT ACHIEVEMENT</strong>
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

                                    <form method="POST"
                                        action="{{ route('admin.achievements.update', $achievement->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <!-- Icon Upload -->
                                            <div class="col-md-6 mb-3">
                                                <label for="icon" class="form-label fw-bold">Achievement
                                                    Icon</label>
                                                <input type="file" id="icon"
                                                    class="form-control @error('icon') is-invalid @enderror"
                                                    name="icon">
                                                @error('icon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                @if ($achievement->icon)
                                                    <div class="mt-2">
                                                        <strong>Current Icon:</strong><br>
                                                        <img src="{{ asset($achievement->icon) }}"
                                                            alt="Current Achievement Icon" width="50">
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Title -->
                                            <div class="col-md-6 mb-3">
                                                <label for="title" class="form-label fw-bold">Achievement
                                                    Title</label>
                                                <input type="text" id="title"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    name="title" placeholder="Enter achievement title"
                                                    value="{{ old('title', $achievement->title) }}">
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Type -->
                                            <div class="col-md-6 mb-3">
                                                <label for="type" class="form-label fw-bold">Type</label>
                                                <select id="type"
                                                    class="form-control @error('type') is-invalid @enderror"
                                                    name="type">
                                                    <option value="" disabled
                                                        {{ old('type', $achievement->type) ? '' : 'selected' }}>Select
                                                        Type</option>
                                                    <option value="Module Completed"
                                                        {{ old('type', $achievement->type) === 'Module Completed' ? 'selected' : '' }}>
                                                        Module Completed</option>
                                                    <option value="Time Spent"
                                                        {{ old('type', $achievement->type) === 'Time Spent' ? 'selected' : '' }}>
                                                        Time Spent</option>
                                                </select>
                                                @error('type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Description -->
                                            <div class="col-md-12 mb-3">
                                                <label for="description" class="form-label fw-bold">Achievement
                                                    Description</label>
                                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                                                    placeholder="Enter achievement description" rows="4">{{ old('description', $achievement->description) }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Criteria: Module select -->
                                            <div class="col-md-6 mb-3 criteria-module-wrapper" style="display:none;">
                                                <label for="criteria_module" class="form-label fw-bold">Select
                                                    Module</label>
                                                <select id="criteria_module"
                                                    class="form-control @error('criteria_module') is-invalid @enderror"
                                                    name="criteria_module">
                                                    <option value="" disabled
                                                        {{ old('criteria_module', $achievement->criteria_module) ? '' : 'selected' }}>
                                                        Select Module</option>
                                                    @foreach ($modules as $module)
                                                        <option value="{{ $module->id }}"
                                                            {{ old('criteria_module', $achievement->criteria_module) == $module->id ? 'selected' : '' }}>
                                                            {{ $module->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('criteria_module')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Criteria: Time spent -->
                                            <div class="col-md-6 mb-3 criteria-amount-wrapper" style="display:none;">
                                                <label for="criteria_amount" class="form-label fw-bold">Time Spent
                                                    (minutes)</label>
                                                <input type="number" id="criteria_amount"
                                                    class="form-control @error('criteria_amount') is-invalid @enderror"
                                                    name="criteria_amount" placeholder="Enter minutes threshold"
                                                    value="{{ old('criteria_amount', $achievement->criteria_amount/60) }}">
                                                @error('criteria_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- XP Reward -->
                                            <div class="col-md-6 mb-3">
                                                <label for="xp_reward" class="form-label fw-bold">XP Reward</label>
                                                <input type="number" id="xp_reward"
                                                    class="form-control @error('xp_reward') is-invalid @enderror"
                                                    name="xp_reward" placeholder="Enter XP reward"
                                                    value="{{ old('xp_reward', $achievement->xp_reward) }}">
                                                @error('xp_reward')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="row pt-2">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary btn-block">Update
                                                    Achievement</button>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <a href="{{ route('admin.achievements.index') }}"
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const moduleWrapper = document.querySelector('.criteria-module-wrapper');
            const amountWrapper = document.querySelector('.criteria-amount-wrapper');

            function toggleCriteria() {
                const val = typeSelect.value;
                if (val === 'Module Completed') {
                    moduleWrapper.style.display = 'block';
                    amountWrapper.style.display = 'none';
                } else if (val === 'Time Spent') {
                    moduleWrapper.style.display = 'none';
                    amountWrapper.style.display = 'block';
                } else {
                    moduleWrapper.style.display = 'none';
                    amountWrapper.style.display = 'none';
                }
            }

            typeSelect.addEventListener('change', toggleCriteria);
            toggleCriteria();
        });
    </script>
</body>

</html>
