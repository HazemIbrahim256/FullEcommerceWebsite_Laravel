@extends('frontend.main_master')
@section('content')
    <div class="body-content">
        <div class="container">
            <div class="row">
                @include('frontend.common.user_sidebar')
                <div class="col-md-1">

                </div>
                <div class="col-md-9">
                    <div class="table-response">
                        <table class="table">
                            <tbody>
                                <tr style="background: #e2e2e2">
                                    <td class="col-md-1">
                                        <label for="">Date</label>
                                    </td>
                                    <td class="col-md-2">
                                        <label for="">Total</label>
                                    </td>
                                    <td class="col-md-3">
                                        <label for="">Payment Method</label>
                                    </td>
                                    <td class="col-md-2">
                                        <label for="">Invoice</label>
                                    </td>
                                    <td class="col-md-2">
                                        <label for="">Order</label>
                                    </td>
                                    <td class="col-md-3">
                                        <label for="">Action</label>
                                    </td>
                                </tr>

                                @foreach ($orders as $item)
                                    <tr>
                                        <td class="col-md-1">
                                            <label for="">{{$item->order_date}}</label>
                                        </td>
                                        <td class="col-md-2">
                                            <label for="">${{$item->amount}}</label>
                                        </td>
                                        <td class="col-md-3">
                                            <label for="">{{$item->payment_method}}</label>
                                        </td>
                                        <td class="col-md-2">
                                            <label for="">{{$item->invoice_no}}</label>
                                        </td>
                                        <td class="col-md-2">
                                            <label for=""> 
                                                
                                            @if($item->status == 'pending')        
                                                <span class="badge badge-pill badge-warning" style="background: #800080;"> Pending </span>
                                            @elseif($item->status == 'confirm')
                                                <span class="badge badge-pill badge-warning" style="background: #0000FF;"> Confirmed </span>
                                            @elseif($item->status == 'processing')
                                                <span class="badge badge-pill badge-warning" style="background: #FFA500;"> Processing </span>

                                            @elseif($item->status == 'picked')
                                                <span class="badge badge-pill badge-warning" style="background: #808000;"> Picked </span>

                                            @elseif($item->status == 'shipped')
                                                <span class="badge badge-pill badge-warning" style="background: #808080;"> Shipped </span>

                                            @elseif($item->status == 'delivered')
                                                <span class="badge badge-pill badge-warning" style="background: #008000;"> Delivered </span>

                                            @if($item->return_order == 1) 
                                            <span class="badge badge-pill badge-warning" style="background:red;">Return Requested </span>
                                            @endif
                                            
                                            @else
                                                <span class="badge badge-pill badge-warning" style="background: #FF0000;"> Canceled </span>

                                            @endif
                                                </label>
                                            </td>



                                        <td class="col-md-3">
                                            <a href="{{url('user/order_details/'.$item->id)}}" class="btn btn-sm btn-primary" title="View"><i class="fa fa-eye"></i> View</a>
                                            <a target="_blank" href="{{ url('user/invoice_download/'.$item->id ) }}" class="btn btn-sm btn-danger" style="margin-top: 5px;"><i class="fa fa-download" style="color: white;"></i> Invoice </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection