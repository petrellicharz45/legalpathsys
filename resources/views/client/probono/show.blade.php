@extends('layouts.client.layout')
@section('title')
<title>{{ @$probonos->title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ @$blog->seo_description }}">
@endsection

<script type="text/javascript" src="{{asset('client/js/demo.js')}}"></script>
      <script type="text/javascript" src="{{asset('client/js/RecordRTC.js')}}"></script>
  <script type="text/javascript" src="{{asset('client/js/gif-recorder.js')}}"></script>
  <script type="text/javascript" src="{{asset('client/js/getScreenId.js')}}"></script>
   <script type="text/javascript" src="{{asset('client/js/gumadapter.js')}}"></script>

@section('client-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->blog ? url($banner->blog) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $probonos->title }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><a href="{{ url('/probono') }}">{{ $navigation->probono }}</a></li>
                        <li><span>{{ $probonos->title }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Blog Start-->
<div class="blog-page single-blog pt_40 pb_90">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-item">
                    <div class="single-blog-image">
                        <img src="/uploads/pdf/{{($probonos->image) }}" alt="">
                        <div class="blog-author">
                            <span><i class="fas fa-user"></i>Admin</span>
                            <span><i class="far fa-calendar-alt"></i> {{ $probonos->created_at->format('m-d-Y') }}</span>
                            <span><i class="fas fa-tag" aria-hidden="true"></i> <a href="{{ url('story-category/'.$probonos->category->title) }}" class="text-white"> {{ $probonos->category->name }}</a></span>
                        </div>
                    </div>
                    <div class="blog-text pt_40">
                        <p>
                            {!! clean($probonos->title) !!}
                        </p>

                        {!! clean($probonos->description) !!}
                    </div>
                </div>
              
                    
              
            </div>
        </div>
    </div>
</div>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0&appId={{ $setting->facebook_comment_script }}&autoLogAppEvents=1" nonce="MoLwqHe5"></script>
@endsection


  
 
  <style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    top: 0;
}
.imgs{
        margin: .5em;
        max-width: calc(100%);
        max-height: calc(100%);
    }
    .imgs img{
        max-width: calc(100%);
        max-height: calc(100%);
        cursor: pointer;
    }
    #imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
        height: 60vh !important;background: black;
    }
    #imagesCarousel .carousel-item.active{
        display: flex !important;
    }
    #imagesCarousel .carousel-item-next{
        display: flex !important;
    }
    #imagesCarousel .carousel-item img{
        margin: auto;
    }
    #imagesCarousel img{
        width: auto!important;
        height: auto!important;
        max-height: calc(100%)!important;
        max-width: calc(100%)!important;
    }
    .vid-item{
        cursor: pointer;
        position: relative;
    }
    .watch{
        position: absolute;
        top: 0;
        left: 0;
        height: calc(100%);
        width: calc(100%);
        opacity: 0;
        background: #00000052;
    }
    .vid-item:hover .watch{
        opacity: 1;
    }
</style>
<script>
    $('.suggested').hover(function(){
        $(this).addClass('active')
        var vid = $(this).find('video')
        var id = vid.get(0).id;
            setTimeout(function(){
                vid.trigger('play')
                document.getElementById(id).playbackRate = 2.0
            },500)
    })
    $('.suggested').mouseout(function(){
        var vid = $(this).find('video')
            setTimeout(function(){
                vid.trigger('pause')
            },500)
    })
</script>