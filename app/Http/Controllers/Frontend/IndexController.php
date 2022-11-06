<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Subcategory;
use App\Models\SubSubcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index()
    {
        $blogpost = BlogPost::latest()->get();
        $products = Product::where('status',1)->orderBy('id','DESC')->limit(6)->get();
        $categories = Category::orderBy('category_name_en','ASC')->get();
        $sliders = Slider::where('status',1)->orderBy('id','DESC')->limit(3)->get();
        $featured = Product::where('featured',1)->orderBy('id','DESC')->limit(6)->get();
        $hot_deals = Product::where('hot_deals',1)->where('discount_price','!=',NULL)->orderBy('id','DESC')->limit(3)->get();
        $offers = Product::where('special_offers',1)->orderBy('id','DESC')->limit(3)->get();
        $deals = Product::where('special_deals',1)->orderBy('id','DESC')->limit(3)->get();
        $skip_category_0 = Category::skip(0)->first();
        //return $skip_cat->id;
        //die();
        $skip_product_0 = Product::where('status',1)->where('category_id',$skip_category_0->id)->orderBy('id','DESC')->limit(3)->get();
        $skip_category_1 = Category::skip(1)->first();
        $skip_product_1 = Product::where('status',1)->where('category_id',$skip_category_1->id)->orderBy('id','DESC')->limit(3)->get();
        $skip_brand_3 = Brand::skip(3)->first();
        $skip_product_3 = Product::where('status',1)->where('brand_id',$skip_brand_3->id)->orderBy('id','DESC')->limit(3)->get();

        return view('frontend.index',compact('categories','sliders','products','featured','hot_deals','offers','deals','skip_category_0','skip_product_0','skip_category_1','skip_product_1','skip_brand_3','skip_product_3','blogpost'));
    }
    public function UserLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function UserProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.user_profile',compact('user'));
    }
    public function UserStore(Request $request)
    {
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        if ($request->file('profile_photo_path')){
            $file = $request->file('profile_photo_path');
            unlink(public_path('upload/user_images/'.$data->profile_photo_path));
            $filename = date('Ymdhi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['profile_photo_path'] = $filename;
        }
        $data->save();
        $notification = array(
            'message' => 'Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('dashboard')->with($notification);
    }
    public function ChangePWD()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.change_password',compact('user'));
    }
    public function UpdatePWD(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ]);
        $hashedpassword = Auth::user()->password;
        if (Hash::check($request->oldpassword,$hashedpassword))
        {
            $user = User::find(Auth::id());
            $user -> password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route('user.logout');
        }else{
            return redirect()->back();
        }
    }
    public function frontProductDetails($id,$slug)
    {
        $product = Product::findOrFail($id);
        
        $color_en = $product->product_color_en;
        $product_color_en = explode(',',$color_en);
        $color_ar = $product->product_color_ar;
        $product_color_ar = explode(',',$color_ar);

        $size_en = $product->product_size_en;
        $product_size_en = explode(',',$size_en);
        $size_ar = $product->product_size_ar;
        $product_size_ar = explode(',',$size_ar);

        //$data['']

        $multiimg = MultiImg::where('product_id',$id)->get();


        $cat_id = $product->category_id;
        $relatedProducts = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->get();
        return view('frontend.product.product_details',compact('product','multiimg','product_color_en','product_color_ar','product_size_en','product_size_ar','relatedProducts'));
    }
    public function TagWiseProduct($tag)
    {
        $products = Product::where('status',1)->where('product_tags_en',$tag)->where('product_tags_ar',$tag)->orderBy('id','DESC')->paginate(3);
        $categories = Category::orderBy('category_name_en','ASC')->get();
        

        return view('frontend.tags.tags_view',compact('products','categories'));
    }


    public function SubcatWiseProduct(Request $request, $subcat_id,$slug)
    {
        $products = Product::where('status',1)->where('subcategory_id',$subcat_id)->orderBy('id','DESC')->paginate(6);
        $categories = Category::orderBy('category_name_en','ASC')->get();

        $breadsubcat = SubCategory::with(['category'])->where('id',$subcat_id)->get();

        ///  Load More Product with Ajax 
		if ($request->ajax()) {
            $grid_view = view('frontend.product.grid_view_product',compact('products'))->render();
        
            $list_view = view('frontend.product.list_view_product',compact('products'))->render();
            return response()->json(['grid_view' => $grid_view,'list_view',$list_view]);	
        
            }
        ///  End Load More Product with Ajax 
                
		return view('frontend.product.subcategory_view',compact('products','categories','breadsubcat'));
    }

    public function SubSubcatWiseProduct($subsubcat_id,$slug)
    {
        $products = Product::where('status',1)->where('subsubcategory_id',$subsubcat_id)->orderBy('id','DESC')->paginate(6);
        $categories = Category::orderBy('category_name_en','ASC')->get();

        $breadsubsubcat = SubSubcategory::with(['category','subcategory'])->where('id',$subsubcat_id)->get();

		return view('frontend.product.subsubcategory_view',compact('products','categories','breadsubsubcat'));
    }

    public function productViewAjax($id)
    {
        $product = Product::with('category','brand')->findOrFail($id);

        $color = $product->product_color_en;
        $product_color = explode(',',$color);

        $size = $product->product_size_en;
        $product_size = explode(',',$size);
        return response()->json(array(
            'product' => $product,
            'color' => $product_color,
            'size' => $product_size,
        ));
    }
    // Product Seach 
	public function ProductSearch(Request $request){
        $request->validate(["search" => "required"]);
		$item = $request->search;
		// echo "$item";
        $categories = Category::orderBy('category_name_en','ASC')->get();
		$products = Product::where('product_name_en','LIKE',"%$item%")->get();
		return view('frontend.product.search',compact('products','categories'));
	}

    ///// Advance Search Options 

	public function SearchProduct(Request $request){
		$request->validate(["search" => "required"]);

		$item = $request->search;		 

		$products = Product::where('product_name_en','LIKE',"%$item%")->select('product_name_en','product_thumbnail','selling_price','id','product_slug_en')->limit(5)->get();
		return view('frontend.product.search_product',compact('products'));



	} // end method 
}
