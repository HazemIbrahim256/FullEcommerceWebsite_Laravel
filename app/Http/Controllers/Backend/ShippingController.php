<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ShipDistrict;
use App\Models\Shipping;
use App\Models\ShipState;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function DivisionView()
    {
        $divisions = Shipping::orderBy('id','DESC')->get();
        return view('backend.ship.division.view_division',compact('divisions'));
    }
    public function DivisionStore(Request $request)
    {
        $request->validate([
            'division_name' => 'required'
        ]);
        Shipping::insert([
            'division_name' => $request->division_name,
            'created_at' => Carbon::now()
        ]);
        $notification = array(
            'message' => 'Added Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function DivisionEdit($id)
    {
        $division = Shipping::findOrFail($id);
        return view('backend.ship.division.edit_division',compact('division'));
    }
    public function DivisionUpdate(Request $request)
    {
        $division_id = $request->id;
        Shipping::findOrFail($division_id)->update([
            'division_name' => $request->division_name,
            'created_at' => Carbon::now()
        ]);
        $notification = array(
            'message' => 'Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('mng.division')->with($notification);
    }
    public function DivisionDelete($id)
    {
        Shipping::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }





    public function DistrictView()
    {
        $divisions = Shipping::orderBy('division_name','ASC')->get();
        $districts = ShipDistrict::with('division')->orderBy('id','DESC')->get();
        return view('backend.ship.district.view_district',compact('districts','divisions'));
    }
    public function DistrictGet($division_id)
    {
        $ship = ShipDistrict::where('division_id',$division_id)->orderBy('district_name','ASC')->get();
        return json_decode($ship);
    }
    public function DistrictStore(Request $request)
    {
        $request->validate([
            'division_id' => 'required',
            'district_name' => 'required'
        ]);
        ShipDistrict::insert([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
            'created_at' => Carbon::now()
        ]);
        $notification = array(
            'message' => 'Added Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function DistrictEdit($id)
    {
        $divisions = Shipping::orderBy('division_name','ASC')->get();
        $district = ShipDistrict::findOrFail($id);
        return view('backend.ship.district.edit_district',compact('district','divisions'));
    }
    public function DistrictUpdate(Request $request)
    {
        $district_id = $request->id;
        ShipDistrict::findOrFail($district_id)->update([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
            'created_at' => Carbon::now()
        ]);
        $notification = array(
            'message' => 'Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('mng.district')->with($notification);
    }
    public function DistrictDelete($id)
    {
        ShipDistrict::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }





    public function StateView()
    {
        
        $divisions = Shipping::orderBy('division_name','ASC')->get();
        $districts = ShipDistrict::orderBy('district_name','ASC')->get();
        $states = ShipState::with('division','district')->orderBy('id','DESC')->get();
        return view('backend.ship.state.view_state',compact('districts','divisions','states'));
    }
    public function StateStore(Request $request)
    {
        $request->validate([
            'division_id' => 'required',
            'district_id' => 'required',
            'state_name' => 'required'
        ]);
        ShipState::insert([
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_name' => $request->state_name,
            'created_at' => Carbon::now()
        ]);
        $notification = array(
            'message' => 'Added Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function StateEdit($id)
    {
        $divisions = Shipping::orderBy('division_name','ASC')->get();
        $districts = ShipDistrict::orderBy('district_name','ASC')->get();
        $state = ShipState::findOrFail($id);
        return view('backend.ship.state.edit_state',compact('districts','divisions','state'));
    }
    public function StateUpdate(Request $request)
    {
        $state_id = $request->id;
        ShipState::findOrFail($state_id)->update([
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_name' => $request->state_name,
            'created_at' => Carbon::now()
        ]);
        $notification = array(
            'message' => 'Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('mng.state')->with($notification);
    }
    public function StateDelete($id)
    {
        ShipState::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
