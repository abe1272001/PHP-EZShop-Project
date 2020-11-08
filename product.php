<?php

session_start();

require_once("createDb.php");
require_once("component.php");

$db = new CreateDb("ezshopdb", "products");

if (isset($_POST["add"])) {
  // print_r($_POST["product_id"]);
  if (isset($_SESSION["cart"])) {

    //使用array內的index，取出值
    // array_column(array,column_key,index_key);
    $item_array_id =  array_column($_SESSION['cart'], "product_id");

    //in_array ( 要比對的值 , 要比對的陣列 , $strict )
    //判斷cart是否已經有此項目
    if (in_array($_POST['product_id'], $item_array_id)) {
      echo "<script>alert('product is already in cart')</script>";
    } else {
      //若沒有此項目，使用count計算目前長度，來取得要新項目要加入的位置（最後）
      $count = count($_SESSION['cart']);
      // echo 'count = ' . $count . '<br>';
      $item_array = array("product_id" => $_POST["product_id"]);
      $_SESSION['cart'][$count] = $item_array;
      // print_r($_SESSION['cart']);
    };
  } else {
    $item_array = array("product_id" => $_POST["product_id"]);
    //創建新session變數，將item-array 加入 購物車
    $_SESSION['cart'][0] = $item_array;
    // print_r(($_SESSION['cart']));
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EZSHOP</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
    integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
    crossorigin="anonymous" />
  <!-- My CSS -->
  <link rel="stylesheet" href="CSS/index.css" />
  <link rel="stylesheet" href="CSS/cart.css" />
</head>

<!-- class="bg-light" -->

<body>
  <!-- header container-fluid -->
  <?php require_once('header.php') ?>

  <!-- Main -->
  <div class="container-fluid product-control">
    <?php
    $pid = $_GET['pid'];
    // echo $pid;
    // product($productName, $unitPrice, $productID, $productImg)
    $sql = "select * from products where ProductID = $pid";
    $result = mysqli_query($db->link, $sql);
    $row = mysqli_fetch_assoc($result);
    product($row["ProductName"], $row["UnitPrice"], $pid, $row["ProductImage"], $row["CatagoryID"], $row["CategoryName"]);
    ?>

  </div>



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
  </script>
  <script src="JS/main.js"></script>
</body>

</html>