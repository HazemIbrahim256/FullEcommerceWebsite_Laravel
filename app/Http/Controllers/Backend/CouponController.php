<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupons;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function CouponView()
    {
        $coupons = Coupons::orderBy('id','DESC')->get();
        return view('backend.coupon.coupon_view',compact('coupons'));
    }
    public function StoreCoupon(Request $request)
    {
        $request->validate([
            'coupon_name' => 'required',
            'coupon_discount' => 'required',
            'coupon_validity' => 'required',
        ],[
            'coupon_name.required' => 'Enter Coupon Name',
            'coupon_discount.required' => 'Enter Coupon Discount',
            'coupon_validity.required' => 'What about the validity ?'
        ]);
        Coupons::insert([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Added Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function CouponEdit($id)
    {
        $coupon = Coupons::findOrFail($id);
        return view('backend.coupon.coupon_edit',compact('coupon'));
    }
    public function UpdateCoupon(Request $request)
    {
        $coupon_id = $request->id;
        Coupons::findOrFail($coupon_id)->update([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('mng.coupon')->with($notification);
    }
    public function CouponDelete($id)
    {
        Coupons::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
