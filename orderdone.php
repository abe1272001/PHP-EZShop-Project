<?php

session_start();

require_once("createDb.php");
require_once("component.php");

$db = new CreateDb("ezshopdb", "products");



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EZ Shop</title>
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
  <div class="container-fluid cart-control">
    <div class="row h-25 w-75 mx-auto mt-4 mb-2 check-nav">
      <div class="row col-md-12 mx-auto">
        <div class="col-md-4 col-sm-12 py-2  text-center  step active border ">
          <span class="badge ">
            <span class=" text">1</span>
          </span>
          <span>購物車
          </span>
        </div>

        <div class="col-md-4 col-sm-12 py-2  text-center step border">
          <span class="badge ">
            <span class="text">2</span>
          </span>
          <span>填寫資料</span>
        </div>
        <div class="col-md-4 col-sm-12 py-2  text-center text-success bg-light step border">
          <span class="badge ">
            <span class="text">3</span>
          </span>
          <span>訂單確認</span>
        </div>

      </div>
    </div>
    <h3 class="text-success mt-5 text-center">訂單完成！</h3>
    <table class="table container mt-5">
      <thead class="thead-light">
        <tr>
          <th scope="col">商品資料</th>
          <th scope="col">單件價格</th>
          <th scope="col">數量</th>
          <th scope="col">小計</th>
        </tr>
      </thead>
      <tbody>
        <!-- 從伺服器抓回 order details -->
        <?php
        $sql = "SELECT o.OrderID, o.CustomerID,od.ProductID, pd.UnitPrice, od.Quantity, pd.ProductName, pd.ProductImage FROM orders o join orderdetails od on o.OrderID = od.OrderID 
        JOIN products pd ON pd.ProductID = od.ProductID
        WHERE o.OrderID = (select MAX(OrderID) FROM orders )";
        $result = mysqli_query($db->link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          orderFromServer("{$row['ProductImage']}", "{$row['ProductName']}", "{$row['UnitPrice']}");
        };
        ?>
        <!-- total price -->
        <?php
        $sql = 'SELECT * FROM 	orders o WHERE o.OrderID = (SELECT MAX(OrderID) FROM orders)';
        $result = mysqli_query($db->link, $sql);
        $row = mysqli_fetch_assoc($result);
        $orderID = $row['OrderID'];
        $totalPrice = $row['TotalPrice'];
        ?>
        <tr>
          <th scope="row">(訂單編號： #<?= $orderID ?>)</th>
          <td></td>
          <td></td>
          <td>總計： $<?= $totalPrice ?></td>
        </tr>
      </tbody>
    </table>

    <div class="container my-5 text-center">
      <a href="index.php" class="btn btn-success mx-2">繼續購物</a>
      <?php
      if (isset($_SESSION['user'])) {
        echo "<a href='member.php' class='mx-2'>查看我的訂單</a>";
      }
      ?>

    </div>

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