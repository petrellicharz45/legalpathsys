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
                    <a href="/uploads/pdf/{{$libraries->pdf}}" download=""><button type="submit" class="btn btn-success">Download Pdf</button></a>
                    <a href="{{ url('view/'.$libraries->pdf) }}"><button type="submit" class="btn btn-info">Read</button></a>

                   
                </div>
            </div>
        </div>
    </div>
</div>



@if ($lawyers->count()!=0)
<div class="team-page pt_40 pb_70 bg_f2f2f2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wow fadeInDown" data-wow-delay="0.1s">
                <div class="main-headline">
                    <h1>{{ $website_lang->where('lang_key','department_lawyers')->first()->custom_lang }}</h1>
                    <p>{{ $description }}</p>
                </div>
            </div>
        </div>


        <div class="row">

            @if ($lawyers->count()!=0)
            @foreach ($lawyers as $lawyer)
            <div class="col-lg-3 col-md-4 col-6 mt_30">
                <div class="team-item">
                    <div class="team-photo">
                        <img src="{{ url($lawyer->image) }}" alt="Team Photo">
                    </div>
                    <div class="team-text">
                        <a href="{{ url('lawyer-details/'.$lawyer->slug) }}">{{ ucfirst($lawyer->name) }}</a>
                        <p>{{ ucfirst($lawyer->department->name) }}</p>
                        <p><span><i class="fas fa-graduation-cap"></i> {{ $lawyer->designations }}</span></p>
                        <p><span><b><i class="fas fa-street-view"></i> {{ ucfirst($lawyer->location->location) }}</b></span></p>
                    </div>
                    <div class="team-social">
                        <ul>
                            @if ($lawyer->facebook)
                            <li><a href="{{ $lawyer->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                            @endif
                            @if ($lawyer->twitter)
                            <li><a href="{{ $lawyer->twitter }}"><i class="fab fa-twitter"></i></a></li>
                            @endif
                            @if ($lawyer->linkedin)
                            <li><a href="{{ $lawyer->linkedin }}"><i class="fab fa-linkedin"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <h3 class="text-danger text-center">{{ $website_lang->where('lang_key','lawyer_not_found')->first()->custom_lang }}</h3>
            @endif


        </div>
    </div>
</div>
@endif





@endsection
