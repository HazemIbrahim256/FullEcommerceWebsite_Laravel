<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Image;

class SliderController extends Controller
{
    public function SliderView()
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.slider_view',compact('sliders'));
    }
    public function Inactive($id)
    {
        Slider::findOrFail($id)->update(['status' => 0]);
        $notification = array(
            'message' => 'Deactivated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    public function Active($id)
    {
        Slider::findOrFail($id)->update(['status' => 1]);
        $notification = array(
            'message' => 'Activated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    public function StoreSlider(Request $request)
    {
        $request -> validate([
            'slider_img' => 'required'
        ],[
            'slider_img.required' => 'Slider Image is empty'
        ]);
        $image = $request->file('slider_img');
        $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(870,370)->save('upload/slider/'.$make_name);
        $save_url = 'upload/slider/'.$make_name;
        Slider::insert([
            'slider_img' => $save_url,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        $notification = array(
            'message' => 'Added Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function SliderEdit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.slider.slider_edit',compact('slider'));
    }
    public function UpdateSlider(Request $request)
    {
        $slider_id = $request->id;
        $old_img = $request->old_image;
        if ($request->file('slider_img'))
        {
            unlink($old_img);
            $image = $request->file('slider_img');
            $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(870,370)->save('upload/slider/'.$make_name);
            $save_url = 'upload/slider/'.$make_name;
            Slider::findOrFail($slider_id)->update([
                'slider_img' => $save_url,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            $notification = array(
                'message' => 'Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('mng.slider')->with($notification);
        }else{
            Slider::findOrFail($slider_id)->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
            $notification = array(
                'message' => 'Updated Succesfully',
                'alert-type' => 'success'
            );
            return redirect()->route('mng.slider')->with($notification);
        }
    }
    public function SliderDelete($id)
    {
        $slider = Slider::findOrFail($id);
        $img = $slider->slider_img;
        unlink($img);
        Slider::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
