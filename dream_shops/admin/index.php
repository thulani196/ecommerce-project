<?php
    require_once '../core/init.config.php';
    //LOGGED IN CHECK
        if(!is_logged_in()){
            login_error_check();
        }

    include 'includes/header.php';
    include 'includes/navigation.php';

    $sql = $db->query("SELECT * FROM orders WHERE `payment_type`=0 AND `paid` = 0 AND 'delivered' = 0");
    $cash_on_delivery_orders = mysqli_num_rows($sql);

    $sql = $db->query("SELECT * FROM orders WHERE `payment_type`=1 AND `shipped` = 0 ");
    $onlinepay_delivery_orders = mysqli_num_rows($sql);

    $sql2 = $db->query("SELECT * FROM orders WHERE `paid`=1 AND `payment_type` = 1 AND `shipped` = 1 AND `delivered` = 0");
    $total_shipments = mysqli_num_rows($sql2);

    $sql3 = $db->query("SELECT * FROM orders WHERE `paid`=1 AND `delivered` = 1");
    $total_delivered = mysqli_num_rows($sql3);


?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 w3-animate-zoom">
            <div class="text-center " >
              <div class="alert alert-info container">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Welcome to the Admin Panel. From here, you can Manage all content on the website.
              </div>
                <h3 class="text-center w3-text-cyan">Dashboard</h3><br>
            </div>

            <div class="container text-justify" >
              <div class="row">

                <div class="col-md-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading text-center">Cash on delivery orders</div>
                      <div class="panel-body" style="background-image:url(../images/eiffel.jpg)">
                        <br />
                        <br />
                          <h1 class="text-center w3-text-white"><?=$cash_on_delivery_orders;?></h1>
                          <br />
                          <br />
                      </div>
                      <div class="panel-footer text-center">
                        <a href="orders.php">View Orders</a>
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading text-center">Online payment orders</div>
                      <div class="panel-body" style="background-image:url(../images/eiffel.jpg)">
                        <br />
                        <br />
                          <h1 class="text-center w3-text-white"><?=$onlinepay_delivery_orders;?></h1>
                          <br />
                          <br />
                      </div>
                      <div class="panel-footer text-center">
                        <a href="orders1.php">View Orders</a>
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading text-center">Shipments</div>
                      <div class="panel-body" style="background-image:url(../images/eiffel.jpg)">
                        <br />
                        <br />
                          <h1 class="text-center w3-text-white"><?=$total_shipments;?></h1>
                          <br />
                          <br />
                      </div>
                      <div class="panel-footer text-center">
                        <a href="shipments.php">View Shipped orders</a>
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading text-center">Delivered</div>
                      <div class="panel-body" style="background-image:url(../images/eiffel.jpg)">
                        <br />
                        <br />
                          <h1 class="text-center w3-text-white"><?=$total_delivered;?></h1>
                          <br />
                          <br />
                      </div>
                      <div class="panel-footer text-center">
                        <a href="deliveries.php">View delivered orders</a>
                      </div>
                    </div>
                </div>

              </div>

            </div>
        </div>


      </div>
    </div>


<script src="js/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
</body>
</html>
