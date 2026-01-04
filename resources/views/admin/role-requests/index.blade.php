<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Manage Role Requests | Admin Panel</title>
</head>

<body>

    <div id="db-wrapper">
        @include('layout.navbar-vertical')
        <div id="page-content">
            @include('layout.header')

            <div class="container-fluid px-6 py-4">
                <div class="py-6">
                    <div class="row mb-6">
                        <div class="col-12">
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>ROLE REQUESTS</strong>
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
                                    <table class="table table-responsive table-bordered text-center align-middle">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Role Requested</th>
                                                <th>Request Message</th>
                                                <th>Request Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($roleRequests as $request)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $request->user->name }}</td>
                                                    <td>{{ $request->requested_role ?? 'Teacher' }}</td>
                                                    <td>{{ $request->request_msg }}</td>
                                                    <td>{{ $request->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <span
                                                            class="badge 
                                                            @if ($request->user->status === 'Approved') bg-success
                                                            @elseif($request->user->status === 'Rejected') bg-danger
                                                            @else bg-warning text-dark @endif">
                                                            {{ $request->user->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($request->user->status === 'Pending')
                                                            <form
                                                                action="{{ route('admin.role-requests.approve', $request->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success btn-sm"
                                                                    title="Approve">
                                                                    <i class="bi bi-check-lg"></i>
                                                                </button>
                                                            </form>

                                                            <form
                                                                action="{{ route('admin.role-requests.reject', $request->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    title="Reject">
                                                                    <i class="bi bi-x-lg"></i>
                                                                </button>
                                                            </form>
                                                        @elseif ($request->user->status === 'Rejected')
                                                            <form
                                                                action="{{ route('admin.role-requests.revaluate', $request->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-warning btn-sm"
                                                                    title="Re-evaluate">
                                                                    <i class="bi bi-arrow-repeat"></i>
                                                                </button>
                                                            </form>
                                                        @elseif ($request->user->status === 'Approved')
                                                            <form
                                                                action="{{ route('admin.role-requests.revert', $request->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-outline-danger btn-sm"
                                                                    title="Revert to Pending">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-muted">No role requests found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('layout.scripts')
</body>

</html>
