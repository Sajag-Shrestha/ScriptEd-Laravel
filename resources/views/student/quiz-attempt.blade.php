<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
    <title>Attempt Quiz | ScriptEd</title>
</head>

<body>
    <div id="db-wrapper">
        @include('layout/navbar-vertical')
        <div id="page-content">
            @include('layout/header')

            <div class="container-fluid px-6 py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="fw-bold mb-4 fs-3">{{ $quiz->title }}</h4>
                                <p class="fs-4 pb-3">{{ $quiz->description }}</p>

                                <form method="POST" action="{{ route('student.quizSubmit', $quiz->id) }}">
                                    @csrf

                                    @foreach ($quiz->questions as $index => $question)
                                        <div class="mb-4">
                                            <h4>{{ $index + 1 }}. {{ $question->question_text }}</h4>

                                            @foreach ($question->answers as $answer)
                                                <div class="form-check fs-5">
                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="answers[{{ $question->id }}]"
                                                        value="{{ $answer->id }}"
                                                        id="q{{ $question->id }}_a{{ $answer->id }}"
                                                        required>
                                                    <label class="form-check-label" for="q{{ $question->id }}_a{{ $answer->id }}">
                                                        {{ $answer->answer_text }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                    @endforeach

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit Quiz</button>
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
</body>
</html>
