@extends('layouts.client.layout')
@section('title')
<title>{{ $navigation->dashboard }}</title>
@endsection
@section('client-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->profile ? url($banner->profile) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{$user->account_type}} {{ $navigation->dashboard }}</h1>
                    <ul>
                        <li><a href="index.php">{{ $navigation->home }}</a></li>
                        <li><span>{{ $navigation->dashboard }}</span></li>
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
            @if ($user->account_type=='Client')
            <div class="col-lg-9">
                <div class="detail-dashboard">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <div class="dash-item db-blue flex mb_30">
                                <i class="fas fa-handshake"></i>
                                <h4>{{ $website_lang->where('lang_key','total_order')->first()->custom_lang }}</h4>
                                <h2>{{ $orders->count() }}</h2>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="dash-item db-red flex mb_30">
                                <i class="fas fa-hourglass-start"></i>
                                <h4>{{ $website_lang->where('lang_key','pending_appointment')->first()->custom_lang }}</h4>
                                <h2>{{ $orders->where('payment_status',0)->count() }}</h2>

                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="dash-item db-blue flex mb_30">
                                <i class="fas fa-check-circle"></i>
                                <h4>{{ $website_lang->where('lang_key','total_appointment')->first()->custom_lang }}</h4>
                                <h2>{{ $appointments->count() }}</h2>
                            </div>
                        </div>
                      
  
                        <div class="col-lg-4 col-sm-6">
                <div class="sidebar float-right">
                    <div class="sidebar-item">
                        <h3>My Cases</h3>
                     
                        @foreach ($stories as $item)
                        <div class="blog-recent-item">
                                <div class="blog-recent-photo">
                                    <a href="{{ url('story-details/'.$item->title) }}"><img src="/uploads/pdf/{{($item->image) }}" alt=""></a>
                                </div>
                                <div class="blog-recent-text">
                                    <a href="{{ url('story-details/'.$item->title) }}">{{ $item->title }}</a>
                                    <div class="blog-post-date">{{ $item->created_at->format('m-d-Y') }}</div>
                                </div>
                            </div>
                           


         

                    </div>
                   
                        @endforeach
                        <div class="sidebar-item">
                        <h3>Other Cases</h3>
                     
                        @foreach ($others as $item)
                        <div class="blog-recent-item">
                                <div class="blog-recent-photo">
                                    <a href="{{ url('story-details/'.$item->title) }}"><img src="/uploads/pdf/{{($item->image) }}" alt=""></a>
                                </div>
                                <div class="blog-recent-text">
                                    <a href="{{ url('story-details/'.$item->title) }}">{{ $item->title }}</a>
                                    <div class="blog-post-date">{{ $item->created_at->format('m-d-Y') }}</div>
                                </div>
                            </div>
                           


         

                    </div>
                   
                        @endforeach


                        @else
                        <div class="col-lg-4"></div>
                

                        <div class="col-lg-4">
                <div class="sidebar">
                    <div class="sidebar-item">
                        <h3>My Books</h3>
                        @foreach ($mybooks as $index)
                            <div class="blog-recent-item">
                                <div class="blog-recent-photo">
                                    <a href="{{ url('library-details/'.$index->book_title) }}"><img src="{{ url($index->image) }}" alt=""></a>
                                </div>
                                <div class="blog-recent-text">
                                    <a href="{{ url('library-details/'.$index->book_title) }}">{{ $index->book_title }}</a>
                                    
                                </div>
                            </div>
                        @endforeach

                        <div class="sidebar-item">
                        <h3>Suggested Books</h3>
                        @foreach ($books as $index)
                            <div class="blog-recent-item">
                                <div class="blog-recent-photo">
                                    <a href="{{ url('library-details/'.$index->book_title) }}"><img src="{{ url($index->image) }}" alt=""></a>
                                </div>
                                <div class="blog-recent-text">
                                    <a href="{{ url('library-details/'.$index->book_title) }}">{{ $index->book_title }}</a>
                                    
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>
                <!--Sidebar End-->
            </div>
                   
                      

                        

@endif

                    </div>
                </div>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</div>
<!--Dashboard End-->


@endsection
