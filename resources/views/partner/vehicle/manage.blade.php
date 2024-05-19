@extends('admin.layout.default')

@section('title', 'Vehicle')
@section('header', 'Vehicle')
@section('content')
    <div id="flash" data-flash="{{ session()->get('success') }}"></div>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <div id="flashError" data-flash="{{ $error }}">
                </div>
            @endforeach
        </ul>
        </div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h6 class="mb-0">Vehicle </h6>
                    </div>
                    <div class="col-6 text-end">
                        <a class="btn btn-outline-success outline mb-0" data-bs-toggle="modal" data-bs-target="#addModal"
                            href="#"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add
                            New Vehicle</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="vehicleTable">
                        <thead>
                            <th>No</th>
                            <th>Vehicle Type</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($vehicle as $row)
                                <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog " role="document">
                                        <div class="modal-content">
                                            <div class="modal-header"
                                                style="background: linear-gradient(to bottom right, #00796B, #008374);">
                                                <h5 class="modal-title text-white" id="exampleModalLabel">Edit Vehicle</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data"
                                                    action="{{ route('partner-vehicle-update', ['id' => $row->id]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="">Vehicle Type</label><span
                                                            class="text-danger">*</span>
                                                        <input type="text" value="{{ $row->vehicle_type }}"
                                                            name="vehicle"
                                                            class="form-control @error('vehicle') is-invalid @enderror">
                                                        @error('vehicle')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"> <i
                                                        class="fa fa-paper-plane"></i> &nbspSubmit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <tr>
                                    <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                    <td class="align-middle text-center">{{ $row->vehicle_type }}</td>
                                    <td class="align-middle text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $row->id }}"> <i
                                                        class="fa fa-pencil-alt"></i>
                                                    Edit</a>
                                                <a href="javascript::void(0)" class="dropdown-item"
                                                    onclick="confirmDelete('#delete-{{ $row->id }}')"><i
                                                        class="fas fa-trash"></i>&nbsp
                                                    Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                    <form method="post" action="{{ route('partner-vehicle-delete', ['id' => $row->id]) }}"
                                        id="delete-{{ $row->id }}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #00796B, #008374);">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Add Tasker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('partner-vehicle-store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="">Vehicle Type</label><span class="text-danger">*</span>
                            <input type="text" value="{{ old('vehicle') }}" name="vehicle"
                                class="form-control @error('vehicle') is-invalid @enderror">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-paper-plane"></i>
                        &nbspSubmit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            let table = new DataTable('#vehicleTable', {
                lengthMenu: [5, 25, 50, 100],
                language: {
                    lengthMenu: 'Show _MENU_ entries',
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                }
            });

        });
    </script>
@stop
