@extends('layouts.admin.layout')
@section('title')
<title>Library</title>
@endsection
@section('admin-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.library.create') }}" class="btn btn-primary"><i class="fas fa-plus" aria-hidden="true"></i>Create </a></h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Library_table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">Serial</th>
                            <th width="20%">Book title</th>
                            <th width="10%">Author</th>
                            <th width="10%">Description</th>
                    
                            <th width="5%">Image</th>
                            <th width="10%" >Action</th>
                        </tr>
                    </thead>
                    @foreach ($library as $index => $item)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $item->book_title }}</td>
                            <td>{{ $item->author }}</td>
                            <td>{{ $item->description }}</td>
                                 
                            <td><img src="{{ url($item->image) }}" alt="doctor image" width="80px"></td>
                            
                           <td>
                                <a href="{{ route('admin.library.edit',$item->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit    "></i></a>
    
                                <a data-toggle="modal" data-target="#deleteModal" href="javascript:;" onclick="deleteData({{ $item->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash    "></i></a>



                            </td>
                        </tr>
                        @endforeach

                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function deleteData(id){
            $("#deleteForm").attr("action",'{{ url("admin/library/") }}'+"/"+id)
        }

        function doctorStatus(id){

// project demo mode check
         var isDemo="{{ env('PROJECT_MODE') }}"
         var demoNotify="{{ env('NOTIFY_TEXT') }}"
         if(isDemo==0){
             toastr.error(demoNotify);
             return;
         }
         // end
            $.ajax({
                type:"get",
                url:"{{url('/admin/library-status/')}}"+"/"+id,
                success:function(response){
                   toastr.success(response)
                },
                error:function(err){
                    console.log(err);

                }
            })
        }
    </script>
@endsection
