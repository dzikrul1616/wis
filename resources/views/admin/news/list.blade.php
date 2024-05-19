@extends('admin.layout.default')

@section('title', 'News Details')
@section('header', 'News Details')
@section('content')
    <div class="row">
        @foreach ($news as $row)
            <div class="col-md-4">
                <div class="card">

                    <div class="card-body">
                        <img class="img-fluid" src="{{ asset('partner/news/thumbnail/' . $row->thumbnail) }}">
                        <h5 class="mt-2">{{ $row->title }} </h5>
                        <p style="font-family: poppins;" class="text-justify">{{ substr($row->description, 0, 200) }}
                            @if (strlen($row->description) > 200)
                                ...
                            @endif
                        </p>
                        <div class="row">
                            <div class="col-md-8">
                                <span style="font-family: poppins;"> Posted by : {{ $row->partner->partner_name }}</span>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-end">
                                    <p style="font-family: poppins;"> {{ date('d F Y', strtotime($row->date_news)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-end">
                            <a class="btn btn-primary " href="{{ route('admin-news-details', ['id' => $row->id]) }}">
                                <i class="fa fa-eye"></i>&nbsp Details
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    </div>
@endSection()
