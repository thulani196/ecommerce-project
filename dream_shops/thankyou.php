<?php
	require_once 'core/init.config.php';
	include 'includes/header.php';
	include 'includes/navigation.php';
?>

<div class="container text-center">
      <?php if(!empty($cart_id)): ?>
      <h3><i>Thank you for shopping with us!</i></h3><br>
      <p><i><b>Please clear your cart after downloading your invoice for security reasons.</b></i></p>
      <a href="receipt.php" target="_blank" class="btn btn-danger w3-large w3-round"><span class="glyphicon glyphicon-print"></span> Click here to get your receipt! <span class="glyphicon glyphicon-download"></span></a>
      <h4> Come back again!</h4>
    <?php else: ?>
      <h4 class="w3-center">It appears your cart is empty. Please click <a href="index.php" class="w3-text-blue"><em><b>Here</b></em></a> to add items to your cart. Thank You!</h4>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
