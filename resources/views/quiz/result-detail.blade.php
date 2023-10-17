@extends('templates.index')
@section('head')
@endsection
@section('content')
<div class="container-xl px-4 mt-5">
    <!-- Custom page header alternative example-->
    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
        <div class="me-4 mb-3 mb-sm-0">
            <h1 class="mb-0">Lessons Quiz Result</h1>
            <div class="small">
                <span class="fw-500 text-primary">{{ $lesson->title }}</span>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Quizes of "{{ $lesson->title }}"</div>
        <div class="card-body">
            <h5>Student : {{ $user->nama }}</h5>
            <h5>Lesson : {{ $lesson->title }}</h5>
            <h5>Quiz : {{ $quiz->title }}</h5>
            <h5>Score : {{ $score }}</h5>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width: 100px">Question</th>
                        <th>Answer</th>
                        <th>Correct Answer</th>
                        <th>Point</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th style="width: 100px">Question</th>
                        <th>Answer</th>
                        <th>Correct Answer</th>
                        <th>Point</th>
                    </tr>
                </tfoot>
                <tbody>
                    {{-- @foreach ([] as $key => $item) --}}
                    @if ($quiz->type == 'multiple')
                    @foreach ($questionAnswer as $key => $item)
                    <tr>
                        <td>{{ $item->no }}</td>
                        <td style="width: 100px">{!! $item->question !!}</td>
                        <td>{{ $item->mTAnswerDetail->first()->selectedOption->option }}</td>
                        <td>{{ $item->option->first()->option }}</td>
                        <td>{{ $item->option->first()->id == $item->mTAnswerDetail->first()->selectedOption->id ? '10' : '0' }}</td>
                    </tr>
                    @endforeach
                    @else
                    @foreach ($questionAnswer as $key => $item)
                    <tr>
                        <td>{{ $item->no }}</td>
                        <td style="width: 100px">{!! $item->question !!}</td>
                        <td>{{ $item->eTAnswerDetail->first()->answer }}</td>
                        <td>
                            <form action="{{ route('question.result.detail.evaluate', [ $lesson->id, $quiz->id, $item->eTAnswerDetail->first()->user_answer_id]) }}" method="post" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->eTAnswerDetail->first()->id }}">
                                <button name="correct" value="true" class="btn btn-sm text-light bg-green" onclick="return confirm('Are you sure to evaluate this answer as correct?')"><i data-feather="check"></i> Correct</button>
                                <button name="wrong" value="true" class="btn btn-sm text-light bg-red" onclick="return confirm('Are you sure to evaluate this answer as wrong?')"><i data-feather="x-circle"></i> Wrong</button>
                            </form>
                        </td>
                        <td>{{ $item->eTAnswerDetail->first()->is_correct == true ? '10' : '0' }}</td>
                    </tr>
                    @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
