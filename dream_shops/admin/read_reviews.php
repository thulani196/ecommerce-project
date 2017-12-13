<?php
    require_once '../core/init.config.php';
    //LOGGED IN CHECK
    if(!is_logged_in()){
        login_error_check();
    }
    include 'includes/header.php';
    include 'includes/navigation.php';
    $sql =$db->query("SELECT * FROM reviews");
    $records = mysqli_num_rows($sql);
    
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
        $toDeleteID = $_GET['delete'];
        $sql ="DELETE FROM reviews WHERE id = '$toDeleteID' ";
        $db->query($sql);
        header("Location: read_reviews.php");
    }
    //MAKE REVIEW FEATURED SO IT CAN BE VISIBLE ON THE HOME PAGE TO OTHER CUSTOMERS
    if(isset($_GET['setFeatured'])){
        $feature = $_GET['setFeatured'];
        $sql ="UPDATE reviews SET featured = 1 WHERE id = '$feature' ";
        $db->query($sql);
        header("Location: read_reviews.php");
    }
    //REMOVE REVIEW FROM FEATURED TO HIDE FROM THE HOME PAGE
    if(isset($_GET['removeFeatured'])){
        $feature = $_GET['removeFeatured'];
        $sql ="UPDATE reviews SET featured = 0 WHERE id = '$feature' ";
        $db->query($sql);
        header("Location: read_reviews.php");
    }
?>
<style>
    #panel,{
        height: 140px;
        width: auto;
    }
    .panel-footer{
        height: 30px;
        padding-top: 1px;
    }
    #review {
        font-size: 12px;
    }
    .center{
        position:relative;
        left: 45px;
        color:green;
    }
</style>

<div class="container w3-animate-zoom">
  <h2 class="text-center">User Reviews</h2>
  <p class="text-center"><strong>Here are some reviews from the customers.</strong></p><br>
  <div class="row">
      
    <?php while($rows = mysqli_fetch_assoc($sql)): ?>   
          <div class="col-md-3 text-justify">
             <div class="panel panel-primary" id="panel">
            <div class="panel-heading"><?= $rows['review_author']; ?> 
                <span class="pull-right">  
                    <a href="read_reviews.php?delete=<?=$rows['id']; ?>" class="btn btn-xs btn-danger glyphicon glyphicon-trash"></a>     
                </span>
            </div>

            <div id="review" class="panel-body"><?= $rows['review']; ?></div>
        <!-- PANEL FOOTER CONTENT -->
        <div class="panel-footer">
            <div class="container-fluid">
                <span class="pull-left">
                    <a class="btn btn-xs btn-primary <?=(($rows['featured']==1)? 'disabled':'') ?>" href="read_reviews.php?setFeatured=<?=$rows['id'];?>"><span class="glyphicon glyphicon-thumbs-up"><span></a>   
                </span>

                <span class="center" >
                    <?php echo ($rows['featured']==0)? '<span style="position:relative; color:purple; right:20px;"><b>Not featured</b></span>':'<b>Featured</b>'; ?>
                </span>

                 <span class="pull-right">
                     <a class="btn btn-xs w3-red <?=(($rows['featured']==0)? 'disabled':'') ?>" href="read_reviews.php?removeFeatured=<?=$rows['id'];?>"><span class="glyphicon glyphicon-thumbs-down"><span></a>
                </span>
            </div>
        </div>
        <!-- PANEL FOOTER ENDS HERE -->
            </div>
          </div>
      <?php endwhile; ?>
  </div>
</div>


<?php include 'includes/footer.php';?>
</div>

<script src="js/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
</body>
</html>
