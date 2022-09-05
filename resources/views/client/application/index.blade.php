@extends('layouts.client.layout')
@section('title')
<title>LegalPath_Application
</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->lawyer_meta_description }}">
@endsection
@section('client-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->lawyer ? url($banner->lawyer) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Job Title:  {{ $opportunity->title }}</h1>
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


<div class="comment-form mt_30">
            <div class="col-md-10 ">

                <div class="container">
                <form method="POST" action="{{ url('application-store') }}" enctype="multipart/form-data">
                        @csrf
                    
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="{{ $website_lang->where('lang_key','name')->first()->custom_lang }}" value="{{$user->name }}">
                                <input type="hidden" class="form-control" name="job_id" value="{{$opportunity->id}}">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="email" placeholder="{{ $website_lang->where('lang_key','email')->first()->custom_lang }}" value="{{ $user->email }}">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" value="{{$user->phone }}" class="form-control" name="phone" placeholder="{{ $website_lang->where('lang_key','phone')->first()->custom_lang }}">
                            </div>
                        
                            <div class="form-group col-md-6">
                                <lable>Attach CV</lable>
                                <input type="file" value="" class="form-control" name="cv" >
                            </div>
                            <div class="form-group col-md-6">
                            <lable>Attach Cover Letter</lable>
                                <input type="file" value="" class="form-control" name="application">
                            </div>
                        
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn">{{ $website_lang->where('lang_key','submit')->first()->custom_lang }}</button>
                            </div>
                        
                        </div>
                    </form>
                </div>

            </div>
        </div>
    






@endsection
