<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Image;

class BrandController extends Controller
{
    public function BrandView()
    {
        $brand = Brand::latest()->get();
        return view('backend.brand.brand_view',compact('brand'));
    }
    public function StoreBrand(Request $request)
    {
        $request->validate([
            'brand_name_en' => 'required',
            'brand_name_ar' => 'required',
            'brand_image' => 'required',
        ],[
            'brand_name_en.required' => 'Input brand name in ENGLISH',
            'brand_name_ar.required' => 'Input brand name in ARABIC',
        ]);
        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
        $save_url = 'upload/brand/'.$name_gen;
        Brand::insert([
            'brand_name_en' => $request->brand_name_en,
            'brand_name_ar' => $request->brand_name_ar,
            'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
            'brand_slug_ar' => str_replace(' ', '-', $request->brand_name_ar),
            'brand_image' => $save_url
        ]);
        $notification = array(
            'message' => 'Added Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function BrandEdit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.brand.brand_edit',compact('brand'));
    }
    public function UpdateBrand(Request $request)
    {
        $brand_id = $request->id;
        $old_img = $request->old_image;
        if ($request->file('brand_image'))
        {
            unlink($old_img);
            $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
        $save_url = 'upload/brand/'.$name_gen;
        Brand::findOrFail($brand_id)->update([
            'brand_name_en' => $request->brand_name_en,
            'brand_name_ar' => $request->brand_name_ar,
            'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
            'brand_slug_ar' => str_replace(' ', '-', $request->brand_name_ar),
            'brand_image' => $save_url
        ]);
        $notification = array(
            'message' => 'Updated Succesfully',
            'alert-type' => 'info'
        );
        return redirect()->route('all.brand')->with($notification);
        }else{
            Brand::findOrFail($brand_id)->update([
                'brand_name_en' => $request->brand_name_en,
                'brand_name_ar' => $request->brand_name_ar,
                'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
                'brand_slug_ar' => str_replace(' ', '-', $request->brand_name_ar),
            ]);
            $notification = array(
                'message' => 'Updated Succesfully',
                'alert-type' => 'info'
            );
            return redirect()->route('all.brand')->with($notification);
        }
    }
    public function BrandDelete($id)
    {
        $brand = Brand::findOrFail($id);
        $img = $brand->brand_image;
        unlink($img);

        Brand::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Succesfully',
            'alert-type' => 'danger'
        );
        return redirect()->back()->with($notification);
    }
}
