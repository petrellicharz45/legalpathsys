@extends('layouts.client.layout')
@section('title')
<title>{{ $libraries->book_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $libraries->book_title }}">
@endsection
@section('client-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->department ? url($banner->department) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $libraries->book_title }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $libraries->book_title }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->


<div class="team-detail-page pt_40 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="team-detail-photo">
                    <img src="{{ url($libraries->image) }}" alt="Team Photo">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="team-detail-text">
                    <h6> BOOK TITLE: </h6><h4>{{ $libraries->book_title }} </h4>
                    <h6>AUTHOR:</h6><span><b> {{ $libraries->author }}</b></span>
                   <!--<a href="/uploads/pdf/{{$libraries->pdf}}" download=""><button type="submit" class="btn btn-success">Download Pdf</button></a>-->
                    
                   <a target="_blank" href="{{ url('view/'.$libraries->pdf) }}"><button type="submit" class="btn btn-info">Read Book</button></a>
                    <h4>Views <span class="c-number">({{$libraries->view_count}} )</span></h4>
                   
                </div>
            </div>
        </div>
    </div>
</div>









@endsection
