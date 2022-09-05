@extends('layouts.client.layout')
@section('title')
<title>LegalPath-Case</title>
@endsection
@section('client-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->profile ? url($banner->profile) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Case Information</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>Case Information</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Dashboard Start-->
<div class="dashboard-area pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('client.profile.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="detail-dashboard add-form">
                    <h2 class="d-headline">Case Information</h2>
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
    </section>  <br>  <br>  <br>
                    <form action="{{ route('client.story.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="book">Case Title *</label>
                                    <input type="text" name="title" class="form-control" id="book_title"  value="{{ old('book_title') }}">
                                </div>
                            </div>
                           
            
                        
                           <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">Case Category *</label>
                                    <select name="case_category_id" id="category" class="form-control">
                                        <option value="">{{ $website_lang->where('lang_key','select_category')->first()->custom_lang }}</option>
                                        @foreach ($categories as $item)
                                        <option {{ old('category')==$item->id? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                     
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Upload image</label>
                                    <input type="file" name="image" class="form-control" id="image" >
                                </div>
                            </div>

                        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" rows="4" cols="50" class="form-control"></textarea>
                                </div>
                            </div>
                   
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                    </form>
                    
    
    <script src="{{asset('client/js/demo.js')}}"></script>
      <script src="{{asset('client/js/RecordRTC.js')}}"></script>
  <script src="{{asset('client/js/gif-recorder.js')}}"></script>
  <script src="{{asset('client/js/getScreenId.js')}}"></script>

  
  <script src="{{asset('client/js/gumadapter.js')}}"></script>

                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->
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