<?php
require_once '../core/init.config.php';
//LOGGED IN CHECK
    if(!is_logged_in()){
        login_error_check();
    }

include 'includes/header.php';
include 'includes/navigation.php';

if(!empty($_FILES)){
   $fileName = @$_FILES['file']['name'];
   $ext = strtolower(substr($fileName, strpos($fileName,'.') + 1));
   $fileName = md5(microtime()).'.'.$ext;
   $type = @$_Files['file']['type'];
   $tmp_name = @$_FILES['file']['tmp_name'];

    if(($ext == 'jpg') || ($ext == 'jpeg') || ($ext == 'png') || ($ext == 'gif')){
    //    $location = $_SERVER['DOCUMENT_ROOT'].'/dream_shops/images/ads/';
        $location = '../images/products/';
        move_uploaded_file($tmp_name, $location.$fileName);
    } else {
      echo '<div style="color:red" class="w3-center">The file type must be jpg, jpeg, gif, or png.</div></br>';
    }
}

if(isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $gQuery = $db->query("SELECT * FROM adverts WHERE id = '$id'");
  $data = mysqli_fetch_assoc($gQuery);
}

if(isset($_POST['add'])) {
    if(!empty($_POST['title'])  && !empty($_POST['description'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = '/dream_shops/images/products/'.$fileName;

        $insert = $db->query("INSERT INTO adverts (id, title, image, description) VALUES (null, '{$title}','$image','{$description}')");
        if($insert){
            header("Location: adverts.php");
        }
    }
}

if(isset($_GET['delete'])){
    $toEditID= $_GET['delete'];
    $sql1 = $db->query("SELECT * FROM adverts WHERE id = '$toEditID'");
    $fetch = mysqli_fetch_assoc($sql1);
    $imageURL = $fetch['image'];
    unlink($imageURL);
    ##################################################################
    $sql = "UPDATE adverts SET `image` = '' WHERE id = '$toEditID' ";
    $db->query($sql);
    header("Location: new_advert.php?edit=$toEditID");
}

else if(isset($_POST['update'])){
  // Edit code goes Here
  $toEditID = $_GET['edit'];
  if(!empty($_POST['title'])  && !empty($_POST['description'])){
    // $g = $db->query("SELECT * FROM adverts WHERE id = '$update' ");
    // $data = mysqli_fetch_assoc($g);
    $title = $_POST['title'];
    $description = $_POST['description'];
    @$image = '/dream_shops/images/products/'.$fileName;
    
    if($data['image'] == '') {
        $uQuery = $db->query("UPDATE adverts SET `title` = '$title', `description`='$description', `image`= '$image' WHERE id = '$id' ");
    } else {
        $uQuery = $db->query("UPDATE adverts SET `title` = '$title', `description` = '$description' WHERE id = '$id' ");
    }
    
    // $_SESSION['ad_update'] = '<div class="w">Advert Successfully Edited!</div>';
    header("Location: adverts.php");
  } else {
    echo '<div class="text-center w3-text-red">All fields are required!</div>';
  }
}

 ?>

 <div class="container">
     <h3 class="text-center">Add a new Advert</h3>
     <form class="form" action="#" method="POST" enctype="multipart/form-data">
        <div class="row">

            <div class="form-group col-md-6">
                <label for="title"></label>
                <input type="text" name="title" value="<?=(isset($_GET['edit']))?''.$data['title'].'':''?>" placeholder="Advert Title..." class="form-control">
            </div>
<!--
            <div class="form-group col-md-6">
                <label for="title"></label>
                <input type="file" name="file" class="form-control">
            </div> -->

            <?php if(!(@$data['image']) || (@$data['image'] == ' ')): ?>
                <div class="form-group col-md-6">
                    <label for="image">Choose product Image<span style="color:red;">*</span>:</label>
                    <input type="file" name="file" id="image" class="form-control w3-btn-block w3-teal">
                </div>
            <?php else: ?>
              <div class="form-group col-md-6 text-center">
                  <img src="<?= $data['image'];?>"  width="100%"height="250px"><br /><br />
                  <a href="new_advert.php?delete=<?=$data['id']?>" class="w3-text-red">Delete Image</a>
              </div>
          <?php endif; ?>

            <div class="form-group col-md-12">
                <label for="title">Ad Description:</label>
                <textarea type="text" placeholder="Advert description..." name="description" rows="8"  class="form-control"><?=(isset($_GET['edit']))?''.$data['description'].'':''?></textarea>
            </div>

            <div class="form-group col-md-12">
                <label for="title"></label>
                <button class="w3-btn w3-blue btn-block" name="<?=(isset($_GET['edit']))? 'update':'add';?>"><?=(isset($_GET['edit']))?'Edit Ad':'Save Advert';?></button>
            </div>



        </div>
     </form>
 </div>
