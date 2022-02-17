<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Validator;
use Session;
use Input;
use DB;


class ProductController extends Controller
{
    public function index(Request $request){
        
          if($request->search==""){           
           $products = Product::orderBy('id','desc')
           ->paginate(5);           
           return view('products.product_index',compact('products'));
        }
        else{
           $products = Product::where('product_name','LIKE','%'.$request->search.'%')
                ->orderBy('id','asc')
                ->paginate(5);
            $products->appends($request->only('search'));
            return view('products.product_index',compact('products'));
        }
    }

   
    public function insert(Request $request){
       $rules = array(
        'product_name' => 'required|unique:products',
        'product_price'=> 'required', 
        'product_gst' => 'required');
        
        $error = Validator::make($request->all(),$rules);
        if($error->fails()){
            return response()->json(['errors'=>$error->errors()->all()]);
        }
        $form_data = array(  
        'product_name' => $request->product_name,
        'product_price'=> $request->product_price,
        'product_gst'=> $request->product_gst
                             );
        //dd($form_data);
        Product::create($form_data);
        return response()->json(['success' => 'Data Inserted Successfully.']);
    }


    public function edit($id){
        if(request()->ajax()){
            $data = Product::findOrFail($id);
            return response()->json(['data'=> $data]);
        }

    }

    public function update(Request $request){
        $rules = array(
        'product_name' => 'required|unique:products',
        'product_price'=> 'required', 
        'product_gst' => 'required'
       );
        
        $error = Validator::make($request->all(),$rules);
        if($error->fails()){
            return response()->json(['errors'=>$error->errors()->all()]);
        }
        $form_data = array( 
        'product_name' => $request->product_name,
        'product_price'=> $request->product_price,
        'product_gst'=> $request->product_gst
        );
        //dd($form_data);
        Product::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data  Updated Successfully.']);

    }

    public function delete($id){
        $data = Product::findOrFail($id);
        $data->delete();
    }

}