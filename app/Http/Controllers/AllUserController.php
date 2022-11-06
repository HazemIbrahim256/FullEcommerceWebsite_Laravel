<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AllUserController extends Controller
{
    public function Orders()
    {
        $orders = Order::where('user_id',Auth::id())->orderBy('id','DESC')->get();
        return view('frontend.user.orders.orders_view',compact('orders'));
    }
    public function OrderDetails($order_id)
    {
        $order = Order::with('division','district','state','user')->where('id',$order_id)->where('user_id',Auth::id())->first();
        $orderitem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();
        return view('frontend.user.orders.order_details',compact('order','orderitem'));
    }

    public function InvoiceDownload($order_id){
        $order = Order::with('division','district','state','user')->where('id',$order_id)->where('user_id',Auth::id())->first();
        $orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();
        //return view('frontend.user.orders.order_invoice',compact('order','orderItem'));
        $pdf = PDF::loadView('frontend.user.orders.order_invoice',compact('order','orderItem'))->setPaper('a4')->setOptions([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    } // end mehtod
    
    
    public function ReturnOrder(Request $request,$order_id){

        Order::findOrFail($order_id)->update([
            'return_date' => Carbon::now()->format('d F Y'),
            'return_reason' => $request->return_reason,
            'return_order' => 1,
        ]);


        $notification = array(
            'message' => 'Return Request Send Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('my.orders')->with($notification);

    } // end method 

    public function ReturnOrderList(){

        $orders = Order::where('user_id',Auth::id())->where('return_reason','!=',NULL)->orderBy('id','DESC')->get();
        return view('frontend.user.orders.return_order_view',compact('orders'));

    } // end method 

    public function CancelOrders(){

        $orders = Order::where('user_id',Auth::id())->where('status','cancel')->orderBy('id','DESC')->get();
        return view('frontend.user.orders.cancel_order_view',compact('orders'));

    } // end method 

    ///////////// Order Traking ///////

    public function OrderTraking(Request $request){

        $invoice = $request->code;

        $track = Order::where('invoice_no',$invoice)->first();

        if ($track) {

            // echo "<pre>";
            // print_r($track);

        return view('frontend.tracking.track_order',compact('track'));

        }else{

            $notification = array(
            'message' => 'Invoice Code Is Invalid',
            'alert-type' => 'error'
        );

        return redirect()->back()->with($notification);

        }

    } // end mehtod 

}
