@if(!empty($orders))   
<div class="table-responsive tableFixHead">
   <table class="table table-striped table-bordered table-hover">
      <thead>
         <tr class="bg-primary">
            <th class="col-xs-1 col-sm-1 col-md-1">S.NO</th>
            <th class="col-xs-1 col-sm-1 col-md-1">DATE</th> 
            <th class="col-xs-1 col-sm-1 col-md-1">BILL NO</th> 
            <th class="col-xs-2 col-sm-2 col-md-2">CUSTOMER NAME</th>  
            <th class="col-xs-2 col-sm-2 col-md-2">CUSTOMER MOBILE</th>      
            <th class="col-xs-2 col-sm-2 col-md-2">PRODUCT NAME(S)</th>        
            <th class="col-xs-1 col-sm-1 col-md-1">TOTAL</th>         
            <th class="col-xs-2 col-sm-2 col-md-2">ACTION</th>
         </tr>
      </thead>
      <tbody >

         <?php $i=0; ?>
         @foreach($orders as $order)
         <?php $i++; ?>
         <tr>
            <td >{{ $i }}</td>
            <td >{{ $order->order_date }}</td>
            <td >{{ $order->order_bill_no }}</td>
            <td >{{ $order->customer_name }}</td>            
            <td >{{ $order->customer_mobile }}</td>            
            <td >{{ implode(',', (array)$order->order_product_name) }}</td>
            <td >{{ $order->order_sub_total }}</td>
         
            <td>
                <!-- class="btn btn-info glyphicon glyphicon-th detailbtn" -->
               <button type="button" name="edit" id="{{ $order->id }}" class="edit btn btn-warning btn-sm">Edit</button> <!-- class="btn btn-warning glyphicon glyphicon-edit editbtn" -->
               <button type="button" name="delete" id="{{ $order->id }}" class="delete btn btn-danger btn-sm">Delete</button> <!-- class="btn btn-danger glyphicon glyphicon-trash deletebtn" -->
            </td>
         </tr>
         @endforeach       
      </tbody>
   </table>
</div>
@endif     
<!-- </div> -->

 {!! $orders->appends(Request::capture()->except('page'))->render() !!}

<!-- {!!$orders->render()!!} -->


<!-- implode(',',$order->order_product_name)
 sometimes if u give above code u will get error below like this
implode(): Invalid arguments passed laravel

solution: u will give the code like this u will solve 
implode(',', (array)$order->order_product_name) -->