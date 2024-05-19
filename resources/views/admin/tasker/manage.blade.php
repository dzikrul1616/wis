@extends('admin.layout.default')

@section('title', 'View Tasker')
@section('header', 'View Tasker')
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
            <div class="card-header">

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="taskerTable">
                        <thead>
                            <th>No</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($tasker as $row)
                                <tr>
                                    <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                    <td class="align-middle text-center"><img width="200px"
                                            src="{{ asset('partner/tasker/' . $row->photo) }}" alt="">
                                    </td>
                                    <td class="align-middle text-center">{{ $row->full_name }}</td>
                                    <td class="align-middle text-center">{{ $row->phone }}</td>
                                    <td class="align-middle text-center">{{ $row->email }}</td>
                                    <td class="align-middle text-center">
                                        <div class="dropdown">
                                            <button class="btn btn bg-primary text-white dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin-tasker-details', ['id' => $row->id]) }}"> <i
                                                        class="fa fa-eye"></i>
                                                    Details</a>
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
@stop
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        let table = new DataTable('#taskerTable', {
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
