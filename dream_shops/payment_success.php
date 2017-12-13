<?php
    require_once 'core/init.config.php';
    include 'includes/header.php';

    if(isset($_GET['tx']) && !empty($_GET['tx']) && $_GET['st'] == 'Complete'){
      $transactionID = $_GET['tx'];
      $status = $_GET['st'];
      $cm = $_GET['cm'];
      $total = $_GET['amt'];
      $date = date("Y-m-d H-m-s");

      if(isset($_GET['tx'])) {
          $customerDetails = $db->query("SELECT * FROM orders WHERE cart_id = '{$cm}' ");
          $customer = mysqli_fetch_assoc($customerDetails);
          $name = $customer['fullname'];
          ###############################################################################
          ########################## CODE TO DEDUCT PRODUCTS ############################
          $items = json_decode($customer['items'],true);
          foreach($items as $item) {
            $newSizes = array();
            $itemID = $item['id'];
            $pQuery = $db->query("SELECT sizes FROM products WHERE id = '$itemID' ");
            $product = mysqli_fetch_assoc($pQuery);
            $sizes = sizesToArray($product['sizes']);

            foreach($sizes as $size){
              if($size['size'] == $item['size']){
                $q = $size['quantity'] - $item['quantity'];
                $newSizes[] = array('size' => $size['size'], 'quantity' => $q);
              } else {
                $newSizes[] = array('size'=>$size['size'], 'quantity'=>$size['quantity']);
              }
              $sizeString =sizesToString($newSizes);
              $db->query("UPDATE products SET `sizes` = '$sizeString' WHERE id = '$itemID' ");
            }
      }

          $sql = $db->query("UPDATE orders SET `paid` = 1, `transaction_id` = '{$transactionID}' WHERE cart_id = '{$cm}'");
          $txQuery = $db->query("INSERT INTO transactions (`id`,`customer_name`,`transaction_id`,`grand_total`,`date`)
                                 VALUES (NULL, '$name','$transactionID','$total','$date')");
      }
    }

?>
<style>
  body {
    background-color: #f4511e;
  }
</style>
<div class="container">
        <div class="row">

              <div class="col-md-3">
              </div>
              <div class="col-md-6"><br><br>
                <br><br><br>
                  <div id="admin_login" style="margin-top:70px;" class="w3-card-12 w3-padding-large w3-animate-opacity w3-white">
                    <?php if($_GET['st'] === 'Completed'): ?>
                      <h3 class="text-center w3-text-purple">Payment Has been successfully made!</h3>
                          <h3 class="text-center"><i>Thank You <?= $name; ?>!</i></h3>
                          <div class="text-center w3-text-blue">
                            <p>Thank you for shopping with us, your payment has been successfully made.<br>Your transaction ID is:
                              <strong><?=$transactionID;?></strong></p>
                            <p>You will be notified once shippment has began.</p>
                          </div>

                          <div class="text-center">
                            <a href="http://localhost/dream_shops/clearcart.php" class="w3-btn w3-purple w3-round w3-ripple">
                              <span class="glyphicon glyphicon-shopping-cart"></span>
                                <i>Back to store</i>
                            </a>

                            <a href="http://localhost/dream_shops/receipt.php" target="_blank" class="w3-btn w3-brown w3-round w3-ripple">
                              <span class="glyphicon glyphicon-print"></span>
                                <i>Get a receipt</i>
                            </a>

                          </div>
                    <?php else: ?>

                      <h3 class="text-center"><i>Transaction could not be completed <i class="fa fa-frown-o fa-1x"></i><br/>Please try again.</i></h3>
                      <div class="text-center">
                        <div class="text-center">
                            <a href="http://localhost/dream_shops/cart.php" class="w3-btn w3-purple w3-round w3-ripple">
                              <span class="glyphicon glyphicon-shopping-cart"></span>
                                <i>Back to cart</i>
                            </a>
                        </div>
                    </div>

                    <?php endif; ?>
                      <br>
                  </div>

              </div>
              <div class="col-md-3"> </div>

        </div>
</div>

</body>
</html>
