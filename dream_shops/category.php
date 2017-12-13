<?php
  require_once 'core/init.config.php';
  include 'includes/header.php';
  include 'includes/navigation.php';


  if(isset($_GET['cat'])){
    $sub_category = $_GET['cat'];
    $sql = $db->query("SELECT * FROM products WHERE 'sub_category' = '$sub_category'");
    $count = mysqli_num_rows($sql);
  }
$ad = $db->query("SELECT * FROM adverts WHERE featured = 1 ORDER BY id DESC");
?>

<div class="container-fluid">
		<div class="row">
      <?php include 'includes/right_panel.php'; ?>
			<div class="col-md-9 w3-animate-opacity" >
        <!-- CODE FOR CHANGING HEADING UPON SELECTING A NEW CATEGORY -->
        <?php
              $sql2 = $db->query("SELECT * FROM products WHERE `sub_category` = '$sub_category' ");
              ////////FETCH PRODUCT CHILD IDs////////////////////////////////
              $pro = mysqli_fetch_assoc($sql2);
              $cat = $pro['sub_category'];
              $child = "SELECT * FROM categories WHERE id = '$cat' ";
              $result = $db->query($child);
              $childRow = mysqli_fetch_assoc($result);
              $parentID = $childRow['parent_category'];
              ///////////////////////////////////////////////////////////////
              $parent ="SELECT * FROM categories WHERE id = $parentID ";
              $result2 = $db->query($parent);
              $parentRow = @mysqli_fetch_assoc($result2);
              $count = @mysqli_num_rows($result2);
              $category = $parentRow['category'].' ~ '.$childRow['category'];
        ?>
        <!--==== CODE FOR CHANGING HEADING UPON SELECTING A NEW CATEGORY ENDS HERE ====-->
    <h3 class="text-center"><?=($count > 0)? ''.$category.'':'No products in this Category.';?></h3><hr>

        <?php while($product = mysqli_fetch_assoc($sql2)): ?>
  					<div class="col-md-3 w3-padding " id="product">
                          <h4 class=""><?= $product['title']; ?></h4>
  		                <img src="<?= $product['image']; ?>" alt="Lenovo PC" class="w3-center img-thumb w3-animate-top" onclick="onClick(this)"/>
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
