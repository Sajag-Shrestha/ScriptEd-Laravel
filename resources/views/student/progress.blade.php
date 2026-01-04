<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Your Progress | ScriptEd</title>

    <style>
        .text-muted{
            color: #9d89a8 !important
        }
    </style>
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
                            <strong>RANK PROGRESS</strong>
                        </div>
                    </li>
                </ul>

                <!-- Rank Progress -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <h4 class="mb-2">Current Rank: <strong>{{ auth()->user()->rank->rank ?? 'Unranked' }}
                            </strong></h4>
                        <img src="{{ asset($rank->icon ?? 'images/default-rank.png') }}" alt="Rank Icon"
                            class="img-fluid mb-3" style="width:80px; height:80px; object-fit:contain;">

                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $progressToNextRank }}%;" aria-valuenow="{{ $progressToNextRank }}"
                                aria-valuemin="0" aria-valuemax="100">
                                {{ $xp }} XP
                            </div>
                        </div>
                        <p class="text-muted pt-1">
                            @if ($nextRank)
                                {{ $nextRank->req_xp - $xp }} XP to <strong>{{ $nextRank->rank }}</strong>
                            @else
                                Max Rank Achieved!
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Achievements Section -->
                
                <ul class="nav nav-line-bottom d-flex justify-content-center mb-4">
                    <li class="nav-item">
                        <div class="nav-link active">
                            <strong>ACHIEVEMENTS</strong>
                        </div>
                    </li>
                </ul>

                <div class="row g-4">
                    @foreach ($achievements as $achievement)
                        @php
                            $userAchievement = $achievement->users->first(); // Assuming one user per achievement context

                            // Initialize default
                            $progress = 0;
                            $progressData = [];

                            if ($userAchievement) {
                                $rawData = $userAchievement->pivot->progress_data ?? '{}';

                                // Decodes if double-encoded
                                if (is_string($rawData)) {
                                    $decoded = json_decode($rawData, true);

                                    if (is_string($decoded)) {
                                        $progressData = json_decode($decoded, true) ?? [];
                                    } else {
                                        $progressData = $decoded ?? [];
                                    }
                                } elseif (is_array($rawData)) {
                                    $progressData = $rawData;
                                }

                                // If earned set it to 100%
                                if (!empty($userAchievement->pivot->earned_at)) {
                                    $progress = 100;
                                } else {
                                    // Calculate progress based on achievement type
                                    if ($achievement->type === 'Time Spent') {
                                        $current = (int) ($progressData['time_spent'] ?? 0);
                                        $required = (int) ($achievement->criteria_amount ?? 1);
                                        $progress = $required > 0 ? min(100, round(($current / $required) * 100)) : 0;
                                    } elseif ($achievement->type === 'Module Completed') {
                                        $progress = (int) ($progressData['progress_percent'] ?? 0);
                                    }
                                }
                            }
                        @endphp

                        <div class="col-sm-6 col-lg-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <img src="{{ asset($achievement->icon ?? 'images/default-achievement.png') }}"
                                        alt="Achievement Icon" class="img-fluid mb-2" style="width:60px; height:60px;">
                                    <h5 class="card-title mb-1">{{ $achievement->title }}</h5>
                                    <p class="text-muted small mb-2">{{ $achievement->description }}</p>

                                    <div class="progress mb-2" style="height: 12px;">
                                        <div class="progress-bar  bg-success @if ($progress === 100) @endif"
                                            role="progressbar" style="width: {{ $progress }}%;"
                                            aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>

                                    @if ($progress === 100)
                                        <p class="small text-success">Completed</p>
                                    @else
                                        <p class="small text-muted">{{ $progress }}% complete</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
    </div>

    @include('layout/scripts')
</body>

</html>
