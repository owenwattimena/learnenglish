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
            <button class="btn btn-primary btn-sm align-end" type="button" data-bs-toggle="modal" data-bs-target="#addQuizModal">Add New</button>
            <!-- Modal -->
            <div class="modal fade" id="addQuizModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Quiz</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('quiz.create', $lesson->id) }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="selectType">Type</label>
                                    <select class="form-control" id="selectType" type="text" placeholder="Enter Description" name="type" >
                                        <option value="multiple">Multiple</option>
                                        <option value="essay">Essay</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="inputTitle">Title</label>
                                    <input class="form-control" id="inputTitle" type="text" placeholder="Enter Title" name="title" />
                                </div>
                                <div class="mb-3">
                                    <label for="inputDescription">Description</label>
                                    <input class="form-control" id="inputDescription" type="text" placeholder="Enter Description" name="description" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn bg-dark text-white" type="button" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit">Add New</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($quiz as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->type }}</td>
                        <td>
                            <a class="btn btn-xs btn-transparent-dark me-2" href="{{ route('question', ["id" => $lesson->id , "quizId" => $item->id]) }}" >Questions</a>
                            <a class="btn btn-xs btn-transparent-dark me-2" href="{{ route('question.result', ["id" => $lesson->id , "quizId" => $item->id]) }}" >Result</a>
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
