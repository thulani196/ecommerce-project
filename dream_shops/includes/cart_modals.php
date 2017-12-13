<?php
 if (isset($_POST['cashDelivery'])) {
   header("Location: thankyou.php");
 }
$itemNumber = 1;
$pro = $db->query("SELECT * FROM products WHERE id = '$product_id' ");

?>
<!-- S
HIPMENT DETAILS MODAL -->
<div class="modal fade" id="shipmentModal" role="dialog" style="display:none">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header w3-indigo">
                	<button class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Shipping details.</h4>
                </div>
                <div class="modal-body">
        			<div class="container-fluid">

                        <span  class="w3-text-red">
                            <div class="text-center" id="modal_errors"></div>
                        </span>

                        <span  class="w3-text-green">
                            <div class="text-center" id="modal_success"></div>
                        </span>

                        <form class="form" action="/dream_shops/thankyou.php" method="post" id="add_order_form">

                            <div class="row">

                            <div class="col-md-6 form-group">
                                <label for="fname">First Name:</label>
                                <input type="text" class="form-control input" name="fname" id="fname">
                            </div>

                             <div class="col-md-6 form-group">
                                <label for="lname">Last Name:</label>
                                <input type="text" class="form-control input" name="lname" id="lname">
                            </div>

                            <div class="col-md-12 form-group">
                               <label for="lname">Phone Number:</label>
                               <input type="text" class="form-control input" name="phone" id="phone">
                           </div>

                             <div class="col-md-6 form-group">
                                <label for="province" >Province:</label>
                                <select class="form-control input" name="province" id="province">
                                 <option value="" selected>--Select your province--</option>
                                 <option value="Lusaka Province">Lusaka Province</option>
                                 <option value="Northern Province">Northern Province</option>
                                 <option value="Southern Province">Southern Province</option>
                                 <option value="Eastern Province">Eastern Province</option>
                                 <option value="Copperbelt Province">Copperbelt Province</option>
                                 <option value="Central Province">Central Province</option>
                                 <option value="Western Province">Western Province</option>
                                 <option value="Luapula">Luapula Province</option>
                                 <option value="Muchinga Province">Muchinga Province</option>
                                 <option value="North-Western Province">North-Western Province</option>
                                </select>
                            </div>

                             <div class="col-md-6 form-group">
                                <label for="city">City:</label>
                                <input type="text" class="form-control input" name="city" id="city">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="fname">Street Address:</label>
                                <input type="text" class="form-control input" name="address" id="address">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="fname">Zip code:</label>
                                <input type="text" class="form-control input" name="zip" id="zip">
                            </div>


                            <div class="col-md-6 form-group">
                                <label for="fname">Email:</label>
                                <input type="email" class="form-control input" name="email" id="email">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="fname">Comfirm Email:</label>
                                <input type="text" class="form-control input" name="email2" id="emailV">
                            </div>

                            <div class="col-md-12 form-group">
                                <button type="submit" name="proceed" onclick="add_order(); return false;" class="w3-btn w3-btn-block w3-indigo">
                                Proceed >>
                                </button>
                            </div>
                        </div>
                        </form>

                    </div>
      			</div>
      			<div class="modal-footer w3-indigo">
        			<button type="button"  class="w3-btn w3-ripple w3-round btn-default w3-red" data-dismiss="modal">Cancel checkout</button>
      			</div>
            </div>
        </div>
    </div>


<!-- DELIVERY TYPE MODAL -->
<div class="modal fade" id="checkoutModal" role="dialog" style="display:none">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header w3-indigo">
                	<button class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Choose your preferred payment method.</h4>
                </div>
                <div class="modal-body">
        			<div class="container-fluid">
                        <div class="row text-center">

                              <div class="col-md-6">
                                <button type="button" onclick="order_details(); return false;" style="background-color:white" id="cashDelivery" name="cashDelivery" class="w3-btn w3-btn-block w3-large w3-white w3-ripple">
                                        <img src="images/cash_on_delivery.jpg" height="100px" width="100%" alt="checkout">
                                </button>
                                    <br />
                                    <br />
                              </div>

                            <div class="col-md-6">
                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" target="_blank" method="post">
                                    <input type="hidden" name="cmd" value="_cart">
                                    <input type="hidden" name="upload" value="1">
                                    <input type="hidden" name="business" value="onlineexpress@info.com">

                                    <?php
                                      $sql =$db->query("SELECT * FROM cart WHERE id = {$cart_id}");
                                      $result = mysqli_fetch_assoc($sql);
                                      $items = json_decode($result['items'], true);

                                      foreach($items as $item)  {
                                        $product_id = $item['id'];
                                        $query = $db->query("SELECT * FROM products WHERE `id` = {$product_id}");
                                        $product = mysqli_fetch_assoc($query);
                                        $sArray = explode(',',$product['sizes']);

                                        foreach ($sArray as $sizeString) {
                                          $s = explode(':',$sizeString);
                                            if($s[0] == $item['size']){
                                              $available = $s[1];

                                              $itemQuantity = $itemQuantity + $item['quantity'];
                                              $total = $item['quantity'] * $product['price'];
                                              $sub_total = $sub_total + $total;
                                              #$tax = TAX * $sub_total;
                                              $tax = number_format($tax, 2);
                                              $grand_total = $tax + $sub_total;
                                            }
                                        }
                                      ?>

                                      <input type="hidden" name="item_name_<?=$itemNumber;?>" value="<?=$product['title'];?>">
                                      <input type="hidden" name="item_number_<?=$itemNumber;?>" value="<?=$itemNumber;?>">
                                      <input type="hidden" name="item_detail_<?=$itemNumber;?>" value="<?=$item['size'];?>">
                                      <input type="hidden" name="quantity_<?=$itemNumber;?>" value="<?=$item['quantity']?>">
                                      <input type="hidden" name="amount_<?=$itemNumber;?>" value="<?= $product['price'];?>">

                                     <?php $itemNumber += 1; ?>
                                    <?php $item['quantity'];?>

                                  <?php } ?>

                                  <input type="hidden" name="tax_cart" value="<?=$tax;?>">
                                  <input type="hidden" name="cancel_return" value="http://127.0.0.1/dream_shops/cart.php">
                                  <input type="hidden" name="currency_code" value="USD">
                                  <input type="hidden" name="custom" value="<?=$cart_id;?>">
                                  <input type="hidden" name="return" value="http://127.0.0.1/dream_shops/payment_success.php">

                                  <button type="submit" onclick="online_order_details();" style="background-color:white" id="cashDelivery" name="cashDelivery" class="w3-btn w3-btn-block w3-large w3-white w3-ripple">
                                      <img src="images/pp.png" height="100px" width="100%" alt="checkout">
                                  </button>

                                </form>
                            </div>
                        </div>
                    </div>
      			</div>
      			<div class="modal-footer w3-indigo">
        			<button type="button" class="w3-btn w3-ripple w3-round btn-default w3-red" data-dismiss="modal">Cancel checkout</button>
      			</div>
            </div>
        </div>
    </div>


    <!-- CREDIT CARD DETAILS MODAL -->
    <div class="modal fade" id="CardModal" role="dialog" style="display:none">
        	<div class="modal-dialog modal-lg">
            	<div class="modal-content">
                	<div class="modal-header w3-indigo">
                    	<button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center">Credit Card Details.</h4>
                    </div>
                    <div class="modal-body">
            			<div class="container-fluid">

                            <span  class="w3-text-red">
                                <div class="text-center" id="card_errors"></div><br>
                            </span>

                            <span  class="w3-text-green">
                                <div class="text-center" id="card_success"></div><br>
                            </span>

                            <form class="form" action="" method="post" id="pay_now_form">

                                <div class="row">

                                <div class="col-md-3 form-group">
                                    <label for="fname">Name on card:</label>
                                    <input type="text" class="form-control input" name="name" id="name">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="fname">Card Number:</label>
                                    <input type="text" class="form-control input" name="card_number" id="card_number">
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="fname">CCV:</label>
                                    <input type="text" class="form-control input" name="ccv" id="ccv">
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="fname">Expire Month:</label>
                                    <select class="form-control" name="expiryMonth" id="expiryMonth">
                                      <option value="" selected=""></option>
                                      <?php for($i=1; $i<=12; $i++): ?>
                                          <option value="<?= $i; ?>"><?= $i; ?></option>
                                      <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="fname">Expiry Year:</label>
                                    <select class="form-control" name="expiryYear" id="expiryYear">
                                      <option value="" selected=""></option>
                                      <?php for($j = date("Y"); $j <= 2025; $j++): ?>
                                        <option value="<?= $j; ?>"><?= $j; ?></option>
                                      <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                  <button type="button" class="btn btn-block btn-primary w3-round w3-hover-green" onclick="pay_now(); return false;">
                                    Pay Now!
                                  </button>
                                </div>

                            </div>
                            </form>

                        </div>
          			</div>
          			<div class="modal-footer w3-indigo">
            			<button type="button"  class="w3-btn w3-ripple w3-round btn-default w3-red" data-dismiss="modal">Cancel Payment</button>
          			</div>
                </div>
            </div>
        </div>
