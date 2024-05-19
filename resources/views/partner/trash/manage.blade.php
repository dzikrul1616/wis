@extends('partner.layout.default')

@section('title', 'Trash Management')
@section('header', 'Trash Management')

@section('content')

    <div class="col-md-12">
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
    <div class="card">
        <div class="card-header pb-0 p-3">
            <div class="row">
                <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0">Trash Management </h6>
                </div>
                <div class="col-6 text-end">
                    <a class="btn btn-outline-success outline mb-0" data-bs-toggle="modal" data-bs-target="#addModal"
                        href="#"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add
                        New Trash</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="trashTable" class="table table-hover table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Trash Name</th>
                        <th>Trash Category</th>
                        <th>Value</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($trash as $row)
                            <tr>
                                <td class="align-middle text-center"> {{ $loop->iteration }}</td>
                                <td class="align-middle text-center">{{ $row->trash_name }}</td>
                                <td class="align-middle text-center">{{ $row->trash_category->category_name }}</td>
                                <td class="align-middle text-center">{{ $row->value_change }}/{{ $row->unit }}</td>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #00796B, #008374);">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Add Trash</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('partner-trash-store') }}">
                        @csrf
                        <input type="hidden" value="{{ session('partner_id') }}" name="partner_id">
                        <div class="mb-3">
                            <label for="">Trash Name</label><span class="text-danger">*</span>
                            <input name="trash_name" placeholder="Glass" type="text"
                                class="form-control @error('trash_name') is-invalid @enderror"
                                value="{{ old('trash_name') }}">
                            @error('trash_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Trash Category</label><span class="text-danger">*</span>
                            <select name="trash_category_id"
                                class="form-control @error('trash_category_id') is-invalid @enderror">
                                <option value="">-- Select Trash Category --</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                @endforeach
                            </select>
                            @error('trash_category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="">Value Change</label><span class="text-danger">*</span>
                                    <input name="value_change" placeholder="200" type="number"
                                        class="form-control @error('value_change') is-invalid @enderror"
                                        value="{{ old('value_change') }}">
                                    @error('value_change')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="">Unit</label><span class="text-danger">*</span>
                                    <select name="units" class="form-control @error('units') is-invalid @enderror">
                                        <option value="">-- Select Unit --</option>
                                        <option value="Kg">KG</option>
                                        <option value="Ton">Ton</option>
                                        <option value="Lt">Liter</option>
                                        <option value="Ounce">Ounce</option>
                                        <option value="Meter">Meter</option>
                                        <option value="Pcs">Piece</option>
                                        <option value="Cm">Centimeter</option>
                                    </select>
                                    @error('units')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" cols="30"
                                rows="6">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Image</label>
                            <input type="file" name="image[]"
                                class="form-control @error('image') is-invalid @enderror" multiple>
                            <span class="text-danger" style="font-size: 12px;">Max size : 2 MB</span>
                            @error('iamge')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
@stop
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        let table = new DataTable('#trashTable', {
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
