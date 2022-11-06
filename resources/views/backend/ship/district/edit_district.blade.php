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
            <h3 class="box-title">Edit District</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <form method="POST" action="{{route('district.update',$district->id)}}">
                    @csrf						
                        
                    <input type="hidden" name="id" value="{{$district->id}}">



                    <div class="form-group">
                        <h5>Divisions Select <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="division_id" required="" class="form-control">
                                <option value="" selected disabled>Select Division</option>
                                @foreach ($divisions as $division)
                                <option value="{{$division->id}}" {{ $division->id == $district->division_id ? 'selected': ''}}>{{$division->division_name}}</option>
                                @endforeach
                            </select>
                            @error('division_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <h5>District Name <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="district_name" class="form-control" value="{{$district->district_name}}">
                            @error('district_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                        
                        
                            
                        
                        
                        
                    <div class="text-xs-right">
                        <input type="submit" class="btn btn-primary mb-5" value="Update">
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