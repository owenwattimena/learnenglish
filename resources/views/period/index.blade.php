@extends('templates.index')

@section('content')
<div class="container-xl px-4 mt-5">
    <!-- Custom page header alternative example-->
    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
        <div class="me-4 mb-3 mb-sm-0">
            <h1 class="mb-0">Period</h1>
            <div class="small">
                <span class="fw-500 text-primary">Learning period</span>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Learning period</div>
        <div class="card-body">
            <button class="btn btn-primary btn-sm align-end" type="button" data-bs-toggle="modal" data-bs-target="#addPeriodModal">Add New</button>
            <!-- Modal -->
            <div class="modal fade" id="addPeriodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Period</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('period.create') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="inputPeriod">Period</label>
                                    <input class="form-control" id="inputPeriod" type="text" placeholder="Enter new period" name="periode" />
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
                        <th>Period</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Period</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($periods as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->periode }}</td>
                        <td>
                            <div class="badge bg-{{ $item->status == true ? 'green' : 'dark'}} text-white rounded-pill">{{ $item->status == true ? 'Active' : 'Inactive' }}</div>
                        </td>
                        <td>
                            <form action="{{ route('period.change', $item->id) }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-xs">Change Status</button>
                            </form>
                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#updatePeriodModal-{{ $key }}"><i data-feather="edit"></i></button>
                            <form action="{{ route('period.delete', $item->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('delete')
                                <button class="btn btn-datatable btn-icon btn-transparent-dark" onclick="return confirm('Are you sure to delete this data?')"><i data-feather="trash-2"></i></button>
                            </form>
                        </td>
                        <!-- Modal -->
                        <div class="modal fade" id="updatePeriodModal-{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add New Period</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('period.udpate', $item->id) }}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="inputPeriod">Period</label>
                                                <input class="form-control" id="inputPeriod" type="text" placeholder="Enter new period" name="periode" value="{{ $item->periode }}" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn bg-dark text-white" type="button" data-bs-dismiss="modal">Close</button>
                                            <button class="btn btn-warning" type="submit">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
