@extends('admin.layout.default')


@section('title', 'News Details')
@section('header', 'News Details')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h6 class="mb-0">News Details </h6>
                    </div>
                    <div class="col-6 text-end">
                        <a class="btn btn-outline bg-primary text-white outline mb-0" href="{{ route('admin-news-list') }}"><i
                                class="fa fa-arrow-left"></i>&nbsp;&nbsp;
                            Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="news-container">
                    <img src="{{ asset('partner/news/thumbnail/' . $news->thumbnail) }}" alt="Gambar Berita"
                        class="news-image">
                    <div class="news-content">
                        <h3>{{ $news->title }}</h3>
                        <p class="text-justify">{{ $news->description }}</p>
                        <p class="mb-0">Date : {{ date('d F Y', strtotime($news->date_news)) }}</p>
                        <p class="mt-0">Posted by : {{ $news->partner->partner_name }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection()
<style>
    .card-body {
        display: flex;
        align-items: center;
    }

    .news-container {
        display: flex;
        align-items: center;
    }

    .news-image {
        width: 400px;
        height: auto;
        margin-right: 20px;
    }

    .news-content {
        flex: 1;
    }

    h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    p {
        font-size: 14px;
        margin-bottom: 5px;
    }
</style>
