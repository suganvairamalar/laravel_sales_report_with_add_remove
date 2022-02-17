<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
     protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_name','customer_mobile','customer_email','order_date','order_bill_no','order_product_name','order_quantity','order_product_price','order_product_amount','order_product_gst','order_product_discount','order_sub_total','order_grand_total'];


    public function getCustomerNameAttribute($value)
    {
      return ucfirst($value);
    }

    public function getCustomerEmailAttribute($value)
    {
      return strtolower($value);
    }


    protected $dates = ['order_date'];

    public function getOrderDateAttribute($value){         
        return Carbon::parse($value)->format('d-m-Y');
    }

     //BELOW FUNCTION USED TO SEND VIEW TO DATABASE in 
    public function setOrderDateAttribute($orderDate) {
        $this->attributes['order_date'] = Carbon::parse($orderDate)->toDateString(); //'toDateTimeString(); use to dd:mm:yyyy:hh:mm:ss
    }
    
    public function getOrderProductNameAttribute($order_product_name){
        return explode(',',$order_product_name);
    }

    public function getOrderProductPriceAttribute($order_product_price){
        return explode(',',$order_product_price);
    }

    public function getOrderProductGstAttribute($order_product_gst){
        return explode(',',$order_product_gst);
    }

    public function getOrderProductAmountAttribute($order_product_amount){
        return explode(',',$order_product_amount);
    }   

    public function getOrderQuantityAttribute($order_quantity){
        return explode(',',$order_quantity);
    }

    public function setCustomerEmailAttribute($value)
    {
      $this->attributes['customer_email'] = strtolower($value);
    }

    public function setCustomerNameAttribute($value)
    {
      $this->attributes['customer_name'] = strtolower($value);
    }
 
    public function setOrderProductNameAttribute($order_product_name){
         $this->attributes['order_product_name'] = implode(",", $order_product_name);
    }

    public function setOrderProductPriceAttribute($order_product_price){
       $this->attributes['order_product_price'] = implode(",", $order_product_price);
    }

    public function setOrderProductGstAttribute($order_product_gst){
         $this->attributes['order_product_gst'] = implode(",", $order_product_gst);
    }

    public function setOrderQuantityAttribute($order_quantity){
       $this->attributes['order_quantity'] = implode(",", $order_quantity);
    }

    public function setOrderProductAmountAttribute($order_product_amount){
       $this->attributes['order_product_amount'] = implode(",", $order_product_amount);
    }
}
