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
            <h1 class="mb-0">Lessons</h1>
            <div class="small">
                <span class="fw-500 text-primary">{{ isset($lesson) ?  ( app('request')->query('type') == 'show' ? 'Detail' : 'Update Lesson' ) : 'Add New Lesson' }}</span>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">{{ isset($lesson) ? ( app('request')->query('type') == 'show' ? 'Detail' : 'Update Lesson' ) : 'Add New Lesson' }}</div>
        <div class="card-body">
            @if (app('request')->query('type') == 'show')
            <a href="{{ route('quiz', $lesson->id) }}" class="btn btn-warning btn-sm mb-3">Quiz</a>
            @endif
            <form action="{{ isset($lesson) ? route('lesson.update', $lesson->id) :  route('lesson.create') }}" method="post">
                @csrf
                @if (isset($lesson))
                    @method('put')
                @endif
                <div class="mb-3">
                    <label for="inputTitle">Title</label>
                    <input class="form-control" id="inputTitle" type="text" placeholder="Enter Title" name="title" value="{{ isset($lesson) ? $lesson->title : '' }}" required {{ isset($lesson) ? (app('request')->query('type') == 'show' ? 'disabled' : '')  : '' }} />
                </div>
                <div class="mb-3">
                    <label for="inputDesc">Description</label>
                    <input class="form-control" id="inputDesc" type="text" placeholder="Enter Description" name="description" value="{{ isset($lesson) ? $lesson->description : '' }}" required {{ isset($lesson) ? (app('request')->query('type') == 'show' ? 'disabled' : '')  : '' }} />
                </div>
                <div class="mb-3">
                    <label for="inputLesson">Lesson</label>
                    @if (isset($lesson) && app('request')->query('type') == 'show')
                    <div class="mt-3">
                        {!! $lesson->lesson !!}
                    </div>
                    @else
                    <textarea class="form-control" id="inputLesson" placeholder="Enter Lesson" name="lesson">{{ isset($lesson) ? $lesson->lesson : '' }}</textarea>
                    @endif
                </div>
                @if (app('request')->query('type') != 'show')
                <button class="btn btn-primary" type="submit">{{ isset($lesson) ? 'Update' : 'Add New' }}</button>
                @endif
            </form>
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
