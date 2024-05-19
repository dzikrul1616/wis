@extends('partner.layout.default')

@section('title', 'News')
@section('header', 'News')
@section('content')
    <div class="row">
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
                        <h6 class="mb-0">News Table</h6>
                    </div>
                    <div class="col-6 text-end">
                        <a class="btn btn-outline-success outline mb-0" data-bs-toggle="modal" data-bs-target="#addModal"
                            href="#"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add
                            News</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="partnerTable">
                        <thead>
                            <th style="width:10px;">No</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">News Title</th>
                            <th class="text-center">Posted</th>
                            <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($news as $row)
                                <tr class="text-dark">
                                    <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                    <td class="align-middle text-center">{{ $row->category->news_category }}</td>
                                    <td class="align-middle text-center">{{ $row->title }}</td>
                                    <td class="align-middle text-center">{{ date('d F Y', strtotime($row->date_news)) }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item"
                                                    href="{{ route('partner-news-details', ['id' => $row->id]) }}"> <i
                                                        class="fa fa-eye"></i>
                                                    Details</a>
                                                <a href="javascript::void(0)" class="dropdown-item"
                                                    onclick="confirmDelete('#delete-{{ $row->id }}')"><i
                                                        class="fas fa-trash"></i>&nbsp
                                                    Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                    <form method="post" action="{{ route('partner-news-delete', ['id' => $row->id]) }}"
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
                    <h5 class="modal-title text-white" id="exampleModalLabel">Add News</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="{{ route('partner-news-store') }}" method="post">
                        @csrf
                        <input type="hidden" name="partner_id" value="{{ session('partner_id') }}">
                        <div class="mb-3">
                            <label for="">Title</label><span class="text-danger">*</span>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title') }}">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">News Category</label> <span class="text-danger">*</span>
                            <select name="category_id"
                                class="form-control @error('category_id') is-invalid @enderror select2">
                                <option>-- Select News Category --</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->news_category }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Thumbnail</label> <span class="text-danger">*</span>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                name="thumbnail">
                            @error('thumbnail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Image</label> <span class="text-danger">*</span>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image[]" multiple>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Description</label><span class="text-danger">*</span>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" cols="30"
                                rows="7">{{ old('description') }}</textarea>
                            @error('description')
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
