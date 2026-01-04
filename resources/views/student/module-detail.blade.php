<!DOCTYPE html>
<html lang="en">
@php
    $progress = $library->progress ?? 0;
    $isInLibrary = $library !== null && $library->is_in_library;
@endphp

<head>
    @include('layout/head')
    <title>View Library | ScriptEd</title>
</head>

<body>

    <div id="db-wrapper">
        @include('layout/navbar-vertical')

        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-2">
                <div class="row justify-content-center">
                    <div class="col-12">

                        <!-- Page Heading -->
                        <ul class="nav nav-line-bottom d-flex justify-content-center mb-4">
                            <li class="nav-item">
                                <div class="nav-link active">
                                    <strong>MODULE DETAIL</strong>
                                </div>
                            </li>
                        </ul>

                        <!-- Module Grid -->
                        <div class="row mb-5">
                            <!-- Left Column: Module Info -->
                            <div class="col-lg-4 mb-2">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h3 class="card-title fw-bold pb-2 border-bottom">{{ $module->name }}</h3>

                                        @if ($module->icon)
                                            <img src="{{ asset($module->icon) }}" alt="Module Icon"
                                                class="img-fluid rounded py-2" width="80">
                                        @else
                                            <div class="bg-secondary text-center rounded py-5 fs-1">
                                                {{ strtoupper(substr($module->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <p class="text-secondary mt-2">Contains {{ $module->courses->count() }}
                                            course{{ $module->courses->count() > 1 ? 's' : '' }}.</p>

                                        @if ($library === null)
                                            <!-- No library record -->
                                            <form method="POST" action="{{ route('library.add', $module->id) }}">
                                                @csrf
                                                <button class="btn btn-primary btn-sm mt-2">
                                                    <i class="bi bi-plus-circle"></i> Add to Library
                                                </button>
                                            </form>
                                        @elseif ($library->is_in_library)
                                            <!-- In Library -->
                                            <div class="d-flex flex-column align-items-center gap-2 mt-2">
                                                <span class="badge px-3 py-2 fs-6"
                                                    style="background-color: rgba(119, 29, 174, 0.15); color: #9469ac; border: 1px solid rgba(152, 93, 188, 0.8)"">
                                                    <i class="bi bi-bookmark-check"></i> In Library
                                                </span>
                                                <form method="POST"
                                                    action="{{ route('library.remove', $module->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-outline-danger btn-sm">
                                                        <i class="bi bi-trash"></i> Remove from Library
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <!-- Has record but removed -->
                                            <form method="POST" action="{{ route('library.add', $module->id) }}">
                                                @csrf
                                                <button class="btn btn-warning btn-sm mt-2">
                                                    <i class="bi bi-arrow-repeat"></i> Re-Add to Library
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Lessons List -->
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="mb-4 border-bottom py-2">Courses</h4>

                                        {{-- Progress Bar --}}
                                        <div class="mb-4 border-bottom pb-2">
                                            <label class="form-label fw-semibold">Progress</label>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ $progress }}%;"
                                                    aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    {{ $progress }}%
                                                </div>
                                            </div>
                                        </div>

                                        @php
                                            $totalCourses = $module->courses->count();
                                            $bufferPercent = 10; // How much to lower threshold (adjust to your liking)
                                        @endphp

                                        @foreach ($module->courses->sortBy('order') as $course)
                                            @php
                                                // Calculate base unlock progress for the course
                                                $baseProgress = (($course->order - 1) / $totalCourses) * 100;

                                                // Apply buffer (never below 0)
                                                $requiredProgress = max(0, $baseProgress - $bufferPercent);
                                            @endphp

                                            <div
                                                class="d-flex justify-content-between align-items-start mb-4 border-bottom pb-3">
                                                <div class="pe-3">
                                                    <div class="small text-secondary mb-1">
                                                        <strong>#{{ str_pad($course->order, 2, '0', STR_PAD_LEFT) }}</strong>
                                                        – {{ $course->difficulty_level }}
                                                    </div>
                                                    <h5 class="mb-1">{{ $course->scraped_title ?? $course->title }}
                                                    </h5>
                                                    <p class="text-secondary small mb-1">
                                                        {{ $course->description ?? 'No description available.' }}
                                                    </p>
                                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                                        <span class="badge bg-primary">Source:
                                                            {{ $course->source }}</span>
                                                        <span class="badge bg-primary">Type: {{ $course->type }}</span>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    @if ($progress >= $requiredProgress)
                                                        <a href="{{ route('student.course', $course->id) }}"
                                                            class="btn btn-sm btn-outline-primary">Open</a>
                                                    @else
                                                        <span class="badge bg-secondary">Locked</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
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
