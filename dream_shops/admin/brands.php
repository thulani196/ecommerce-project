<?php
    require_once '../core/init.config.php';
    //LOGGED IN CHECK
    if(!is_logged_in()){
        login_error_check();
    }
    if(!permission()){
      permission_error();
    }
    include 'includes/header.php';
    include 'includes/navigation.php';
    $sql = "SELECT * FROM brand ORDER BY brand";
    $result = $db->query($sql);

    //Code snippet to EDIT a brand
    if(isset($_GET['edit']) && !empty($_GET['edit'])){
        $toEditID = $_GET['edit'];
        $sql = "SELECT * FROM brand WHERE id = '$toEditID' ";
        $select_result = $db->query($sql);
        $rows = mysqli_fetch_assoc($select_result);
    }

    //Code snippet to DELETE a brand
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
        $toDelete = $_GET['delete'];
        $delete_query = "DELETE FROM brand WHERE id = '$toDelete'";
        $db->query($delete_query);
        header('Location: brands.php');
    }
?>
<div class="container w3-animate-zoom">
<?php
    @$brand_name = $_POST['brand'];
        if(isset($brand_name)){
            if(!empty($brand_name)){
                $brand_name = $_POST['brand'];
                $brand_name = sanitize($brand_name);
                //Get brands for Database
                    $sql1 = "SELECT * FROM brand WHERE brand = '$brand_name'";
                        /*
                        if(isset($_GET['edit'])){
                            //$sql = "SELECT * FROM brand WHERE brand = '$brand_name' AND id != '$toEditID'";
                        }
                        */
                    $result = $db->query($sql1);
                    $count = mysqli_num_rows($result);
                    if($count > 0){

                        echo '<div class="w3-center w3-red"> <b>'.$brand_name.'</b> Already exists. Please choose another Brand name.</div></br>';
                    } else {
                        $sql2 = "INSERT INTO brand (id, brand) VALUES (null, '$brand_name')";
                            if(isset($_GET['edit'])){
                                $sql2 = "UPDATE brand SET brand = '$brand_name' WHERE id = '$toEditID' ";
                            }
                        $add_brand = $db->query($sql2);
                        header('Location:brands.php');
                        echo '<b>'.$brand_name.' Successfully Added!';
                    }
            } else {
                echo '<strong> Please fill in the Brand name...</strong>';
            }
        }
?>
    <div class="text-center" >
        <div class="well well-lg">
             <form class="form-inline" role="form" method="POST" action="<?= (isset($_GET['edit'])? 'brands.php?edit='.$_GET['edit']:'brands.php') ; ?>" >
                <div class="form-group">
                  <label for="brands"> </label>
                  <input type="text" class="form-control" value="<?= (isset($_GET['edit'])? ''.$rows['brand'].'' :'' ) ;?>" placeholder="Brand name..." name="brand" >
                  <input type="submit" class="w3-btn w3-green w3-ripple w3-round-large" value="<?=( isset($_GET['edit']))? 'Edit' :'Add'; ?> Brand" name="submit">
                    <?php
                      if(isset($_GET['edit'])){
                        echo '<a href="brands.php" name="cancel" class="w3-btn w3-orange w3-ripple w3-round-large">Cancel Edit</a>';
                      }
                    ?>
                </div>
            </form>
        </div>
    </div><br>

<h2 class="text-center">Brands</h2>
    <table class="table table-striped table-bordered table-condensed" style="width:auto; margin:0 auto;" >
        <thead>
            <th></th> <th>Brand</th> <th></th>
        </thead>
        <tbody>
             <?php while($brands = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><a href="brands.php?edit=<?php echo $brands['id'];?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-edit"></span></a></td>
                        <td><?php echo $brands['brand'];?></td>
                        <td><a href="brands.php?delete=<?php echo $brands['id'];?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
                    </tr>
             <?php endwhile; ?>
        </tbody>
    </table>
    <br>
</div>
<?php include 'includes/footer.php';?>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
