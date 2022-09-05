@extends('layouts.admin.layout')
@section('title')
<title>{{ $email->name }}</title>
@endsection
@section('admin-content')
<a href="{{ route('admin.email.template') }}" class="btn btn-success mb-2"><i class="fas fa-backward" aria-hidden="true"></i> {{ $website_lang->where('lang_key','go_back')->first()->custom_lang }}</a>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $email->name }}</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>{{ $website_lang->where('lang_key','variable')->first()->custom_lang }}</th>
                            <th>{{ $website_lang->where('lang_key','meaning')->first()->custom_lang }}</th>
                        </thead>
                        <tbody>
                            <tr>
                                @php
                                    $client_name="{{name}}";
                                @endphp
                                <td>{{ $client_name }}</td>
                                <td>{{ $website_lang->where('lang_key','client_name')->first()->custom_lang }}</td>
                            </tr>
                            <tr>
                                @php
                                    $client_email="{{email}}";
                                @endphp
                                <td>{{ $client_email }}</td>
                                <td>{{ $website_lang->where('lang_key','client_email')->first()->custom_lang }}</td>
                            </tr>

                            <tr>
                                @php
                                    $client_phone="{{phone}}";
                                @endphp
                                <td>{{ $client_phone }}</td>
                                <td>{{ $website_lang->where('lang_key','client_phone')->first()->custom_lang }}</td>
                            </tr>
                            <tr>
                                @php
                                    $subject="{{subject}}";
                                @endphp
                                <td>{{ $subject }}</td>
                                <td>{{ $website_lang->where('lang_key','msg_subject')->first()->custom_lang }}</td>
                            </tr>

                            <tr>
                                @php
                                    $message="{{message}}";
                                @endphp
                                <td>{{ $message }}</td>
                                <td>{{ $website_lang->where('lang_key','message')->first()->custom_lang }}</td>
                            </tr>




                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">

                    <form action="{{ route('admin.email.update',$email->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">{{ $website_lang->where('lang_key','subject')->first()->custom_lang }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $email->subject }}" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="">{{ $website_lang->where('lang_key','description')->first()->custom_lang }} <span class="text-danger">*</span></label>
                            <textarea name="description" cols="30" rows="10" class="form-control summernote">{{ $email->description }}</textarea>

                        </div>

                        <button class="btn btn-success" type="submit">{{ $website_lang->where('lang_key','update')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

