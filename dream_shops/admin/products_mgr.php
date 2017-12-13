<?php
require_once '../core/init.config.php';
//LOGGED IN CHECK
    if(!is_logged_in()){
        login_error_check();
    }
include 'includes/header.php';
include 'includes/navigation.php';
//////////////////////////////////////////////
$sql = "SELECT * FROM products ORDER BY id DESC";
$p_run = $db->query($sql);
//$products = mysqli_fetch_assoc($p_run);

//Code snippet for DELETE a product
if(isset($_GET['delete']) && !empty($_GET['delete'])){
  $toDeleteID = $_GET['delete'];
  $sql = "DELETE FROM products WHERE id = '$toDeleteID' ";
  $query_run = $db->query($sql);

  $sqlSelect = $db->query("SELECT * FROM products WHERE `id`='{$toDeleteID}'");
  $row = mysqli_fetch_assoc($sqlSelect);
  $imgLink = $_SERVER['DOCUMENT_ROOT'].$row['image'];
  unlink($imgLink);

  header("Location:products_mgr.php");
}

//Code to EDIT a product (redirects to post_product.php) and SETS a session
if(isset($_GET['edit']) && !empty($_GET['edit'])){
  $_SESSION['id'] = $_GET['edit'];
  $id = $_GET['edit'];
  header("Location: post_product.php?edit=$id");
}

//Put product on FEATURED Section
if(isset($_GET['featured']) && !empty($_GET['featured'])) {
  $toFeatureID = $_GET['featured'];
  $sql = "UPDATE products SET featured = 1 WHERE id = '$toFeatureID' ";
  $feature = $db->query($sql);
  header("Location:products_mgr.php");
}

//Remove PRODUCT from featured SECTION
if(isset($_GET['removeFeatured']) && !empty($_GET['removeFeatured'])) {
  $removeFeatureID = $_GET['removeFeatured'];
  $sql = "UPDATE products SET featured = 0 WHERE id = '$removeFeatureID' ";
  $remove_feature = $db->query($sql);
  header("Location:products_mgr.php");
}

?>
<div class="container w3-animate-zoom">
    <header class="text-center"><h2>Manage Products</h2></header><br>
    <div class="row">
        <div class=" col-md-12">
            <a class="btn btn-primary btn-md pull-right" href="post_product.php">Add a product</a>
        </div>
    </div>
    <br>
    <div class="w3-responsive">
      <table class="w3-table w3-striped w3-bordered table-condensed w3-border w3-card-4 w3-small">
          <thead class="w3-blue">
              <th>Actions</th>
              <th>Image</th>
              <th>Product Title</th>
          <!--<th>List price</th> -->
              <th>Price (K)</th>
              <th>Featured</th>
              <th>Brand</th>
              <th>Category</th>
          </thead>
          <!-- Table Body -->
          <tbody>
            <?php while($products = mysqli_fetch_assoc($p_run)): ?>
              <?php
                  $featured = $products['featured'];
                  $pro_id = $products['brand'];
                  $sql = "SELECT * FROM brand WHERE id = $pro_id";
                  $sqlRun = $db->query($sql);
                  $brand = mysqli_fetch_assoc($sqlRun);
                  
                  //////////////////////////////////////////////////////
                  $cat_id = $products['categories'];
                  $sql2 = "SELECT * FROM categories where id = $cat_id";
                  $c_run = $db->query($sql2);
                  $cat_rows = mysqli_fetch_assoc($c_run);
               ?>
                <tr>
                    <td>
                      <div style="height:35px; margin:0px 0px 0px 25px;">
                          <a class="btn btn-xs w3-red " href="products_mgr.php?delete=<?=$products['id']; ?>"><span class="glyphicon glyphicon-trash"><span></a>
                          <a class="btn btn-xs w3-green " href="products_mgr.php?edit=<?=$products['id']; ?>"><span class="glyphicon glyphicon-edit"><span></a>
                      </div>
                    </td>
                    <td><img src="<?=$products['image']; ?>" alt="product image" style="height:35px; margin:0px 0px 0px 25px;" /></td>
                    <td><?=$products['title']; ?></td>
                <!-- <td><?=$products['list_price']; ?></td> -->
                    <td><?=$products['price']; ?></td>
                    <td>
                      <div style="height:35px; margin:0px 0px 0px 25px;">
                        <a class="btn btn-xs w3-green <?=(($products['featured']==1)? 'disabled':'') ?>" href="products_mgr.php?featured=<?=$products['id'];?>"><span class="glyphicon glyphicon-plus"><span></a>
                        <a class="btn btn-xs w3-red <?=(($products['featured']==0)? 'disabled':'') ?>" href="products_mgr.php?removeFeatured=<?=$products['id'];?>"><span class="glyphicon glyphicon-minus"><span></a>
                      </div>
                    </td>
                    <td><?=$brand['brand']; ?></td>
                    <td><?=$cat_rows['category']; ?></td>
                </tr>
              <?php endwhile; ?>
          </tbody>
      </table>
                              </div>

</div>
<?php include 'includes/footer.php';?>
<script src="js/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
</body>
</html>
