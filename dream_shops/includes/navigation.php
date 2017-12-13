<?php
    $sql = "SELECT * FROM categories WHERE parent_category = 0";
    $result = $db->query($sql);


    if(!empty($cart_id)){
      $cQuery = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
      $cart = mysqli_fetch_assoc($cQuery);
      @$items_decoded = json_decode($cart['items'], true);
      $arrays = sizeof($items_decoded);

      if($arrays == 1) {
            $count = $arrays. ' Item';
          } else {
            $count = $arrays. ' Items';
          }
          } else {
          $count = 'Empty';
        }

 ?>

<div class="header-background container-fluid" id="header-image" >
<nav class="navbar navbar-default w3-animate-opacity" style="background:transparent; border:none;">
  <div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#Navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="index.php" class="navbar-brand Listitem" style="font-size:15px;"><b>HOME</b></a>
  </div>
  <div class="collapse navbar-collapse" id="Navigation">
      <ul class="nav navbar-nav" style="word-spacing:0.1em;">
        <?php while($parent = mysqli_fetch_assoc($result)): ?>
            <?php
                $parent_id = $parent['id'];
                $sql1 = "SELECT * FROM categories WHERE parent_category = '$parent_id' ";
                $result2 = $db->query($sql1);
            ?>
<li class="dropdown">
          <a href="index.php" class="dropdown-toggle Listitem w3-hover-white" data-toggle="dropdown"><?php echo $parent['category']; ?><span class=""></span></a>

          <ul class="dropdown-menu" role="menu">
          <?php while($child = mysqli_fetch_assoc($result2)): ?>
              <li class=""><a href="category.php?cat=<?php echo $child['id']; ?>" class="subcat w3-hover-black"><?php echo $child['category']; ?></a></li>
          <?php endwhile; ?>
          </ul>
</li>
          <?php endwhile; ?>
          
          <li><a href="#Contact" class="subcat w3-hover-deep-orange" style="color: #fff !important;">Contact us</a></li>
           <li><a href="cart.php" class="subcat w3-hover-deep-orange" style="color: #fff !important;"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart  - <?=@$count ?> </a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
   <div class="row">
       <div class="col-md-12">
           <h1 class="w3-text-white w3-center">Online Express Store!</h1><br>

           <h4 class="w3-center w3-text-white">Online Express Store - home of all your Gadgets and Clothing needs!</h4>
       <br>
             <form class="form-inline w3-center" method="GET" action="results.php">
               <div class="form-group">
                   <input type="text" name="search_key" class="form-control" size="50" placeholder="Search for products..." required>
               </div>
               <button type="submit" name="submit" value="search" class="w3-btn w3-ripple w3-red w3-round w3-small">Search</button>
             </form>
       </div>

   </div>
</div>

</div>
<div id="headerWrapper">

</div>
<div class="container-fluid">
<br>

</div>
