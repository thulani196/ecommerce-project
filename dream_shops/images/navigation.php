<?php
  $sql = "SELECT * FROM categories WHERE parent_category = 0";
  $result = $db->query($sql);
 ?>
<nav class="navbar navbar-fixed-top navbar-default">
  <div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#Navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="index.php" class="navbar-brand Listitem">Tutu's Store</a>
  </div>
  <div class="collapse navbar-collapse" id="Navigation">
      <ul class="nav navbar-nav">
        <?php while($parent = mysqli_fetch_assoc($result)): ?>
            <?php
              $parent_id = $parent['id'];
              $sql1 = "SELECT * FROM categories WHERE parent_category = '$parent_id' ";
              $result2 = $db->query($sql1);
            ?>
<li class="dropdown">
          <a href="#" class="dropdown-toggle Listitem" data-toggle="dropdown"><?php echo $parent['category']; ?><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
          <?php while($child = mysqli_fetch_assoc($result2)): ?>
              <li><a href="#" class="subcat"><?php echo $child['category']; ?></a></li>
          <?php endwhile; ?>
          </ul>
</li>
          <?php endwhile; ?>
          <li><a href="#" class="subcat" style="color: #fff !important;">Articles <span class="glyphicon glyphicon-pencil"></span></a></li>
          <li><a href="#Contact" class="subcat" style="color: #fff !important;">Contact us <span class="glyphicon glyphicon-envelope"></span></a></li>
      </ul>
    </div>
  </div>
</nav>
<div id="headerWrapper">
</div>
<div class="container-fluid">
<br>
    <div class="well well-md text-center" style="background-color:#f4511e; color: #fff !important;">
      <strong>We have in stock all you may need ranging for Gadgets, Clothes, Accessories & so many more items...</strong>
    </div>
</div>
