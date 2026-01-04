<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Add Course | ScriptEd</title>
    <style>
        .webview-container {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 20px;
            margin: 20px 0;
            width: 100%;
        }

        #webview {
            width: 100%;
            height: 80vh;
            min-height: 500px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            position: relative;
        }

        #webview iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.5);
        }

        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
    </style>
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
                    <!-- Card -->
                    <div class="row mb-6">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>ADD COURSE</strong>
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

                                    <form method="POST" action="{{ route('admin.courses.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">


                                            <!-- Course Title -->
                                            <div class="col-md-6 mb-4">
                                                <label for="courseTitle" class="form-label fw-bold">Course Title</label>
                                                <input type="text" class="form-control" id="courseTitle"
                                                    name="title" placeholder="Enter course title" required>
                                            </div>

                                            <!-- Module -->
                                            <div class="col-md-6 mb-4">
                                                <label for="module" class="form-label fw-bold">Module</label>
                                                <select class="form-select" id="module" name="module_id" required>
                                                    <option value="" disabled selected>Select Course Module
                                                    </option>
                                                    @foreach ($modules as $module)
                                                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <!-- Course Description -->
                                            <div class="col-md-6 mb-4">
                                                <label for="courseDescription" class="form-label fw-bold">Course
                                                    Description</label>
                                                <textarea class="form-control" id="courseDescription" name="description" rows="5"
                                                    placeholder="Enter course description" required></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Order -->
                                                <div class="mb-4">
                                                    <label for="order" class="form-label fw-bold">Module
                                                        Order</label>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="changeOrder(-1)">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                        <input type="number" class="form-control text-center"
                                                            id="order" name="order" value="0" min="0" required>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="changeOrder(1)">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Type -->
                                                <div class="mb-4">
                                                    <label for="type" class="form-label fw-bold">Type</label>
                                                    <select class="form-select" id="type" name="type" required>
                                                        <option value="" disabled selected>Select type</option>
                                                        <option value="Documentation">Documentation</option>
                                                        <option value="Structured Course">Structured Course</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Difficulty Level -->

                                            <div class="col-md-6 mb-4">
                                                <label for="difficultyLevel" class="form-label fw-bold">Difficulty
                                                    Level</label>
                                                <select class="form-select" id="difficultyLevel"
                                                    name="difficulty_level" required>
                                                    <option value="" disabled selected>Select difficulty level
                                                    </option>
                                                    <option value="Beginner">Beginner</option>
                                                    <option value="Intermediate">Intermediate</option>
                                                    <option value="Advanced">Advanced</option>
                                                </select>
                                            </div>

                                            <!-- Source -->
                                            <div class="col-md-6 mb-4">
                                                <label for="source" class="form-label fw-bold">Source</label>
                                                <input type="text" class="form-control" id="source" name="source"
                                                    placeholder="Enter source" required>
                                            </div>

                                            <!-- Course URL -->
                                            <div class="col-md-12 mb-6">
                                                <label for="courseURL" class="form-label fw-bold">Course URL</label>
                                                <input type="url" class="form-control" id="courseURL" name="url"
                                                    placeholder="Enter course URL to scrape data" required>
                                            </div>
                                        </div>

                                        <!-- Webview -->
                                        <div class="webview-container mb-4">
                                            <div class="row align-items-center mb-3">
                                                <div class="col">
                                                    <h5 class="mb-0">Webview Preview</h5>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="loadWebview()">
                                                            <i class="fas fa-search"></i> Load Webview
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                            onclick="refreshWebview()">
                                                            <i class="fas fa-sync"></i> Refresh
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="webview"></div>
                                        </div>

                                        <!-- Controls -->


                                        <!-- Form Buttons -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary btn-block">Add
                                                    Course</button>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <button type="reset"
                                                    class="btn btn-secondary btn-block">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        @include('layout/scripts')
        <script>
            function loadWebview() {
                const url = document.getElementById('courseURL').value;
                const webview = document.getElementById('webview');

                if (!url) {
                    alert('Please enter a valid URL');
                    return;
                }

                try {
                    webview.innerHTML = `
            <iframe 
                src="${url}" 
                frameborder="0" 
                allowfullscreen
                onload="iframeLoaded(event)"
                onerror="iframeError(event)"
            ></iframe>
        `;
                } catch (error) {
                    console.error('Error loading webview:', error);
                    webview.innerHTML = `
            <div class="alert alert-danger">
                Error loading URL: ${error.message}
            </div>
        `;
                }
            }

            function iframeLoaded(event) {
                console.log('Iframe loaded successfully:', event.target.src);
                const iframe = event.target;
                // Set the iframe height to match its content
                iframe.style.height = 'auto';
                iframe.style.minHeight = '500px';
            }

            function iframeError(event) {
                console.error('Error loading iframe:', event);
                const iframe = event.target;
                iframe.parentElement.innerHTML = `
        <div class="alert alert-danger">
            Failed to load URL: ${iframe.src}
        </div>
    `;
            }

            function refreshWebview() {
                const webview = document.getElementById('webview');
                webview.innerHTML = '';
                loadWebview();
            }

            function changeOrder(amount) {
                const input = document.getElementById('order');
                let value = parseInt(input.value) || 0;
                input.value = Math.max(0, value + amount);
            }
        </script>
</body>

</html>
