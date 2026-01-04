<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Edit Quiz | ScriptEd</title>
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
                                            <strong>EDIT QUIZ</strong>
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

                                    <form method="POST" action="{{ route('teacher.quizzes.update', $quiz->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <!-- General Information -->
                                        <div class="mb-4">
                                            <h5 class="fw-bold mb-3">General Information</h5>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Quiz Title</label>
                                                <input type="text" name="title" class="form-control"
                                                    value="{{ old('title', $quiz->title) }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Description</label>
                                                <textarea name="description" class="form-control" rows="3">{{ old('description', $quiz->description) }}</textarea>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <!-- Questions Section -->
                                        <div class="mb-4">
                                            <h5 class="fw-bold mb-3">Questions</h5>
                                            @foreach ($quiz->questions as $qIndex => $question)
                                                <div class="border rounded p-3 mb-4">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Question
                                                            {{ $qIndex + 1 }}</label>
                                                        <input type="text"
                                                            name="questions[{{ $qIndex }}][question_text]"
                                                            class="form-control"
                                                            value="{{ old("questions.{$qIndex}.question_text", $question->question_text) }}"
                                                            required>
                                                    </div>

                                                    @foreach ($question->answers as $oIndex => $option)
                                                        <div class="mb-2">
                                                            <label class="form-label">Option {{ $oIndex + 1 }}</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    name="questions[{{ $qIndex }}][options][{{ $oIndex }}][option_text]"
                                                                    class="form-control"
                                                                    value="{{ old("questions.{$qIndex}.options.{$oIndex}.option_text", $option->answer_text) }}"
                                                                    required>

                                                                <span class="input-group-text">
                                                                    <input type="checkbox"
                                                                        name="questions[{{ $qIndex }}][options][{{ $oIndex }}][is_correct]"
                                                                        {{ old("questions.{$qIndex}.options.{$oIndex}.is_correct", $option->is_correct) ? 'checked' : '' }}>
                                                                    Correct
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                            <div id="questions"></div>

                                            <button type="button" class="btn btn-outline-primary mt-3"
                                                onclick="addQuestion()">Add Question</button>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary btn-block">Update
                                                    Quiz</button>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <a href="{{ route ('teacher.quizzes.index')}}"
                                                    class="btn btn-secondary btn-block">Back</a>
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
        let questionCount = {{ count($quiz->questions) }};

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
    
                    ${[0, 1, 2, 3].map(i => `
                                        <div class="mb-2">
                                            <label class="form-label">Option ${i + 1}</label>
                                            <div class="input-group">
                                                <input type="text" name="questions[${index}][options][${i}][option_text]" class="form-control" placeholder="Option ${i + 1} text" ${i < 2 ? 'required' : ''}>
                                                <span class="input-group-text">
                                                    <input type="checkbox" name="questions[${index}][options][${i}][is_correct]"> Correct
                                                </span>
                                            </div>
                                        </div>
                                    `).join('')}
                </div>
            `);

        }
    </script>


    @include('layout/scripts')
</body>

</html>
