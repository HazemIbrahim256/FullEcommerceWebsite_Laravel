@extends('admin.admin_master')
@section('admin')
<div class="container-full">
<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content">
    <div class="row">
        
    <!---- Add brand ---->

    <div class="col-12">

        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Sub-Subcategory</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <form method="POST" action="{{route('subsubcategory.update')}}">
                    @csrf						
                        
                    <input type="hidden" name="id" value="{{$subsubcategory->id}}">

                    <div class="form-group">
                        <h5>Category Select <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="category_id" required="" class="form-control">
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($category as $cat)
                                <option value="{{$cat->id}}" {{$cat->id==$subsubcategory->category_id?'selected':''}}>{{$cat->category_name_en}}</option>
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
                                @foreach ($subcategory as $subcat)
                                <option value="{{$subcat->id}}" {{$subcat->id==$subsubcategory->subcategory_id?'selected':''}}>{{$subcat->subcategory_name_en}}</option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <h5>Sub-Subcategory Name EN <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="subsubcategory_name_en" class="form-control" value="{{$subsubcategory->subsubcategory_name_en}}">
                            @error('subsubcategory_name_en')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
            
            
                    <div class="form-group">
                        <h5>Sub-Subcategory Name AR <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="subsubcategory_name_ar" class="form-control" value="{{$subsubcategory->subsubcategory_name_ar}}">
                            @error('subsubcategory_name_ar')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
            
            
                    
            
            
                        
                    <div class="text-xs-right">
                        <input type="submit" class="btn btn-primary mb-5" value="Update Sub-Subcategory">
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