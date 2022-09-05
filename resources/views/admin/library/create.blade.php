@extends('layouts.admin.layout')
@section('title')
<title>Library</title>
@endsection
@section('admin-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.library.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> All_books</a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Library_form</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.library.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="book">Book Title *</label>
                                    <input type="text" name="book_title" class="form-control" id="book_title"  value="{{ old('book_title') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="author">Author*</label>
                                    <input type="text" name="author" class="form-control" id="author"  value="{{ old('author') }}">
                                </div>
                            </div>
                            

                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Book Image *</label>
                                    <input type="file" name="image" class="form-control" id="image" >
                                </div>
                            </div>

                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Book File Pdf *</label>
                                    <input type="file" name="pdf" class="form-control" id="pdf" >
                                </div>
                            </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="show_homepage">Show_homepage *</label>
                                    <select name="show_homepage" id="show_homepage" class="form-control">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>


                              <div class="col-md-4">
                                <div class="form-group">
                                    <label for="department">Type *</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="">select_type</option>
                                        @foreach ($departments as $item)
                                        <option {{ old('department')==$item->id? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        
                           <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">Category *</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">{{ $website_lang->where('lang_key','select_category')->first()->custom_lang }}</option>
                                        @foreach ($categories as $item)
                                        <option {{ old('category')==$item->id? 'selected' : ''}} value="{{ $item->id }}">{{ $item->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

               

                        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                   


                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
