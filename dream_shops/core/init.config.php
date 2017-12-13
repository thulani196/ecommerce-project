<?php

    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $my_db = 'my_store_db';
    $db = new mysqli($db_host, $db_user, $db_password, $my_db);

    session_start();
    if($db->connect_error){
      exit('Cannot establish connection to server...'.$db->connect_error);
    }
    require_once $_SERVER['DOCUMENT_ROOT'].'/dream_shops/config.php';
    require_once BASEURL.'helpers/helpers.php';
    include $_SERVER['DOCUMENT_ROOT'].'/dream_shops/fpdf/fpdf.php';

    $cart_id = '';
    if(isset($_COOKIE[CART_COOKIE])) {
      $cart_id = sanitize($_COOKIE[CART_COOKIE]);
    }

    if(isset($_SESSION['user'])){
      $userID = $_SESSION['user'];
      $sql= $db->query("SELECT * FROM users WHERE id = '$userID' ");
      $user_info = mysqli_fetch_assoc($sql);
      $fn= explode(' ',$user_info['full_name']);
      @$user_info['first'] = $fn[0];
      @$user_info['last'] = $fn[1];
    }

    if(isset($_SESSION['cart_success_flash'])){
       echo '<div class="w3-green w3-center">'.$_SESSION['cart_success_flash'].'</div> ';
       unset($_SESSION['cart_success_flash']);
   }

   if(isset($_SESSION['confirm_payment'])){
     $id = $_SESSION['confirm_payment'];
     $get = $db->query("SELECT * FROM orders WHERE id = '{$id}'");
     $customer = mysqli_fetch_assoc($get);
     echo '<div class=" container alert alert-success text-center">Payment and delivery successfully confirmed for <strong> '.$customer['fullname'].'!</strong></div>';
     unset($_SESSION['confirm_payment']);
   }

   if(isset($_SESSION['confirm_shipment'])){
     $id = $_SESSION['confirm_shipment'];
     $get = $db->query("SELECT * FROM orders WHERE id = '{$id}'");
     $customer = mysqli_fetch_assoc($get);
     echo '<div class=" container alert alert-success text-center">Shipment process to <strong> '.$customer['fullname'].'</strong> started!</div>';
     unset($_SESSION['confirm_shipment']);
   }

    if(isset($_SESSION['error_flash'])){
        echo '<div class="w3-black w3-center">'.$_SESSION['error_flash'].'</div> ';
        unset($_SESSION['error_flash']);
    }

    if(isset($_SESSION['user_adding_error'])){
        echo '<div class="w3-red w3-center">'.$_SESSION['user_adding_error'].'</div> ';
        unset($_SESSION['user_adding_error']);
    }

     if(isset($_SESSION['logged_in'])){
        echo '<div class="w3-green w3-center">'.$_SESSION['logged_in'].'</div> ';
        unset($_SESSION['logged_in']);
    }

    if(isset($_SESSION['add_admin'])){
        echo '<div class="w3-green w3-center">'.$_SESSION['add_admin'].'</div> ';
        unset($_SESSION['add_admin']);
    }

    if(isset($_SESSION['permission_error'])){
        echo '<div class="w3-red w3-center">'.$_SESSION['permission_error'].'</div> ';
        unset($_SESSION['permission_error']);
    }

 ?>
