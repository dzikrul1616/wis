@extends('admin.layout.default')

@section('title', 'Tasker Details')
@section('header', 'Tasker Details')
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
                        <h6 class="mb-0">Tasker </h6>
                    </div>
                    <div class="col-6 text-end">
                        <a class="btn btn-outline bg-primary text-white outline mb-0"
                            href="{{ route('admin-tasker-manage') }}"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;
                            Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-3">Partner Info</h4>
                                <div class="mb-3">
                                    <center>
                                        <img class="mb-3" width="200"
                                            src="{{ asset('partner/photo/' . $tasker->partner->partner_image) }}"
                                            alt="">
                                        <p>{{ $tasker->partner->partner_name }}</p>
                                    </center>
                                    <div class="mb-3">
                                        <label for="">Partner Email</label>
                                        <input type="text" class="form-control"
                                            value="{{ $tasker->partner->partner_email }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Partner Phone</label>
                                        <input type="text" class="form-control"
                                            value="{{ $tasker->partner->partner_phone }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Partner Country</label>
                                        <input type="text" class="form-control"
                                            value="{{ $tasker->partner->province }}, {{ $tasker->partner->country }}"
                                            readonly>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="text-primary" for="">Open Hour</label>
                                            <input type="text" class="form-control"
                                                value="{{ $tasker->partner->open_hour }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-danger" for="">Closed Hour</label>
                                            <input type="text" class="form-control"
                                                value="{{ $tasker->partner->closed_hour }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-3">Tasker Info</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Photo</label>
                                        <div class="card">
                                            <div class="card-body">
                                                <center>
                                                    <img class="mb-3 img-fluid"
                                                        src="{{ asset('partner/tasker/' . $tasker->photo) }}"
                                                        alt="">
                                                    <p>{{ $tasker->full_name }}</p>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="">Email</label>
                                            <input type="text" class="form-control" value="{{ $tasker->email }}"
                                                readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Phone</label>
                                            <input type="text" class="form-control" value="{{ $tasker->phone }}"
                                                readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Gender</label>
                                            <input type="text" class="form-control"
                                                value="{{ $tasker->gender === 'female' ? 'Female' : 'Male' }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Birth Date</label>
                                            <input type="text" class="form-control"
                                                value="{{ date('d F Y', strtotime($tasker->birth_date)) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-primary">Location</p>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="">Country</label>
                                        <input type="text" class="form-control" value="{{ $tasker->country }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Province</label>
                                        <input type="text" class="form-control" value="{{ $tasker->province }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Address</label>
                                    <textarea class="form-control" readonly>{{ $tasker->address }}</textarea>
                                </div>
                                <p class="text-primary">Vehicle</p>
                                <label for="">Vehicle Type</label>
                                <input type="text" class="form-control" value="{{ $tasker->vehicle->vehicle_type }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
