@extends('layouts.client.layout')
@section('title')
<title>LegalPath-Case</title>
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
                    <h1>{{ $navigation->story }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $navigation->story }}</span></li>
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
            @foreach ($stories as $story)
            <div class="col-lg-4 col-sm-6">
                <div class="blog-item">
                    <div class="blog-image">
                       
                        <img src="/uploads/pdf/{{($story->image) }}" alt="">
                        
                    </div>
                    <div class="blog-author">
                        <span><i class="fas fa-user"></i>Client</span>
                        <span><i class="far fa-calendar-alt"></i> {{ date('d F, Y', strtotime($story->created_at->format('Y-m-d'))) }}</span>
                    </div>
                    <div class="blog-text">
                        <h3><a href="{{ url('case-details/'.$story->title) }}">{{ $story->title }}</a></h3>
                        <p>
                            {{ $story->description }}

                        </p>


                        @if ($isRtl=='RTL')
                            <a class="sm_btn" href="{{ url('case-details/'.$story->title) }}">{{ $website_lang->where('lang_key','learn_more')->first()->custom_lang }} ←</a>
                            @else
                            <a class="sm_btn" href="{{ url('case-details/'.$story->title) }}">{{ $website_lang->where('lang_key','learn_more')->first()->custom_lang }} →</a>
                            @endif

                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <!--Pagination Start-->
        {{ @$stories->links('client.paginator') }}
        <!--Pagination End-->
    </div>
</div>
<!--Blog End-->





@endsection
