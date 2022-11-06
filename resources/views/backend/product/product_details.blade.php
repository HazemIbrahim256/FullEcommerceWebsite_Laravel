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
			<h4 class="box-title">Product Details</h4>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
			<div class="col">
                    <input type="hidden" name="id" value="{{$products->id}}">
					<div class="row">
					<div class="col-12">						
						
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5>Brand Select <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <select name="brand_id" required="" class="form-control">
                                            <option value="" selected disabled>Select Brand</option>
                                            @foreach ($brand as $brnd)
                                            <option value="{{$brnd->id}}"{{$brnd->id == $products -> brand_id ? 'selected': ''}}>{{$brnd->brand_name_en}}</option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5>Category Select <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <select name="category_id" required="" class="form-control">
                                            <option value="" selected disabled>Select Category</option>
                                            @foreach ($category as $cat)
                                            <option value="{{$cat->id}}"{{$cat->id==$products->category_id?'selected':''}}>{{$cat->category_name_en}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5>SubCategory Select <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <select name="subcategory_id" required="" class="form-control">
                                            <option value="" selected disabled>Select Subcategory</option>
                                            @foreach ($subcategory as $subcat)
                                            <option value="{{$subcat->id}}"{{$subcat->id==$products->subcategory_id?'selected':''}}>{{$subcat->subcategory_name_en}}</option>
                                            @endforeach
                                        </select>
                                        @error('subcategory_id')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5>Sub-Subcategory Select <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <select name="subsubcategory_id" required="" class="form-control">
                                            <option value="" selected disabled>Select Sub-Subcategory</option>
                                            @foreach ($subsubcategory as $subsubcat)
                                            <option value="{{$subsubcat->id}}"{{$subsubcat->id==$products->subsubcategory_id?'selected':''}}>{{$subsubcat->subsubcategory_name_en}}</option>
                                            @endforeach
                                        </select>
                                        @error('subsubcategory_id')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
									<h5>Product Name in ENGLISH <span class="text-danger">*</span></h5>
									<div class="controls">
										<input type="text" value="{{$products->product_name_en}}" name="product_name_en" class="form-control" required> 
										@error('product_name_en')
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
                            </div>
							<div class="col-md-4">
                            <div class="form-group">
								<h5>Product Name in ARABIC <span class="text-danger">*</span></h5>
								<div class="controls">
									<input type="text" value="{{$products->product_name_ar}}" name="product_name_ar" class="form-control" required> 
									@error('product_name_ar')
                                            <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
							</div>
							</div>
                        </div>

						<div class="row">
                            
                            <div class="col-md-4">
                                <div class="form-group">
									<h5>Product Code <span class="text-danger">*</span></h5>
									<div class="controls">
										<input type="text" value="{{$products->product_code}}" name="product_code" class="form-control" required> 
										@error('product_code')
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
                            </div>
							<div class="col-md-4">
                            <div class="form-group">
								<h5>Product Quantity <span class="text-danger">*</span></h5>
								<div class="controls">
									<input type="text" value="{{$products->product_qty}}" name="product_qty" class="form-control" required> 
									@error('product_qty')
                                            <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
							</div>
							</div>

							
                        </div>
						
						<div class="row">
                            
							<div class="col-md-3">
								<div class="form-group">
									<h5>Product Tags in ENGLISH <span class="text-danger">*</span></h5>
									<div class="controls">
										<input data-role="tagsinput" value="{{$products->product_tags_en}}" type="text" name="product_tags_en" class="form-control" required> 
										@error('product_tags_en')
												<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
								</div>
							<div class="col-md-3">
								<div class="form-group">
									<h5>Product Tags in ARABIC <span class="text-danger">*</span></h5>
									<div class="controls">
										<input data-role="tagsinput" value="{{$products->product_tags_ar}}" type="text" name="product_tags_ar" class="form-control" required> 
										@error('product_tags_ar')
												<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
								</div>

                            <div class="col-md-3">
                                <div class="form-group">
									<h5>Product Size in ENGLISH <span class="text-danger"></span></h5>
									<div class="controls">
										<input type="text" value="{{$products->product_size_en}}" name="product_size_en" class="form-control" data-role="tagsinput" required> 
										@error('product_size_en')
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
                            </div>
							<div class="col-md-3">
								<div class="form-group">
									<h5>Product Size in ARABIC <span class="text-danger"></span></h5>
									<div class="controls">
										<input value="{{$products->product_size_ar}}" data-role="tagsinput" type="text" name="product_size_ar" class="form-control" required> 
										@error('product_size_ar')
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>

	
                        </div>

						<div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
									<h5>Product Color in ENGLISH <span class="text-danger">*</span></h5>
									<div class="controls">
										<input type="text" name="product_color_en" class="form-control" value="{{$products->product_color_en}}" data-role="tagsinput" required> 
										@error('product_color_en')
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
                            </div>
							<div class="col-md-3">
								<div class="form-group">
									<h5>Product Color in ARABIC <span class="text-danger">*</span></h5>
									<div class="controls">
										<input value="{{$products->product_color_ar}}" data-role="tagsinput" type="text" name="product_color_ar" class="form-control" required> 
										@error('product_color_ar')
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="col-md-3">
                            <div class="form-group">
								<h5>Selling Price <span class="text-danger">*</span></h5>
								<div class="controls">
									<input type="text" value="{{$products->selling_price}}" name="selling_price" class="form-control" required> 
									@error('selling_price')
                                            <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
							</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<h5>Discount Price <span class="text-danger"></span></h5>
									<div class="controls">
										<input type="text" value="{{$products->discount_price}}" name="discount_price" class="form-control" > 
										@error('discount_price')
												<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
								</div>
                        </div>

						<div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
									<h5>Short description in ENGLISH <span class="text-danger">*</span></h5>
									<div class="controls">
										<textarea name="short_description_en" id="textarea" class="form-control" required placeholder="Textarea text">
                                            {!!$products->short_description_en!!}
                                        </textarea>
									</div>
								</div>
                            </div>

							<div class="col-md-6">
                                <div class="form-group">
									<h5>Short description in ARABIC <span class="text-danger">*</span></h5>
									<div class="controls">
										<textarea name="short_description_ar" id="textarea" class="form-control" required placeholder="Textarea text">
                                            {!!$products->short_description_ar!!}
                                        </textarea>
									</div>
								</div>
                            </div>
                        </div>

						<div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
									<h5>Long description in ENGLISH <span class="text-danger">*</span></h5>
									<div class="controls">
										<textarea id="editor1" name="long_description_en" rows="10" cols="80" required>
                                            {!!$products->long_description_en!!}
                                        </textarea>										
									</div>
								</div>
                            </div>

							<div class="col-md-6">
                                <div class="form-group">
									<h5>Long description in ARABIC <span class="text-danger">*</span></h5>
									<div class="controls">
										<textarea id="editor2" name="long_description_ar" rows="10" cols="80" required>
                                            {!!$products->long_description_ar!!}
                                        </textarea>																				
									</div>
								</div>
                            </div>
                        </div>

						
					</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<div class="controls">
									<fieldset>
										<input type="checkbox" id="checkbox_2" name="hot_deals" value="1" {{$products->hot_deals == 1?'checked':''}}>
										<label for="checkbox_2">Hot deals</label>
									</fieldset>
									<fieldset>
										<input type="checkbox" id="checkbox_3" name="featured" value="1" {{$products->featured == 1?'checked':''}}>
										<label for="checkbox_3">Featured</label>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="controls">
									<fieldset>
										<input type="checkbox" id="checkbox_4" name="special_offers" value="1" {{$products->special_offers == 1?'checked':''}}>
										<label for="checkbox_4">Special offers</label>
									</fieldset>
									<fieldset>
										<input type="checkbox" id="checkbox_5" name="special_deals" value="1" {{$products->special_deals == 1?'checked':''}}>
										<label for="checkbox_5">Special deals</label>
									</fieldset>
								</div>
							</div>
						</div>
					</div>

			</div>
			<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.box-body -->
		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->


	<section class="content">
		<div class="row">
		<div class="col-md-12">
			<div class="box bt-3 border-info">
				<div class="box-header">
				<h4 class="box-title">Product Images <strong>Update</strong></h4>
				</div>


					<div class="row row-sm">
						@foreach ($multiImgs as $img)
							<div class="col-md-3">
								<div class="card">
									<img src="{{asset($img->photo_name)}}" class="card-img-top" style="height: 130px; width: 280px;">
									<div class="card-body">
									    <h5 class="card-title">
											<a href="{{route('product.multiImg.delete',$img->id)}}" class="btn btn-sm btn-danger" title="Delete Data" id=""><i class="fa fa-trash"></i></a>
										</h5>
									    <p class="card-text">
											<div class="form-group">
												<label for="" class="form-control-label">Change Image <span class="tx-danger">*</span></label>
												<input type="file" class="form-control" name="multi_img[{{$img->id}}]">
											</div>
										</p>
									</div>
								</div>
							</div>
						@endforeach
						
					</div>

			</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="row">
		<div class="col-md-12">
			<div class="box bt-3 border-info">
				<div class="box-header">
				<h4 class="box-title">Product Thumbnail <strong>Update</strong></h4>
				</div>


					<input type="hidden" name="id" value="{{$products->id}}">
					<input type="hidden" name="oldthumbnail" value="{{$products->product_thumbnail}}">
					<div class="row row-sm">
							<div class="col-md-4">
								<div class="card">
									<img src="{{asset($products->product_thumbnail)}}" class="card-img-top" style="height: 130px; width: 280px;">
									<div class="card-body">
									
									<p class="card-text">
											
									</p>
									</div>
								</div>
							</div>
						
					</div>
					

			</div>
			</div>
		</div>
	</section>

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
							$('select[name="subsubcategory_id"]').html('');
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
			$('select[name="subcategory_id"]').on('change',function(){
				var subcategory_id = $(this).val();
				if(subcategory_id){
					$.ajax({
						url: "{{url('/category/subsubcategory/ajax')}}/"+subcategory_id,
						type: "GET",
						dataType: "json",
						success:function(data){
							var d = $('select[name="subsubcategory_id"]').empty();
							$.each(data, function(key, value){
								$('select[name="subsubcategory_id"]').append('<option value="'+value.id+'">'+value.subsubcategory_name_en+'</option>');
							});
						},
					});
				}else{
					alert('danger');
				}
			});
		});
	</script>

<script type="text/javascript">
	function mainThumURL(input)
	{
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e){
				$('#mainThmbnl').attr('src',e.target.result).width(80).height(80);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>

<script type="text/javascript">

$(document).ready(function(){
	$('#multiImg').on('change', function(){ //on file input change
	if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
	{
		var data = $(this)[0].files; //this file data
			
		$.each(data, function(index, file){ //loop though each file
			if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
				var fRead = new FileReader(); //new filereader
				fRead.onload = (function(file){ //trigger function on successful read
				return function(e) {
					var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(80)
				.height(80); //create image element 
					$('#preview_img').append(img); //append image to output element
				};
				})(file);
				fRead.readAsDataURL(file); //URL representing the file's data.
			}
		});
			
	}else{
		alert("Your browser doesn't support File API!"); //if File API is absent
	}
	});
});
	
</script>

@endsection