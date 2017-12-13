<?php
  require_once '../core/init.config.php';
    if(!is_logged_in()){
        login_error_check();
    }
    if(!permission()){
      permission_error();
    }
  include 'includes/header.php';
  include 'includes/navigation.php';
  $sql = "SELECT * FROM users";
  $result = $db->query($sql);
  #################################
  $row_count = 1; ####//Row Counter
  #################################
  //FIELDS DETAILS
  @$name = sanitize($_POST['name']);
  @$email = sanitize($_POST['email']);
  @$role = sanitize($_POST['role']);
  @$password = sanitize($_POST['password']); 
  @$password2 = sanitize($_POST['password2']); 
  @$joinDate = date("Y-m-d H:m:i");
  
  //CODE TO REGISTER A NEW ADMINISTRATOR
  if(isset($_POST['add'])){
      if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['role']) && !empty($_POST['password'])){
          if($_POST['password'] == $_POST['password2']){
                //HASHING THE PASSWORD FOR SECURITY
                $password = password_hash($password, PASSWORD_DEFAULT);
                //INSERT QUERY REGISTERING NEW ADMIN TO THE DATABASE
                $sql = "INSERT INTO users (full_name, email, password, join_date, permissions) VALUES('$name','$email','$password','$joinDate','$role')";
                $insert = $db->query($sql);
                $_SESSION['add_admin'] = 'New user successfully added!';
                header("Location: users.php");
          } else {
                echo '<div class="w3-red w3-center"> Passwords do not match!</div> ';
          } 
      } else {
                echo '<div class="w3-red w3-center"> All fields with an asterisks are required!</div> ';
      }
  }
//CODE TO EDIT A USER
if(isset($_POST['update'])){
      if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['role']) && !empty($_POST['password'])){
          if($_POST['password'] == $_POST['password2']){
                $toEditID = $_SESSION['edit'];
                //HASHING THE PASSWORD FOR SECURITY
                $password = password_hash($password, PASSWORD_DEFAULT);
                //INSERT QUERY REGISTERING NEW ADMIN TO THE DATABASE
                $update = $db->query("UPDATE users SET `full_name` = '$name', `email`='$email', `password`='$password', 
                                      `join_date`='$joinDate',`permissions`='$role' WHERE `id` = '$toEditID' ");
                
                //$update = $db->query($sql);
                $_SESSION['add_admin'] = 'Update successful!';
                unset($_SESSION['edit']);
                header("Location: users.php");
          } else {
                echo '<div class="w3-red w3-center"> Passwords do not match!</div> ';
          } 
      } else {
                echo '<div class="w3-red w3-center"> All fields with an asterisks are required!</div> ';
      }
  }

  //CODE TO DELETE A DATABASE USER
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
        $toDeleteID = $_GET['delete'];
        $delete = $db->query("DELETE FROM users WHERE id = '$toDeleteID' ");
        $_SESSION['add_admin'] = 'Record successfully deleted!';
        header("Location: users.php");
    }

//CODE TO EDIT A USER (UPDATE DATABASE)
if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $_SESSION['edit'] = $_GET['edit'];
    $toEditID = $_SESSION['edit'];
    $myedit = $db->query("SELECT * FROM users WHERE id = '$toEditID' ");
    $edit = mysqli_fetch_assoc($myedit);
}
 ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">

        <h3 class="">New user Form</h3><hr>
        <form action="users.php" method="POST" class="form" id="add_user">
            <div class="col-sm-6">
                <div class="form-group">
                    <input type="text" value="<?=(isset($_GET['edit']))? ''.$edit['full_name'].'': ''.$name.'';?>" name="name" class="form-control" placeholder="Full name*">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                     <input type="email" value="<?=(isset($_GET['edit']))? ''.$edit['email'].'': ''.$email.'';?>" name="email" class="form-control" placeholder="User email*">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="role">User role*:</label>
                     <select id="permission"  name="role" class="form-control">
                         <option value="" selected>select a user role</option>
                         <option value="admin">Admin</option>
                         <option value="editor" >Editor</option>
                         <option value="editor,admin">Editor & Admin</option>
                     </select>
                </div>
            </div>
            <div class="col-sm-6 form-group">
                <input type="password" name="password" class="form-control" placeholder="Password*" >
            </div>
            <div class="col-sm-6 form-group">
                <input type="password" name="password2" class="form-control" placeholder="Confirm password*" >
            </div>
            <div class="col-sm-12">
                <input type="submit" class="btn btn-info" name="<?=(isset($_GET['edit']))?'update':'add';?>" 
                       value="<?=(isset($_GET['edit']))? 'Edit user': 'Add user';?>">
                <?php if(isset($_GET['edit'])): ?>
                    <a href="users.php"  class="btn btn-info" name="">Cancel</a>
                <?php endif; ?>
            </div>
        </form>

        </div>
        <div class="col-md-6"><h3>User's table</h3>

            <table class="table table-striped table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Roles</th>
                        <th>Last login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($rows = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row_count++; ?></td>
                        <td><?=$rows['full_name']; ?></td>
                        <td><?=$rows['permissions']; ?></td>
                        <td><?=$rows['last_login']; ?></td>
                        <td>
                            <a href="users.php?delete=<?=$rows['id'];?>" class="w3-btn w3-small w3-red"><span class="glyphicon glyphicon-trash"></span></a>
                            <a href="users.php?edit=<?=$rows['id'];?>" class="w3-btn w3-small w3-blue"><span class="glyphicon glyphicon-edit"></span></a>
                        </td>
                    </tr>
                  <?php endwhile;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>

