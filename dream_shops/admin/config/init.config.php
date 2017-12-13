<?php
       $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $my_db = 'my_store_db';
    $db = new mysqli($db_host, $db_user, $db_password, $my_db);
    if($db->connect_error){
      exit('Cannot establish connection to server...'.$db->connect_error);
    }
    require_once $_SERVER['DOCUMENT_ROOT'].'/dream_shops/config.php';
    require_once BASEURL.'helpers/helpers.php';
?>

