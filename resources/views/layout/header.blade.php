<div class="header">
    <!-- navbar -->
    <nav class="navbar-classic navbar navbar-expand-lg">
        <a id="nav-toggle" href="#"><i data-feather="menu" class="nav-icon me-2 icon-xs"></i></a>
        <div class="ms-lg-3 d-none d-md-none d-lg-block">

        </div>
        <!--Navbar nav -->
        <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
            @if (Auth::user()->role === 'Admin')
                <li class="dropdown stopevent">
                    <a class="btn btn-light btn-icon rounded-circle indicator text-muted position-relative"
                        href="#" role="button" id="dropdownNotification" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">

                        <i class="icon-xs" data-feather="bell"></i>

                        @if ($pendingUsers->count() > 0)
                            <span
                                class="position-absolute top-5 start-100 translate-middle bg-danger text-white d-flex align-items-center justify-content-center"
                                style="width: 18px; height: 18px; font-size: 12px; border: 1.5px solid white; border-radius: 50%;">
                                {{ $pendingUsers->count() > 9 ? '9+' : $pendingUsers->count() }}
                                <span class="visually-hidden">pending user requests</span>
                            </span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                        aria-labelledby="dropdownNotification">
                        <div class="">
                            <div class="border-bottom px-3 pt-2 pb-3 d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-inherit fw-medium fs-4">Notifications</p>
                            </div>

                            <ul class="list-group list-group-flush notification-list-scroll">
                                @forelse($pendingUsers as $user)
                                    <li class="list-group-item">
                                        <a href="{{ route('admin.role-requests.index') }}" class="text-muted">
                                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                                            <p class="mb-0">
                                                {{ optional($roleRequests->firstWhere('user_id', $user->id))->request_msg ?? 'No request message.' }}
                                            </p>
                                        </a>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center">
                                        <p class="mb-0 text-muted">No pending user approvals.</p>
                                    </li>
                                @endforelse
                            </ul>

                            <div class="border-top px-3 py-2 text-center">
                                <a href="{{ route('admin.role-requests.index') }}" class="text-inherit fw-semi-bold">
                                    View all Notifications
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @endif




            <!-- List -->
            <li class="dropdown ms-2">
                <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md avatar-indicators avatar-online">
                        <img alt="avatar" src="{{ asset(Auth::user()->profile_image) }}" class="rounded-circle" />
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <div class="px-4 pb-0 pt-2">


                        <div class="lh-1 ">
                            <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                            <div class="text-inherit fs-6">{{ Auth::user()->role }}</div>
                        </div>
                        <div class=" dropdown-divider mt-2"></div>
                    </div>

                    <ul class="list-unstyled">

                        <li>
                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>View
                                Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="me-2 icon-xxs dropdown-item-icon" data-feather="settings"></i>Account Settings
                            </a>
                        </li>
                        <li>
                            @auth
                                <a type="submit" class="dropdown-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>Sign Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="dropdown-item"
                                    style="display-none">
                                    @csrf
                                </form>
                            @endauth
                        </li>
                    </ul>

                </div>
            </li>
        </ul>
    </nav>
</div>
