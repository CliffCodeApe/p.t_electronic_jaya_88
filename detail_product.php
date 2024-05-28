<?php
    include ("admin/con.php");
    $id = $_GET['product_id'];
    $q = "SELECT * FROM products WHERE product_id = ?";
    $r = mysqli_prepare($con,$q);
    $stmt = mysqli_prepare($con, $q);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detailed Product</title>
    </head>
    <body>
        <?php
            $name = $product["name"];
            $desc = $product["description"];
            $image = $product["img"];
            $stock = $product["stock"];
            $price = $product["price"];
            echo "
            <h1>$name</h1>
            <img src=\"admin/img/$image\">
            <p>Price: $price</p>
            <p>Stock: $stock</p>
            <p>Description:</p>
            <p>$desc</p>
            ";
        ?>

    </body>
</html>