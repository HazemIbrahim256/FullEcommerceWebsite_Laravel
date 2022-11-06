@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="container-full">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Basic Forms -->
        <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Edit Blog Post </h4>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col">

        <form method="post" action="{{ route('blog.post.update') }}" >
        @csrf

                    <div class="row">
<div class="col-12">	





<div class="row"> <!-- start 2nd row  -->


        <div class="col-md-6">

                <div class="form-group">
        <h5>Post Title English <span class="text-danger">*</span></h5>
        <div class="controls">
            <input type="text" value="{{$blog->post_title_en}}" name="post_title_en" class="form-control" required="">
    @error('post_title_en') 
    <span class="text-danger">{{ $message }}</span>
    @enderror
        </div>
    </div>

        </div> <!-- end col md 6 -->


        <div class="col-md-6">

                <div class="form-group">
        <h5>Post Title Arabic <span class="text-danger">*</span></h5>
        <div class="controls">
            <input type="text" value="{{$blog->post_title_ar}}" name="post_title_ar" class="form-control" required="">
    @error('post_title_ar') 
    <span class="text-danger">{{ $message }}</span>
    @enderror
            </div>
    </div>

        </div> <!-- end col md 6 -->

    </div> <!-- end 2nd row  -->







<div class="row"> <!-- start 6th row  -->
        <div class="col-md-6">

    <div class="form-group">
<h5>BlogCategory Select <span class="text-danger">*</span></h5>
<div class="controls">
    <select name="category_id" class="form-control" required="" >
        <option value="" selected="" disabled="">Select BlogCategory</option>
        @foreach($blogcategory as $category)
        <option value="{{ $category->id }}"{{$category->id == $blog->category_id ? 'selected': ''}}>{{ $category->blog_category_name_en }}</option>	
        @endforeach
    </select>
    @error('category_id') 
    <span class="text-danger">{{ $message }}</span>
    @enderror 
    </div>
        </div>

        </div> <!-- end col md 6 -->

        




    </div> <!-- end 6th row  -->









<div class="row"> <!-- start 8th row  -->
        <div class="col-md-6">

    <div class="form-group">
        <h5>Post Details English <span class="text-danger">*</span></h5>
        <div class="controls">
<textarea id="editor1" name="post_details_en" rows="10" cols="80" required="">
    {!!$blog->post_details_en!!}
                    </textarea>  
            </div>
    </div>

        </div> <!-- end col md 6 -->

        <div class="col-md-6">

        <div class="form-group">
        <h5>Post Details Arabic <span class="text-danger">*</span></h5>
        <div class="controls">
<textarea id="editor2" name="post_details_ar" rows="10" cols="80">
    {!!$blog->post_details_ar!!}
                    </textarea>       
            </div>
    </div>


        </div> <!-- end col md 6 -->		 

    </div> <!-- end 8th row  -->


    <hr>

    <div class="text-xs-right">
<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update Post">
                    </div>
                </form>




        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
    <!-- Main content -->
    <section class="content">

        <!-- Basic Forms -->
        <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Edit Blog Post Image </h4>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col">

        <form method="post" action="{{ route('blog.post.image.update') }}" enctype="multipart/form-data" >
        @csrf
        <input type="hidden" name="id" value="{{$blog->id}}">
        <input type="hidden" name="oldpostimg" value="{{$blog->post_image}}">
                    <div class="row row-sm">

    <div class="col-md-6">
        <div class="card">
            <img src="{{asset($blog->post_image)}}" class="card-img-top" style="height: 130px; width: 280px;">
            <div class="card-body">
                <p class="card-text">
                    <div class="form-group">
                        <h3>Post Main Image  <span class="text-danger">*</span></h3>
                        <label for="" class="form-control-label">Change Image <span class="tx-danger">*</span></label>
                        <input type="file" name="post_image" class="form-control" onchange="mainThamUrl(this)" required>
                        <img src="" id="mainThmb" alt="">

                    </div>
                </p>
            </div>
        </div>

            </div> <!-- end col md 6 -->
                    </div>
                    <hr>
                    <div class="text-xs-right">
                        <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Post Image Update">
                                            </div>
        </form>
            </div>
            </div>
        </div>
        </div>
    </section>




<script type="text/javascript">
function mainThamUrl(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
            $('#mainThmb').attr('src',e.target.result).width(80).height(80);
        };
        reader.readAsDataURL(input.files[0]);
    }
}	
</script>






@endsection 