<?php
	require_once 'core/init.config.php';
	include 'includes/header.php';
	include 'includes/navigation.php';

	//Getting products by category if selected
		$sql = "SELECT * FROM products WHERE featured = 1 ORDER BY id DESC";
		$result = $db->query($sql);

	//GETTING FEATURED ADVERTS FROM THE DATABASE
		$ad = $db->query("SELECT * FROM adverts WHERE featured = 1 ORDER BY id DESC");
 ?>
<div class="container-fluid">
		<div class="row">
			<?php include 'includes/right_panel.php'; ?>
			<div class="col-md-9 w3-animate-opacity" >
				<h3 class="text-center">Featured Products</h3><hr>
	<?php while($product = @mysqli_fetch_assoc($result)): ?>
					<div class="col-lg-3 col-md-4 col-sm-4 w3-padding " id="product">
		                <h4 class=""><?php echo $product['title']; ?></h4>
		                <img src="<?php echo $product['image']; ?>" alt="Lenovo PC" class="w3-center img-thumb w3-animate-top" onclick="onClick(this)"/>
				       <br><br>
				       <div class="">

                            <p><span class="w3-text-green w3-animate-right">Price</span>: $<?php echo $product['price']; ?></p>
                            <button type="button" class="w3-btn w3-small w3-btn-block w3-indigo w3-round w3-animate-bottom" onclick="detailsmodal(<?php echo $product['id']; ?>)">More Details</button>
				       </div>
					</div>
	<?php endwhile; ?>
			</div>
<?php
		include 'includes/image-modal.php';
 ?>
				</div>
</div>
	<!-- <?php	include 'includes/contact.php'; ?> -->
	  </div>
	</div>
<!-- Footer -->
<?php include 'includes/footer.php'; ?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
</body>
</html>
