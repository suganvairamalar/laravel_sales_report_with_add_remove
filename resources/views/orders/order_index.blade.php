@extends('layouts.order_app')
@section('content')
<div class="jumbotron">
   <div class="row">
      <div class="pull-left">
         <button type="button" name="order_create_record" id="order_create_record" class="btn btn-success btn-sm">ADD</button>
      </div>
      <div class="pull-right">
         <div class="form-group form-inline">
            <form id="order_search_form" action="/" autocomplete="off">
               {{ csrf_field() }}
               {{ method_field('GET') }}

               <label >SEARCH</label>
               <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

               <select class="form-control" name="search_dropdown" id="search_dropdown">
                          <option value="">Select Search</option>
                          <option value="order_date">ORDER DATE</option>
                          <option value="order_bill_no">BILL NO</option>
                          <option value="customer_name">CUSTOMER NAME</option>
                          <option value="customer_mobile">CUSTOMER MOBILE</option>
                        </select>
               <input type="text" class="form-control" name="search" id="search">
               <button type="submit" class="btn btn-warning" id="order_search_submit" name="order_search_submit">
               <span class="glyphicon glyphicon-search"></span></button> 
               <a href="{{route('order.index')}}" class="btn btn-primary"><span class="reloadbtn glyphicon glyphicon-refresh"></span></a>
            </form>
         </div>
      </div>
   </div>
   <div class="row">
      @include('orders.order_list')   
   </div>
</div>
<div class="row">
   <div id="order_form_Modal" class="modal fade " role="dialog">
      <div class="modal-dialog modal-xl">
         <div class="modal-content">
            <div class="modal-header bg-danger">
               <label class="modal-title">ADD FORM</label>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="start_cloes"><span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form method="post" id="order_form" class="form-horizontal" autocomplete="off">
               <div class="modal-body bg-primary">
                  <span id="order_form_result"></span>
                  {{ csrf_field() }}
                  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> 
              
                  <table id="tbl_detail_order" >
                     <div class="form-group">
                     <label class="control-label1 col-md-1 col-lg-1 col-xs-1 col-sm-1">DATE </label>
                     <div class="col-md-3 col-lg-3 col-xs-3 col-sm-3">
                        <input type="text" id="order_date" name="order_date" class="form-control datepicker order_date" placeholder="DD-MM-YYYY" style="">
                     </div>  
                       <label class="control-label1 col-md-1 col-lg-1 col-xs-1 col-sm-1">Bill No </label>
                     <div class="col-md-2 col-lg-2 col-xs-2 col-sm-2">
                       <input type="text" name="order_bill_no" id="order_bill_no" class="form-control" readonly />
                     </div>  

                  </div>
                     

                  <div class="form-group">
                     <label class="control-label1 col-md-1 col-lg-1 col-xs-1 col-sm-1">Name </label>
                     <div class="col-md-3 col-lg-3 col-xs-3 col-sm-3">
                        <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="name">
                     </div>  
                     <label class="control-label1 col-md-1 col-lg-1 col-xs-1 col-sm-1">Mobile </label>
                     <div class="col-md-3 col-lg-3 col-xs-3 col-sm-3">
                        <input type="text" id="customer_mobile" name="customer_mobile" class="form-control" placeholder="mobile">
                     </div>                    
                     <label class="control-label1 col-md-1 col-lg-1 col-xs-1 col-sm-1">Email </label>
                     <div class="col-md-3 col-lg-3 col-xs-3 col-sm-3">
                        <input type="text" id="customer_email" name="customer_email" class="form-control" placeholder="email">
                     </div>  
                    
                     </div>                    
                  </div>

                     <thead >
                        <th class="col-xs-1 col-sm-1 col-md-1"><input class='check_all' type='checkbox' onclick=""/></th>
                        <th class="col-xs-1 col-sm-1 col-md-1">S. No</th>  
                        <th class="col-xs-2 col-sm-2 col-md-2">PRODUCT</th>
                        <th class="col-xs-2 col-sm-2 col-md-2">PRICE</th>
                        <th class="col-xs-2 col-sm-2 col-md-2">GST</th>
                        <th class="col-xs-1 col-sm-1 col-md-1">QUANTITY</th>
                        <th class="col-xs-2 col-sm-2 col-md-2">AMOUNT</th>
                     </thead>
                     <tbody>
                        <tr id="tr_data_order">
                           <td class="col-xs-1 col-sm-1 col-md-1"><input type='checkbox' class='chkbox'/></td>
                           <td class="col-xs-1 col-sm-1 col-md-1 "><span id='sn'>1.</span></td>
                           <td class="col-xs-2 col-sm-2 col-md-2 "><input class="form-control order_product_name" type='text' data-type="product_name" id='order_product_name_1' name='order_product_name[]'/> </td>
                           <td class="col-xs-2 col-sm-2 col-md-2 "><input class="form-control order_product_price" type='text' data-type="product_price" id='order_product_price_1' name='order_product_price[]'/> </td>
                          <td class="col-xs-2 col-sm-2 col-md-2 "><input class="form-control order_product_gst" type='text' data-type="product_gst" id='order_product_gst_1' name='order_product_gst[]'/> </td>
                           <td class="col-xs-1 col-sm-1 col-md-1 "><input class="form-control order_quantity" type='text' data-type="quantity" id='order_quantity_1' name='order_quantity[]'/> </td>
                           <td class="col-xs-2 col-sm-2 col-md-2 "><input class="form-control order_product_amount" type='text' data-type="product_amount" id='order_product_amount_1' name='order_product_amount[]' readonly /> </td>
                        </tr>
                     </tbody>
                  </table>
                  <table id="tbl_data_subtotal" width="100%"  >
                     <tbody>
                        <tr id="tbl_data_subtotal_tr" class="" style=>
                           <td class="col-xs-1 col-sm-1 col-md-1">&nbsp;</td>
                           <td class="col-xs-1 col-sm-1 col-md-1">&nbsp;</td>
                           <td class="col-xs-1 col-sm-1 col-md-1" style="display:none;">&nbsp;</td>
                           <td class="col-xs-2 col-sm-2 col-md-2">&nbsp;</td>
                           <td class="col-xs-2 col-sm-2 col-md-2">&nbsp;</td>
                           <td class="col-xs-2 col-sm-2 col-md-2">&nbsp;</td>
                           <td class="col-xs-1 col-sm-1 col-md-1"><strong>SUBTOTAL</strong></td>
                           <td class="col-xs-2 col-sm-2 col-md-2"><input class="form-control order_sub_total" type='text' id='order_sub_total' name='order_sub_total' readonly /></td>
                        </tr>
                     </tbody>
                  </table>
                  <button type="button" class='btn btn-danger delete'>- Delete</button>
                  <button type="button" class='btn btn-success addbtn'>+ Add More</button>
               </div>
               <div class="modal-footer bg-danger">
                  <input type="hidden" name="hidden_id" id="hidden_id" class="form-control">  

                  <input type="hidden" name="hidden_order_date" id="hidden_order_date" class="form-control"/>   

                  <input type="hidden" name="hidden_order_bill_no" id="hidden_order_bill_no" class="form-control"/>   

                  <input type="hidden" name="hidden_customer_name" id="hidden_customer_name" class="form-control"/>

                  <input type="hidden" name="hidden_customer_mobile" id="hidden_customer_mobile" class="form-control"/>

                  <input type="hidden" name="hidden_customer_email" id="hidden_customer_email" class="form-control"/>

                                
                  <input type="hidden" name="hidden_order_product_name" id="hidden_order_product_name" class="form-control"/>                  
                  <input type="hidden" name="hidden_order_product_price" id="hidden_order_product_price" class="form-control"/>  
                   <input type="hidden" name="hidden_order_product_gst" id="hidden_order_product_gst" class="form-control"/>  
                  <input type="hidden" name="hidden_order_quantity" id="hidden_order_quantity" class="form-control"/>  
                  <input type="hidden" name="hidden_order_product_amount" id="hidden_order_product_amount" class="form-control"/> 
                  <input type="hidden" name="hidden_order_sub_total" id="hidden_order_sub_total" class="form-control"/> 
                  <input type="hidden" name="order_action" id="order_action" />                 
                  <button type="button" class="btn btn-secondary" id="cloes" data-dismiss="modal">CLOSE</button>
                  <input type="submit" name="order_action_button" id="order_action_button" class="btn btn-primary" value="SAVE">
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


<div class="row">
      <div id="order_confirm_Modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header bg-danger">
                  <label class="modal-title">CONFIRMATION</label>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <p style="color:red;font-size:16px;font-weight: bold;font-style: italic;">Are you sure !! want to delete this record?</p>
               </div>
               <div class="modal-footer bg-danger">
                  <button type="button" name="order_ok_button" id="order_ok_button" class="btn btn-danger">OK</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection