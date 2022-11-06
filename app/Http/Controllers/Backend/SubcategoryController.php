<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubSubcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function SubcatView()
    {
        $category = Category::orderBy('category_name_en','ASC')->get();
        $subcategory = Subcategory::latest()->get();
        return view('backend.category.subcategory_view',compact('subcategory','category'));
    }
    public function StoreSubcat(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_ar' =>'required'
        ],[
            'category_id.required' => 'Select a category',
            'subcategory_name_en.required' => 'Input subcategory name in ENGLISH',
            'subcategory_name_ar.required' => 'Input subcategory name in ARABIC',
        ]);
        Subcategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_ar' => $request->subcategory_name_ar,
            'subcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subcategory_name_en)),
            'subcategory_slug_ar' => str_replace(' ', '-', $request->subcategory_name_ar),
        ]);
        $notification = array(
            'message' => 'Added Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function SubcatEdit($id)
    {
        $category = Category::orderBy('category_name_en','ASC')->get();
        $subcategory = Subcategory::findOrFail($id);
        return view('backend.category.subcategory_edit',compact('subcategory','category'));
    }
    public function UpdateSubcat(Request $request)
    {
        $subcategory_id = $request->id;
        Subcategory::findOrFail($subcategory_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_ar' => $request->subcategory_name_ar,
            'subcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subcategory_name_en)),
            'subcategory_slug_ar' => str_replace(' ', '-', $request->subcategory_name_ar),
        ]);
        $notification = array(
            'message' => 'Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.subcats')->with($notification);
    }
    public function SubcatDelete($id)
    {

        Subcategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Succesfully',
            'alert-type' => 'danger'
        );
        return redirect()->back()->with($notification);
    }



    //////SUB SUBCATEGORY//////



    public function SubsubcatView()
    {
        $category = Category::orderBy('category_name_en','ASC')->get();
        $subsubcategory = SubSubcategory::latest()->get();
        return view('backend.category.subsubcategory_view',compact('subsubcategory','category'));
    }
    public function GetSubCat($category_id)
    {
        $subcat = Subcategory::where('category_id',$category_id)->orderBy('subcategory_name_en','ASC')->get();
        return json_encode($subcat);
    }
    public function GetSubSubCat($subcategory_id)
    {
        $subsubcat = SubSubcategory::where('subcategory_id',$subcategory_id)->orderBy('subsubcategory_name_en','ASC')->get();
        return json_encode($subsubcat);
    }
    public function StoreSubsubcat(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'subsubcategory_name_en' => 'required',
            'subsubcategory_name_ar' =>'required'
        ],[
            'category_id.required' => 'Select a category',
            'subcategory_id.required' => 'Select a Subcategory',
            'subsubcategory_name_en.required' => 'Input Sub-subcategory name in ENGLISH',
            'subsubcategory_name_ar.required' => 'Input Sub-subcategory name in ARABIC',
        ]);
        SubSubcategory::insert([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name_en' => $request->subsubcategory_name_en,
            'subsubcategory_name_ar' => $request->subsubcategory_name_ar,
            'subsubcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subsubcategory_name_en)),
            'subsubcategory_slug_ar' => str_replace(' ', '-', $request->subsubcategory_name_ar),
        ]);
        $notification = array(
            'message' => 'Added Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function SubsubcatEdit($id)
    {
        $category = Category::orderBy('category_name_en','ASC')->get();
        $subcategory = Subcategory::orderBy('subcategory_name_en','ASC')->get();
        $subsubcategory = SubSubcategory::findOrFail($id);
        return view('backend.category.subsubcategory_edit',compact('subsubcategory','subcategory','category'));
    }
    public function UpdateSubsubcat(Request $request)
    {
        $subsubcategory_id = $request->id;
        SubSubcategory::findOrFail($subsubcategory_id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name_en' => $request->subsubcategory_name_en,
            'subsubcategory_name_ar' => $request->subsubcategory_name_ar,
            'subsubcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subsubcategory_name_en)),
            'subsubcategory_slug_ar' => str_replace(' ', '-', $request->subsubcategory_name_ar),
        ]);
        $notification = array(
            'message' => 'Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.subsubcats')->with($notification);
    }
    public function SubsubcatDelete($id)
    {

        SubSubcategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Succesfully',
            'alert-type' => 'danger'
        );
        return redirect()->back()->with($notification);
    }
}
