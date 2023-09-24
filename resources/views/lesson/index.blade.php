@extends('templates.index')
@section('head')
@endsection
@section('content')
<div class="container-xl px-4 mt-5">
    <!-- Custom page header alternative example-->
    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
        <div class="me-4 mb-3 mb-sm-0">
            <h1 class="mb-0">Lessons</h1>
            <div class="small">
                <span class="fw-500 text-primary">List of Lesson</span>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">List of Lesson</div>
        <div class="card-body">
            <a class="btn btn-primary btn-sm align-end" href="{{ route('lesson.add') }}">Add New</a>

            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($lessons as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                            <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('lesson.edit', ["id" => $item->id , "type" => "show"]) }}" ><i data-feather="eye"></i></a>
                            <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('lesson.edit', $item->id) }}" ><i data-feather="edit"></i></a>
                            <form action="{{ route('lesson.delete', $item->id) }}" method="post" class="d-inline">
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
