@extends('partner.layout.default')

@section('title', 'News Details')
@section('header', 'News Details')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6>News Details</h6>
                <div class="d-flex align-items-center">
                    <a href="{{ route('partner-news-manage') }}" class="btn btn-warning btn-sm ms-auto"> <i
                            class="fa fa-arrow-left"></i>&nbspBack</a>
                </div>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data"
                    action="{{ route('partner-news-update', ['id' => $news->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <label for="">Thumbnail</label>
                                    <center>
                                        <img width="300" src="{{ asset('partner/news/thumbnail/' . $news->thumbnail) }}"
                                            alt="">
                                    </center>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="">Thumbnail</label>
                                <input name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror"
                                    type="file" value="{{ $news->thumbnail }}">
                            </div>
                            <div class="mb-3">
                                <label for="">News Title</label>
                                <input name="title" class="form-control @error('title') is-invalid @enderror"
                                    type="text" value="{{ $news->title }}">
                            </div>
                            <div class="mb-3">
                                <label for="">News Category</label>
                                <select name="news_category"
                                    class="form-control @error('news_category') is-invalid @enderror">
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}"
                                            @if ($news->category && $news->category->news_category == $item->news_category) selected @endif>{{ $item->news_category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">Date Post</label>
                                <input class="form-control" type="text"
                                    value="{{ date('d F Y', strtotime($news->date_news)) }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" cols="30"
                                    rows="6">{{ $news->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="1" @if ($news->status == 1) selected @endif>ACTIVE</option>
                                    <option value="0" @if ($news->status == 0) selected @endif>DISABLE
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-paper-plane"></i> &nbsp; Submit
                            </button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <label for="">Image</label>
                    @foreach ($news->photos as $item)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <img src="{{ asset('partner/news/' . $item->image) }}" class="img-fluid" alt=""
                                        data-image-id="{{ $item->id }}">

                                </div>
                                <div class="card-footer bg-secondary">
                                    <a href="javascript::void(0)" class="text-white dropdown-item"
                                        onclick="confirmDelete('#delete-{{ $item->id }}')"><i
                                            class="fas fa-trash"></i>&nbsp
                                        Delete</a>
                                </div>
                            </div>
                            <form method="post" action="{{ route('partner-news-image-delete', ['id' => $item->id]) }}"
                                id="delete-{{ $item->id }}">
                                @csrf
                                @method('delete')
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
@endSection()
