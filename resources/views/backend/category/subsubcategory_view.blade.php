@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="container-full">
<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content">
    <div class="row">
        


    <div class="col-9">

        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Sub->SubCategory List <span class="badge badge-pill badge-danger"> {{ count($subsubcategory) }} </span></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Subategory Name </th>
                        <th>Sub-Subcategory Name EN</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subsubcategory as $item)
                        
                    <tr>
                        <td>{{$item['category']['category_name_en']}}</td>
                        <td>{{$item['subcategory']['subcategory_name_en']}}</td>
                        <td>{{$item->subsubcategory_name_en}}</td>
                        <td>
                            <a href="{{route('subsubcategory.edit',$item->id)}}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                            <a href="{{route('subsubcategory.delete',$item->id)}}" class="btn btn-danger" id="delete"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->


    <!---- Add brand ---->

    <div class="col-3">

        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add Sub-Subcategory</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <form method="POST" action="{{route('subsubcategory.store')}}">
                    @csrf						
                        
                    
                    <div class="form-group">
                        <h5>Category Select <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="category_id" required="" class="form-control">
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($category as $cat)
                                <option value="{{$cat->id}}">{{$cat->category_name_en}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <h5>Subcategory Select <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="subcategory_id" class="form-control">
                                <option value="" selected disabled>Select Subcategory</option>
                                
                            </select>
                            @error('subcategory_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <h5>Sub-Subcategory Name EN <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="subsubcategory_name_en" class="form-control">
                            @error('subsubcategory_name_en')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
            
            
                    <div class="form-group">
                        <h5>Sub-Subcategory Name AR <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="subsubcategory_name_ar" class="form-control">
                            @error('subsubcategory_name_ar')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
            
            
                    
            
            
                        
                    <div class="text-xs-right">
                        <input type="submit" class="btn btn-primary mb-5" value="Add Sub-Subcategory">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('select[name="category_id"]').on('change',function(){
            var category_id = $(this).val();
            if(category_id){
                $.ajax({
                    url: "{{url('/category/subcategory/ajax')}}/"+category_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data){
                        var d = $('select[name="subcategory_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="subcategory_id"]').append('<option value="'+value.id+'">'+value.subcategory_name_en+'</option>');
                        });
                    },
                });
            }else{
                alert('danger');
            }
        });
    });
</script>

@endsection