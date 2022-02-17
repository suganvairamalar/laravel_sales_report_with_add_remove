$(document).ready(function(){

	/*alert( $('#product_category_id').val());
    return;*/

    $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
   

	$( "#reset").click(function() {     
	   // $("#product_category_id").select2("val", 'null');
	   
	    $('#product_name').val('');
	    $('#product_price').val('');
	    $('#product_gst').val('');
	    location.reload(true);
    });	

	$('#product_form').on('click','#product_action_button',function(e){
		e.preventDefault();
		 if($('#product_action').val()=='ADD'){
				/*alert("Hi");
				return;*/
				 $.ajax({
		            url:'/product_add_data',
		            method:'GET',
		            data:$('#product_form').serialize(),
		            dataType:"json",
		            success:function(data)
		              {
		               /* console.log(data);
		            return;*/
		               var html = '';
		                  if(data.errors){
		                    html = '<div class="alert alert-danger">';
		                    for(var count = 0; count < data.errors.length; count++){
		                      html += '<p>' + data.errors[count] + '</p>';
		                      }
		                      html += '</div>';
		                    }
		                    if(data.success){
		                    html = '<div class="alert alert-success">' + data.success + '</div>';
		                    //$('#position_form')[0].reset();
		                    //$("#position_form").trigger("reset");
		                    location.reload(true);
		                  }
		                  $('#product_form_result').html(html);
		              }
          	});
		 }

		 if($('#product_action').val()=='UPDATE'){
				/*alert("Hi");
				return;*/
				 $.ajax({
		            url:'/product_update_data',
		            method:'POST',
		            data:$('#product_form').serialize(),
		            dataType:"json",
		            success:function(data)
		              {
		               /* console.log(data);
		            return;*/
		               var html = '';
		                  if(data.errors){
		                    html = '<div class="alert alert-danger">';
		                    for(var count = 0; count < data.errors.length; count++){
		                      html += '<p>' + data.errors[count] + '</p>';
		                      }
		                      html += '</div>';
		                    }
		                    if(data.success){
		                    html = '<div class="alert alert-success">' + data.success + '</div>';
		                    //$('#position_form')[0].reset();
		                    //$("#position_form").trigger("reset");
		                    location.reload(true);
		                  }
		                  $('#product_form_result').html(html);
		              }
          	});
		 }
	});

	$(document).on('click','.edit',function(){
		var id = $(this).attr('id');
		$('#product_form_result').html('');
		$.ajax({
			url:'/product_edit_data/'+id,
			dataType:"json",
			success:function(html){
				
				
				$('#product_name').val(html.data.product_name);
				$('#product_price').val(html.data.product_price);
				$('#product_gst').val(html.data.product_gst);
       
				$('#hidden_id').val(html.data.id);
        
    		$('#heading').text("PRODUCT EDIT DATA");          
     		$('#product_action_button').val("UPDATE");
     		$('#product_action').val("UPDATE");
     		$('#product_action_button').removeClass('btn btn-success').addClass('btn btn-warning');  
			}
		});
	});


	var product_id;
  $(document).on('click', '.delete', function(){
      product_id = $(this).attr('id');
      $('#product_confirm_Modal').modal('show');      
  });

  $('#product_ok_button').click(function(){
        $.ajax({
          url:'/product_delete_data/'+product_id,
          beforeSend:function(){
            $('#product_ok_button').text('Deleting.....');
            },
            success:function(data){
              setTimeout(function(){
                $('product_confirm_Modal').modal('hide');
                location.reload();
              }, 2000);
            }
        });
  });

  //SEARCH DROPDOWN
  $(document).on("change",'#search_dropdown',function(){
    var select_value = $('#search_dropdown option:selected').val();
      //alert(select_value);
      if(select_value=='category'){
        $('#search').attr('placeholder','Search By Category');
      }
      else if(select_value=='product'){
        $('#search').attr('placeholder','Search By Product');
      }
      else{
        $('#search').attr('placeholder','');
      }
  });

  

   $('#product_search_submit').on('click',function(){
   		var _token = $('#token').val();
   		if($('#search').val()==''){
    	alert("enter to search");
    	return false;

      }  
      $.ajax({
         type:'GET',
         url:'/products',
         data:{'search':$value,_token:_token},
               success: function(data){
                console.log(data);
               }
            });
   });



   


});