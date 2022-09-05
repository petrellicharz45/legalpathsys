@extends('layouts.client.layout')
@section('title')
<title>{{ $title_meta->library_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->library_meta_description }}">
@endsection
@section('client-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->lawyer ? url($banner->lawyer) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $navigation->library }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $navigation->library }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->


<div class="doctor-search">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="s-container">
                <form action="{{ url('search-library') }}">

                    <div class="s-box">
                        <select name="library" class="form-control select2">
                            <option value="">select book</option>
                            @foreach ($libraries as $library)
                            <option {{ @$library_id==$library->id?'selected':'' }} value="{{ $library->id }}">{{($library->book_title) }}</option>
                            @endforeach
                        </select>
                    </div>
                   
                    <div class="s-button">
                        <button type="submit">search</button>
                    </div>
                </form>
                </div>

            </div>
        </div>
    </div>
</div>




<!--Service Start-->
<div class="case-study-home-page case-study-area pt_50">
    <div class="container">
        <div class="row">

            @if ($libraries->count()!=0)
            @foreach ($libraries as $index)
            <div class="col-lg-4 col-md-6 mt_15">
                <div class="case-item">
                    <div class="case-box">
                        <div class="case-image">
                            <img src="{{ url($index->image) }}" alt="">
                            <div class="overlay"><a href="{{ url('library-details/'.$index->book_title) }}" class="btn-case">See_details</a>
                            </div>
                        </div>
                        <div class="case-content">
                            <h4><a href="{{ url('library-details/'.$index->book_title) }}">{{ $index->book_title }}</a></h4>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            
            @else
            <h3 class="text-danger text-center">Book_not_found</h3>
            @endif


        </div>
        {{ @$libraries->links('client.paginator') }}
    </div>
</div>
<!--Service End-->






@endsection
