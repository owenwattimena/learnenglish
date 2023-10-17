@extends('templates.index')
@section('head')
@endsection
@section('content')
<div class="container-xl px-4 mt-5">
    <!-- Custom page header alternative example-->
    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
        <div class="me-4 mb-3 mb-sm-0">
            <h1 class="mb-0">Lessons Quiz</h1>
            <div class="small">
                <span class="fw-500 text-primary">{{ $lesson->title }}</span>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Quizes of "{{ $lesson->title }}"</div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Student</th>
                        <th>Corect Answer</th>
                        <th>Score</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Student</th>
                        <th>Corect Answer</th>
                        <th>Score</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($answers as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->nama }}</td>
                        <td >{{ $item->correct_answer }} of {{ $total_question }}</td>
                        <td >{{ $item->score }}</td>
                        <td >{{ $item->start_at }}</td>
                        <td >{{ $item->end_at }}</td>
                        <td>
                            <a class="btn btn-xs btn-transparent-dark me-2" href="{{ route('question.result.detail', [ $lesson->id, $quiz->id, $item->id]) }}" >Detail</a>
                            <form action="{{ route('quiz.delete', [ $lesson->id, $item->id ]) }}" method="post" class="d-inline">
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
@endsection
