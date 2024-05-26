<?php
include ("con.php");

function insert($con, $name, $desc, $price, $stock, $img){
    $dir = "img/";
    $imgFile = $dir . basename($_FILES["img"]["name"]);
    $uploading = 1;
    $imageFileType = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["img"]["tmp_name"]);
    if($check !== false) $uploading = 1;
    else $uploading = 0;

    if (file_exists($imgFile)) $uploading = 0;

    if ($_FILES["img"]["size"] > 500000)$uploading = 0;

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") $uploading = 0;

    if ($uploading == 0) echo "Sorry, your file was not uploaded.";
    else {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $imgFile)) {
            $img = $_FILES["img"]["name"];
            $q = "INSERT INTO products (name, description, price, stock, img) VALUES (?, ?, ?, ?, ?)";
            $state = mysqli_prepare($con, $q);
            mysqli_stmt_bind_param($state, "sssss", $name, $desc, $price, $stock, $img);
            mysqli_stmt_execute($state);
            header("Location: list_products.php");
            exit();
        } else echo "Sorry, there was an error uploading your file.";
    }
}

function update($con, $id, $name, $desc, $price, $stock, $img) {
    $dir = "img/";
    $imgFile = $dir . basename($_FILES["img"]["name"]);
    $uploading = 1;
    $imageFileType = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));

    if ($img["size"] > 0) {
        $check = getimagesize($img["tmp_name"]);
        if ($check !== false) $uploading = 1;
        else $uploading = 0;

        if (file_exists($imgFile)) $uploading = 0;

        if ($img["size"] > 500000) $uploading = 0;

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") $uploading = 0;

        if ($uploading == 0) echo "Sorry, your file was not uploaded.";
        else {
            if (move_uploaded_file($img["tmp_name"], $imgFile)) {
                $img = $img["name"];
                $q = "UPDATE products SET name = ?, description = ?, price = ? ,stock = ?, img = ? WHERE product_id = ?";
                $state = mysqli_prepare($con, $q);
                mysqli_stmt_bind_param($state, "sssssi", $name, $desc, $price, $stock, $img, $id);
                mysqli_stmt_execute($state);
                header("Location: list_products.php");
                exit();
            } else echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $q = "UPDATE products SET name = ?, description = ?, price = ? ,stock = ? WHERE product_id = ?";
        $state = mysqli_prepare($con, $q);
        mysqli_stmt_bind_param($state, "ssssi", $name, $desc, $price, $stock, $id);
        mysqli_stmt_execute($state);
        header("Location: list_products.php");
        exit();
    }
}

function destroy($con, $id) {
    $q = "SELECT img FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($con, $q);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $img);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $q = "DELETE FROM products WHERE product_id = ?";
    $state = mysqli_prepare($con, $q);
    mysqli_stmt_bind_param($state, "i", $id);
    mysqli_stmt_execute($state);
    if (mysqli_stmt_affected_rows($state) > 0)
    {
        $imgFile = "img/" . $img;
        if (file_exists($imgFile)) unlink($imgFile);
    }
    else echo "Product deleting error: " . mysqli_error($con);

    header("Location: list_products.php");
    exit();
}