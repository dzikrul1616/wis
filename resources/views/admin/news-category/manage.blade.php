@extends('admin.layout.default')

@section('title', 'News')
@section('header', 'News')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Category News Table</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn btn-outline-success outline mb-0" data-bs-toggle="modal" data-bs-target="#addModal"
                                href="#"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add
                                Category News</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="partnerTable">
                            <thead>
                                <th style="width:10px;">No</th>
                                <th class="text-center">Category</th>
                                <th style="width:100px;" class="text-center">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($category as $row)
                                    <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header"
                                                    style="background: linear-gradient(to bottom right, #00796B, #008374);">
                                                    <h5 class="modal-title text-white" id="exampleModalLabel">Detail Partner
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ route('admin-news-category-update', ['id' => $row->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="">News Category</label>
                                                            <input type="text"
                                                                class="form-control @error('news_category') is-invalid @enderror"
                                                                name="news_category" value="{{ $row->news_category }}">
                                                            @error('news_category')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <tr class="text-dark">
                                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                        <td class="align-middle text-center">{{ $row->news_category }}</td>
                                        <td class="align-middle text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-success dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $row->id }}" href="#"> <i
                                                            class="fa fa-pencil-alt"></i>&nbsp
                                                        Edit</a>
                                                    <a href="javascript::void(0)" class="dropdown-item"
                                                        onclick="confirmDelete('#delete-{{ $row->id }}')"><i
                                                            class="fas fa-trash"></i>&nbsp
                                                        Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <form method="post"
                                            action="{{ route('admin-news-category-delete', ['id' => $row->id]) }}"
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
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            let table = new DataTable('#partnerTable', {
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
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to bottom right, #00796B, #008374);">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Detail Partner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin-news-category-store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="">News Category</label>
                            <input type="text" class="form-control @error('news_category') is-invalid @enderror"
                                name="news_category" value="{{ old('news_category') }}">
                            @error('news_category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endSection()
