<?php
include 'con.php';


$search = "";

if(isset($_POST["search"])){
  $search = $_POST['search'];
  $q = "SELECT * FROM products WHERE name LIKE ?";
  $stmt = mysqli_prepare($con, $q);
  $search_param = "%" . $search . "%";
  mysqli_stmt_bind_param($stmt, "s", $search_param);
  mysqli_stmt_execute($stmt);
  $r = mysqli_stmt_get_result($stmt);
}else{
  $q = "SELECT * FROM products";
  $r = mysqli_query($con, $q);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>List of Products</title>
    </head>
    <body>
        <a href="dashboard.php">Go Back</a>

        <form action="insert_product.php" method="post" enctype="multipart/form-data" id="insert">
          <input type="text" name="name" placeholder="Product Name">
          <input type="number" name="price" placeholder="Product Price">
          <input type="number" name="stock" placeholder="Product Stock">
          <textarea name="description" id="" placeholder="Product Description"></textarea>
          <input type="file" name="img">
          <button type="submit">Submit</button>
        </form>

        <h1>List of products</h1>
        <form action="" method="post">
          <input type="search" name="search" id="" value="<?php echo htmlspecialchars($search);?>">
          <button type="submit">Search</button>
        </form>
          <table border="1">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Image</th>
            <th>Description</th>
            <th>created_at</th>
            <th>Action</th>
          </tr>
          <?php
          while ($row = mysqli_fetch_array($r)) {
            $id = $row["product_id"];
            $name = $row["name"];
            $desc = $row["description"];
            $image = $row["img"];
            $stock = $row["stock"];
            $price = $row["price"];
            $created = $row['created_at'];

            echo"
            <tr>
              <td>$id</td>
              <td>$name</td>
              <td>$price</td>
              <td>$stock</td>
              <td><img src=\"img/$image\" alt=\"$image\" width='200'></td>
              <td>$desc</td>
              <td>$created</td>
              <td>
              <a href=\"update_product.php?product_id=$id\">Update</a>
              <form action=\"delete_product.php\" style=\"display: inline;\">
                <input type=\"hidden\" name=\"product_id\" value=\"$id\">
                <button type=\"submit\">Delete</button>
              </form>
              </td>
            </tr>
            ";
          }
          ?>
          
        </table>

          <script>

          </script>
    </body>
</html>