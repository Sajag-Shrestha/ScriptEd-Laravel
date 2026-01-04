<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Manage Ranks | ScriptEd</title>
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
                    <!-- Table -->
                    <div class="row mb-6">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <!-- Card -->
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>MANAGE RANKS</strong>
                                        </div>
                                    </li>
                                </ul>

                                <!-- Success Message -->
                                @if (session('success'))
                                    <div class="alert alert-success text-center">
                                        {{ session('success') }}
                                        <meta http-equiv="refresh" content="2">
                                    </div>
                                @endif

                                <!-- Tab content -->
                                <div class="tab-content p-4">
                                    <div class="tab-pane fade show active">
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Order</th>
                                                        <th>Icon</th>
                                                        <th>Rank</th>
                                                        <th>XP Required</th>
                                                        <th>Created At</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($ranks as $rank)
                                                        <tr>
                                                            <td>{{ $rank->order }}</td>
                                                            <td>
                                                                <a href="{{ asset($rank->icon) }}" data-fancybox="images" data-caption="{{ $rank->rank }}">
                                                                    <img src="{{ asset($rank->icon) }}" alt="{{ $rank->name }} icon" class="img-fluid" width="50px">
                                                                </a>
                                                            </td>
                                                            <td>{{ $rank->rank }}</td>
                                                            <td>{{ $rank->req_xp }}</td>
                                                            <td>{{ $rank->created_at->format('Y-m-d g:i A') }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.ranks.edit', $rank->id) }}"
                                                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                                                <form action="{{ route('admin.ranks.delete', $rank->id) }}"
                                                                    method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this rank?');"><i class="bi bi-trash-fill"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5">No ranks found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- tab-pane -->
                                </div> <!-- tab-content -->
                            </div> <!-- card -->
                        </div>
                    </div>
                    <!-- Table -->
                </div>
            </div>
        </div>
    </div>

    @include('layout/scripts')
</body>

</html>
