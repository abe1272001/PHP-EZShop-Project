<?php

//start session
session_start();
// session_unset();
// require_once("dbConnect.php");
require_once("component.php");
require_once("createDb.php");

//立即生成db
$database = new CreateDb("ezshopdb", "products");


if (isset($_POST["add"])) {
  // print_r($_POST["product_id"]);
  if (isset($_SESSION["cart"])) {

    //使用array內的index，取出值
    // array_column(array,column_key,index_key);
    $item_array_id =  array_column($_SESSION['cart'], "product_id");
    // var_dump($item_array_id);
    //in_array ( 要比對的值 , 要比對的陣列 , $strict )
    //判斷cart是否已經有此項目
    if (in_array($_POST['product_id'], $item_array_id)) {
      echo "<script>alert('product is already in cart')</script>";
      echo "<script>window.location = 'index.php'</script>";
    } else {
      //若沒有此項目，使用count計算目前長度，來取得要新項目要加入的位置（最後）
      $count = count($_SESSION['cart']);
      // echo 'count = ' . $count . '<br>';
      $item_array = array("product_id" => $_POST["product_id"], "product_price" => $_POST["product_price"], "product_count" => 1);
      $_SESSION['cart'][$count] = $item_array;
      // print_r($_SESSION['cart']);
    };
    // var_dump($_SESSION['cart']);
  } else {
    $item_array = array("product_id" => $_POST["product_id"], "product_price" => $_POST["product_price"], "product_count" => 1);
    //創建新session變數，將item-array 加入 購物車
    $_SESSION['cart'][0] = $item_array;
    // print_r(($_SESSION['cart']));
    // var_dump($_SESSION['cart']);
  }
}

// if (isset($_SESSION["user"])) {
//   $sUserName = $_SESSION["user"];
//   // echo "session yes";
// } else {
//   $sUserName = "Guest";
//   // echo "session no";
// }

// if (isset($_GET["logout"])) {
//   header("Location: index.php");
//   unset($_SESSION['user']);
//   unset($_SESSION['userid']);
//   exit();
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
    integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
    crossorigin="anonymous" />
  <!-- My CSS -->
  <link rel="stylesheet" href="CSS/index.css" />
  <title>EZ Shop</title>
  <style>

  </style>
</head>

<body>
  <!-- header container-fluid -->
  <?php require_once('header.php') ?>

  <!--------------------------------------- MAIN BODY --------------------------------------------->
  <main>
    <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active" data-interval="2000">
          <img src="images/hero_3.png" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block">
            <h5 class="display-3">LAST SUPPER</h5>
            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
          </div>
        </div>
        <div class="carousel-item" data-interval="2000">
          <img src="images/hero_4.png" class="d-block w-100" alt="..." />
          <div class="carousel-caption d-none d-md-block">
            <h5 class="display-3">CRUSADES</h5>
            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <!-- Shop-container -->
    <div class="shop-container container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="list-group sticky-top mt-4" id="list-tab" role="tablist">
            <a href="#list-All" class="list-group-item list-group-item-action active" data-toggle="list"
              role="tab">All</a>
            <a href="#category-1" class="list-group-item list-group-item-action" data-toggle="list" role="tab">Shirt</a>
            <a href="#category-2" class="list-group-item list-group-item-action" data-toggle="list"
              role="tab">Jacket</a>
            <a href="#category-3" class="list-group-item list-group-item-action" data-toggle="list"
              role="tab">Sweater</a>
            <a href="#category-4" class="list-group-item list-group-item-action" data-toggle="list"
              role="tab">Accessory</a>
          </div>
        </div>
        <div class="col-md-9">
          <!-- row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4  -->
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mr-3" id="list-All" role="tabpanel" aria-labelledby="list-home-list">
              <!----- Card使用function傳入---->
              <div class='cards-container row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3'>
                <?php $result = $database->getProductData();
                while ($row = mysqli_fetch_assoc($result)) { ?>
                <?php
                  component($row["ProductName"], $row["UnitPrice"], $row["ProductID"], $row["ProductImage"], $row["CatagoryID"], $row["CategoryName"]);
                  ?>
                <?php } ?>
              </div>
            </div>

            <div class="tab-pane fade show mr-3" id="category-1" role="tabpanel" aria-labelledby="list-home-list">
              <!----- Card使用function傳入---->
              <div class='cards-container row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3'>
                <?php
                $sql = "select * from products where Category = 1";
                $result = mysqli_query($database->link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  component($row["ProductName"], $row["UnitPrice"], $row["ProductID"], $row["ProductImage"], $row["CatagoryID"], $row["CategoryName"]);
                } ?>
              </div>
            </div>

            <div class="tab-pane fade show mr-3" id="category-2" role="tabpanel" aria-labelledby="list-home-list">
              <!----- Card使用function傳入---->
              <div class='cards-container row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3'>
                <?php
                $sql = "select * from products where Category = 2";
                $result = mysqli_query($database->link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  component($row["ProductName"], $row["UnitPrice"], $row["ProductID"], $row["ProductImage"], $row["CatagoryID"], $row["CategoryName"]);
                } ?>
              </div>
            </div>

            <div class="tab-pane fade show mr-3" id="category-3" role="tabpanel" aria-labelledby="list-home-list">
              <!----- Card使用function傳入---->
              <div class='cards-container row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3'>
                <?php
                $sql = "select * from products where Category = 3";
                $result = mysqli_query($database->link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  component($row["ProductName"], $row["UnitPrice"], $row["ProductID"], $row["ProductImage"], $row["CatagoryID"], $row["CategoryName"]);
                } ?>
              </div>
            </div>

            <div class="tab-pane fade show mr-3" id="category-4" role="tabpanel" aria-labelledby="list-home-list">
              <!----- Card使用function傳入---->
              <div class='cards-container row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3'>
                <?php
                $sql = "select * from products where Category = 4";
                $result = mysqli_query($database->link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  component($row["ProductName"], $row["UnitPrice"], $row["ProductID"], $row["ProductImage"], $row["CatagoryID"], $row["CategoryName"]);
                } ?>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- footer -->

    <footer class="footer mt-2">
      <p>&copy;EZ Shop by Abe Chen</p>
    </footer>
  </main>


  <!-- Login Modal -->
  <div class="modal fade" id="login" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" method="post" action="index.php">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">會員登入</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" />
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" />
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
          <hr />

          <div class="row social d-flex">
            <a href="#" class="col-12 fb btn mb-2">
              <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
            </a>
            <a href="#" class="col-12 twitter btn mb-2">
              <i class="fab fa-twitter fa-fw"></i> Login with Twitter
            </a>
            <a href="#" class="col-12 google btn mb-2">
              <i class="fab fa-google fa-fw"></i> Login with Google+
            </a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" name="btnLogin" id="btnLogin">登入</button>
          <a class="btn btn-primary" href="signUp.php" role="button">註冊</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Already Login Model-->
  <div class="modal fade" id="loginAlready" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" method="post" action="index.php">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">會員登入</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h5>歡迎登入 UserName</h5>


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" name="btnLogin" id="btnLogin">登出
          </button>
          <a class="btn btn-primary" href="signUp.php" role="button">註冊</a>
        </div>
      </form>
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