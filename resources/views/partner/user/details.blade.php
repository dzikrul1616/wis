@extends('partner.layout.default')

@section('title', 'Detail User Application')
@section('header', 'Detail User Application')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Details {{ $user[0]->full_name }} Application</p>
                        <a href="{{ route('partner-customer-manage', ['id' => $user[0]->partner_id]) }}"
                            class="btn btn-warning btn-sm ms-auto"> <i class="fa fa-arrow-left"></i>&nbspBack</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">Credential Information</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Name</label>
                                <input class="form-control" type="text" value="{{ $user[0]->full_name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email</label>
                                <input class="form-control" type="email" value="{{ $user[0]->email }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Partner Phone</label>
                                <input class="form-control" type="text" value="{{ $user[0]->phone }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Nationality</label>
                                <input class="form-control" type="text" value="{{ $user[0]->country }}" readonly>
                            </div>
                        </div>
                    </div>
                    <hr class="horizontal dark">
                    <p class="text-uppercase text-sm">Contact Information</p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Address</label>
                                <textarea class="form-control" id="" cols="30" rows="6" readonly> {{ $user[0]->address }}</textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="horizontal dark">
                    <p class="text-uppercase text-sm">Coordinate</p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <label for="">Maps</label>
                                    <div id="maps" style="height: 418px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <img src="{{ asset('template') }}/assets/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-4 order-lg-2">
                        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                            <a href="javascript:;">
                                <img src="{{ asset('images/user/' . $user[0]->photo) }}"
                                    class="rounded-circle img-fluid border border-2 border-white">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                    <div class="d-flex justify-content-between">
                        @if ($user[0]->status == 'PENDING')
                            <button type="button" class="text-white btn btn-sm btn-secondary mb-0 d-none d-lg-block"
                                disabled>Pending</button>
                        @else
                            <button type="button" class="text-white btn btn-sm btn-primary mb-0 d-none d-lg-block"
                                disabled>Approved</button>
                        @endif

                        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i
                                class="ni ni-collection"></i></a>
                        <a href="mailto:{{ $user[0]->email }}"
                            class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block">Email</a>
                        <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none"><i
                                class="ni ni-email-83"></i></a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-center">
                                <div class="d-grid text-center">
                                    <span class="text-lg font-weight-bolder">22</span>
                                    <span class="text-sm opacity-8">Friends</span>
                                </div>
                                <div class="d-grid text-center mx-4">
                                    <span class="text-lg font-weight-bolder">10</span>
                                    <span class="text-sm opacity-8">Photos</span>
                                </div>
                                <div class="d-grid text-center">
                                    <span class="text-lg font-weight-bolder">89</span>
                                    <span class="text-sm opacity-8">Comments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <h5>
                            {{ $user[0]->full_name }}<span class="font-weight-light">
                                {{ \Carbon\Carbon::parse($user[0]->created_at)->diffForHumans() }}
                            </span>

                        </h5>
                        <div class="h6 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{ $user[0]->province }}, {{ $user[0]->country }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.js"></script>
    <script>
        var maps = L.map('maps').setView([{{ $user[0]->latitude }}, {{ $user[0]->longitude }}], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(maps);
        L.marker([{{ $user[0]->latitude }}, {{ $user[0]->longitude }}]).addTo(maps)
            .bindPopup('{{ $user[0]->full_name }}' + ' location')
            .openPopup();
    </script>
@endSection()
