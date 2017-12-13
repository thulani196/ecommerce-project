<?php

function sanitize($dirty){
    return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}

//Function to log an admin IN
function login($userID) {
    $_SESSION['user'] = $userID;
    global $db;
    $date = date("Y-m-d H:i:s");
    $db->query("UPDATE users SET last_login = '$date' WHERE id = '$userID' ");
    $_SESSION['logged_in'] = 'You are now logged in';
    header("Location: index.php");
}

//CODE TO GENERATE A RANDOM INVOICE ID/NUMBER
function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
              $str = 'OES';
              $count = strlen($charset);
              while ($length--) {
                  $str .= $charset[mt_rand(0, $count-1)];
              }
              return $str;
}

//function to check if the user is logged in
function is_logged_in() {
    if(isset($_SESSION['user']) && $_SESSION['user'] > 0){
        return true;
    }
        return false;
}

function login_error_check($redirect = 'login.php'){
    $_SESSION['error_flash'] = 'You must be logged in to view that page.';
    header('Location: '.$redirect);
}

function permission_error($url = 'index.php'){
  $_SESSION['permission_error'] = 'You do not have permission to that page';
  header('Location: '.$url);
}

function sizesToArray($string) {
  $sizesArray = explode(',',$string);
  $returnArray = array();
  foreach($sizesArray as $size){
    $s = explode(':', $size);
    $returnArray[] = array('size' => $s[0], 'quantity' => $s[1]);
  }
  return $returnArray;
}

function sizesToString($array){
  $sizeString = '';
  foreach($array as $size){
    $sizeString .= $size['size'].':'.$size['quantity'].',';
  }
  $trimmed = rtrim($sizeString,',');
  return $trimmed;
}

function permission($permission = 'admin'){
  global $user_info;
  $permissions = explode(',', $user_info['permissions']);
  if(in_array($permission, $permissions,true)) {
    return true;
  }
    return false;
}
 ?>
