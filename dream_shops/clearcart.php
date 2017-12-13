<?php
	require_once 'core/init.config.php';
	$db->query("DELETE FROM cart WHERE `id` = '{$cart_id}'");
	setcookie(CART_COOKIE,'',1,"/",$domain,false);
	header("Location: cart.php");
?>
