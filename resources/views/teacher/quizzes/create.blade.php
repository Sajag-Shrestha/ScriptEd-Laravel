<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Add Quiz | ScriptEd</title>
</head>

<body>
    <div id="db-wrapper">
        @include('layout/navbar-vertical')
        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-4">
                <div class="py-6">
                    <div class="row mb-6 d-flex justify-content-center">
                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                            <div class="card">
                                <ul class="nav nav-line-bottom d-flex justify-content-center">
                                    <li class="nav-item">
                                        <div class="nav-link active">
                                            <strong>ADD QUIZ</strong>
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

                                    <form method="POST" action="{{ route('teacher.quizzes.store') }}">
                                        @csrf

                                        <!-- General Information -->
                                        <div class="mb-4">
                                            <h5 class="fw-bold mb-3">General Information</h5>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Quiz Title</label>
                                                <input type="text" name="title" class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Description</label>
                                                <textarea name="description" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <!-- Questions Section -->
                                        <div class="mb-4">
                                            <h5 class="fw-bold mb-3">Questions</h5>
                                            <div id="questions"></div>

                                            <button type="button" class="btn btn-outline-primary mt-3" onclick="addQuestion()">Add Question</button>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary btn-block">Add Quiz</button>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <button type="reset" class="btn btn-secondary btn-block">Reset</button>
                                            </div>
                                        </div>

                                    </form>
                                </div> <!-- card-body -->
                            </div> <!-- card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS to Add Questions and Options -->
    <script>
        let questionCount = 0;

        function addQuestion() {
            const container = document.getElementById('questions');
            const index = questionCount++;

            container.insertAdjacentHTML('beforeend', `
                <div class="border rounded p-3 mb-4 position-relative" id="question-${index}">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="document.getElementById('question-${index}').remove()">×</button>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Question ${index + 1}</label>
                        <input type="text" name="questions[${index}][question_text]" class="form-control" placeholder="Enter question text" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Option 1</label>
                        <div class="input-group">
                            <input type="text" name="questions[${index}][options][0][option_text]" class="form-control" placeholder="Option 1 text" required>
                            <span class="input-group-text">
                                <input type="checkbox" name="questions[${index}][options][0][is_correct]"> Correct
                            </span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Option 2</label>
                        <div class="input-group">
                            <input type="text" name="questions[${index}][options][1][option_text]" class="form-control" placeholder="Option 2 text" required>
                            <span class="input-group-text">
                                <input type="checkbox" name="questions[${index}][options][1][is_correct]"> Correct
                            </span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Option 3</label>
                        <div class="input-group">
                            <input type="text" name="questions[${index}][options][2][option_text]" class="form-control" placeholder="Option 3 text">
                            <span class="input-group-text">
                                <input type="checkbox" name="questions[${index}][options][2][is_correct]"> Correct
                            </span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Option 4</label>
                        <div class="input-group">
                            <input type="text" name="questions[${index}][options][3][option_text]" class="form-control" placeholder="Option 4 text">
                            <span class="input-group-text">
                                <input type="checkbox" name="questions[${index}][options][3][is_correct]"> Correct
                            </span>
                        </div>
                    </div>
                </div>
            `);
        }
    </script>

    @include('layout/scripts')
</body>

</html>
