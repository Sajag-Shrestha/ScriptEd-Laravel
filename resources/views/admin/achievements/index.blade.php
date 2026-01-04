<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout/head')
    <title>Manage Achievements | ScriptEd</title>
</head>
<body>
    <div id="db-wrapper">
        @include('layout/navbar-vertical')
        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-4">
                <div class="py-6">
                    <!-- Card -->
                    <div class="card">
                        <ul class="nav nav-line-bottom d-flex justify-content-center">
                            <li class="nav-item">
                                <div class="nav-link active">
                                    <strong>MANAGE ACHIEVEMENTS</strong>
                                </div>
                            </li>
                        </ul>

                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                                <meta http-equiv="refresh" content="2">
                            </div>
                        @endif

                        <div class="table-responsive p-4">
                            <table class="table table-bordered text-center align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Icon</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Criteria</th>
                                        <th>XP Reward</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($achievements as $ach)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($ach->icon)
                                                    <a href="{{ asset($ach->icon) }}" data-fancybox="images" data-caption="{{ $ach->title }}">
                                                        <img src="{{ asset($ach->icon) }}" alt="{{ $ach->title }}" width="50">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $ach->title }}</td>
                                            <td>{{ $ach->type }}</td>
                                            <td>
                                                @if($ach->type === 'Module Completed')
                                                    {{-- display module name --}}
                                                    {{ optional($ach->module)->name }} Module Completion
                                                @else
                                                    {{-- time spent threshold --}}
                                                    {{ $ach->criteria_amount/60 }} min
                                                @endif
                                            </td>
                                            <td>{{ $ach->xp_reward }}</td>
                                            <td>
                                                <a href="{{ route('admin.achievements.edit', $ach->id) }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('admin.achievements.delete', $ach->id) }}"
                                                      method="POST"
                                                      class="d-inline-block"
                                                      onsubmit="return confirm('Are yous sure you want to delete this achievement?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No achievements found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>
            </div>
        </div>
    </div>
    @include('layout/scripts')
</body>
</html>
