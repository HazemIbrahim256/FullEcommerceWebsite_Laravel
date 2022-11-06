@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="container-full">
<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content">
    <div class="row">
        


    <div class="col-8">

        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">States List</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Divisions Name</th>
                        <th>Districts Name</th>
                        <th>States Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($states as $item)
                        
                    <tr>
                        <td width="25%">{{$item->division->division_name}}</td>

                        <td width="25%">{{$item->district->district_name}}</td>
                        <td width="25%">{{$item->state_name}}</td>

                        <td width="30%">
                            <a href="{{route('state.edit',$item->id)}}" class="btn btn-info" title="Edit"><i class="fa fa-pencil"></i> </a>
                            <a href="{{route('state.delete',$item->id)}}" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i> </a>
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

    <div class="col-4">

        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add State</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <form method="POST" action="{{route('state.store')}}">
                    @csrf						
                        
                    <div class="form-group">
                        <h5>Divisions Select <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="division_id" required="" class="form-control">
                                <option value="" selected disabled>Select Division</option>
                                @foreach ($divisions as $division)
                                <option value="{{$division->id}}">{{$division->division_name}}</option>
                                @endforeach
                            </select>
                            @error('division_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <!--<div class="form-group">
                        <h5>Districts Select <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="district_id" required="" class="form-control">
                                <option value="" selected disabled>Select District</option>
                                @foreach ($districts as $district)
                                <option value="{{$district->id}}">{{$district->district_name}}</option>
                                @endforeach
                            </select>
                            @error('district_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>-->
                    <div class="form-group">
                        <h5>Districts Select <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="district_id" class="form-control">
                                <option value="" selected disabled>Select District</option>
                                
                            </select>
                            @error('district_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <h5>State Name <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="state_name" class="form-control">
                            @error('state_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                        
                        
                        
                        
                        
                    <div class="text-xs-right">
                        <input type="submit" class="btn btn-primary mb-5" value="Add State">
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
        $('select[name="division_id"]').on('change',function(){
            var division_id = $(this).val();
            if(division_id){
                $.ajax({
                    url: "{{url('/district-get/ajax')}}/"+division_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data){
                        $('select[name="state_id"]').empty();
                        var d = $('select[name="district_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="district_id"]').append('<option value="'+value.id+'">'+value.district_name+'</option>');
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