$(document).ready(function(){

  $( "#start_cloes").click(function() { //it will use to clear the form data while clicking close button
    location.reload(true);
   });

  $( "#cloes").click(function() { //it will use to clear the form data while clicking close button
    location.reload(true);
   });


  $('#order_search_submit').on('click',function(){

            var _token = $('#token').val();
            $value = $('#search').val();
            $search_dropdown = $('#search_dropdown option:selected').val();
            /*alert($search_dropdown);
            return;*/
            if($search_dropdown == "")
            {
            $('#search_dropdown').focus();
            alert("Please select");
            return false;
            }

            if(($search_dropdown!='') && ($value=='')){
              $('#search').focus();
              alert("Please enter to search");
              return false;
            }
           
            
            $.ajax({
               type:'GET',
               url:'/',
               data:{'search_dropdown':$search_dropdown,'search':$value,_token:_token},
               success: function(data){
                console.log(data);
               }
            });
   });


  $(document).on("change",'#search_dropdown',function(){
    var select_value = $('#search_dropdown option:selected').val();
      //alert(select_value);
      
      if(select_value=='order_date'){
        $('#search').attr('placeholder','DD-MM-YYYY');
      }
      else if(select_value=='order_bill_no'){
        $('#search').attr('placeholder','Search By Bill No');
      }
      else if(select_value=='customer_name'){
        $('#search').attr('placeholder','Search By Customer Name');
      }
      else if(select_value=='customer_mobile'){
        $('#search').attr('placeholder','Search By Customer Mobile');
      }
      else{
        $('#search').attr('placeholder','');
      }
  });





    $(".order_date").datepicker({
      showOn: 'button',
      showAnim: 'slideDown',
      //dateFormat: "dd-mm-yy",
      dateFormat: 'dd-mm-yy',
      defaultDate: new Date(),
            yearRange: "-100:+0",
      /*changeMonth: true,
      changeYear: true*/
      changeMonth: true, //use to enable month dropdown
      changeYear: true ,  //use to enable month dropdown
      minDate:(0),
      maxDate:(365)
      //maxDate: 0 //use to enable date from today..futute date should disable
      // maxDate: new Date() //use to enable date from today..futute date should disable
      //minDate:(0), maxDate:(365) //use to enable date from today..previous date should disable
   });

	$('#order_create_record').click(function(){
  	//alert("Hiiii");
  	$('.modal-title').text('ADD NEW RECORD');
  	$('#order_action_button').val('ADD');
  	$('#order_action').val('ADD');
  	$('#order_form_Modal').modal('show');

  });

 var i=$('#tbl_detail_order tr').length;

 $(".addbtn").on('click',function(){
  count=$('#tbl_detail_order tr').length;
  
    var data="<tr><td><input type='checkbox' class='chkbox'/></td>";
      data+="<td><span id='sn"+i+"'>"+count+".</span></td>";     
      data+="<td><input class='form-control order_product_name' type='text' data-type='product_name' id='order_product_name_"+i+"' name='order_product_name[]'/></td>";
      data+="<td><input class='form-control order_product_price' type='text' data-type='product_price' id='order_product_price_"+i+"' name='order_product_price[]'/></td>";
      data+="<td><input class='form-control order_product_gst' type='text' data-type='product_gst' id='order_product_gst_"+i+"' name='order_product_gst[]'/></td>";
      data+="<td><input class='form-control order_quantity' type='text' data-type='order_quantity' id='order_quantity"+i+"' name='order_quantity[]'/></td>";      
      data+="<td><input class='form-control order_product_amount' type='text' data-type='order_product_amount' id='order_product_amount"+i+"' name='order_product_amount[]'/></td></tr>";
    
  $('#tbl_detail_order').append(data);
  i++;
});


$(".delete").on('click', function() {
  $('.chkbox:checkbox:checked').parents("tr").remove();
  $('.check_all').prop("checked", false); 
  updateSerialNo();
  total();
});

	
 $('.check_all').on('click',function() {

  $('input[class=chkbox]:checkbox').each(function(){ 
    if($('input[class=check_all]:checkbox:checked').length == 0){ 
      $(this).prop("checked", false); 
    } else {
      $(this).prop("checked", true); 
    } 
  });
});

 function updateSerialNo(){
  obj=$('#tbl_detail_order tr').find('span');
  $.each( obj, function( key, value ) {
    id=value.id;
    $('#'+id).html(key+1);
  });
  total();
}


$(document).on('focus','.order_product_name',function(){
 

  type = $(this).data('type');

  
  
  if(type =='product_name' )autoType='product_name'; 
  if(type =='product_price' )autoType='product_price'; 
  if(type =='product_gst' )autoType='product_gst'; 
  //if(type =='employee_email' )autoType='employee_email'; 
  
   $(this).autocomplete({
       minLength: 0,
       source: function( request, response ) {
            $.ajax({
                url: '/orders_product_fetch',
                dataType: "json",
                data: {
                    term : request.term,
                    type : type,
                },
                success: function(data) {
                    var array = $.map(data, function (item) {
                       return {
                           label: item[autoType],
                           value: item[autoType],
                           data : item
                       }
                   });
                    response(array)
                }
            });
       },
       //minLength: 1,
    delay: 300, //used to increase the speed to show dropdown display data 
       select: function( event, ui ) {
           var data = ui.item.data;           
           id_arr = $(this).attr('id');
           id = id_arr.split("_");
           elementId = id[id.length-1];           
           $('#order_product_name_'+elementId).val(data.product_name);
           $('#order_product_price_'+elementId).val(data.product_price);
           $('#order_product_gst_'+elementId).val(data.product_gst);
       }
   });
 });

//FOR RANDON GENERATE NUMBER
   var makeUniqueRandom = (function() {
    var randoms = {};
    return function(low, hi) {
        var rand;
        while (true) {
            rand = Math.floor((Math.random() * (hi - low)) + low);
            if (!randoms[rand]) {
                randoms[rand] = true;
                return rand;
            }
        }
    }
})();

    $("#order_bill_no").each(function() {
    this.value = makeUniqueRandom(1, 10000);
});


function round(value, exp) {
  if (typeof exp === 'undefined' || +exp === 0)
    return Math.round(value);

  value = +value;
  exp = +exp;

  if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
    return NaN;

  // Shift
  value = value.toString().split('e');
  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

  // Shift back
  value = value.toString().split('e');
  return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
}


Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator){
    var n = this,
        decPlaces       = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
        decSeparator    = decSeparator == undefined ? "." : decSeparator,
        thouSeparator   = thouSeparator == undefined ? "." : thouSeparator,
        sign = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
        return sign + (j ? i.substr(0, j) + thouSeparator : "")
        + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator)
        + (decPlaces ? decSeparator + Math.abs(n-i).toFixed(decPlaces).slice(2) : "");
  };

function number(input){
  $(input).keypress(function (evt){
      var theEvent = evt || window.event;
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode( key );
      var regex = /[-\d\.]/;
      var objRegex = /^-?\d*[\.]?\d*$/;
      var val = $(evt.target).val();
      if(!regex.test(key) || !objRegex.test(val+key) || !theEvent.keyCode == 46 || !theEvent.keyCode == 8){
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
      }
  });
}

function numberOnly(input){
  $(input).keypress (function (evt){
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    if(charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
      return true;
  });
}


function findRowNum(input){
  $('tbody').delegate(input,'keydown',function(){
    var tr = $(this).parent().parent();
    number(tr.find(input));
  });
}
function findRowNumOnly(input){
  $('tbody').delegate(input,'keydown',function(){
      var tr = $(this).parent().parent();
      number(tr.find(input));
  });
}

findRowNumOnly('.order_quantity');
findRowNum('.order_product_price');

$('tbody').delegate('.order_quantity,.order_product_price','keyup',function(){
        var tr = $(this).parent().parent();
        var qty = tr.find('.order_quantity').val();
        var price = tr.find('.order_product_price').val();
        var gst = tr.find('.order_product_gst').val();
        var rate = (qty * price);
        var amount =  

        round((rate * gst / 100) + rate, 2).toFixed(2);
        tr.find('.order_product_amount').val(amount);
        //tr.find('.order_product_amount').val(amount.formatMoney(2,',','.'));
        total();
    });

    function total(){
      var total = 0;
      $('.order_product_amount').each(function(i,e){
        
           var order_product_amount = $(this).val()-0;
           total += order_product_amount;
      });
      //$('.order_sub_total').val(total);
      $('.order_sub_total').val(total.formatMoney(2,',','.'))
      //$('.order_sub_total').val(total.formatMoney(2,',','.')  + " $")
    }


    $('#order_form').on('click','#order_action_button',function(e){
      e.preventDefault();

      if($('#order_action_button').val()=='ADD'){
        
        
          $.ajax({
            url:'/order_add_data',
            method:'post',
            data:$('#order_form').serialize(),
                dataType:"json",
                beforeSend:function(){
                        $('#order_action_button').attr('disabled','disabled');
                        },
                success:function(data){
                  if(data.error)
                      {
                          var error_html = '';
                          for(var count = 0; count < data.error.length; count++)
                          {
                              error_html += '<p>'+data.error[count]+'</p>';
                          }
                          $('#order_form_result').html('<div class="alert alert-danger">'+error_html+'</div>');
                      }

                      else
                      {
                          //dynamic_field(1);
                          $('#order_form_result').html('<div class="alert alert-success">'+data.success+'</div>');
                           $('#order_form')[0].reset();
                           location.reload();
                      }                     
                      $('#order_action_button').attr('disabled', false);
                      //$('#remove').attr('disabled', false);


                  }

          });

    }

    if($('#order_action_button').val()=='EDIT'){
        
          $.ajax({
            url:'/order_update_data',
            method:'post',
            data:$('#order_form').serialize(),
                dataType:"json",
                beforeSend:function(){
                        $('#order_action_button').attr('disabled','disabled');
                        },
                success:function(data){
                  if(data.error)
                      {
                          var error_html = '';
                          for(var count = 0; count < data.error.length; count++)
                          {
                              error_html += '<p>'+data.error[count]+'</p>';
                          }
                          $('#order_form_result').html('<div class="alert alert-danger">'+error_html+'</div>');
                      }

                      else
                      {
                          //dynamic_field(1);
                          $('#order_form_result').html('<div class="alert alert-success">'+data.success+'</div>');
                           $('#order_form')[0].reset();
                           location.reload();
                      }                     
                      $('#order_action_button').attr('disabled', false);
                      //$('#remove').attr('disabled', false);


                  }

          });

    }



    });


$(document).on('click', '.edit', function(){ 
      /*alert('edit');
      return;*/
      updateSerialNo();
      var id = $(this).attr('id');
      $('#order_form_result').html('');
      $.ajax({
        url:'/order_edit_data/'+id,
        dataType:"json",
        success:function(html){

          $('#order_date').val(html.data.order_date);
          $('#order_bill_no').val(html.data.order_bill_no);
          $('#customer_name').val(html.data.customer_name);
          $('#customer_mobile').val(html.data.customer_mobile);
          $('#customer_email').val(html.data.customer_email);
          
          $('#order_sub_total').val(html.data.order_sub_total);               

          var hidden_id = $('#hidden_id').val(html.data.id);           

          var order_product_name = $('#hidden_order_product_name').val(html.data.order_product_name);
          var array_order_product_name = $(order_product_name).val().split(',');   
          
          var order_product_price = $('#hidden_order_product_price').val(html.data.order_product_price);
          var array_order_product_price = $(order_product_price).val().split(',');

          var order_product_gst = $('#hidden_order_product_gst').val(html.data.order_product_gst);
          var array_order_product_gst = $(order_product_gst).val().split(',');    

          var order_quantity = $('#hidden_order_quantity').val(html.data.order_quantity);
          var array_order_quantity = $(order_quantity).val().split(',');   

          var order_product_amount = $('#hidden_order_product_amount').val(html.data.order_product_amount);
          var array_order_product_amount = $(order_product_amount).val().split(',');  

          //console.log(array);
          
        var i=$('#tbl_detail_order tr').length-1;
        $.each(array_order_product_name,function(j){
          
      
          /*  var tr ='<tr>'+
                 '<td class="td1"><input type="text" name="languages_name[]" id="languages_name" class="form-control languages_name_list" placeholder="Add language name" value="'+array[i]+'" /></td>'+
                 '<td class="td1"><button type="button" name="remove" id="remove" class="remove btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button></td>'+
                '</tr>';
                $('#language_field').append(tr);*/

                
  count=$('#tbl_detail_order tr').length-1;
  
    var data="<tr><td class='td1'><input type='checkbox' class='chkbox'/></td>";
      data+="<td class='td1'><span id='sn"+i+"' >"+count+".</span></td>"; 

      data+="<td class='td1'><input class='form-control order_product_name' type='text' data-type='product_name' id='order_product_name_"+"s"+""+i+"' name='order_product_name[]' value='"+array_order_product_name[j]+"'/></td>";

      data+="<td class='td1'><input class='form-control order_product_price' type='text' data-type='product_price' id='order_product_price_"+"s"+""+i+"' name='order_product_price[]' value='"+array_order_product_price[j]+"'/></td>";

       data+="<td class='td1'><input class='form-control order_product_gst' type='text' data-type='product_gst' id='order_product_gst_"+"s"+""+i+"' name='order_product_gst[]' value='"+array_order_product_gst[j]+"'/></td>";

      data+="<td class='td1'><input class='form-control order_quantity' type='text' data-type='order_quantity' id='order_quantity"+"s"+""+i+"' name='order_quantity[]' value='"+array_order_quantity[j]+"'/></td>";
     
      data+="<td class='td1'><input class='form-control order_product_amount' type='text' data-type='order_product_amount' id='order_product_amount"+"s"+""+i+"' name='order_product_amount[]' value='"+array_order_product_amount[j]+"'/></td></tr>";
    
  $('#tbl_detail_order').append(data);
  i++;            
           });
     
          $('#order_product_name').append(html.data.hidden_order_product_name);
          $('#order_product_price').append(html.data.hidden_order_product_price);
          $('#order_product_gst').append(html.data.hidden_order_product_gst);
          $('#order_quantity').append(html.data.hidden_order_quantity);
          $('#order_product_amount').append(html.data.hidden_order_product_amount);
          
          $('#hidden_id').val(html.data.id);         
          $('#hidden_order_product_name').val(html.data.order_product_name);
          $('#hidden_order_product_price').val(html.data.order_product_price);
           $('#hidden_order_product_gst').val(html.data.order_product_gst);
          $('#hidden_order_quantity').val(html.data.order_quantity);
          $('#hidden_order_product_amount').val(html.data.order_product_amount);
          $('#hidden_order_sub_total').val(html.data.order_sub_total);
          $('#hidden_order_bill_no').val(html.data.order_bill_no);
          $('#hidden_order_date').val(html.data.order_date);
          $('#hidden_customer_name').val(html.data.customer_name);
          $('#hidden_customer_mobile').val(html.data.customer_mobile);
          $('#hidden_customer_email').val(html.data.customer_email);
          
          $('.modal-title').text("EDIT THE RECORD");
          $(".modal-body").removeClass('bg-primary').addClass('bg-success');
          $(".modal-header").removeClass('bg-danger').addClass('bg-primary');
          $(".modal-footer").removeClass('bg-danger').addClass('bg-primary');
          $('#order_action_button').val("EDIT");
          $('#order_action').val("EDIT");
          $('#order_action_button').removeClass('btn btn-primary').addClass('btn btn-warning');
          $('#cloes').removeClass('btn btn-secondary').addClass('btn btn-success');
          $('#order_form_Modal').modal('show');        
         $('#order_product_name').remove(); //use to edit first row array[0] to relocate to first remove button place 
         $('#order_product_price').remove(); //use to edit first row array[0] to relocate to first remove button place 
          $('#order_product_gst').remove(); //use to edit first row array[0] to relocate to first remove button place 
         $('#order_quantity').remove(); //use to edit first row array[0] to relocate to first remove button place 
         $('#order_product_amount').remove(); //use to edit first row array[0] to relocate to first remove button place 

          $("#tr_data_order").remove(); //use to delete first row in edit
         
        }
      });
   });


var order_id;
  $(document).on('click', '.deleterow', function(){
      order_id = $(this).attr('id');
      $('#order_confirm_Modal').modal('show');      
  });

  $('#order_ok_button').click(function(){
        $.ajax({
          url:'/order_delete_data/'+order_id,
          beforeSend:function(){
            $('#order_ok_button').text('Deleting.....');
            },
            success:function(data){
              setTimeout(function(){
                $('order_confirm_Modal').modal('hide');
                location.reload();
              }, 2000);
            }
        });
  });


});
