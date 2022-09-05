@extends('layouts.legaloffice.layout')
@section('title')
<title>{{ $website_lang->where('lang_key','profile')->first()->custom_lang }}</title>
@endsection
@section('lawyer-content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ $website_lang->where('lang_key','profile')->first()->custom_lang }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ $website_lang->where('lang_key','change_password')->first()->custom_lang }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="prescription-tab" data-toggle="tab" href="#prescription" role="tab" aria-controls="prescription" aria-selected="false">{{ $website_lang->where('lang_key','prescription_contact')->first()->custom_lang }}</a>
                    </li>

                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active mt-5" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form action="{{ route('legaloffice.update.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">{{ $website_lang->where('lang_key','exist_image')->first()->custom_lang }}:</label>
                                <img src="{{ url($legals->image) }}" alt="doctor image" width="100px" class="img-thumbnail ml-3">
                            </div>
                            <div class="form-group">
                                <label for="image">{{ $website_lang->where('lang_key','new_image')->first()->custom_lang }}</label>
                                <input type="file" class="form-control-file" name="image" id="image">
                                <input type="hidden" name="old_image" value="{{ $legals->image }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ $website_lang->where('lang_key','name')->first()->custom_lang }}</label>
                                        <input type="text" name="name" class="form-control" id="name" value="{{ ucfirst($legals->name) }}">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ $website_lang->where('lang_key','email')->first()->custom_lang }}</label>
                                        <input type="text" class="form-control" id="email" value="{{ $legals->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">{{ $website_lang->where('lang_key','phone')->first()->custom_lang }}</label>
                                        <input type="text" name="phone" class="form-control" id="phone" value="{{$legals->phone }}">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="designations">{{ $website_lang->where('lang_key','designation')->first()->custom_lang }} *</label>
                                    <select name="office" id="office" class="form-control">
                                        <option value="">select_office</option>
                                        @foreach ($offices as $item)
                                        <option {{ $legals->office==$item->id? 'selected' : ''}} value="{{ $item->id }}">{{ $item->office }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                               
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="location">{{ $website_lang->where('lang_key','location')->first()->custom_lang }}</label>
                                        <input type="text" value="{{ $legals->location->location }}" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="facebook">{{ $website_lang->where('lang_key','facebook')->first()->custom_lang }}</label>
                                        <input type="text" class="form-control" name="facebook" id="facebook" value="{{ $legals->facebook }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="twitter">{{ $website_lang->where('lang_key','twitter')->first()->custom_lang }}</label>
                                        <input type="text" class="form-control" name="twitter" id="twitter" value="{{ $legals->twitter }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="linkedin">{{ $website_lang->where('lang_key','linkedin')->first()->custom_lang }}</label>
                                        <input type="text" class="form-control" name="linkedin" id="linkedin" value="{{ $legals->linkedin }}">
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="about">{{ $website_lang->where('lang_key','about')->first()->custom_lang }}</label>
                                        <textarea name="about" id="about" cols="30" rows="5" class="form-control">{{ $legals->about }}</textarea>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">{{ $website_lang->where('lang_key','address')->first()->custom_lang }}</label>
                                        <textarea name="address" id="address" class="summernote">{{ $legals->address }}</textarea>

                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="experiences">{{ $website_lang->where('lang_key','experience')->first()->custom_lang }}</label>
                                        <textarea name="experiences" id="experiences" class="summernote">{{ $legals->experience }}</textarea>

                                    </div>
                                </div>

                              

                            </div>

                            <button type="submit" class="btn btn-success">{{ $website_lang->where('lang_key','update')->first()->custom_lang }}</button>
                        </form>
                    </div>
                    <div class="tab-pane fade mt-5" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form action="{{ route('legaloffice.change.password') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{ $website_lang->where('lang_key','password')->first()->custom_lang }}</label>
                                        <input type="password" name="password" class="form-control">

                                    </div>
                                    <div class="form-group">
                                        <label for="">{{ $website_lang->where('lang_key','confirm_pass')->first()->custom_lang }}</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-success">{{ $website_lang->where('lang_key','update')->first()->custom_lang }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="tab-pane fade mt-5" id="prescription" role="tabpanel" aria-labelledby="prescription-tab">
                        <form action="{{ route('legaloffice.update.prescription') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{ $website_lang->where('lang_key','email')->first()->custom_lang }}</label>
                                        <input type="email" name="prescription_email" class="form-control" value="{{ $legals->prescription_email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{ $website_lang->where('lang_key','phone')->first()->custom_lang }}</label>
                                        <input type="text" name="prescription_phone" class="form-control" value="{{ $legals->prescription_phone }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{ $website_lang->where('lang_key','address')->first()->custom_lang }}</label>
                                        <input type="text" name="prescription_address" class="form-control" value="{{ $legals->prescription_address }}">
                                    </div>
                                    <button type="submit" class="btn btn-success">{{ $website_lang->where('lang_key','update')->first()->custom_lang }}</button>
                                </div>
                            </div>

                        </form>
                    </div>


                  </div>
            </div>
        </div>
    </div>
</div>

@endsection
