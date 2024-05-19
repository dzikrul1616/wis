@extends('partner.layout.default')

@section('title', 'Trash Category')
@section('header', 'Trash Category')

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
                    <h6 class="mb-0">Trash Category </h6>
                </div>
                <div class="col-6 text-end">
                    <a class="btn btn-outline-success outline mb-0" data-bs-toggle="modal" data-bs-target="#addModal"
                        href="#"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add
                        New Trash Category</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="trashTable">
                    <thead>
                        <th>No</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($category as $row)
                            <div class="modal fade" id="editModal{{ $row->id }}" tabindex="0" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header"
                                            style="background: linear-gradient(to bottom right, #00796B, #008374);">
                                            <h5 class="modal-title text-white" id="exampleModalLabel">Edit Trash
                                                Category
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" enctype="multipart/form-data"
                                                        action="{{ route('partner-trash-category-update', ['id' => $row->id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" value="{{ session('partner_id') }}"
                                                            name="partner_id">
                                                        <div class="mb-3">
                                                            <label for="">Category Name</label><span
                                                                class="text-danger">*</span>
                                                            <input name="category_name" placeholder="Glass" type="text"
                                                                class="form-control @error('category_name') is-invalid @enderror"
                                                                value="{{ $row->category_name }}">
                                                            @error('category_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="">Description</label>
                                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" cols="30"
                                                                rows="6">{{ $row->description }}</textarea>
                                                            @error('description')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="">Image</label>
                                                            <input type="file" name="image[]"
                                                                class="form-control @error('image') is-invalid @enderror"
                                                                multiple>
                                                            <span class="text-danger" style="font-size: 12px;">Max size
                                                                : 2
                                                                MB</span>
                                                            @error('image')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mt-4">
                                                        <label for="">Image</label><span class="text-danger"></span>
                                                        <div class="row">
                                                            @foreach ($row->photos as $item)
                                                                <div class="col-md-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <a target="_blank"
                                                                                href="{{ asset('partner/trash/category/' . $item->image) }}">
                                                                                <img class="img-fluid"
                                                                                    src="{{ asset('partner/trash/category/' . $item->image) }}"
                                                                                    alt="">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary"> <i
                                                    class="fa fa-paper-plane"></i>
                                                &nbspSubmit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <tr>
                                <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                <td class="align-middle text-center">{{ $row->category_name }}</td>
                                <td class="align-middle text-center">
                                    {{ strlen($row->description) > 60 ? substr($row->description, 0, 60) . '...' : $row->description }}
                                </td>
                                <td class="align-middle text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
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
                                <form method="post"
                                    action="{{ route('partner-trash-category-delete', ['id' => $row->id]) }}"
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
                    <h5 class="modal-title text-white" id="exampleModalLabel">Add Trash Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data"
                        action="{{ route('partner-trash-category-store') }}">
                        @csrf
                        <input type="hidden" value="{{ session('partner_id') }}" name="partner_id">
                        <div class="mb-3">
                            <label for="">Category Name</label><span class="text-danger">*</span>
                            <input name="category_name" placeholder="Glass" type="text"
                                class="form-control @error('category_name') is-invalid @enderror"
                                value="{{ old('category_name') }}">
                            @error('category_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
                            @error('image')
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
