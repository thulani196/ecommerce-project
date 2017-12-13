<?php
    require_once '../core/init.config.php';
    //LOGGED IN CHECK
        if(!is_logged_in()){
            login_error_check();
        }

    include 'includes/header.php';
    include 'includes/navigation.php';

    $sql = $db->query("SELECT * FROM orders WHERE `payment_type`=1 AND `shipped` = 0 ");
    $rows = mysqli_num_rows($sql);

    if(isset($_GET['ship']) && !empty($_GET['ship'])){
      $id = $_GET['ship'];
      $sql = $db->query("UPDATE orders SET `shipped` = 1 WHERE id = '{$id}' ");
      $_SESSION['confirm_shipment'] = $id;
      header("Location: index.php");
    }

?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 w3-animate-zoom">
            <div class="text-center " >
              <div class="alert alert-info container">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Welcome to the Admin Panel. From here, you can Manage all content on the website.
              </div>
                <h3 class="text-center w3-text-cyan">Customer Orders</h3><br>
            </div>

            <div class="container text-justify">

              <table class="table table-bordered table-condensed table-striped">

                  <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Contact Number</th>
                        <th>Province</th>
                        <th>City</th>
                        <th>payment type</th>
                        <th>Paid</th>
                        <th>Other Options</th>
                    </tr>
                  </thead>

              <tbody>
                <?php if($rows > 0): ?>

                  <?php while($order = mysqli_fetch_assoc($sql)): ?>

                    <?php if($order['payment_type'] == 1 && $order['shipped'] == 0 && ($order['paid'] == 0 || $order['paid'] == 1)  ): ?>
                    <tr>
                        <td> <?= $order['fullname']; ?> </td>
                        <td> <?= $order['phone']; ?> </td>
                        <td> <?= $order['province']; ?> </td>
                        <td> <?= $order['city']; ?> </td>

                         <td class="text-center">
                           <?= ($order['payment_type'] == 1)? '<span class="btn btn-xs w3-blue">online-payment</span>' :
                                '<span class="btn btn-xs w3-green">cash-on-delivery</span>' ; ?>
                         </td>

                         <td class="text-center">
                           <?= ($order['paid'] == 1)? '<div class="btn btn-xs w3-green "><span class="glyphicon glyphicon-saved"></span></div>' :

                           '<div class="btn btn-xs w3-red "><span class="glyphicon glyphicon-remove"></span></div>'; ?>
                         </td>

                         <td class="text-center">

                           <button class="btn btn-xs btn-default">Details</button>

                           <?php if($order['payment_type'] == 1): ?>
                               <a href="orders1.php?ship=<?=$order['id'];?>"
                                   class="btn btn-xs btn-default <?=($order['payment_type'] == 1 && $order['paid'] == 0)? 'disabled' : ''; ?>">
                                   Ship
                               </a>

                         <?php endif; ?>

                           <?php if($order['payment_type'] == 0 && $order['paid'] == 0 ): ?>
                                <a href="index.php?confirm_pay=<?= $order['id']; ;?>" class="btn btn-xs btn-primary">Confirm payment</a>
                           <?php elseif ($order['payment_type'] == 0 && $order['paid'] == 1): ?>
                                <div class="btn btn-xs btn-success disabled">Paid!</div>
                           <?php endif; ?>

                         </td>

                    </tr>
                    <?php endif; ?>

                    <?php if($order['payment_type'] == 0 && $order['paid'] == 0): ?>
                    <tr>
                        <td> <?= $order['fullname']; ?> </td>
                        <td> <?= $order['phone']; ?> </td>
                        <td> <?= $order['province']; ?> </td>
                        <td> <?= $order['city']; ?> </td>

                         <td class="text-center">
                           <?= ($order['payment_type'] == 1)? '<span class="btn btn-xs w3-blue">online-payment</span>' :
                                '<span class="btn btn-xs w3-green">cash-on-delivery</span>' ; ?>
                         </td>

                         <td class="text-center">
                           <?= ($order['paid'] == 1)? '<div class="btn btn-xs w3-green "><span class="glyphicon glyphicon-saved"></span></div>' :

                           '<div class="btn btn-xs w3-red "><span class="glyphicon glyphicon-remove"></span></div>'; ?>
                         </td>

                         <td class="text-center">

                           <button class="btn btn-xs btn-default">Details</button>

                           <?php if($order['payment_type'] == 1): ?>
                               <a href="index.php?ship=<?=$order['id'];?>"
                                   class="btn btn-xs btn-default <?=($order['payment_type'] == 1 && $order['paid'] == 0)? 'disabled' : ''; ?>">
                                   Ship
                               </a>

                         <?php endif; ?>

                           <?php if($order['payment_type'] == 0 && $order['paid'] == 0 ): ?>
                                <a href="orders.php?confirm_pay=<?= $order['id']; ;?>" class="btn btn-xs btn-primary">Confirm payment</a>
                           <?php elseif ($order['payment_type'] == 0 && $order['paid'] == 1): ?>
                                <div class="btn btn-xs btn-success disabled">Paid!</div>
                           <?php endif; ?>
                         </td>
                    </tr>
                    <?php endif; ?>

                  <?php endwhile; ?>

                <?php else: ?>
                <h1 class="text-center">The are no orders to show :( .</h1>
              <?php endif; ?>

                  </tbody>
              </table>
            </div>
        </div>


      </div>
    </div>


<script src="js/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
</body>
</html>
