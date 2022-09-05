@extends('layouts.legaloffice.layout')
@section('title')
<title>{{ $website_lang->where('lang_key','prescription')->first()->custom_lang }}</title>
@endsection
@section('lawyer-content')
<div class="card shadow mb-4">
    <div class="card-body" id="search-particular-appointment">
        <div class="prescription">
            <div class="top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="logo"><img src="{{ url($setting->logo) }}" alt=""></div>
                        @if ( $legals->prescription_address)
                            <div class="address">
                                <i class="fas fa-map-marker-alt"></i> {{ $legals->prescription_address }}
                            </div>
                        @endif

                        @if ($legals->prescription_phone)
                        <div class="phone">
                            <i class="fas fa-phone"></i> {{ $legals->prescription_phone }}
                        </div>
                        @endif

                        @if ($legals->prescription_email)
                        <div class="email">
                            <i class="far fa-envelope"></i>  {{ $legals->prescription_email }}
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="right">
                            <h2>{{ $appointment->legals->name }}</h2>
                            <p>
                                {{ $appointment->legals->designations }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="patient-info">
                <div class="row">
                    <div class="col-md-6">
                        {{ $website_lang->where('lang_key','name')->first()->custom_lang }}: {{ $appointment->user->name }}
                    </div>
                    <div class="col-md-3">
                        {{ $website_lang->where('lang_key','email')->first()->custom_lang }}: {{ $appointment->user->email }}
                    </div>
                    <div class="col-md-3 text-right">
                        {{ $website_lang->where('lang_key','date')->first()->custom_lang }}: {{ date('m-d-Y',strtotime($appointment->date)) }}
                    </div>
                </div>
            </div>


            <div class="main-section">
                <h4>{{ $website_lang->where('lang_key','subject')->first()->custom_lang }}: {{ $appointment->prescription->subject }}</h4>
                <p class="test">{!! clean($appointment->prescription->description) !!}</p>


                @if ($appointment->prescription->prescriptionFile->count()>0)
                <div class="lawyer-doc-file">
                    <hr>
                    <h4>{{ $website_lang->where('lang_key','important_doc')->first()->custom_lang }}: </h4>
                    <ol>
                        @foreach ($appointment->prescription->prescriptionFile as $item)
                            <li><a href="{{ route('legaloffice.download-doc',$item->file) }}">{{ $item->file }}</a></li>
                        @endforeach


                    </ol>
                </div>
                @endif
            </div>

            <div class="footer">
                <h2>{{ $website_lang->where('lang_key','signature')->first()->custom_lang }}</h2>
                <p>
                    {{ $appointment->legals->name }}<br> {{ $appointment->legals->office }}
                </p>
            </div>




        </div>
        <div class="mt-4 print-section">
            <button class="btn btn-success" onclick="window.print()">{{ $website_lang->where('lang_key','print')->first()->custom_lang }}</button>
            <a class="btn btn-primary" href="{{ route('legaloffice.edit-prescription',$appointment->id) }}">Edit</a>
        </div>
    </div>


</div>

@endsection
