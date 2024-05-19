@extends('admin.layout.default')

@section('title', 'Partners')
@section('header', 'Partners')
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
                        <h6 class="mb-0">Partners Table</h6>
                    </div>
                    <div class="col-6 text-end">
                        {{-- <a class="btn btn-outline-success outline mb-0" href="javascript:;"><i
                                class="fas fa-plus"></i>&nbsp;&nbsp;Add
                            New Card</a> --}}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="partnerTable">
                        <thead>
                            <th style="width:10px;">No</th>
                            <th class="text-center">Partner Name
                            </th>
                            <th class="text-center">Partner Email
                            </th>
                            <th class="text-center">Partner Phone
                            </th>
                            <th class="text-center">Country</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($partner as $row)
                                <tr class="text-dark">
                                    <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                    <td class="align-middle text-center">{{ $row->partner_name }}</td>
                                    <td class="align-middle text-center">{{ $row->partner_email }}</td>
                                    <td class="align-middle text-center">{{ $row->partner_phone }}</td>
                                    <td class="align-middle text-center">{{ $row->country }}</td>
                                    <td class="align-middle text-center text-sm">
                                        <span
                                            class="badge badge-sm {{ $row->status_partner === 'PENDING' ? 'bg-gradient-secondary' : ($row->status_partner === 'ACCEPTED' ? 'bg-gradient-success' : 'bg-gradient-danger') }}">{{ $row->status_partner }}</span>
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
                                                    href="{{ route('admin-partner-details', ['id' => $row->id]) }}"> <i
                                                        class="fa fa-eye"></i>
                                                    Details</a>
                                                <a class="dropdown-item" href="#"> <i class="fa fa-trash"></i>
                                                    &nbspDelete</a>
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
@endSection
