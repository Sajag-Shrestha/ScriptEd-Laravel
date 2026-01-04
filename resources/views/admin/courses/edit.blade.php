<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Edit Course | ScriptEd</title>
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
        @include('layout/navbar-vertical')

        <div id="page-content">
            @include('layout/header')
            <div class="container-fluid px-6 py-4">
                <div class="py-6">
                    <div class="row mb-6">
                        <div class="col-xl-12">
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>EDIT COURSE</strong>
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
                                    @endif

                                    <form method="POST" action="{{ route('admin.courses.update', $course->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <!-- Course Title -->
                                            <div class="col-md-6 mb-4">
                                                <label for="courseTitle" class="form-label fw-bold">Course Title</label>
                                                <input type="text" class="form-control" id="courseTitle"
                                                    name="title" value="{{ old('title', $course->title) }}">
                                            </div>

                                            <!-- Module -->
                                            <div class="col-md-6 mb-4">
                                                <label for="module" class="form-label fw-bold">Module</label>
                                                <select class="form-select" id="module" name="module_id">
                                                    <option value="" disabled>Select Course Module</option>
                                                    @foreach ($modules as $module)
                                                        <option value="{{ $module->id }}"
                                                            {{ old('module_id', $course->module_id) == $module->id ? 'selected' : '' }}>
                                                            {{ $module->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Course Description -->
                                            <div class="col-md-6">
                                                <label for="courseDescription" class="form-label fw-bold">Course
                                                    Description</label>
                                                <textarea class="form-control" id="courseDescription" name="description" rows="5">{{ old('description', $course->description) }}</textarea>
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
                                                            id="order" name="order" value="{{old ('order', $course->order)}}" min="0">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="changeOrder(1)">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <!-- Type -->
                                                <div class="md-4">
                                                    <label for="type" class="form-label fw-bold">Type</label>
                                                    <select class="form-select" id="type" name="type">
                                                        <option disabled>Select type</option>
                                                        <option value="Documentation"
                                                            {{ old('type', $course->type) == 'Documentation' ? 'selected' : '' }}>
                                                            Documentation</option>
                                                        <option value="Structured Course"
                                                            {{ old('type', $course->type) == 'Structured Course' ? 'selected' : '' }}>
                                                            Structured Course</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <!-- Difficulty Level -->
                                            <div class="col-md-6 mb-4">
                                                <label for="difficultyLevel" class="form-label fw-bold">Difficulty
                                                    Level</label>
                                                <select class="form-select" id="difficultyLevel"
                                                    name="difficulty_level">
                                                    <option value="" disabled>Select difficulty level</option>
                                                    <option value="Beginner"
                                                        {{ old('difficulty_level', $course->difficulty_level) == 'Beginner' ? 'selected' : '' }}>
                                                        Beginner</option>
                                                    <option value="Intermediate"
                                                        {{ old('difficulty_level', $course->difficulty_level) == 'Intermediate' ? 'selected' : '' }}>
                                                        Intermediate</option>
                                                    <option value="Advanced"
                                                        {{ old('difficulty_level', $course->difficulty_level) == 'Advanced' ? 'selected' : '' }}>
                                                        Advanced</option>
                                                </select>
                                            </div>

                                            <!-- Source -->
                                            <div class="col-md-6 mb-4">
                                                <label for="source" class="form-label fw-bold">Source</label>
                                                <input type="text" class="form-control" id="source" name="source"
                                                    value="{{ old('source', $course->source) }}">
                                            </div>

                                            <!-- Course URL -->
                                            <div class="col-md-12 mb-6">
                                                <label for="courseURL" class="form-label fw-bold">Course URL</label>
                                                <input type="url" class="form-control" id="courseURL" name="url"
                                                    value="{{ old('url', $course->url) }}">
                                            </div>
                                        </div>

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
                                            <div id="webview">
                                                @if ($course->url)
                                                    <iframe src="{{ $course->url }}"
                                                        onload="iframeLoaded(event)"></iframe>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary btn-block">Update
                                                    Course</button>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <a href="{{ route('admin.courses.index') }}"
                                                    class="btn btn-secondary btn-block">Back</a>
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

        @include('layout/scripts')
        <script>
            function loadWebview() {
                const url = document.getElementById('courseURL').value;
                const webview = document.getElementById('webview');

                if (!url) {
                    alert('Please enter a valid URL');
                    return;
                }

                webview.innerHTML = `
                    <iframe 
                        src="${url}" 
                        frameborder="0" 
                        allowfullscreen 
                        onload="iframeLoaded(event)"
                    ></iframe>`;
            }

            function refreshWebview() {
                loadWebview();
            }

            function changeOrder(amount) {
                const input = document.getElementById('order');
                let value = parseInt(input.value) || 0;
                input.value = Math.max(0, value + amount);
            }
        </script>
    </div>
</body>

</html>
