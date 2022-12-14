<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ShipDistrict;
use App\Models\ShipState;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function DistrictGet($division_id)
    {
        $ship = ShipDistrict::where('division_id',$division_id)->orderBy('district_name','ASC')->get();
        return json_decode($ship);
    }
    public function StateGet($district_id)
    {
        $ship = ShipState::where('district_id',$district_id)->orderBy('state_name','ASC')->get();
        return json_decode($ship);
    }

    public function CheckoutStore(Request $request)
    {
        //dd($request->all());
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['postal_code'] = $request->postal_code;
        $data['division_id'] = $request->division_id;
        $data['district_id'] = $request->district_id;
        $data['state_id'] = $request->state_id;
        $data['notes'] = $request->notes;
        $cartTotal = Cart::total();

        if ($request->payment_method == 'stripe') {
            return view('frontend.payment.stripe',compact('data','cartTotal'));
        } elseif ($request->payment_method == 'card') {
            return 'card';
        } else {
            return view('frontend.payment.COD',compact('data','cartTotal'));
        }
    }
}
