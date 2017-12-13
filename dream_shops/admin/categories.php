<?php
require_once '../core/init.config.php';
//LOGGED IN CHECK
    if(!is_logged_in()){
        login_error_check();
    }
include 'includes/header.php';
include 'includes/navigation.php';
$sql = "SELECT * FROM categories WHERE parent_category = 0 ORDER BY category ASC";
$result = $db->query($sql);

if(isset($_POST['Add'])){
    if(!empty($_POST['child']) && !empty($_POST['parent'])){
        $parentID = $_POST['parent'];
        $category = $_POST['child'];
        $sql = "INSERT INTO categories (id, category, parent_category) VALUES (null, '$category', '$parentID' )";
        $insertQuery = $db->query($sql);
        @$success = '<div  class="w3-center w3-green">Category added Successfully!</div></br>';

    } else {
        @$error =  '<div  class="w3-center w3-red">Category name cannot be empty!</div></br>';
    }
}

//QUERY TO UPDATE A CATEGORY
if(isset($_POST['update'])){
    if(!empty($_POST['child']) && !empty($_POST['parent'])){
        $editID = $_GET['edit'];
        $parentID = $_POST['parent'];
        $category = $_POST['child'];
        $sql = "UPDATE categories SET category = '$category', parent_category = '$parentID' WHERE id = '$editID' ";
        $updateQuery = $db->query($sql);
        @$success = '<div  class="w3-center w3-green">Category Successfully UPDATE!</div></br>';

    } else {
        @$error =  '<div  class="w3-center w3-red">Category name cannot be empty!</div></br>';
    }
}
//DELETING A CATEGORY
if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $toDeleteID = $_GET['delete'];
    $deleteQuery = $db->query("DELETE FROM categories WHERE id = '$toDeleteID' ");
    header("Location: categories.php");
}

//EDITING A CATEGORY
if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $toEditID = $_GET['edit'];
    $editQuery = $db->query("SELECT * FROM categories WHERE id = '$toEditID' ");
    $row = mysqli_fetch_assoc($editQuery);
    $subCat = $row['id'];

    $query2 = $db->query("SELECT * FROM categories WHERE parent_category = 0");
    $parent = mysqli_fetch_assoc($query2);
    $parentID = $parent['id'];
}

?>

<body>
    <script src="js/jquery-1.11.2.min.js"></script>
    <div class="container-fluid w3-animate-zoom">
        <div class="row">
            <div class="col-md-5">
                <?php
                    if(empty($_POST['child'])){
                        echo @$error;
                    } else if($insertQuery) {
                        echo @$success;
                    }
                ?>
                <h4 class=" text-center">Add a Category</h4>
                <form class="form" action="categories.php" method="POST">
                    <div class="form-group">
                        <label for="category">Parent Category</label>
                        <select name="parent" class="form-control">
                        <?php while($rows = mysqli_fetch_assoc($result)): ?>
                            <option value="<?=$rows['id']; ?>"><?=$rows['category']; ?></option>
                        <?php endwhile ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="child">Category</label>
                            <input type="text" name="child" class="form-control"
                            value="<?=(isset($_GET['edit'])?''.$row['category'].'' :'' ); ?>"
                            placeholder="Category name...">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="<?=(isset($_GET['edit'])? 'update': 'Add') ;?>" class="w3-btn w3-round w3-deep-purple btn-block" value="<?=(isset($_GET['edit']))? 'Update': 'Add category' ; ?>">

                        <?php if(isset($_GET['edit'])): ?>
                           <a href="categories.php" class="w3-btn w3-round w3-red btn-block">
                                Cancel edit
                           </a>
                        <?php endif; ?>

                    </div>
                </form>

            </div>
<?php
    $parentQuery = $db->query("SELECT * FROM categories WHERE parent_category = 0 ORDER BY category ASC");
?>
            <div class="col-md-7 text-center">
                <h4>Categories</h4>
                <table class="table table-bordered table-striped table-condensed">
                <?php while($parent = mysqli_fetch_assoc($parentQuery)): ?>
                    <?php
                        $parentID = $parent['id'];
                        $childQuery = $db->query("SELECT * FROM categories WHERE parent_category = '$parentID' ");
                    ?>
                    <thead>
                        <!-- Parent categories -->
                        <tr>
                            <th class="alert alert-info w3-text-black"><?php echo $parent['category']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Child Categories -->
                    <?php while($child = mysqli_fetch_assoc($childQuery)): ?>
                        <tr class="">
                            <td>
                                <span class="pull-left">
                                    <a href="categories.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-primary">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                </span>
                                    <?=$child['category']; ?>
                                <span class="pull-right">
                                    <a href="categories.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-danger">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                <?php endwhile; ?>
                </table>
            </div>

        </div>
    </div>
</body>
<?php include 'includes/footer.php'; ?>
<script src="js/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
</body>
</html>
