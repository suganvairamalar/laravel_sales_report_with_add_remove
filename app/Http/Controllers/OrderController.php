<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use DB;
use DateTime;
use Carbon\Carbon;
use Form;
use Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        /*$orders = Order::orderBy('id','asc')->paginate(5);
        return view('orders.order_index',compact('orders'));*/
        if($request->search==""){
            $orders = Order::orderBy('id','desc')
                      ->paginate(5); 
            return view('orders.order_index',compact('orders'));
        }
        else{
           $orders = Order::select('orders.*')
                        ->orderBy('id','desc');
                         
             if($request->get('search_dropdown')=='order_date'){
                 $orders->where('order_date','=',date('Y-m-d', strtotime($request->get('search'))));
                } 
             if($request->get('search_dropdown')=='order_bill_no'){
                $orders->where('order_bill_no','LIKE','%'.$request->get('search').'%');
                } 
             if($request->get('search_dropdown')=='customer_name'){
                $orders->where('customer_name','LIKE','%'.$request->get('search').'%');
                }
             if($request->get('search_dropdown')=='customer_mobile'){
                $orders->where('customer_mobile','LIKE','%'.$request->get('search').'%');
                }
             $orders=$orders->paginate(5);
             $orders->appends($request->only('search'));
             return view('orders.order_index',compact('orders'));
        }
    }

    public function order_product_fetch(Request $request){

        $query = $request->get('term','');
       
        $products = Product::orderBy('id','desc');
         
        if($request->type=='product_name'){
                      $products->where('product_name','LIKE','%'. $query.'%');
                      } 
        if($request->type=='product_price'){
                      $products->where('product_price','LIKE','%'. $query.'%');
                      }  
       if($request->type=='product_gst'){
                      $products->where('product_gst','LIKE','%'. $query.'%');
                      } 
        $products=$products->get();

         $data=array();

          foreach ($products as $product) {
                $data[]=array(
                        
                              'product_name'  => $product->product_name,
                              'product_price' => $product->product_price,
                              'product_gst' => $product->product_gst
                        );
        }
        if(count($data)){
             return $data;
             }
        else{
            return ['product_name'=>'','product_price'=>'','product_gst'=>''];
        }
    }

    public function insert(Request $request){
      $order = new Order();   

       $rules = [
              'order_date' => 'required',
              'customer_name' => 'required',
              'customer_mobile'=> 'required', 
              'customer_email' => 'required|email'
       ];

        foreach($request->input('order_product_name') as $key => $value) {
            $rules["order_product_name.{$key}"] = 'required';
        }

        foreach($request->input('order_product_price') as $key => $value) {
            $rules["order_product_price.{$key}"] = 'required';
        }

        foreach($request->input('order_product_gst') as $key => $value) {
            $rules["order_product_gst.{$key}"] = 'required';
        }

         foreach($request->input('order_quantity') as $key => $value) {
            $rules["order_quantity.{$key}"] = 'required';
        }

        foreach($request->input('order_product_amount') as $key => $value) {
            $rules["order_product_amount.{$key}"] = 'required';
        }

        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
         return response()->json(['error'  => $error->errors()->all()]);
        } 

        $form_data = array(
            'order_date' => date('Y-m-d', strtotime($request->order_date)), 
            'order_bill_no' => $request->order_bill_no,
            'customer_name' => $request->customer_name,
            'customer_mobile' => $request->customer_mobile,
            'customer_email' => $request->customer_email,
            'order_product_name'     => $request->order_product_name,
            'order_product_name'     => $request->order_product_name, 
            'order_product_name'     => $request->order_product_name,                         
            'order_product_price'    => $request->order_product_price,
            'order_product_gst'     => $request->order_product_gst,
            'order_quantity'         => $request->order_quantity,
            'order_product_amount'   => $request->order_product_amount,
            'order_sub_total'        => $request->order_sub_total
                        );

        Order::create($form_data);
        
        return response()->json(['success' => 'Data Inserted Successfully.']);

    }

    public function edit($id){
    if(request()->ajax()){
        $data = Order::findOrFail($id);       
        return response()->json(['data' => $data]);
      }
   }

   public function update(Request $request){
     $rules = [
        'order_date' => 'required',
        'customer_name' => 'required',
        'customer_mobile'=> 'required', 
        'customer_email' => 'required|email'

     ];
       
        foreach($request->input('order_product_name') as $key => $value) {
            $rules["order_product_name.{$key}"] = 'required';
        }       

        foreach($request->input('order_product_price') as $key => $value) {
            $rules["order_product_price.{$key}"] = 'required';
        }

        foreach($request->input('order_product_gst') as $key => $value) {
            $rules["order_product_gst.{$key}"] = 'required';
        }

         foreach($request->input('order_quantity') as $key => $value) {
            $rules["order_quantity.{$key}"] = 'required';
        }

        foreach($request->input('order_product_amount') as $key => $value) {
            $rules["order_product_amount.{$key}"] = 'required';
        }

      $error = Validator::make($request->all(), $rules);
      if($error->fails())
      {
       return response()->json(['error'  => $error->errors()->all()]);
      }     

      $form_data = array(
                       
        'order_date'             => date('Y-m-d', strtotime($request->order_date)),
        
        'customer_name' => $request->customer_name,
        'customer_mobile' => $request->customer_mobile,
        'customer_email' => $request->customer_email,      
        'order_product_name'     => implode(',',$request->order_product_name),        
        'order_product_price'    => implode(',',$request->order_product_price),
        'order_product_gst'     => implode(',',$request->order_product_gst),
        'order_product_amount'   => implode(',',$request->order_product_amount),
        'order_quantity'         => implode(',',$request->order_quantity),
        'order_sub_total'        => $request->order_sub_total
                        );
      
      Order::whereId($request->hidden_id)->update($form_data);
      return response()->json(['success' => 'Data Updated Success.']);
   }


    public function delete($id){
        $data = Order::findOrFail($id);
        $data->delete();
    }


}
