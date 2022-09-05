@extends('layouts.lawyer.layout')
@section('title')
<title>Opportunities</title>
@endsection
@section('lawyer-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('lawyer.opportunity.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i>All Opportunities</a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Opportunity Form</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('lawyer.opportunity.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Job Title *</label>
                                    <input type="text" name="title" class="form-control" id="title"  value="{{ old('title') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Company Name *</label>
                                    <input type="text" name="company" class="form-control" id="company"  value="{{ old('company') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Position *</label>
                                    <input type="text" name="position" class="form-control" id="position"  value="{{ old('position') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Salary Range *</label>
                                    <input type="text" name="salary" class="form-control" id="salary" value="{{ old('salary') }}">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type Of Opportunity *</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="">select_type</option>
                                        @foreach ($opportunitytypes as $item)
                                        <option {{ old('types')==$item->id? 'selected' : ''}} value="{{ $item->id }}">{{ $item->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Attach Job Description *</label>
                                    <input type="file" name="file" class="form-control" id="file" >
                                </div>
                            </div>

                          
                           
                            
    


                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ $website_lang->where('lang_key','status')->first()->custom_lang }} *</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">{{ $website_lang->where('lang_key','active')->first()->custom_lang }}</option>
                                        <option value="0">{{ $website_lang->where('lang_key','inactive')->first()->custom_lang }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Closing Date *</label>
                                    <input type="date" name="closing" class="form-control" id="file" >
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin">Application Link</label>
                                    <input type="text" class="form-control" name="link" id="link">
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                           
                            <div class="custom-control custom-checkbox checkbox-xl">
          <input type="checkbox" class="custom-control-input" id="checkbox-3" value="1" name="apply">
          <label class="custom-control-label" for="checkbox-3">Quick Apply</label>
        </div>
</div>
</div>
                               </div>

                            <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="seo_description">Simple description</label>
                                    <textarea name="description" id="description" class="summernote">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-success">{{ $website_lang->where('lang_key','save')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
