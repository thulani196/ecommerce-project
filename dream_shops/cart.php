<?php

    require_once 'core/init.config.php';
    include 'includes/header.php';
    include 'includes/navigation.php';
    $i = 1;
    $total = 0;
    $sub_total = 0;
    $grand_total = 0;
    $itemQuantity = 0;

 
    // $c = $db->query("SELECT * FROM cart WHERE id = {$cart_id}");
    // if(mysqli_num_rows($c) <= 0){
    //   setcookie(CART_COOKIE,'',1,"/",$domain,false);
    //   header("Location: results.php");
    // }

 ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="page-header">
        <h3 class="text-center">Your shopping cart</h3>
        <?php if(!empty($cart_id)): ?>
          <div class="w3-responsive w3-card-8">
          <table class="w3-table w3-condensed w3-striped w3-card-8 table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>price (per)</th>
                <th>Total Price</th>

              </tr>
            </thead>
            <tbody>
              <?php
                $sql =$db->query("SELECT * FROM cart WHERE id = {$cart_id}");
                
             

                $result = mysqli_fetch_assoc($sql);
                $items = json_decode($result['items'], true);
                //var_dump($items); //SHOULD BE REMOVED LATER

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
                        $tax = TAX * $sub_total;
                        $tax = number_format($tax, 2);
                        $grand_total = $tax + $sub_total;
                        
                      }
                  }

                ?>
              <tr>
                <td><?= $i ?></td>
                <td><?=$product['title']; ?></td>
                <td><?=$item['size']; ?></td>
                <td>
                  <button class="btn btn-xs btn-danger" onclick="update_cart('remove',<?=$product['id'];?>, '<?=$item['size'];?>');">-</button>
                    <?=$item['quantity']; ?>

                <?php if($item['quantity'] < $available):?>
                  <button class="btn btn-xs btn-success" onclick="update_cart('add',<?=$product['id'];?>, '<?=$item['size'];?>');">+</button>
                <?php else: ?>
                  <span class="text-danger">Max</span>
                <?php endif; ?>
                </td>
                <td><?=$product['price']; ?></td>
                <td><?=$total; ?></td>
                <?php $i += 1; ?>
              </tr>
<?php  } ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
            
            <p class="w3-center">It appears your cart is empty. Please click <a href="index.php" class="w3-text-blue"><em><b>Here</b></em></a> to add items to your cart. Thank You!</p>
        <?php endif; ?>

      </div>
    </div>

  <?php if(!empty($cart_id)): ?>
    <div class="col-md-6">
    </div>

    <div class="col-md-6">
      <div class="w3-responsive w3-card-2">
      <table class="w3-table w3-striped table  table-bordered table-condensed w3-card-4">

          <thead>
            <tr class="w3-blue">
              <th>Total Items</th>
              <th>Sub-Total</th>
              <th>Tax Charge</th>
              <th>Grand Total</th>
            </tr>
          </thead>
            <tr>
              <td><?= $itemQuantity ?></td>
              <td><?= $sub_total; ?></td>
              <td><?= $tax; ?></td>
              <td class="w3-red"><?= $grand_total; ?></td>
            </tr>
      </table>
    </div>
      <hr>
      <button data-toggle="modal" data-target="#shipmentModal" class="w3-btn w3-btn-block w3-large w3-indigo w3-ripple">Check out  <span class="glyphicon glyphicon-log-out"></span></button><br><br>
      <a href="clearcart.php"  class="w3-btn w3-btn-block w3-large w3-grey w3-hover-red w3-ripple w3-text-white">Clear Cart <span class="glyphicon glyphicon-remove"></span></a>
      <br><br>
       <a href="index.php"  class="w3-btn w3-btn-block w3-large w3-purple w3-ripple w3-text-white">Continue Shopping <span class="glyphicon glyphicon-shopping-cart"></span></a>


    <!-- CHECKOUT MODAL -->
    <?php include 'includes/cart_modals.php'; ?>

    </div>
<?php endif; ?>
  </div>
  </div>

<?php include 'includes/footer.php'; ?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
