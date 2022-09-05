@extends('layouts.client.layout')
@section('title')
<title>LegalPath_opportunity</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->blog_meta_description }}">
@endsection
@section('client-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->blog ? url($banner->blog) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $navigation->opportunity }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $navigation->opportunity }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Blog Start-->
<div class="blog-page pt_40 pb_90">
    <div class="container">
        <div class="row">
            @foreach ($opportunity as $opportunity)
            <div class="col-lg-4 col-sm-6">
                <div class="blog-item">
                    <div class="blog-author">
                      
                        <span><i class="far fa-calendar-alt"></i> Closing Date:  {{($opportunity->closing_date) }}</span>
                    </div>
                    <div class="blog-text">
                        
                    <h3>Job Title:   <a href="{{ url('opportunity-details/'.$opportunity->id) }}">{{ $opportunity->title }}</a></h3>
                      <h6>Company Name:  {{$opportunity->company}}</h6> 
                    
                    <h5>Description</h5>
                    <p>      {!! clean($opportunity->description) !!}

                        </p>


                        @if ($opportunity->quick_apply=='1')
                            <a class="sm_btn" href="{{ url('application/'.$opportunity->id) }}">Quick Apply ←</a>
                            @else
                            <a target="_blank" class="sm_btn" href="{{ $opportunity->apply_link}}">Apply →</a>
                            @endif

                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <!--Pagination Start-->

        <!--Pagination End-->
    </div>
</div>
<!--Blog End-->



@endsection
