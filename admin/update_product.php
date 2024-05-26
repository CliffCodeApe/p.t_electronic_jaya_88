<?php
include 'con.php';
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $_POST['description'];
    $imgFile = $_FILES['img'];

    update($con, $id, $name, $desc, $price, $stock, $imgFile);
}

$id = $_GET['product_id'];
$q = "SELECT * FROM products WHERE product_id = ?";
$r = mysqli_prepare($con,$q);
$stmt = mysqli_prepare($con, $q);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
    <input type="text" name="name" placeholder="Product Name" value="<?php echo $product['name']; ?>">
    <input type="number" name="price" placeholder="Product Price" value="<?php echo $product['price']; ?>">
    <input type="number" name="stock" placeholder="Product Stock" value="<?php echo $product['stock']; ?>">
    <textarea name="description" id="" placeholder="Product Description"><?php echo $product['description']; ?></textarea>
    <img src="img/<?php echo $product['img']; ?>" alt="" width="200">
    <input type="file" name="img">
    <button type="submit">Submit</button>
</form> 