<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function CatView()
    {
        $category = Category::latest()->get();
        return view('backend.category.category_view',compact('category'));
    }
    public function StoreCat(Request $request)
    {
        $request->validate([
            'category_name_en' => 'required',
            'category_name_ar' => 'required',
            'category_icon' => 'required'
        ],[
            'category_name_en.required' => 'Input category name in ENGLISH',
            'category_name_ar.required' => 'Input category name in ARABIC',
        ]);
        Category::insert([
            'category_name_en' => $request->category_name_en,
            'category_name_ar' => $request->category_name_ar,
            'category_slug_en' => strtolower(str_replace(' ', '-', $request->category_name_en)),
            'category_slug_ar' => str_replace(' ', '-', $request->category_name_ar),
            'category_icon' => $request->category_icon
        ]);
        $notification = array(
            'message' => 'Added Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function CatEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.category.category_edit',compact('category'));
    }
    public function UpdateCat(Request $request)
    {
        $category_id = $request->id;
        Category::findOrFail($category_id)->update([
            'category_name_en' => $request->category_name_en,
            'category_name_ar' => $request->category_name_ar,
            'category_slug_en' => strtolower(str_replace(' ', '-', $request->category_name_en)),
            'category_slug_ar' => str_replace(' ', '-', $request->category_name_ar),
            'category_icon' => $request->category_icon
        ]);
        $notification = array(
            'message' => 'Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.cats')->with($notification);
    }
    public function CatDelete($id)
    {

        Category::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Succesfully',
            'alert-type' => 'danger'
        );
        return redirect()->back()->with($notification);
    }
}
