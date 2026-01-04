<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layout/head')
    <title>Profile Overview | ScriptEd</title>
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
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page header -->
                        <div class="border-bottom pb-4 mb-4">
                            <h3 class="mb-0 fw-bold">Overview</h3>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="pt-20 rounded-top"
                            style="background:url(../assets/images/background/profile-cover.jpg) no-repeat;
                             background-size: cover;">
                        </div>
                        <div class="bg-darkish rounded-bottom smooth-shadow-sm">
                            <div class="d-flex align-items-center justify-content-between pt-4 pb-6 px-4">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="avatar-xxl avatar-indicators avatar-online me-2 position-relative d-flex justify-content-end align-items-end mt-n10">
                                        <img src="{{ asset(Auth::user()->profile_image) }}"
                                            class="avatar-xxl rounded-circle border border-4 border-white-color-40"
                                            alt="">
                                        @if (Auth::user()->email_verified_at)
                                            <a href="#" class="position-absolute top-0 right-0 me-2"
                                                data-bs-toggle="tooltip" title="Verified">
                                                <img src="../assets/images/svg/checked-mark.svg" alt=""
                                                    height="30" width="30">
                                            </a>
                                        @endif
                                    </div>
                                    <div class="lh-1">
                                        <h2 class="mb-0">{{ Auth::user()->name }}</h2>
                                        <p class="mt-1 mb-0 d-block">{{ Auth::user()->role }}</p>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('profile.edit') }}"
                                        class="btn btn-outline-primary d-none d-md-block">
                                        Edit Profile
                                    </a>
                                </div>
                            </div>

                            <!-- Nav Tabs -->
                            <ul class="nav nav-lt-tab px-4" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-overview-tab" data-bs-toggle="pill"
                                        href="#pills-overview" role="tab" aria-controls="pills-overview"
                                        aria-selected="true">
                                        Overview
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-affiliation-tab" data-bs-toggle="pill"
                                        href="#pills-affiliation" role="tab" aria-controls="pills-affiliation"
                                        aria-selected="false">
                                        Affiliation
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content py-6" id="pills-tabContent">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="pills-overview" role="tabpanel"
                        aria-labelledby="pills-overview-tab">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">About Me</h4>
                                        <div class="row">
                                            <div class="col-12 mb-5">
                                                <h6 class="text-uppercase fs-5 ls-2">Email</h6>
                                                <p class="mb-0">{{ Auth::user()->email }}</p>
                                            </div>
                                            <div class="col-6 mb-5">
                                                <h6 class="text-uppercase fs-5 ls-2">Member Since</h6>
                                                <p class="mb-0">{{ Auth::user()->created_at->format('Y-m-d') }}</p>
                                            </div>
                                            @if (Auth::user()->email_verified_at)
                                                <div class="col-6 mb-5">
                                                    <h6 class="text-uppercase fs-5 ls-2">Verified at</h6>
                                                    <p class="mb-0">
                                                        {{ Auth::user()->email_verified_at->format('Y-m-d') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (Auth::user()->role === 'Student')
                                <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">Achievements</h4>
                                            @foreach ($earnedAchievements as $achievement)
                                                <div class="d-md-flex justify-content-between align-items-center mb-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-shape icon-lg border p-4 rounded-1">
                                                            <img width="30" src="{{ asset($achievement->icon) }}"
                                                                alt="">
                                                        </div>
                                                        <div class="ms-3">
                                                            <h5 class="mb-1">
                                                                <a href="{{ route('student.progress') }}"
                                                                    class="text-inherit">
                                                                    {{ $achievement->title }}
                                                                </a>
                                                            </h5>
                                                            <p class="mb-0 fs-5 text-muted">
                                                                {{ $achievement->description }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Affiliation Tab -->
                    <div class="tab-pane fade" id="pills-affiliation" role="tabpanel"
                        aria-labelledby="pills-affiliation-tab">
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Affiliations</h4>

                                <!-- Search Bar -->
                                <div class="mb-3 position-relative">
                                    <input type="text" id="affiliation-search" class="form-control"
                                        placeholder="Search by name to affiliate...">
                                    <div id="affiliation-search-results" class="list-group position-absolute w-100"
                                        style="z-index: 1050;"></div>
                                </div>

                                <!-- Affiliation List -->
                                <div id="affiliation-list" class="mt-3">
                                    @forelse ($affiliations as $affiliate)
                                        <div class="d-flex align-items-center border rounded p-2 mb-2">
                                            <img src="{{ asset($affiliate->profile_image) }}" alt="Profile Image"
                                                class="rounded-circle" width="40" height="40">
                                            <div class="ms-3">
                                                <div class="fw-bold">{{ $affiliate->name }}</div>
                                                <small class="text-muted">{{ ucfirst($affiliate->role) }}</small>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted">No affiliations found.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /tab-content -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @include('layout/scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('affiliation-search');
            const resultsContainer = document.getElementById('affiliation-search-results');
            const affiliationList = document.getElementById('affiliation-list');

            let debounceTimeout = null;

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                clearTimeout(debounceTimeout);
                if (query.length < 2) {
                    resultsContainer.innerHTML = '';
                    resultsContainer.style.display = 'none';
                    return;
                }

                debounceTimeout = setTimeout(() => {
                    fetch(`/affiliations/search?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(users => {
                            if (users.length === 0) {
                                resultsContainer.innerHTML =
                                    '<div class="list-group-item text-muted">No results found</div>';
                            } else {
                                resultsContainer.innerHTML = users.map(user => `
                            <button type="button" class="list-group-item list-group-item-action d-flex align-items-center bg-light" data-id="${user.id}">
                                <img src="${user.profile_image}" alt="Profile" class="rounded-circle" width="30" height="30" loading="lazy">
                                <span class="ms-2">${user.name} <small class="text-muted">(${user.role})</small></span>
                            </button>
                        `).join('');
                            }
                            resultsContainer.style.display = 'block';
                        });
                }, 300);
            });

            resultsContainer.addEventListener('click', function(e) {
                const btn = e.target.closest('button');
                if (!btn) return;

                const userId = btn.getAttribute('data-id');
                const userName = btn.innerText.trim();

                fetch('/affiliations/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            user_id: userId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Add new affiliation visually
                            affiliationList.insertAdjacentHTML('beforeend', `
                    <div class="d-flex align-items-center border rounded p-2 mb-2 bg-white">
                        <img src="${btn.querySelector('img').src}" alt="Profile Image" class="rounded-circle" width="40" height="40">
                        <div class="ms-3">
                            <div class="fw-bold">${userName}</div>
                            <small class="text-muted">${btn.querySelector('small').innerText}</small>
                        </div>
                    </div>
                `);
                            searchInput.value = '';
                            resultsContainer.innerHTML = '';
                            resultsContainer.style.display = 'none';
                        } else {
                            alert(data.error || 'Could not add affiliation');
                        }
                    })
                    .catch(() => alert('An error occurred'));
            });

            // Hide results if clicked outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                    resultsContainer.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
