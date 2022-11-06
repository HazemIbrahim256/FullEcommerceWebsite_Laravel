@extends('admin.admin_master')
@section('admin')
<div class="container-full">
<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content">
    <div class="row">
        


    <div class="col-9">

        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">SubCategory List <span class="badge badge-pill badge-danger"> {{ count($subcategory) }} </span> </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Subategory Name EN</th>
                        <th>Subcategory Name AR</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subcategory as $item)
                        
                    <tr>
                        <td>{{$item['category']['category_name_en']}}</td>
                        <td>{{$item->subcategory_name_en}}</td>
                        <td>{{$item->subcategory_name_ar}}</td>
                        <td>
                            <a href="{{route('subcategory.edit',$item->id)}}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                            <a href="{{route('subcategory.delete',$item->id)}}" class="btn btn-danger" id="delete"><i class="fa fa-trash"></i> Delete</a>
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
            <h3 class="box-title">Add Subcategory</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <form method="POST" action="{{route('subcategory.store')}}">
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
                        <h5>Subcategory Name EN <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="subcategory_name_en" class="form-control">
                            @error('subcategory_name_en')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
            
            
                    <div class="form-group">
                        <h5>Subcategory Name AR <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="subcategory_name_ar" class="form-control">
                            @error('subcategory_name_ar')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
            
            
                    
            
            
                        
                    <div class="text-xs-right">
                        <input type="submit" class="btn btn-primary mb-5" value="Add Subcategory">
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
@endsection