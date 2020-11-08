<?php
session_start();

require_once("createDb.php");
require_once("component.php");

$db = new CreateDb("ezshopdb", "products");

// require_once("component.php");
// $result = mysqli_query(
//   $link,
//   "select ProductID, ProductName, ProductDesc, UnitPrice, productImage FROM products"
// );

if (isset($_SESSION["user"])) {
  $sUserName = $_SESSION["user"];
  // echo "session yes";
} else {
  $sUserName = "Guest";
  // echo "session no";
}

if (isset($_POST['okBtn'])) {
  $sql = <<<sqlCommand
    insert into users
        (UserName, UserEmail, UserPassword, UserPhone, UserAddress) values
        ("{$_POST['user-name']}","{$_POST['email']}", "{$_POST['password']}", "{$_POST['phone']}", "{$_POST['address']}") 
  sqlCommand;
  if (!mysqli_query($db->link, $sql)) {
    echo "Error creating table:" . mysqli_error($db->link);
  }
  // mysqli_query($db->link, $sql);

  echo "<script>alert('帳號申請成功')</script>";
  echo "<script>window.location = 'login.php'</script>";
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
  <link rel="stylesheet" href="CSS/sign-up.css" />

  <title>EZ-Shop</title>
</head>

<body>

  <!-- header container-fluid -->
  <?php require_once('header.php') ?>

  <!--------------------------------------- MAIN BODY --------------------------------------------->
  <div class="container  my-5 w-25">
    <h3 class="text-center">會員註冊</h3>
    <form method="post" class="login-form" action="signup.php">
      <div class="form-group">
        <label for="user-name">用戶名</label>
        <input type="text" name="user-name" class="form-control" id="user-name" aria-describedby="emailHelp" value="陳偉信"
          placeholder="name" required>
      </div>
      <div class="form-group">
        <label for="email">電郵</label>
        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp"
          value="example@gmail.com" placeholder="email" required>
      </div>
      <div class="form-group">
        <label for="password">密碼</label>
        <input type="password" name="password" class="form-control" id="password" value="example" placeholder="password"
          required>
        <small>至少8個字元</small>
      </div>
      <div class="form-group">
        <label for="phone">電話</label>
        <input type="tel" name="phone" class="form-control" id="phone" aria-describedby="emailHelp" value="0987654567"
          placeholder="phone" required>
      </div>
      <div class="form-group">
        <label for="address">住址</label>
        <input type="text" name="address" class="form-control" id="address" value="台中市南屯區大墩路七段368號"
          placeholder="address" required>
      </div>

      <button class="btn btn-success ml-2" name="okBtn">註冊</button>
    </form>

  </div>






  <!-- Login Modal -->
  <div class="modal fade" id="login" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content">
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
          <button type="submit" class="btn btn-success">登入</button>
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