@extends('templates.index')
@section('head')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.7.0/tinymce.min.js" integrity="sha512-kGk8SWqEKL++Kd6+uNcBT7B8Lne94LjGEMqPS6rpDpeglJf3xpczBSSCmhSEmXfHTnQ7inRXXxKob4ZuJy3WSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="https://cdn.tiny.cloud/1/jujlw32q6s63oorfl0y0orwk0fl498uabaybevidcgrvohkp/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
@section('content')
<div class="container-xl px-4 mt-5">
    <!-- Custom page header alternative example-->
    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
        <div class="me-4 mb-3 mb-sm-0">
            <h1 class="mb-0">Quiz</h1>
            <div class="small">
                <span class="fw-500 text-primary">Lesson : {{ $lesson->title }}</span><br>
                <span class="fw-500 text-primary">Quiz : {{ $quiz->title }}</span><br>
                <span class="fw-500 text-primary">Type : {{ $quiz->type }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header">Add Question</div>
                <div class="card-body">
                    <form action="{{ route('question.create', ['id' => $lesson->id, 'quizId' => $quiz->id]) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="inputNo">No.</label>
                            <input class="form-control" id="inputNo" type="text" placeholder="Enter number of Question" name="no" />
                        </div>
                        <div class="mb-3">
                            <label for="inputNo">Question</label>
                            <textarea class="form-control" id="inputNo" placeholder="Enter Question" name="question"></textarea>
                        </div>
                        @if ($quiz->type == 'multiple')
                        <div class="mb-3">
                            <label for="optionA">Option A</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" value="option_a" name="answer" required>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter option A" name="option_a" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="optionB">Option B</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" value="option_b" name="answer" required>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter option B" name="option_b" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="optionC">Option C</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" value="option_c" name="answer" required>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter option C" name="option_c" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="optionD">Option D</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" value="option_d" name="answer"  required>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter option D" name="option_d" required>
                            </div>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Add Question</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header">{{ $quiz->title }} of "{{ $lesson->title }}"</div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Question</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Question</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($questions as $key => $item)
                            <tr>
                                <td>{{ $item->no }}</td>
                                <td>{!! $item->question !!}</td>
                                <td>
                                    <form action="{{ route('question.delete', [ $lesson->id, $quiz->id, $item->id]) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark" onclick="return confirm('Are you sure to delete this data?')"><i data-feather="trash-2"></i></button>
                                    </form>
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('script')
<script>
    tinymce.init({
        selector: 'textarea'
        , plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount'
        , toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat'
    , });

</script>
@endsection
