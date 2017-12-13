<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/dream_shops/core/init.config.php';

    @$fullname = $_POST['fname'].' '.$_POST['lname'];
    @$phone = $_POST['phone'];
    @$province = $_POST['province'];
    @$city = $_POST['city'];
    @$address = sanitize($_POST['address']);
    @$zip = $_POST['zip'];
    @$email = $_POST['email'];

    if(!empty($cart_id)) {
        $get =$db->query("SELECT * FROM cart WHERE id = $cart_id");
        $item = mysqli_fetch_assoc($get);
        $items = $item['items'];

        //GENERATE A RANDOM INVOICE NUMBER
        $invoice = randString(5);

          $sql1 = $db->query("SELECT * FROM orders WHERE `cart_id` = {$cart_id} ");
          $res = mysqli_fetch_assoc($sql1);
          $rows = mysqli_num_rows($sql1);
          $id = $res['id'];

          if($rows == 1 ) {

            $sql = "UPDATE orders
            SET `fullname`='$fullname', `phone`='$phone',
                `province`='$province', `city`='$city', `address`='$address',
                `zip`='$zip', `email`='$email', `items`='$items',`payment_type`='1' WHERE id = '$id'  ";

          } else if($rows <= 0) {

            // $sql = "INSERT INTO `orders` (`cart_id`,`fullname`, `phone`, `province`, `city`, `address`, `zip`, `email`, `items`, `invoice`)
            //         VALUES ('$cart_id','$fullname', '$phone', '$province', '$city', '$address', '$zip', '$email', '$items', '$invoice')";

            $sql = "INSERT INTO `orders` (`id`, `cart_id`, `fullname`, `phone`, `province`, `city`, `address`, `zip`, `email`, `items`,`payment_type`, `invoice`, `paid`)
            VALUES (NULL, '$cart_id', '$fullname', '$phone', '$province', '$city', '$address', '$zip', '$email', '$items','1', '$invoice', '0')";

          }

        $db->query($sql);
    }




?>
