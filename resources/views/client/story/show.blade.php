@extends('layouts.client.layout')
@section('title')
<title>{{ @$story->title }}</title>
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
                    <h1>{{ $story->title }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><a href="{{ url('/blog') }}">{{ $navigation->story }}</a></li>
                        <li><span>{{ $story->title }}</span></li>
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
                        <img src="/uploads/pdf/{{($story->image) }}" alt="">
                        <div class="blog-author">
                            <span><i class="fas fa-user"></i>Client</span>
                            <span><i class="far fa-calendar-alt"></i> {{ $story->created_at->format('m-d-Y') }}</span>
                            <span><i class="fas fa-tag" aria-hidden="true"></i> <a href="{{ url('story-category/'.$story->category->title) }}" class="text-white"> {{ $story->category->name }}</a></span>
                        </div>
                    </div>
                    <div class="blog-text pt_40">
                        <p>
                            {!! clean($story->description) !!}
                        </p>

                        {!! clean($story->description) !!}
                    </div>
                </div>
                @if ($setting->comment_type==0)
                <div class="comment-list mt_30">
                    <h4>{{ $website_lang->where('lang_key','comments')->first()->custom_lang }}</h4>
                </div>
                <div class="fb-comments" data-href="{{ Request::url() }}" data-width="" data-numposts="10"></div>
                @else
                <div class="comment-list mt_30">
                    @if ($story->comments->where('status',1)->count() !=0)
                        <h4>{{ $website_lang->where('lang_key','comments')->first()->custom_lang }} <span class="c-number">({{ $story->comments->where('status',1)->count() }})</span></h4>
                    @endif

                    <ul>
                        @foreach ($story->comments->where('status',1) as $comment)
                        <li>
                            <div class="comment-item">
                                <div class="thumb">
                                    @php
                                    $gravatar_link = 'http://www.gravatar.com/avatar/' . md5($comment->email) . '?s=32';
                                    header("content-type: image/jpeg");
                                    @endphp
                                    <img src="{{ $gravatar_link }}" alt="">
                                </div>
                                <div class="com-text">
                                    <h5>{{ ucwords($comment->name) }}</h5>
                                    <span class="date"><i class="fas fa-calendar"></i>{{ date('d F, Y', strtotime($comment->created_at->format('Y-m-d'))) }}</span>
                                    <p>
                                        {{ $comment->comment }}
                                    </p>
                                    <video height="100px" controls> 
      <source src="/uploads/pdf/{{ $comment->file }}" type="video/mp4"> 
                                </div>
                            </div>
                        </li>

                        @endforeach

                    </ul>
                </div>
                <div class="comment-form mt_30">
                    <h4>{{ $website_lang->where('lang_key','submit_comment')->first()->custom_lang }}</h4>
                    <form method="POST" action="{{ url('story-store') }}" enctype="multipart/form-data">
                        @csrf
                        @auth
                        <div class="form-row row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="name" placeholder="{{ $website_lang->where('lang_key','name')->first()->custom_lang }}" value="{{$user->name }}">
                                <input type="hidden" class="form-control" name="story_id" value="{{ $story->id }}" value="{{ old('name') }}">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="email" placeholder="{{ $website_lang->where('lang_key','email')->first()->custom_lang }}" value="{{ $user->email }}">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" value="{{$user->phone }}" class="form-control" name="phone" placeholder="{{ $website_lang->where('lang_key','phone')->first()->custom_lang }}">
                            </div>
                            @else
                            <div class="form-row row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="name" placeholder="{{ $website_lang->where('lang_key','name')->first()->custom_lang }}" value="{{old('name') }}">
                                <input type="hidden" class="form-control" name="story_id" value="{{ $story->id }}" value="{{ old('name') }}">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="email" placeholder="{{ $website_lang->where('lang_key','email')->first()->custom_lang }}" value="{{ old('email') }}">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" value="{{old('phone') }}" class="form-control" name="phone" placeholder="{{ $website_lang->where('lang_key','phone')->first()->custom_lang }}">
                            </div>
                            @endauth
                            <div class="form-group col-12">
                                <textarea class="form-control" name="comment" placeholder="{{ $website_lang->where('lang_key','comment')->first()->custom_lang }}">{{ old('comment') }}</textarea>
                            </div>
                            <div class="form-group col-md-12">
                            <input type="file" name="image" class="form-control" id="image" >
</div>
                            @if($setting->allow_captcha==1)
                            <div class="form-group col-12">
                                <div class="g-recaptcha" data-sitekey="{{ $setting->captcha_key }}"></div>
                            </div>
                            @endif

                           
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn">{{ $website_lang->where('lang_key','submit')->first()->custom_lang }}</button>
                            </div>
                        </div>
                    </form>
                    <section class="experiment recordrtc">
      <h2 class="header">
        <select class="recording-media">
          <option value="record-video">Video</option>
          <option value="record-audio">Audio</option>
          <option value="record-screen">Screen</option>
        </select>

        into
        <select class="media-container-format">
          <option>WebM</option>
          <option disabled>Mp4</option>
          <option disabled>WAV</option>
          <option disabled>Ogg</option>
        </select>

        <button>Start Recording</button>
      </h2>
       <div style="text-align: center; display: none;">
        <button id="save-to-disk">Save To Disk</button>
        
      </div>


  <video controls name="vidoe" id="video"></video>

      <br>

    
    </section>
    
    <script src="{{asset('client/js/demo.js')}}"></script>
      <script src="{{asset('client/js/RecordRTC.js')}}"></script>
  <script src="{{asset('client/js/gif-recorder.js')}}"></script>
  <script src="{{asset('client/js/getScreenId.js')}}"></script>

  
  <script src="assets/js/gumadapter.js"></script>
                </div>
                @endif

            </div>
            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="sidebar-item">
                        <h3>Case category</h3>
                        <ul>
                            @foreach ($storyCategories as $category)
                                <li class="{{ $story->case_category_id==$category->id ? 'active' :'' }}"><a href="{{ url('story-category/'.$category->title) }}"><i class="fas fa-chevron-right"></i>{{ $category->name }}</a></li>
                            @endforeach


                        </ul>
                    </div>
                    <div class="sidebar-item">
                        <h3>{{ $website_lang->where('lang_key','recent_posts')->first()->custom_lang }}</h3>
                        @foreach ($latestStory as $item)
                            <div class="blog-recent-item">
                                <div class="blog-recent-photo">
                                    <a href="{{ url('story-details/'.$item->title) }}"><img src="/uploads/pdf/{{($item->image) }}" alt=""></a>
                                </div>
                                <div class="blog-recent-text">
                                    <a href="{{ url('story-details/'.$item->title) }}">{{ $item->title }}</a>
                                    <div class="blog-post-date">{{ $item->created_at->format('m-d-Y') }}</div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
                <!--Sidebar End-->
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