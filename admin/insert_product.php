<?php
include 'con.php';
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $_POST['description'];
    $imgFile = $_FILES['img'];

    insert($con, $name, $desc, $price, $stock, $imgFile);
}