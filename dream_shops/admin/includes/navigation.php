<?php
      $sql = "SELECT * FROM categories WHERE parent_category = 0";
      $result = $db->query($sql);
 ?>
<nav class="navbar navbar-fixed-top navbar-inverse w3-indigo">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#Navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="index.php" class="navbar-brand Listitem w3-text-white w3-hover-black">Home</a>
  </div>
  <div class="collapse navbar-collapse " id="Navigation">
      <ul class="nav navbar-nav ">
        <li> <a href="brands.php" class="w3-text-white w3-hover-red"><span class="glyphicon glyphicon-pencil"></span> Brands</a> </li>

        <li> <a href="products_mgr.php" class="w3-text-white w3-hover-red">Manage Products</a></li>
        <li> <a href="categories.php" class="w3-text-white w3-hover-red"><span class="glyphicon glyphicon-pencil"></span>Categories</a> </li>
        <li> <a href="read_reviews.php" class="w3-text-white w3-hover-red"><span class="glyphicon glyphicon-pencil"></span> Reviews</a> </li>
        <li> <a href="adverts.php" class="w3-text-white w3-hover-red"><span class="glyphicon glyphicon-th"></span> Adverts</a> </li>

        <?php if(permission()): ?>
          <li> <a href="users.php" class="w3-text-white w3-hover-red"><span class="glyphicon glyphicon-user"></span> Users</a> </li>
        <?php endif; ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
            <li><a href="summary.php" class="w3-text-white w3-hover-red"><span class="glyphicon glyphicon-usd"></span> Transactions Summary</a></li>
            <li><a href="../index.php"  class="w3-text-white w3-hover-red"><span class="glyphicon glyphicon-globe"></span> Visit Site</a></li>

          <li class="dropdown">
              <a href="#" data-toggle="dropdown" class="w3-text-white w3-hover-red"><?= @$user_info['first'].' '.@$user_info['last']; ?></a>
                <ul class="dropdown-menu" role="menu">

                  <li><a href="logout.php">Logout</a></li>
                  <li><a href="#">Change password</a></li>
                </ul>
          </li>

      </ul>
    </div>
  </div>
</nav>
