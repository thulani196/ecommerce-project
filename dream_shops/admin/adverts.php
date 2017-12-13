<?php
    require_once '../core/init.config.php';
    //LOGGED IN CHECK
        if(!is_logged_in()){
            login_error_check();
        }

    include 'includes/header.php';
    include 'includes/navigation.php';
    $sql = $db->query("SELECT * FROM adverts");

    if(isset($_GET['delete'])){
        $todELETE = $_GET['delete'];
        $sqlSelect = $db->query("SELECT * FROM adverts WHERE `id`='{$todELETE}'");
        $row = mysqli_fetch_assoc($sqlSelect);
        $imgLink = $_SERVER['DOCUMENT_ROOT'].$row['image'];
        unlink($imgLink);

        $sql = $db->query("DELETE FROM adverts WHERE `id`='{$todELETE}'");
        header("Location: adverts.php");
    }

    if(isset($_GET['feature'])){
      $toFeature = $_GET['feature'];
      $sql = $db->query("UPDATE adverts SET featured = 1 WHERE `id`='{$toFeature}'");
        if($sql) {
          header("Location: adverts.php");
        }
    }

    if(isset($_GET['unfeature'])){
      $toFeature = $_GET['unfeature'];
      $sql = $db->query("UPDATE adverts SET featured = 0 WHERE `id`='{$toFeature}'");
        if($sql) {
          header("Location: adverts.php");
        }
    }

?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="new_advert.php" class="w3-btn w3-ripple w3-round w3-indigo pull-right">Add an advert</a>
        </div>
        <table class="table table-striped table-condensed">

            <thead>
                <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php while($advert = mysqli_fetch_assoc($sql)): ?>
                    <tr>
                        <td><img src="<?= $advert['image'];?>" alt="ad" style="height:35px;"></td>
                        <td><?= $advert['title'];?></td>
                        <td><?= substr($advert['description'],0,80);?></td>
                        <td>
                            <a href="adverts.php?feature=<?= $advert['id'];?>" class="w3-btn w3-green <?= (($advert['featured'] == 1)? 'w3-disabled':'')?>">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                            </a>



                            <a href="adverts.php?unfeature=<?= $advert['id'];?>" class="w3-btn w3-purple <?= (($advert['featured'] == 0)? 'w3-disabled':'')?>">
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                            </a>

                            <a href="new_advert.php?edit=<?= $advert['id'];?>" class="w3-btn w3-blue">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>

                            <a href="adverts.php?delete=<?= $advert['id'];?>" class="w3-btn w3-red ">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>

    </div>
</div>
