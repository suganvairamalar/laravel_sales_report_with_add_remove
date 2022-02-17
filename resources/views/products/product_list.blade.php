 @if(!empty($products))               
               <table class="table table-striped table-bordered table-hover" width="100%">
                  <thead>  
                   <form id="product_search_form" action="/products">  
                  <tr>

                     {{ csrf_field() }}
                           {{ method_field('GET') }}
                      <td class="col-lg-6 col-xs-6 col-sm-6 col-md-6" colspan="4">
                           <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                           <input type="text" class="form-control" name="search" id="search">
                     </td>
                     <td class="col-lg-2 col-xs-2 col-sm-2 col-md-2">
                     <button type="submit" class="btn btn-warning" id="product_search_submit" name="product_search_submit" title="Search">
                     <span class="glyphicon glyphicon-search"></span></button> 
                     <a href="{{route('product.index')}}" class="btn btn-primary" title="Refresh" data-placement="bottom"><span class="reloadbtn glyphicon glyphicon-refresh"></span></a>                     
                     </td>                     
                  </tr>   
                  </form>              
                     <tr class="bg-primary">
                        <th class="col-lg-1 col-xs-1 col-sm-1 col-md-1">S.NO</th>
                       
                        
                        <th class="col-lg-2 col-xs-2 col-sm-2 col-md-2">PRODUCT</th>

                        <th class="col-lg-2 col-xs-2 col-sm-2 col-md-2">PRICE</th>

                        <th class="col-lg-2 col-xs-2 col-sm-2 col-md-2">INSTOCK</th>
                        <th class="col-lg-2 col-xs-2 col-sm-2 col-md-2">ACTION</th>
                     </tr>
                  </thead>
                  <tbody >
                     <?php $i=0; ?>
                     @foreach($products as $product)
                     <?php $i++; ?>
                     <tr>
                        <td  class="col-xs-1 col-sm-1 col-md-1">{{ $i }}</td>
                        
                        <td  class="col-lg-2 col-xs-2 col-sm-2 col-md-2">{{ $product->product_name }}</td>
                        <td  class="col-lg-2 col-xs-2 col-sm-2 col-md-2">{{ $product->product_price }}</td>
                        <td  class="col-lg-2 col-xs-2 col-sm-2 col-md-2">{{ $product->product_gst }}</td>
                        <td  class="col-lg-2 col-xs-2 col-sm-2 col-md-2">
                           <!-- class="btn btn-info glyphicon glyphicon-th detailbtn" -->
                           <button type="button" name="edit" id="{{ $product->id }}" class="edit btn btn-warning glyphicon glyphicon-edit btn-md" title="Edit" data-placement="bottom"></button> <!-- class="btn btn-warning btn-sm editbtn" -->
                           <button type="button" name="delete" id="{{ $product->id }}" class="delete btn btn-danger glyphicon glyphicon-trash btn-md" title="Delete" data-placement="bottom"></button> <!-- class="btn btn-danger btn-sm deletebtn" -->
                        </td>
                     </tr>
                     @endforeach       
                  </tbody>
               </table>
            @endif    
            {!! $products->appends(Request::capture()->except('page'))->render() !!}
            <!-- {!!$products->render()!!}  -->