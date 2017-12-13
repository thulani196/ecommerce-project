<?php
    require_once '../config/init.config.php';
    $parentID = (int) $_POST['parentID'];
    $childQuery =  $db->query("SELECT * FROM categories WHERE parent_category = '$parentID' ORDER BY category");
ob_start();

?>
<?php while($child = mysqli_fetch_assoc($childQuery)): ?>
    <option value="<?php echo $child['id']; ?>"><?=$child['category']; ?></option>
<?php endwhile; ?>

<?php
    echo ob_get_clean();
?>
