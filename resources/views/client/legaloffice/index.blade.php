@extends('layouts.client.layout')
@section('title')
<title>LegalPath-Legaloffices</title>
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
                    <h1>{{ $navigation->legaloffice }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $navigation->legaloffice }}</span></li>
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
                <form action="{{ url('search-legaloffice') }}">

                    <div class="s-box">
                        <select name="location" class="form-control select2">
                            <option value="">{{ $website_lang->where('lang_key','select_location')->first()->custom_lang }}</option>
                            @foreach ($locations as $location)
                            <option {{ @$location_id==$location->id?'selected':'' }} value="{{ $location->id }}">{{ ucwords($location->location) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="s-box">
                        <select name="office" class="form-control select2">
                            <option value="">Select Office</option>
                            @foreach ($offices as $office)
                            <option {{ @$office_id==$office->id?'selected':'' }} value="{{ $office->id }}">{{ ucwords($office->office) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="s-box">
                        <select name="legaloffice" class="form-control select2">
                            <option value="">Select Legal Office</option>
                            @foreach ($legalForSearch as $legal)
                            <option {{ @$legaloffice_id==$legal->id?'selected':'' }} value="{{ $legal->id }}">{{ $legal->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="s-button">
                        <button type="submit">{{ $website_lang->where('lang_key','search')->first()->custom_lang }}</button>
                    </div>
                </form>
                </div>

            </div>
        </div>
    </div>
</div>




<!--Service Start-->
<div class="team-page pt_40 pb_70">
    <div class="container">
        <div class="row">

            @if ($legals->count()!=0)
            @foreach ($legals as $index => $legal)
            <div class="col-lg-3 col-md-4 col-6 mt_30">
                <div class="team-item">
                    <div class="team-photo">
                        <img src="{{ url($legal->image) }}" alt="Team Photo">
                    </div>
                    <div class="team-text">
                        <a href="{{ url('legaloffice-details/'.$legal->slug) }}">{{ $legal->name }}</a>
                        <p></p>
                        <p><span><i class="fas fa-graduation-cap"></i> {{ ucfirst($legal->type->office) }}</span></p>
                        <p><span><b><i class="fas fa-street-view"></i> {{ ucfirst($legal->location->location) }}</b></span></p>
                    </div>
                    <div class="team-social">
                        <ul>
                            @if ($legal->facebook)
                            <li><a href="{{ $legal->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                            @endif
                            @if ($legal->twitter)
                            <li><a href="{{ $legal->twitter }}"><i class="fab fa-twitter"></i></a></li>
                            @endif
                            @if ($legal->linkedin)
                            <li><a href="{{ $legal->linkedin }}"><i class="fab fa-linkedin"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <h3 class="text-danger text-center">Legal office not found</h3>
            @endif


        </div>
        {{ @$legals->links('client.paginator') }}
    </div>
</div>
<!--Service End-->






@endsection
