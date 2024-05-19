@extends('partner.layout.default')

@section('title', 'Manage Transaction')
@section('header', 'Manage Transaction')

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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="transactionTable">
                        <thead>
                            <th>No</th>
                            <th>Username</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($tr as $row)
                                <tr>
                                    <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                    <td class="align-middle text-center">{{ $row->user->full_name }}</td>
                                    <td class="align-middle text-center">{{ $row->transaction_point }}</td>
                                    <td class="align-middle text-center">{{ $row->status }}</td>
                                    <td class="align-middle text-center">
                                        @if ($row->status == 'PENDING')
                                            <form class="mt-2"
                                                action="{{ route('partner-transaction-verify', ['id' => $row->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" name="status" value="ACCEPTED"
                                                    class="btn btn-success"> <i class="fas fa-check"></i>
                                                    &nbspAccept</button>
                                                <button type="submit" name="status" value="CANCEL" class="btn btn-danger">
                                                    <i class="fa fa-times"></i> &nbspCancel</button>
                                            </form>
                                        @elseif ($row->status == 'ACCEPTED')
                                            <button disabled class="btn btn-success">Accepted</button>
                                        @elseif ($row->status == 'CANCEL')
                                            <button disabled class="btn btn-danger">Cancelled</button>
                                        @endif
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
        let table = new DataTable('#transactionTable', {
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
