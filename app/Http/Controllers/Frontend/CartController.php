<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupons;
use App\Models\Product;
use App\Models\Shipping;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function AddtoCart(Request $request, $id)
    {
        if (Session::has('coupon')){
            Session::forget('coupon');
        }
        
        $product = Product::findOrFail($id);

        if ($product->discount_price == NULL) {
            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->selling_price,
                'weight' => 1,
                'options' => [
                    'image' => $product->product_thumbnail,
                    'color' => $request->color,
                    'size' => $request->size
                ],
            ]);

            return response()->json([ 'success' => 'Successfully Added']);
        } else {
            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->discount_price,
                'weight' => 1,
                'options' => [
                    'image' => $product->product_thumbnail,
                    'color' => $request->color,
                    'size' => $request->size
                ],
            ]);
            
            return response()->json([ 'success' => 'Successfully Added']);

        }
        
    }
    public function AddtominiCart()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => round($cartTotal),
        ));
    }
    public function miniCartRemove($rowId)
    {
        Cart::remove($rowId);
        return response()->json(['success' => 'Product Removed']);
    }

    public function couponApply(Request $request)
    {
        $coupon = Coupons::where('coupon_name',$request->coupon_name)->where('coupon_validity','>=',Carbon::now()->format('Y-m-d'))->first();
        if ($coupon) {
            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount / 100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount / 100)
            ]);
            return response()->json(array(
                'validity' => true,
                'success' => 'Coupon Applied'
            ));
        } else {
            return response()->json(['error' => 'Invalid Coupon']);
        }
    }
    public function couponCalculation()
    {
        if (Session::has('coupon')) {
            return response()->json(array(
                'subtotal' => Cart::total(),
                'coupon_name' => session()->get('coupon')['coupon_name'],
                'coupon_discount' => session()->get('coupon')['coupon_discount'],
                'discount_amout' => session()->get('coupon')['discount_amount'],
                'total_amount' => session()->get('coupon')['total_amount'],
            ));
        } else {
            return response()->json(array(
                'total' => Cart::total(),
            ));
        }
        
    }
    public function couponRemove()
    {
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon Removed']);
    }


    public function Checkout()
    {
        if (Auth::check())
        {
            if (Cart::total() > 0)
            {
                $carts = Cart::content();
                $cartQty = Cart::count();
                $cartTotal = Cart::total();

                $divisions = Shipping::orderBy('division_name','ASC')->get();
                return view('frontend.checkout.checkout_view',compact('carts','cartQty','cartTotal','divisions'));
            } else {
                $notification = array(
                    'message' => 'Your Cart is Empty!!',
                    'alert-type' => 'error'
                );
                return redirect()->to('/')->with($notification);
            }
        } else {
            $notification = array(
                'message' => 'Login First!!',
                'alert-type' => 'error'
            );
            return redirect()->route('login')->with($notification);
        }
    }
}
