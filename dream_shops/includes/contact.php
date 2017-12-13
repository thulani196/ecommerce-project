<br><br>
<div class="jumbotron w3-animate-opacity" id="Contact">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            		    <section style="margin:50px;">
            			    <div class="page-header" id="Contacts">
            				    <h3 class="w3-center" style="color: #f4511e";>Contact us</h3>
                        <?php
                              if(isset($_POST['name']) && isset($_POST['email']) && isset ($_POST['query'])) {
                                  $name = $_POST['name'];
                                  $email = $_POST['email'];
                                  $content = $_POST['query'];

                                  $sql = "INSERT INTO mail (id, sender_name, sender_email, content) VALUES (NULL, '$name', '$email', '$content')";
                                  if($myMail = $db->query($sql) === TRUE){
                                      echo "Mail successfully sent!";
                                  } else {
                                    echo "Error: " . $sql . "<br>" . $db->error;
                                  }
                              }
                         ?>
            				<form role="form" method="post" action="index.php#Contact">
                                <div class="form-group"><br />
                        	        <label for="name" >Name <span class="w3-text-red">*</span>:</label>
                      	            <input type="text" class="form-control" name="name" placeholder="Enter your name..." required="required"><br />
                                    <label for="email">Email address <span class="w3-text-red">*</span>:</label>
                                    <input type="email" class="form-control" name="email" required="required" placeholder="Enter your email..."><br />
                                    <label for="question">Question <span class="w3-text-red">*</span>:</label>
                                    <textarea class="form-control" name="query" rows="5" placeholder="Type your query..." required="required"></textarea>
                                </div>
                    <button type="submit" class="w3-btn w3-blue w3-round w3-medium"><span class="glyphicon glyphicon-send"></span> Send</button>
                              </form>
                         	    <hr/>
            		        </div>
                    </section>
        </div>

        <div class="col-md-6">
          <section style="margin:50px;">
            <div class="page-header" id="Contacts">
              <h3 class="w3-center w3-text-purple" style="color: #f4511e";>Leave us a review</h3>
                <?php
                      if(isset($_POST['author_name']) && isset($_POST['author_email']) &&isset ($_POST['review'])) {
                          $author = $_POST['author_name'];
                          $email = $_POST['author_email'];
                          $review = $_POST['review'];

                          $sql = "INSERT INTO reviews (id, review_author, author_email, review) VALUES (NULL, '$author', '$email', '$review')";
                          if($myReview = $db->query($sql) === TRUE){
                              echo "Review successfully sent!";
                          } else {
                            echo "Error: " . $sql . "<br>" . $db->error;
                          }
                      }
                 ?>
                    <form role="form" method="post" action="index.php#Contact">
                        <div class="form-group"><br />
                            <label for="name" >Name <span class="w3-text-red">*</span>:</label>
                            <input type="text" class="form-control" name="author_name" placeholder="Enter your name..." required="required"><br />
                            <label for="email">Email address :</label>
                            <input type="email" class="form-control" name="author_email" placeholder="Enter your email..."><br />
                            <label for="question">Review <span class="w3-text-red">*</span>:</label>
                            <textarea class="form-control" name="review" rows="5" placeholder="What do you think about us or our services?" required="required"></textarea>
                        </div>
                        <button type="submit" class="w3-btn w3-purple w3-round w3-medium">Review</button>
                    </form>
                    <hr/>
              </div>
             </section>
        </div>
</div>
</div>
</div>
