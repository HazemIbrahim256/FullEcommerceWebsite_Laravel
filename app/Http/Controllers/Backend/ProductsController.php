<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\SubSubcategory;
use Carbon\Carbon;
use Image;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function AddProduct()
    {
        $category = Category::latest()->get();
        $brand = Brand::latest()->get();
        return view('backend.product.product_add',compact('brand','category'));
    }
    public function StoreProduct(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,zip,pdf|max:2048',
        ]);
    
        if ($files = $request->file('file')) {
            $destinationPath = 'upload/pdf'; // upload path
            $digitalItem = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath,$digitalItem);
        }

        $image = $request->file('product_thumbnail');
    	$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    	Image::make($image)->resize(917,1000)->save('upload/products/thumbnail/'.$name_gen);
    	$save_url = 'upload/products/thumbnail/'.$name_gen;


        $product_id = Product::insertGetId([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,
            'product_name_en' => $request->product_name_en,
            'product_name_ar' => $request->product_name_ar,
            'product_slug_en' =>  strtolower(str_replace(' ', '-', $request->product_name_en)),
            'product_slug_ar' => str_replace(' ', '-', $request->product_name_ar),
            'product_code' => $request->product_code,

            'product_qty' => $request->product_qty,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_ar' => $request->product_tags_ar,
            'product_size_en' => $request->product_size_en,
            'product_size_ar' => $request->product_size_ar,
            'product_color_en' => $request->product_color_en,
            'product_color_ar' => $request->product_color_ar,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_description_en' => $request->short_description_en,
            'short_description_ar' => $request->short_description_ar,
            'long_description_en' => $request->long_description_en,
            'long_description_ar' => $request->long_description_ar,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offers' => $request->special_offers,
            'special_deals' => $request->special_deals,

            'product_thumbnail' => $save_url,
            'digital_file' => $digitalItem,
            'status' => 1,
            'created_at' => Carbon::now(),   	 


            
        ]);
            $images = $request->file('multi_img');
            foreach ($images as $img) {
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(917,1000)->save('upload/products/multi-image/'.$make_name);
            $uploadPath = 'upload/products/multi-image/'.$make_name;
            MultiImg::insert([

                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(), 
    
            ]);
            }

            $notification = array(
                'message' => 'Product Inserted Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('mng.product')->with($notification);
    }
    public function MngProduct()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_view',compact('products'));
    }
    public function EditProduct($id)
    {
        $multiImgs = MultiImg::where('product_id',$id)->get();
        $category = Category::latest()->get();
        $brand = Brand::latest()->get();
        $subcategory = Subcategory::latest()->get();
        $subsubcategory = SubSubcategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('backend.product.product_edit',compact('products','category','brand','subcategory','subsubcategory','multiImgs'));
    }

    public function UpdateProduct(Request $request)
    {
        $product_id = $request->id;
        Product::findOrFail($product_id)->update([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,
            'product_name_en' => $request->product_name_en,
            'product_name_ar' => $request->product_name_ar,
            'product_slug_en' =>  strtolower(str_replace(' ', '-', $request->product_name_en)),
            'product_slug_ar' => str_replace(' ', '-', $request->product_name_ar),
            'product_code' => $request->product_code,

            'product_qty' => $request->product_qty,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_ar' => $request->product_tags_ar,
            'product_size_en' => $request->product_size_en,
            'product_size_ar' => $request->product_size_ar,
            'product_color_en' => $request->product_color_en,
            'product_color_ar' => $request->product_color_ar,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_description_en' => $request->short_description_en,
            'short_description_ar' => $request->short_description_ar,
            'long_description_en' => $request->long_description_en,
            'long_description_ar' => $request->long_description_ar,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offers' => $request->special_offers,
            'special_deals' => $request->special_deals,

            'status' => 1,
            'created_at' => Carbon::now(),   	 


            
        ]);
        $notification = array(
            'message' => 'Product Updated Successfully, Without Image',
            'alert-type' => 'success'
        );

        return redirect()->route('mng.product')->with($notification);
    }

    public function UpdateProductImgs(Request $request)
    {
        $imgs = $request->multi_img;
        foreach ($imgs as $id => $img )
        {
            $imgDel = MultiImg::findOrFail($id);
            unlink($imgDel->photo_name);
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(917,1000)->save('upload/products/multi-image/'.$make_name);
            $uploadPath = 'upload/products/multi-image/'.$make_name;
            MultiImg::where('id',$id)->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),
            ]);
        }
        $notification = array(
            'message' => 'Product Images Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    public function UpdateProductThmbnl(Request $request)
    {
        $pro_id = $request->id;
        $oldImg = $request->oldthumbnail;
        unlink($oldImg);

        $image = $request->file('product_thumbnail');
    	$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    	Image::make($image)->resize(917,1000)->save('upload/products/thumbnail/'.$name_gen);
    	$save_url = 'upload/products/thumbnail/'.$name_gen;
        Product::findOrFail($pro_id)->update([
            'product_thumbnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Product Thumbnail Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    public function DeleteImgs($id)
    {
        $oldImg = MultiImg::findOrFail($id);
        unlink($oldImg->photo_name);
        MultiImg::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    public function Inactive($id)
    {
        Product::findOrFail($id)->update(['status' => 0]);
        $notification = array(
            'message' => 'Deactivated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    public function Active($id)
    {
        Product::findOrFail($id)->update(['status' => 1]);
        $notification = array(
            'message' => 'Activated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    public function Details($id)
    {
        $multiImgs = MultiImg::where('product_id',$id)->get();
        $category = Category::latest()->get();
        $brand = Brand::latest()->get();
        $subcategory = Subcategory::latest()->get();
        $subsubcategory = SubSubcategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('backend.product.product_details',compact('products','category','brand','subcategory','subsubcategory','multiImgs'));
    }
    public function ProductDelete($id)
    {
        $product = Product::findOrFail($id);
        unlink($product->product_thumbnail);
        Product::findOrFail($id)->delete();

        $images = MultiImg::where('product_id',$id)->get();
        foreach ($images as $img)
        {
            unlink($img->photo_name);
            MultiImg::where('product_id',$id)->delete();
        }
        $notification = array(
            'message' => 'Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // product Stock 
    public function ProductStock(){

        $products = Product::latest()->get();
        return view('backend.product.product_stock',compact('products'));
    }
}
