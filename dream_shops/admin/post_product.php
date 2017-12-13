<?php
    require_once '../core/init.config.php';
    //LOGGED IN CHECK
    if(!is_logged_in()){
        login_error_check();
    }
    include 'includes/header.php';
    include 'includes/navigation.php';
    $sql = "SELECT * FROM categories WHERE parent_category = 0 ORDER BY category";
    $sql2 = "SELECT * FROM brand ORDER BY brand";
    $sql3 = "SELECT * FROM products";
    $result = $db->query($sql);
    $result2 = $db->query($sql2);
    $result3 = $db->query($sql3);
    $location = '';

    //======Product Details==========//
    @$title = sanitize($_POST['title']);
    #@$lprice = sanitize($_POST['list_price']);
    @$oprice = sanitize($_POST['our_price']);
    @$category = sanitize($_POST['parent']);
    @$sub_category = sanitize($_POST['child']);
    @$brand = sanitize($_POST['brand']);
    @$sizes = sanitize($_POST['size']);
    @$details = sanitize($_POST['details']);

    //----PRODUCT DETAILS-----///
    if(!empty($_FILES)){
       $fileName = @$_FILES['file']['name'];
       $ext = strtolower(substr($fileName, strpos($fileName,'.') + 1));
       $fileName = md5(microtime()).'.'.$ext;
       $type = @$_Files['file']['type'];
       $tmp_name = @$_FILES['file']['tmp_name'];

        if(($ext == 'jpg') || ($ext == 'jpeg') || ($ext == 'png') || ($ext == 'gif')){
           $location = '../images/products/';
           move_uploaded_file($tmp_name, $location.$fileName);
        } else {
          echo '<div style="color:red" class="w3-center">The file type must be jpg, jpeg, gif, or png.</div></br>';
        }
    }
    //Code to add new product to the database
    if(isset($_POST['post'])){
      if(!empty($_POST['title']) && !empty($_POST['our_price']) && !empty($_POST['brand']) && !empty($_POST['details']) ){
          @$image = '/dream_shops/images/products/'.$fileName;
          $insertQuery = "INSERT INTO products (`title`,`price`,`brand`,`categories`,`sub_category`,`image`,`description`,`sizes`)
                          VALUES ('$title', '$oprice','$brand','$category','$sub_category','$image','$details','$sizes')";

          $db->query($insertQuery);
          header("Location: products_mgr.php");
      } else {
          echo '<div style="color:red" class="w3-center">Fields with an Astrisk are required!</div></br>';
      }
    }
    else if(isset($_POST['update'])){
              @$image = '/dream_shops/images/products/'.$fileName;
              $toEditID = $_SESSION['id'];
              $sql = $db->query("SELECT * FROM products WHERE id = '$toEditID' ");
              $rows = mysqli_fetch_assoc($sql);

              //Code that updates an Image if it does not exist in the database.
              if(($rows['image'] == '')){
                   $updateQuery = "UPDATE products SET title='$title', price='$oprice', brand='$brand',
                              categories='$category', sub_category='$sub_category', image='$image', description='$details',
                              sizes='$sizes'  WHERE id = '$toEditID' ";
              } else {
              //Code to skip updating the image if the admin decides to keep the currently existing one.
                 $updateQuery = "UPDATE products SET title='$title', price='$oprice', brand='$brand',
                              categories='$category', sub_category='$sub_category', description='$details',
                              sizes='$sizes'  WHERE id = '$toEditID' ";
              }

              $db->query($updateQuery);
              unset($_SESSION['id']);
              header("Location: products_mgr.php");
          }

    if(isset($_POST['category'])){
      $sql = "SELECT `category` FROM categories WHERE id = parent_category";
      $child = $db->query($sql);
    }
    //Assigning session to variable if at all it has been SET
    if(isset($_SESSION['id'])){
      $toEditID = $_SESSION['id'];
      $sql = "SELECT * FROM products WHERE id = '$toEditID' ";
      $query_run = $db->query($sql);
      $rows = mysqli_fetch_assoc($query_run);
    }

    //DESTROYING Session if CANCEL button is pressed
    if(isset($_GET['cancelEdit']) && !empty($_GET['cancelEdit'])){
        unset($_SESSION['id']);
        header("Location: products_mgr.php");
    }

    //DELETING PRODUCT IMAGE UPON EDITING
    if(isset($_GET['removeImage'])){
        $toEditID= $_GET['removeImage'];
        $sql1 = $db->query("SELECT * FROM products WHERE id = '$toEditID'");
        $fetch = mysqli_fetch_assoc($sql1);
        $imageURL = $_SERVER['DOCUMENT_ROOT'].$fetch['image'];
        unlink($imageURL);
        ##################################################################
        $sql = "UPDATE products SET `image` = '' WHERE id = '$toEditID' ";
        $db->query($sql);
        header("Location: post_product.php?edit=$toEditID");
    }

?>
<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<div class="container">
  <div class="row">
      <div class="col-md-4">
        <?php if(isset($_SESSION['id'])): ?>
          <figure>
            <h4>Product Image</h4>
            <img alt="<?= (!empty($rows['image']))?'product image':'No Image to display'; ?>" name="product_image" src="<?=(isset($toEditID))? ''.$rows['image'].'': ''; ?>" class="img-responsive img-thumb">
            <br>
        <figcaption>
            <a style="text-decoration:none;" href="post_product.php?removeImage=<?= $rows['id']; ?>"><span class="w3-text-red">Delete Image</span></a>
        </figcaption>
          </figure>
         <?php endif; ?>
      </div>
        <div class="col-md-4 w3-card-12 w3-padding-large w3-animate-zoom">
            <?php
                if(isset($toEditID)){
                    echo '<div class="w3-center "><b>EDIT PRODUCT</b></div>';
                }
                if(isset($_SESSION['id'])){
                    echo '<a type="button" class="w3-btn-block w3-btn-medium w3-orange " name="cancel" value="Cancel Edit" href="post_product.php?cancelEdit='.$toEditID.'">Cancel Edit</a></br></br>';
                }
            ?>
            <form class="form" role="form" action="post_product.php" method="post" enctype="multipart/form-data" id="product_image">
                <div class="form-group">
                <label for="title">Product title<span style="color:red;">*</span>: </label>
                <input type="text" class="form-control" name="title" value="<?=(isset($toEditID))? ''.$rows['title'].'':''; ?>">
                </div>

          
                <div class="form-group">
                    <label for="title">Our Price<span style="color:red;">*</span>: </label>
                    <input type="text" class="form-control" name="our_price" value="<?=(isset($toEditID))? ''.$rows['price'].'':''; ?>" >
                </div>
                <?php if(!(@$rows['image']) || (@$rows['image'] == ' ')): ?>
                    <div class="form-group">
                        <label for="image">Choose product Image<span style="color:red;">*</span>:</label>
                        <input type="file" name="file" id="image" class="form-control w3-btn-block w3-teal">
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="parent">Product category:</label>
                    <select class="form-control" name="parent" id="parent">
                        <option value="">--Choose a category--</option>
                        <?php while($category = mysqli_fetch_assoc($result)): ?>
                            <option value="<?= $category['id']; ?>"><?= (isset($toEditID))? ''.$category['category'].'':''.$category['category'].''; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="child">Sub-category:</label>
                    <select class="form-control" name="child" id="child">
                    </select>
                </div>

                 <div class="form-group">
                    <label for="brand">Product brand<span style="color:red;">*</span>:</label>
                        <select class="form-control" name="brand">
                            <option value="">--Choose a brand--</option>
                            <?php while($brand = mysqli_fetch_assoc($result2)): ?>
                                <option value="<?= $brand['id']; ?>"><?php echo $brand['brand']; ?></option>
                            <?php endwhile; ?>
                        </select>
                 </div>

                 <div class="form-group">
                   <label for="featured">Sizes:</label>
                   <sub><span class="text-danger">e.g "Size:Quantity, Size:Quantity"</span></sub>
                   <input type="text" name="size" placeholder="'Large:12, Medium:10, Small:5' respectively..." class="form-control" value="<?=(isset($toEditID))? ''.$rows['sizes'].'':''; ?>">
                 </div>

                <div class="form-group">
                    <label for="details">Product details<span style="color:red;">*</span>:</label>
                    <textarea rows="5" class="form-control" name="details" ><?=(isset($toEditID))? ''.$rows['description'].'':''; ?></textarea>
                </div>

        <input type="submit" class="w3-btn-block w3-btn-medium w3-blue w3-ripple" name="<?=(isset($toEditID))? 'update': 'post'; ?>" value="<?=(isset($toEditID))? 'Update ': 'Post ' ?>Product " ><br>

            </form>
        </div>
      <div class="col-md-4"></div>
  </div>
</div>
<?php include 'includes/footer.php';?>
<!-- Necessary for transitions -->
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
