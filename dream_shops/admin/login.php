<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/dream_shops/core/init.config.php';  
    include 'includes/header.php';
    $email = (isset($_POST['email']))?sanitize($_POST['email']) :'' ;
    $password = (isset($_POST['password']))?sanitize($_POST['password']) :'' ;
    //Removing blank spaces from both ends of the Password or email
    $email = trim($email);
    $password = trim($password);
    $hashed = password_hash($password, PASSWORD_DEFAULT);
?>
<style>
  body {
    background-color: #f4511e;
  }
</style>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
              <h3 class="text-center w3-text-white">Online Express Store Admin Login</h3>
                <div id="admin_login" style="margin-top:60px;" class="w3-card-12 w3-padding-large w3-white">
                  
                <?php
                    
                    if(isset($_POST['login'])){
                      if(empty($_POST['email']) || empty($_POST['password'])){
                        echo 'Email and password are required to proceed.';
                      } else {
                          //Ensuring password is 6 or more characters long
                          if(strlen($password) < 6){
                            echo 'password must be at least 6 characters';
                            } else {
                             //Check if Email exists in database
                              $sql = $db->query("SELECT * FROM users WHERE email = '$email' ");
                              $user = mysqli_fetch_assoc($sql);
                              $count = mysqli_num_rows($sql);
                              if ($count < 1){
                                echo 'email not found in database.';
                              } else {
                                if(!password_verify($password, $user['password'])){
                                    echo 'The password you entered was incorrect, please try again.';
                                }else {
                                    
                                    //FINALLY LOG THE USER IN
                                    $userID = $user['id'];
                                    login($userID);
                                    //header("Location: index.php");
                                }
                              }
                          }
                      } 
                    }
                     
                ?>

                    <h3 class="text-center">ADMIN LOGIN</h3>
                    <form role="form" action="login.php" method="post">
                        <div class="form-group" >
                            <label for="email">Email:</label>
                            <input placeholder="Email here..." value="<?=$email;?>" name="email" type="email" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" placeholder="Password here..."/>
                        </div>
                        <input type="submit" name="login" class="w3-btn w3-indigo w3-btn-block w3-ripple" value="Login"/>

                    </form>
                    <br>
                </div>

            </div>
            <div class="col-md-3"> </div>

        </div>
    </div>
<div class="breaks">

    <footer class="container-fluid text-center w3-text-white">
    	  <a href="#Home" title="To Top">
    	    <span class="glyphicon glyphicon-chevron-up"></span>
    	  </a>
          <h4>Howdie! Admin!</h4>
    	  <p>&copy; Copyright 2016-<?php echo date("Y"); ?> Online Express Store</a></p>
    </footer>

</div>

</body>
</html>
