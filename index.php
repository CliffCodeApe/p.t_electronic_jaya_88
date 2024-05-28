<?php
    include ("admin/con.php");
    $q = "SELECT * FROM products";
    $r = mysqli_query($con, $q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    <h1>P.T ELECTRONIC MAKMUR 88</h1>

    <?php
    while ($row = mysqli_fetch_array($r)){
        $id = $row["product_id"];
        $name = $row["name"];
        $image = $row["img"];
        echo "
        <div class=\"card\">
            <a href=\"detail_product.php?product_id=$id\">
            <img src=\"admin/img/$image\" width='200'>
            <h1>$name</h1>
            </a>
        </div>
        ";
    }
    ?>

</body>
</html>