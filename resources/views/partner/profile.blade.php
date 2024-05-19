@extends('partner.layout.default')

@section('title', 'Partner profile')
@section('header', 'Partner profile')
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
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Details {{ $partner->full_name }} Application</p>
                        <a href="{{ route('dashboard-partner') }}" class="btn btn-warning btn-sm ms-auto"> <i
                                class="fa fa-arrow-left"></i>&nbspBack</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">Credential Information</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Name</label>
                                <input class="form-control" type="text" value="{{ $partner->partner_name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email</label>
                                <input class="form-control" type="email" value="{{ $partner->partner_email }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Partner Phone</label>
                                <input class="form-control" type="text" value="{{ $partner->partner_phone }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Nationality</label>
                                <input class="form-control" type="text" value="{{ $partner->country }}" readonly>
                            </div>
                        </div>
                    </div>
                    <hr class="horizontal dark">
                    <p class="text-uppercase text-sm">Open Days</p>
                    <form method="post" action="{{ route('partner-profile-update', ['id' => $partner->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Open Hours</label>
                                <input type="time" value="{{ $partner->open_hour }}" name="open_hour"
                                    class="form-control @error('open_hour') is-invalid @enderror">
                            </div>
                            <div class="col-md-6">
                                <label for="">Closed Hours</label>
                                <input type="time" value="{{ $partner->closed_hour }}" name="closed_hour"
                                    class="form-control @error('closed_hour') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label for="">Days</label>
                                        <select class="form-control select2" multiple="multiple" name="days[]"
                                            id="options" style="width: 100%">
                                            @php
                                                $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                            @endphp
                                            @foreach ($daysOfWeek as $day)
                                                <option value="{{ $day }}"
                                                    @if ($partner->openDays->contains('day', $day)) selected @endif>{{ $day }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Contact Information</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Address</label>
                                    <textarea class="form-control" id="" cols="30" rows="6" readonly> {{ $partner->address }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-success ms-auto"><i class="fa fa-paper-plane"></i>&nbsp Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <img src="{{ asset('template') }}/assets/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-4 order-lg-2">
                        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                            <a href="javascript:;" class="image-upload">
                                <img src="{{ asset('partner/photo/' . $partner->partner_image) }}"
                                    class="rounded-circle img-fluid border border-2 border-white" id="partnerImage">
                                <input type="file" id="photoInput" name="partner_image" style="display: none;">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                    <div class="d-flex justify-content-between">
                        @if ($partner->status == 'PENDING')
                            <button type="button" class="text-white btn btn-sm btn-secondary mb-0 d-none d-lg-block"
                                disabled>Pending</button>
                        @else
                            <button type="button" class="text-white btn btn-sm btn-primary mb-0 d-none d-lg-block"
                                disabled>Approved</button>
                        @endif

                        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i
                                class="ni ni-collection"></i></a>
                        <a href="mailto:{{ $partner->email }}"
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
                            {{ $partner->full_name }}<span class="font-weight-light">
                                {{ \Carbon\Carbon::parse($partner->created_at)->diffForHumans() }}
                            </span>

                        </h5>
                        <div class="h6 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{ $partner->province }}, {{ $partner->country }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endSection()
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageUpload = document.querySelector('.image-upload');
        const photoInput = document.querySelector('#photoInput');
        const partnerImage = document.querySelector('#partnerImage');

        imageUpload.addEventListener('click', function() {
            photoInput.click();
        });

        photoInput.addEventListener('change', function() {
            if (photoInput.files && photoInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    partnerImage.setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(photoInput.files[0]);
            }
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'classic',
            width: '100%',
            height: '80%',
            allowClear: true,
            multiple: true,
            minimumResultsForSearch: Infinity,

        });

        $('.select2').on('select2:opening select2:closing', function(event) {
            var $searchfield = $(this).parent().find('.select2-search__field');
            $searchfield.prop('disabled', false);
        });
    });
</script>


<style>
    .select2-container--above .select2-dropdown {
        transform: translateY(-100%);
    }
</style>
