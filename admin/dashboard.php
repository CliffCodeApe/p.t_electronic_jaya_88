<?php
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
    </head>
    <body>
        <h1>Dashboard</h1>
        <h2>
            <a href="list_products.php">List of Products</a>
        </h2>
        <a href="../auth/logout.php">Logout</a>
    </body>
</html>