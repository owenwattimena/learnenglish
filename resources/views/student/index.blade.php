@extends('templates.index')

@section('content')
<div class="container-xl px-4 mt-5">
    <!-- Custom page header alternative example-->
    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
        <div class="me-4 mb-3 mb-sm-0">
            <h1 class="mb-0">Students</h1>
            <div class="small">
                <span class="fw-500 text-primary">List of Student</span>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">List of Student</div>
        <div class="card-body">
            <button class="btn btn-primary btn-sm align-end" type="button" data-bs-toggle="modal" data-bs-target="#addPeriodModal">Add New</button>
            <!-- Modal -->
            <div class="modal fade" id="addPeriodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('student.create') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="inputName">Name</label>
                                    <input class="form-control" id="inputName" type="text" placeholder="Enter Student Name" name="nama" required />
                                </div>
                                <div class="mb-3">
                                    <label for="inputNIS">NIS</label>
                                    <input class="form-control" id="inputNIS" type="text" placeholder="Enter NIS" name="nis" required />
                                </div>
                                <div class="mb-3">
                                    <label for="inputNISN">NISN</label>
                                    <input class="form-control" id="inputNISN" type="text" placeholder="Enter NISN" name="nisn" required />
                                </div>
                                <div class="mb-3">
                                    <label for="inputPassword">Password</label>
                                    <input class="form-control" id="inputPassword" type="password" placeholder="Enter Password" name="password" required />
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
                        <th>Name</th>
                        <th>NIS/NISN</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>NIS/NISN</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($user as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->nis }}/{{ $item->nisn }}</td>
                        <td>
                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#updatePeriodModal-{{ $key }}"><i data-feather="edit"></i></button>
                            <form action="{{ route('student.delete', $item->id) }}" method="post" class="d-inline">
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
                                        <h5 class="modal-title" id="exampleModalLabel">Update Student</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('student.update', $item->id) }}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="inputNama{{ $key }}">Nama</label>
                                                <input class="form-control" id="inputNama{{ $key }}" type="text" placeholder="Enter Name" name="nama" value="{{ $item->nama }}" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputNIS{{ $key }}">NIS</label>
                                                <input class="form-control" id="inputNIS{{ $key }}" type="text" placeholder="Enter NIS" name="nis" value="{{ $item->nis }}" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputNISN{{ $key }}">NISN</label>
                                                <input class="form-control" id="inputNISN{{ $key }}" type="text" placeholder="Enter NISN" name="nisn" value="{{ $item->nisn }}" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputPassword{{ $key }}">Password</label>
                                                <input class="form-control" id="inputPassword{{ $key }}" type="password" placeholder="Enter Password" name="password" />
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
