<?php
  require_once 'core/init.config.php';
  include 'includes/header.php';
  include 'includes/navigation.php';

  if(isset($_GET['submit'])){
    $key = @$_GET['search_key'];
    $sql = "SELECT * FROM products WHERE title LIKE '%".$key."%'  ";
    $s = $db->query($sql);
    @$count = mysqli_num_rows($s);
  }

  $ad = $db->query("SELECT * FROM adverts WHERE featured = 1 ORDER BY id DESC");
?>
<div class="container-fluid">
		<div class="row">
      <?php include 'includes/right_panel.php'; ?>
			<div class="col-md-9 w3-animate-opacity" >
        <?= (@$count < 1)? '<h4 class="text-center">No results Found</h4>' :'<h4 class="text-center">  '.$count.' Results Found</h4>' ; ?>
        <!--==== CODE FOR CHANGING HEADING UPON SELECTING A NEW CATEGORY ENDS HERE ====-->
        <?php while($product = @mysqli_fetch_assoc($s)): ?>
					<div class="col-md-3 w3-padding " id="product">
                <h4 class=""><?php echo $product['title']; ?></h4>
		                <img src="<?php echo $product['image']; ?>" alt="Lenovo PC" class="w3-center img-thumb w3-animate-top" onclick="onClick(this)"/>
				        <br><br><div class="">
		                
		                <p><span class="w3-text-green w3-animate-right">Our Price</span>: K<?php echo $product['price']; ?></p>
		                <button type="button" class="btn btn-sm btn-success w3-animate-bottom" onclick="detailsmodal(<?php echo $product['id']; ?>)">Details</button>
									</div>
					</div>
	<?php endwhile; ?>
			</div>
<?php
		include 'includes/image-modal.php';
 ?>
				</div>
			</div>
	<?php	//include 'includes/contact.php'; ?>
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
