<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>View Course | ScriptEd</title>
</head>

<body>

    <div id="db-wrapper">
        @include('layout/navbar-vertical')

        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-4">
                <div class="row justify-content-center py-6">
                    <div class="col-lg-8">
                        <div class="card shadow">
                            <ul class="nav nav-line-bottom d-flex justify-content-center">
                                <li class="nav-item">
                                    <div class="nav-link active">
                                        <strong>COURSE DETAILS</strong>
                                    </div>
                                </li>
                            </ul>

                            <div class="card-body">
                                <!-- Course Icon -->
                                <div class="text-center mb-4">
                                    <a href="{{ asset($course->module->icon) }}" data-fancybox="icon" data-caption="{{ $course->module->name }}">
                                        <img src="{{ asset($course->module->icon) }}" alt="{{ $course->module->name}} Icon" class="img-fluid" style="max-height: 120px;">
                                    </a>
                                </div>

                                <!-- Course Details -->
                                <dl class="row">
                                    <dt class="col-sm-4">Title</dt>
                                    <dd class="col-sm-8">{{ $course->title }}</dd>

                                    <dt class="col-sm-4">Description</dt>
                                    <dd class="col-sm-8">{{ $course->description }}</dd>

                                    <dt class="col-sm-4">Module</dt>
                                    <dd class="col-sm-8">{{ $course->module->name }} #{{ $course->order }}</dd>

                                    <dt class="col-sm-4">Source</dt>
                                    <dd class="col-sm-8">{{ $course->source }}</dd>

                                    <dt class="col-sm-4">Type</dt>
                                    <dd class="col-sm-8">{{ $course->type }}</dd>

                                    <dt class="col-sm-4">Difficulty Level</dt>
                                    <dd class="col-sm-8">{{ $course->difficulty_level }}</dd>

                                    <dt class="col-sm-4">URL</dt>
                                    <dd class="col-sm-8">
                                        <a href="{{ $course->url }}" target="_blank">{{ $course->url }}</a>
                                    </dd>
                                </dl>

                                <!-- Back Button -->
                                <div class="mt-5 d-flex justify-content-between">
                                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-primary">Edit Course</a>
                                    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Back to Courses</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout/scripts')
</body>

</html>
