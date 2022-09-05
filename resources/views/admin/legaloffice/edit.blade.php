@extends('layouts.admin.layout')
@section('title')
<title>Legal Office</title>
@endsection
@section('admin-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.legaloffice.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> All Legal Offices </a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Legaloffice_Form</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.legaloffice.update',$legals->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ $website_lang->where('lang_key','name')->first()->custom_lang }} *</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ $legals->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">{{ $website_lang->where('lang_key','email')->first()->custom_lang }} *</label>
                                    <input type="text" name="email" class="form-control" id="email" value="{{ $legals->email }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">{{ $website_lang->where('lang_key','phone')->first()->custom_lang }} *</label>
                                    <input type="text" name="phone" class="form-control" id="phone" value="{{ $legals->phone }}">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">{{ $website_lang->where('lang_key','image')->first()->custom_lang }}</label>
                                    <input type="file" name="image" class="form-control" id="image" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">{{ $website_lang->where('lang_key','exist_image')->first()->custom_lang }}</label>
                                    <img src="{{ url($legals->image) }}" alt="doctor image" width="120px">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="appointment_fee">{{ $website_lang->where('lang_key','appointment_fee')->first()->custom_lang }} *</label>
                                    <input type="text" name="appointment_fee" class="form-control" id="appointment_fee"  value="{{ $lawyer->fee }}">
                                </div>
                            </div>




                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="office">Office *</label>
                                    <select name="office" id="office" class="form-control">
                                        <option value="">select_office</option>
                                        @foreach ($offices as $item)
                                        <option {{ $legals->office_id==$item->id? 'selected' : ''}} value="{{ $item->id }}">{{ $item->office }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="location">{{ $website_lang->where('lang_key','location')->first()->custom_lang }} *</label>
                                    <select name="location" id="location" class="form-control">
                                        <option value="">{{ $website_lang->where('lang_key','select_location')->first()->custom_lang }}</option>
                                        @foreach ($locations as $item)
                                        <option {{ $lawyer->location_id==$item->id? 'selected' : ''}} value="{{ $item->id }}">{{ $item->location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="facebook">{{ $website_lang->where('lang_key','facebook')->first()->custom_lang }}</label>
                                    <input type="text" class="form-control" name="facebook" id="facebook" value="{{ $lawyer->facebook }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="twitter">{{ $website_lang->where('lang_key','twitter')->first()->custom_lang }}</label>
                                    <input type="text" class="form-control" name="twitter" id="twitter" value="{{ $lawyer->twitter }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="linkedin">{{ $website_lang->where('lang_key','linkedin')->first()->custom_lang }}</label>
                                    <input type="text" class="form-control" name="linkedin" id="linkedin" value="{{ $lawyer->linkedin }}">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ $website_lang->where('lang_key','status')->first()->custom_lang }} *</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $lawyer->status==1 ? 'selected':'' }} value="1">{{ $website_lang->where('lang_key','active')->first()->custom_lang }}</option>
                                        <option {{ $lawyer->status==0 ? 'selected':'' }} value="0">{{ $website_lang->where('lang_key','inactive')->first()->custom_lang }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="show_homepage">{{ $website_lang->where('lang_key','show_homepage')->first()->custom_lang }} *</label>
                                    <select name="show_homepage" id="show_homepage" class="form-control">
                                        <option {{ $legals->show_homepage==0 ? 'selected':'' }} value="0">{{ $website_lang->where('lang_key','no')->first()->custom_lang }}</option>
                                        <option {{ $legals->show_homepage==1 ? 'selected':'' }}  value="1">{{ $website_lang->where('lang_key','yes')->first()->custom_lang }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="seo_title">{{ $website_lang->where('lang_key','seo_title')->first()->custom_lang }}</label>
                                    <input type="text" name="seo_title" class="form-control" id="seo_title" value="{{ $legals->seo_title }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="seo_description">{{ $website_lang->where('lang_key','seo_description')->first()->custom_lang }}</label>
                                    <textarea name="seo_description" id="seo_description" cols="30" rows="3" class="form-control" >{{ $legals->seo_description }}</textarea>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-success">{{ $website_lang->where('lang_key','update')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
