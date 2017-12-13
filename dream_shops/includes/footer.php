<script>

function detailsmodal(id){
  var data = {"id" : id};
  jQuery.ajax({
    url: '/dream_shops/includes/product-modal.php',
    method: "post",
    data: data,
    success: function(data){
      jQuery('body').append(data);
      jQuery('#details-modal').modal('toggle');
    },
    error: function(){
      alert("Something went wrong");
    }
  });
}

//METHOD THAT REDIRECTS TO RECEIPT

function update_cart(mode, edit_id, edit_size) {
  var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
  jQuery.ajax({
    url : "/dream_shops/admin/parsers/update_cart.php",
    data : data,
    method : "post",
    success : function(){
      location.reload();
    },
    error : function(){
      alert("An error occured!");
    }
  })
}

function add_to_cart(){
  jQuery('modal_errors').html("");
  var size = jQuery('#size').val();
  var quantity = parseInt(jQuery('#quantity').val());
  var available = parseInt(jQuery('#available').val());
  var error = '';
  var data = jQuery('#add_product_form').serialize();

    if(size == '' || quantity == '' || quantity <= 0 ){
        error += '<p class="text-danger text-center">You must choose a size and quantity.</p>';
        jQuery('#modal_errors').html(error);
        return;
    } else if(available < quantity){
        error += '<p class="text-danger text-center">There are only '+available+' of these items Available.</p>';
        jQuery('#modal_errors').html(error);
        return;
    } else {
        jQuery.ajax({
            url : '/dream_shops/admin/parsers/add_cart.php',
            method: 'post',
            data : data,
            success: function (){
              location.reload();
            },
            error : function(){alert('Something went wrong')}
        });
    }
}
//ADDS INFORMATION TO DB FOR A CASH ON DELIVERY ORDER
 function add_order(){
     jQuery('modal_errors').html("");
         var fname = $('#fname').val();
         var lname = $('#lname').val();
         var province = $('#province').val();
         var phone = $('#phone').val();
         var city = $('#city').val();
         var address = $('#address').val();
         var zip = $('#zip').val();
         var email = $('#email').val();
         var emailVerify = $('#emailV').val();
         var error = '';
         var form_success = '';
         var data = $('#add_order_form').serialize();

     if(fname == '' || lname == '' || province == '' || city == '' || address == '' || zip == '' || email == '' || phone == '')
        {
            error += 'All fields are required.';
            jQuery('#modal_errors').html(error);
            return;
        }else if(emailVerify != email){
            error += 'Unmatched emails entered. Please ensure your emails are matching.';
            jQuery('#modal_errors').html(error);
            return;
        } else{

                        form_success += 'Form OK!';
                        jQuery('#modal_success').html(form_success);
                        jQuery('#checkoutModal').modal('show');
          }
 }

function pay_now(){
    var data = jQuery('#CardModal').serialize();
    var name = jQuery('#name').val();
    var card_number = jQuery('#name').val();
    var ccv = jQuery('#ccv').val();
    var expiry_month = jQuery('#expiryMonth').val();
    var expiry_year = jQuery('#expiryYear').val();
    var success = '';
    var error = '';

    if(name == '' || card_number == '' || ccv == '' || expiry_month == '' || expiry_year == '') {
        error = 'All fields are required to process the transaction.';
        jQuery('#card_errors').html(error);
    } else {
        success = 'Form data OK.';
        jQuery('#card_success').html(success);
        jQuery('#card_errors').html('');
    }
}


function order_details(){
    jQuery('modal_errors').html("");
        var fname = $('#fname').val();
        var lname = $('#lname').val();
        var province = $('#province').val();
        var phone = $('#phone').val();
        var city = $('#city').val();
        var address = $('#address').val();
        var zip = $('#zip').val();
        var email = $('#email').val();
        var emailVerify = $('#emailV').val();
        var error = '';
        var form_success = '';
        var data = $('#add_order_form').serialize();

    if(fname == '' || lname == '' || province == '' || city == '' || address == '' || zip == '' || email == '' || phone == '')
       {
           error += 'All fields are required.';
           jQuery('#modal_errors').html(error);
           return;
       }else if(emailVerify != email){
           error += 'Unmatched emails entered. Please ensure your emails are matching.';
           jQuery('#modal_errors').html(error);
           return;
       } else{
            jQuery.ajax({
                  url: '/dream_shops/helpers/add_order.php',
                  method: 'post',
                  data : data,
                  success : function(){
                     window.location.href="/dream_shops/thankyou.php";
                  },
                  error : function(){
                   alert("Something went wrong.");
                  }
            });
       }
}


function online_order_details(){
    jQuery('modal_errors').html("");
        var fname = $('#fname').val();
        var lname = $('#lname').val();
        var province = $('#province').val();
        var phone = $('#phone').val();
        var city = $('#city').val();
        var address = $('#address').val();
        var zip = $('#zip').val();
        var email = $('#email').val();
        var emailVerify = $('#emailV').val();
        var error = '';
        var form_success = '';
        var data = $('#add_order_form').serialize();

    if(fname == '' || lname == '' || province == '' || city == '' || address == '' || zip == '' || email == '' || phone == '')
       {
           error += 'All fields are required.';
           jQuery('#modal_errors').html(error);
           return;
       }else if(emailVerify != email){
           error += 'Unmatched emails entered. Please ensure your emails are matching.';
           jQuery('#modal_errors').html(error);
           return;
       } else{
            jQuery.ajax({
                  url: '/dream_shops/helpers/online_pay.php',
                  method: 'post',
                  data : data,
                  success : function(){
                    //  window.location.href="https://www.sandbox.paypal.com/cgi-bin/webscr";
                    location.reload();
                  },
                  error : function(){
                   alert("Something went wrong.");
                  }
            });
       }
}


</script>
<footer class="container-fluid text-center">
	  <a href="#" title="To Top">
	    <span class="glyphicon glyphicon-chevron-up"></span>
	  </a>
	  <p>&copy; Copyright 2016-<?php echo date("Y"); ?> Online Express Store</a></p>
</footer>
