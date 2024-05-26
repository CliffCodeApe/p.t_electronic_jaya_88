<?php
include("con.php");
include("config.php");

if(isset($_GET['product_id'])){
    $id = $_GET['product_id'];
    destroy($con, $id);
}