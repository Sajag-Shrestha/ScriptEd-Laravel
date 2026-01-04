<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layout/head')
    <title>View Library | ScriptEd</title>
</head>

<body>

    <div id="db-wrapper">
        @include('layout/navbar-vertical')

        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-2">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <!-- Page Heading -->
                        <ul class="nav nav-line-bottom d-flex justify-content-center mb-4">
                            <li class="nav-item">
                                <div class="nav-link active">
                                    <strong class="text-uppercase">{{ $course->module->name }} COURSE CONTENT</strong>
                                </div>
                            </li>
                        </ul>



                        <!-- Module Grid -->
                        <div class="row">
                            <h2 class="mb-3">{{ $course->title }}</h2>

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">{{ $course->scraped_title ?? $course->title }}</h3>
                                    <div class="scraped-html mt-3">
                                        {!! $course->scraped_html !!}
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                {{-- Left button --}}
                                <div>
                                    @if ($previousCourse)
                                        <a href="{{ route('student.course', $previousCourse->id) }}"
                                            class="btn btn-primary">
                                            ← Previous
                                        </a>
                                    @elseif (!$previousCourse && $nextCourse)
                                        <a href="{{ route('student.module-detail', $course->module_id) }}"
                                            class="btn btn-outline-primary">
                                            ← Back to Module
                                        </a>
                                    @endif
                                </div>

                                {{-- Center button --}}
                                <div>
                                    @if ($previousCourse && $nextCourse)
                                        <a href="{{ route('student.module-detail', $course->module_id) }}"
                                            class="btn btn-outline-primary">
                                            Back to Module
                                        </a>
                                    @endif
                                </div>

                                {{-- Right button --}}
                                <div>
                                    @if ($nextCourse)
                                        <a href="{{ route('student.course', $nextCourse->id) }}"
                                            class="btn btn-primary">
                                            Next →
                                        </a>
                                    @elseif (!$nextCourse && $previousCourse)
                                        <a href="{{ route('student.module-detail', $course->module_id) }}"
                                            class="btn btn-outline-primary">
                                            Back to Module →
                                        </a>
                                    @endif
                                </div>
                            </div>




                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const moduleId = {{ $course->module_id }};
            const courseId = {{ $course->id }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const startTime = Date.now();
            const url = "{{ route('library.track') }}";

            let hasSent = false;

            function sendProgress() {
                if (hasSent) return;
                hasSent = true;

                const timeSpent = Math.floor((Date.now() - startTime) / 1000);

                const form = new FormData();
                form.append('_token', csrfToken);
                form.append('module_id', moduleId);
                form.append('course_id', courseId);
                form.append('time_spent', timeSpent);

                navigator.sendBeacon(url, form);
            }

            window.addEventListener('pagehide', sendProgress);
            window.addEventListener('beforeunload', sendProgress);
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) sendProgress();
            });
        });
    </script>


    @include('layout/scripts')
</body>

</html>
