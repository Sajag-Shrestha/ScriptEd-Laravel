<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Setting | ScriptEd</title>
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
                        <div>
                            <div
                                class="border-bottom pb-4 mb-4 d-flex align-items-center
                  justify-content-center">
                                <div class="mb-2 mb-lg-0">
                                    <h3 class="mb-0 fw-bold">General</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-8">
                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                            <meta http-equiv="refresh" content="2;url={{ route('profile.edit') }}">
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger text-center">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <meta http-equiv="refresh" content="3">
                    @endif
                    <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                        <div class="mb-4 mb-lg-0">
                            <h4 class="mb-1">General Setting</h4>
                            <p class="mb-0 fs-5 text-muted">Profile configuration settings </p>
                        </div>

                    </div>

                    <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                        <!-- card -->
                        <div class="card">
                            <!-- card body -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('settings.profile') }}"
                                    enctype="multipart/form-data" id="profile-form">
                                    @csrf
                                    <div class="mb-6">
                                        <h4 class="mb-1">General Settings</h4>
                                    </div>

                                    <div class="row align-items-center mb-8">
                                        <div class="col-md-3 mb-3 mb-md-0">
                                            <h5 class="mb-0">Avatar</h5>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img id="profile-preview"
                                                        src="{{ asset(Auth::user()->profile_image ?? 'default.jpg') }}"
                                                        class="rounded-circle avatar avatar-lg" alt="avatar">
                                                </div>
                                                <div>
                                                    <!-- File input (hidden) -->
                                                    <input type="file" name="profile_image" id="profile_image"
                                                        accept="image/*" style="display: none;"
                                                        onchange="previewImage(this)">

                                                    <button type="button" class="btn btn-outline-white me-1"
                                                        onclick="document.getElementById('profile_image').click()">Change</button>
                                                    <button type="button" class="btn btn-outline-white"
                                                        onclick="removeImage()">Remove</button>

                                                    <!-- Hidden field to indicate removal -->
                                                    <input type="hidden" name="remove_image" id="remove_image"
                                                        value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <h4 class="mb-1">Basic information</h4>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="fullName" class="col-sm-4 col-form-label form-label">Full
                                            name</label>
                                        <div class="col-md-8 col-12">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Full name" id="fullName"
                                                value="{{ old('name', Auth::user()->name) }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="email" class="col-sm-4 col-form-label form-label">Email</label>
                                        <div class="col-md-8 col-12">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Email" id="email"
                                                value="{{ old('email', Auth::user()->email) }}" required>
                                        </div>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="offset-md-4 col-md-8 mt-4">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mb-8">
                    <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                        <div class="mb-4 mb-lg-0">
                            <h4 class="mb-1">Password Setting</h4>
                            <p class="mb-0 fs-5 text-muted">Change password settings </p>
                        </div>

                    </div>

                    <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                        <!-- card -->
                        <div class="card" id="edit">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="mb-6">
                                    <h4 class="mb-1">Change your password</h4>

                                </div>
                                <form method="POST" action="{{ route('settings.password') }}">
                                    @csrf
                                    <!-- row -->
                                    <div class="mb-3 row">
                                        <label for="currentPassword" class="col-sm-4 col-form-label form-label">Current
                                            password</label>

                                        <div class="col-md-8 col-12">
                                            <input type="password" class="form-control"
                                                placeholder="Enter Current password" id="currentPassword"
                                                name="current_password" required>
                                        </div>
                                    </div>
                                    <!-- row -->
                                    <div class="mb-3 row">
                                        <label for="currentNewPassword" class="col-sm-4 col-form-label form-label">New
                                            password</label>

                                        <div class="col-md-8 col-12">
                                            <input type="password" class="form-control"
                                                placeholder="Enter New password" id="currentNewPassword"
                                                name="new_password" required>
                                        </div>
                                    </div>
                                    <!-- row -->
                                    <div class="row align-items-center">
                                        <label for="confirmNewpassword"
                                            class="col-sm-4 col-form-label form-label">Confirm
                                            new password</label>
                                        <div class="col-md-8 col-12 mb-2 mb-lg-0">
                                            <input type="password" class="form-control"
                                                placeholder="Confirm new password" id="confirmNewpassword"
                                                name="new_password_confirmation" required>
                                        </div>
                                        <!-- list -->
                                        <div class="offset-md-4 col-md-8 col-12 mt-4">
                                            <h6 class="mb-1">Password requirements:</h6>
                                            <p>Ensure that these requirements are met:</p>
                                            <ul>
                                                <li> Minimum 8 characters long the more, the better</li>
                                                <li>At least one lowercase character</li>
                                                <li>At least one uppercase character</li>
                                                <li>At least one number, symbol, or whitespace character
                                                </li>
                                            </ul>
                                            <button type="submit" class="btn btn-primary">Save
                                                Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Role Request --}}

                @if (Auth::user()->role === 'Student')
                    <div class="row mb-8">
                        <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                            <div class="mb-4 mb-lg-0">
                                <h4 class="mb-1">Request Teacher Role</h4>
                                <p class="mb-0 fs-5 text-muted">Submit a request to become a teacher</p>
                            </div>
                        </div>

                        <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    @if (Auth::user()->status === 'Pending')
                                        <div class="alert alert-warning text-center mb-4">
                                            Your request to become a teacher is currently <strong>pending</strong>.
                                        </div>
                                    @elseif (Auth::user()->status === 'Approved')
                                        <div class="alert alert-success text-center mb-4">
                                            Your request has been <strong>approved</strong>. You are now a Teacher!
                                        </div>
                                    @elseif (Auth::user()->status === 'Rejected')
                                        <div class="alert alert-danger text-center mb-4">
                                            Your previous request was <strong>rejected</strong>. Administrator may or may not re-consider.
                                        </div>
                                    @else
                                        <form method="POST" action="{{ route('request.teacher') }}">
                                            @csrf

                                            <div class="row">
                                                <label for="request_msg"
                                                    class="col-sm-4 col-form-label form-label">Request Message</label>
                                                <div class="col-md-8 col-12">
                                                    <input type="text" class="form-control" id="request_msg"
                                                        name="request_msg" placeholder="Enter your message here"
                                                        value="{{ old('request_msg') }}" required>
                                                </div>
                                            </div>


                                            <div class="row align-items-center">
                                                <div class="offset-md-4 col-md-8 mt-4">
                                                    <p>Click the button below to send a request to the
                                                        administrator to become a teacher.</p>
                                                    <button type="submit" class="btn btn-primary">Request Teacher
                                                        Role</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif



                {{-- Delete Account --}}

                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                        <div class="mb-4 mb-lg-0">
                            <h4 class="mb-1">Delete Account</h4>
                            <p class="mb-0 fs-5 text-muted">Delete Account along with its library and records</p>
                        </div>

                    </div>

                    <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                        <!-- card -->

                        <div class="card mb-6">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="mb-6">
                                    <h4 class="mb-1">Danger Zone</h4>
                                </div>
                                <div>
                                    <!-- text -->
                                    <p>Delete any and all content you have, such as library, courses, achievements.</p>

                                    <form method="POST" action="{{ route('settings.delete') }}"
                                        onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Confirm your password</label>
                                            <input type="password" name="password" id="password"
                                                class="form-control" placeholder="Enter your password" required>
                                        </div>

                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                            Delete Account
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Scripts -->
    <script>
        function previewImage(input) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
            }
            if (input.files[0]) {
                reader.readAsDataURL(input.files[0]);
                document.getElementById('remove_image').value = "0"; // clear remove flag
            }
        }

        function removeImage() {
            document.getElementById('profile-preview').src = "{{ asset('uploads/default.png') }}"; // fallback image
            document.getElementById('remove_image').value = "1";
            document.getElementById('profile_image').value = "";
        }
    </script>
    @include('layout/scripts')



</body>

</html>
