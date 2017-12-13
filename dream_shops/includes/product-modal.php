<?php
    require_once '../core/init.config.php';
    $id = $_POST['id'];
    $id = (int)$id;
    $sql = "SELECT * FROM products WHERE id = '$id'";
    $result = $db->query($sql);
    $product = mysqli_fetch_assoc($result);
    $brand_id = $product['brand'];
    $sql = "SELECT brand FROM brand WHERE id = '$brand_id'";
    $brand_query = $db->query($sql);
    $brand = mysqli_fetch_assoc($brand_query);
    $size_string = $product['sizes'];
    $size_array = explode(',', $size_string);
?>


<!-- Details Light box modal-->
<?php ob_start(); ?>
<div class="modal fade details-1 w3-animate-opacity" id="details-modal" tabindex="-3" role="dialog" aria-labelledby="details-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!--Modal Header-->
    <div class="modal-header w3-orange">
        <button class="close" type="button" onclick="closeModal()" aria-label="close"><span  aria-hidden="true">&times;</button>
        <h4 class="modal-title text-centre w3-text-black"><?php echo $product['title']; ?></h4>
    </div>
    <!--Modal Body-->
    <div class="modal-body">
      <div class="container-fluid">
        <div class="row">
          <span id="modal_errors" class="bg-danger"></span>
          <div class="col-sm-6">
            <div class="center-block">
              <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['image']; ?>" class="details img-responsive">
            </div>
          </div>

          <div class="col-sm-6">
            <h4>Details</h4>
            <p><?php echo nl2br($product['description']); ?></p>
            <hr>

            <p>Price: $<?php echo $product['price']; ?></p>
            <p>Brand: <?php echo $brand['brand']; ?></p>
              
            <form action="add_cart.php" method="post" id="add_product_form">
                <input type="hidden" name="product_id" value="<?=$id;?>">
                <input type="hidden" name="available" id="available" value="">
              <div class="form-group">
                <div class="col-xs-3">
                  <label for="quantity">Quantity</label>
                  <input type="number" class="form-control" id="quantity" name="quantity">
                </div>
                <div class="col-xs-9"></div>
              </div>

              <br><br>
              <div class="form-group">
                <label for="size">Size:</label>
                <select name="size" id="size" class="form-control" id="add_product_form">
                  <option value="">--Choose your size--</option>
                  <?php foreach ($size_array as $string) {
                      $string_array = explode(':', $string);
                      $size = $string_array[0];
                      $available = $string_array[1];
    echo '<option value="'.$size.'" data-available="'.$available.'" id="available">'.$size.' ('.$available. ' Available)</option>';
                  } 
                    ?>

                </select>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer w3-orange">
      <button class="btn btn-default" onclick="closeModal()">Close</button>
      <button class="btn btn-primary" onclick="add_to_cart();return false;" ><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</button>
    </div>
  </div>
</div>
</div>

<script>
    jQuery('#size').change(function(){
        var available = jQuery('#size option:selected').data("available");
        jQuery('#available').val(available);
    });
    
    function closeModal(){
        jQuery('#details-modal').modal('hide');
              setTimeout(function(){
              jQuery('#details-modal').remove();
              },300);
        }
</script>
<?php echo ob_get_clean(); ?>
