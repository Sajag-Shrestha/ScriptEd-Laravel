<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Your Library | ScriptEd</title>
</head>

<body>

    <div id="db-wrapper">
        @include('layout/navbar-vertical')
        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-2">

                <ul class="nav nav-line-bottom d-flex justify-content-center mb-4">
                    <li class="nav-item">
                        <div class="nav-link active">
                            <strong>YOUR LIBRARY</strong>
                        </div>
                    </li>
                </ul>

                @php
                    $myLibs = $libraries->where('is_in_library', true);
                @endphp

                @if ($myLibs->isEmpty())
                    <div class="alert alert-info text-center">
                        You haven’t added any modules to your library yet.
                    </div>
                @else
                    <div class="row g-4">
                        @foreach ($myLibs as $lib)
                            @php $m = $lib->module; @endphp
                            <div class="col-sm-6 col-lg-4">
                                <div class="card h-100 shadow-sm position-relative overflow-hidden">
                                    {{-- Progress Circle --}}
                                    @php
                                        $radius = 20;
                                        $circumference = 2 * pi() * $radius;
                                        $progress = max(0, min(100, $lib->progress));
                                        $dashArray = $circumference;
                                        $dashOffset = $circumference * (1 - $progress / 100);
                                    @endphp

                                    <div class="position-absolute top-0 end-0 m-3">
                                        <svg width="48" height="48">
                                            <circle cx="24" cy="24" r="{{ $radius }}"
                                                fill="#f1f5f9" />
                                            <circle cx="24" cy="24" r="{{ $radius }}" fill="none"
                                                stroke="#198754" stroke-width="4" stroke-dasharray="{{ $dashArray }}"
                                                stroke-dashoffset="{{ $dashOffset }}" transform="rotate(-90 24 24)" />
                                            <text x="24" y="28" text-anchor="middle" font-size="12" fill="#198754">
                                                {{ $progress }}%
                                            </text>
                                        </svg>
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        {{-- Icon --}}
                                        <div class="text-center mb-3">
                                            <div class="d-inline-block p-1" style="width:100px; height:100px;">
                                                <img src="{{ asset($m->icon) }}" alt="{{ $m->name }}"
                                                    class="img-fluid"
                                                    style="max-height:100%; max-width:100%; object-fit:contain;">
                                            </div>
                                        </div>

                                        {{-- Title & Badge --}}
                                        <h5 class="card-title text-center mb-1 fs-4">{{ $m->name }}</h5>
                                        <div class="text-center mb-3">
                                            @if ($lib->status === 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-warning text-dark">In Progress</span>
                                            @endif
                                        </div>

                                        {{-- Meta --}}
                                        <p class="mb-1 small text-secondary">
                                            <i class="bi bi-clock-history me-1"></i>
                                            Last opened: {{ optional($lib->last_opened)->diffForHumans() }}
                                        </p>
                                        <p class="mb-3 small text-secondary">
                                            <i class="bi bi-stopwatch me-1"></i>
                                            Time: {{ gmdate('H:i:s', $lib->time_spent) }}
                                        </p>

                                        {{-- Continue button --}}
                                        <a href="{{ route('student.module-detail', $m->id) }}"
                                            class="btn btn-primary mt-auto">
                                            Continue
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                @endif

            </div>
        </div>
    </div>

    @include('layout/scripts')
</body>

</html>
