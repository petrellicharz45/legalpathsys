@extends('layouts.admin.layout')
@section('title')
<title>Probono Cases</title>
@endsection
@section('admin-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.probono.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> All Probono Cases</a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Probono Case Form</h6>
                </div>
                <div class="card-body">

                <form action="{{ route('admin.probono.update',$probono->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="book">Case Title *</label>
                                    <input type="text" name="title" class="form-control" id="book_title"  value="{{ $probono->title }}"value="{{ old('book_title') }}">
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
                </div>
            </div>
        </div>
    </div>

@endsection
