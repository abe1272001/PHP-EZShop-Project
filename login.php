<?php
session_start();

require_once("createDb.php");
require_once("component.php");

$database = new CreateDb("ezshopdb", "products");


if (isset($_POST["btnOK"])) {
  //取得user name
  $result =  $database->getUserData();
  //判定帳號密碼
  $localEmail = $_POST["email"];
  $localPassword =  $_POST["password"];

  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['UserEmail'] == $localEmail && $row['UserPassword'] == $localPassword) {
      $_SESSION['user'] = $row['UserName'];
      $_SESSION['userid'] = $row['UserID'];
      $sUserName = $row['UserName'];
      if (isset($_SESSION['cart'])) {
        header("Location: cart.php");
      } else {
        // echo "<script>alert('登入成功，重新導向中')</script>";
        header("Location: index.php");
      }
    } else {
      echo "<script>alert('登入失敗')</script>";
      echo "<script>window.location = 'login.php'</script>";
    }
  }
};

// if (isset($_SESSION["user"])) {
//   // echo $_SESSION["user"];
//   $sUserName = $_SESSION["user"];
//   // echo "session yes" . $sUserName;
// } else {
//   $sUserName = "Guest";
//   // echo "session no";
// }

if (isset($_GET["logout"])) {
  header("Location: index.php");
  unset($_SESSION['user']);
  unset($_SESSION['userid']);
  exit();
}
//重新導向
// if (trim($sUserName) != "" && $sUserName != "Guest") {
//   // header(sprintf("Location: %s", "member.php"));
//   if (isset($_SESSION["lastPage"]))
//     header(sprintf("Location: %s", $_SESSION["lastPage"]));
//   else
//     header("Location: index.php");
//   exit();
// }



// $sUserName = $_POST["email"];
// if (trim($sUserName) != "") {
//   // $_SESSION['userName'] = $sUserName;
//   if (isset($_SESSION["lastPage"]))
//     header(sprintf("Location: %s", $_SESSION["lastPage"]));
//   else
//     header("Location: index.php");
//   exit();
// }


//member
// if (!isset($_SESSION["userName"])) {
//   $_SESSION['lastPage'] = "member.php";
//   header("Location: login.php");
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
  <!-- <link rel="stylesheet" href="CSS/sign-up.css" /> -->
  <link rel="stylesheet" href="CSS/login.css" />
  <title>EZ Shop</title>
</head>

<body>

  <!-- header container-fluid -->
  <?php require_once('header.php') ?>

  <!--------------------------------------- MAIN BODY --------------------------------------------->
  <div class="container mt-5">

    <div class="row">
      <div class="col-12 col-md-6">
        <h3>會員登入</h3>
        <form method="post" class="login-form" action="login.php">
          <div class="form-group">
            <label for="email">電郵</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value=""
              placeholder="email" required>
          </div>
          <div class="form-group">
            <label for="password">密碼</label>
            <input type="password" name="password" class="form-control" id="password" value="" placeholder="password"
              required>
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">記住我</label>
          </div>
          <button type="submit" class="btn btn-primary" name="btnOK">登入</button>
          <a href="signup.php" class="btn btn-success ml-2">註冊</a>
        </form>
      </div>
      <div class="col-12 col-md-6 mt-4">
        <div class="row social mt-5">
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
    </div>

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