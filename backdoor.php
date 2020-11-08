<?php
session_start();

require_once("createDb.php");
require_once("component.php");

$db = new CreateDb("ezshopdb", "products");


if (isset($_SESSION["user"])) {
  $sUserName = $_SESSION["user"];
  // echo "session yes";
} else {
  $sUserName = "Guest";
  // echo "session no";
}

if ($sUserName != 'admin') {
  header("Location: login.php");
  echo ('haha');
  exit();
}

//直接從資料庫刪除使用者
if (isset($_POST['delete'])) {
  if ($_GET['action'] == 'delete') {
    $id = $_GET['id'];
    echo $id;
    // echo "yo";
    $sql = "DELETE from users where UserID = $id";
    $db->link;
    mysqli_select_db($db->link, $db->dbname);
    $result =  mysqli_query($db->link, $sql);
    if (!$result) {
      die('Could not delete data: ' . mysqli_connect_error());
    }
    echo "<script>alert('User has been Remove)</script>";
    echo "<script>window.location = 'backdoor.php'</script>";
    mysqli_close($db->link);
  }
}

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

  <title>EZ Shop</title>
</head>

<body>

  <!-- header container-fluid -->
  <?php require_once('header.php') ?>

  <!--------------------------------------- MAIN BODY --------------------------------------------->
  <div class="container mt-5">
    <h3 class="">後台管理</h3>
    <div class="row mt-3">
      <div class="col-md-3">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list"
            href="#list-home" role="tab" aria-controls="home">User</a>
          <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
            href="#list-profile" role="tab" aria-controls="profile">Order</a>
          <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
            href="#list-messages" role="tab" aria-controls="messages">Messages</a>
          <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
            href="#list-settings" role="tab" aria-controls="settings">Settings</a>
        </div>
      </div>
      <div class="col-md-9 container">
        <div class="tab-content mt-2" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
            <table class="table ">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">姓名</th>
                  <th scope="col">Email</th>
                  <th scope="col">密碼</th>
                  <th scope="col">電話</th>
                  <th scope="col">地址</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $result = $db->getUserData();
                while ($row = mysqli_fetch_assoc($result)) {
                  userList($row['UserID'], $row['UserName'], $row['UserEmail'], $row['UserPassword'], $row['UserPhone'], $row['UserAddress']);
                }


                ?>

              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">First</th>
                  <th scope="col">Last</th>
                  <th scope="col">Handle</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">

          </div>
          <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">

          </div>
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