<?php

session_start();

require_once("createDb.php");
require_once("component.php");

$db = new CreateDb("ezshopdb", "products");

if (isset($_POST['remove'])) {
  if ($_GET['action'] == 'remove') {
    foreach ($_SESSION['cart'] as $key => $value) {
      if ($value['product_id'] == $_GET['id']) {
        unset($_SESSION['cart'][$key]);
        echo "<script>alert('Product has been Remove)</script>";
        echo "<script>window.location = 'finishorder.php'</script>";
      }
    }
  }
}

if (isset($_POST['OrderOkBtn'])) {
  $sql_order = <<<sqlcommand
    insert into orders 
    (CustomerID, ShipName, ShipAddress, ShipPhone, ShipPayment, TotalPrice) values
    ('{$_SESSION["userid"]}', '{$_POST["ship-name"]}', '{$_POST["ship-address"]}', '{$_POST["ship-phone"]}', '{$_POST["ship-payment"]}', '{$_POST["total_price"]}')
  sqlcommand;
  mysqli_query($db->link, $sql_order);
  //找到最大的orderID
  $sql_max_orderID = "SELECT MAX(OrderID) m FROM orders";
  $queryOrderID =  mysqli_query($db->link, $sql_max_orderID);
  $orderID = mysqli_fetch_assoc($queryOrderID);
  $product_id = array_column($_SESSION['cart'], 'product_id');
  $result = $db->getProductData();
  while ($row = mysqli_fetch_assoc($result)) {
    foreach ($product_id as $id) {
      if ($row['ProductID'] == $id) {
        $sql_order_details = "
        insert into orderdetails
        (OrderID, ProductID, UnitPrice, Quantity) values
        ({$orderID['m']},{$row['ProductID']},{$row['UnitPrice']},1)
      ";
        mysqli_query($db->link, $sql_order_details);
      }
    }
  };
  header("Location: orderdone.php");
  unset($_SESSION['cart']);
  exit();
}

$total = 0;
if (isset($_SESSION['cart'])) {
  $product_id = array_column($_SESSION['cart'], 'product_id');
  $result = $db->getProductData();
  while ($row = mysqli_fetch_assoc($result)) {
    foreach ($product_id as $id) {
      if ($row['ProductID'] == $id) {
        $total = $total + (int)$row["UnitPrice"];
      }
    }
  }
};

//取得使用者資訊填入欄位

$userName = null;
$userEmail = null;
$userPhone = null;
$userAddress = null;
// var_dump($_SESSION['userid']);
// var_dump($_SESSION['user']);

if (isset($_SESSION['userid'])) {
  $userid = $_SESSION['userid'];
  $sql = "SELECT UserName, UserEmail, UserPhone, UserAddress FROM users WHERE UserID = $userid";
  $result = mysqli_query($db->link, $sql);
  $row = mysqli_fetch_assoc($result);
  global $userName;
  global $userEmail;
  global $userPhone;
  global $userAddress;
  $userName = $row['UserName'];
  $userEmail = $row['UserEmail'];
  $userPhone = $row['UserPhone'];
  $userAddress = $row['UserAddress'];
} else {
  $userName = null;
  $userEmail = null;
  $userPhone = null;
  $userAddress = null;
}


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

        <div class="col-md-4 col-sm-12 py-2  text-center  text-success bg-light step border">
          <span class="badge ">
            <span class="text">2</span>
          </span>
          <span>填寫資料</span>
        </div>
        <div class="col-md-4 col-sm-12 py-2  text-center step border">
          <span class="badge ">
            <span class="text">3</span>
          </span>
          <span>訂單確認</span>
        </div>

      </div>
    </div>
    <?php
    if (!isset($_SESSION["user"])) {
      echo "
      <div class='row h-25 w-75 mt-4 mb-2 py-2 mx-auto border rounded bg-light'>
      <div class='row col-md-12 mx-2'>
        <p class=' mr-auto my-auto'>已經是會員？登入後可以更方便管理訂單！</p>
        <a href='login.php' class=' btn btn-light'>登入</a>
        <!-- data-toggle='modal' data-target='#login' -->
      </div>
    </div>
    ";
    };


    ?>

    <!-- 訂單明細 -->
    <div class="accordion container mt-4" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <div class="mb-0">
            <button class="btn btn-link btn-block text-center text-decoration-none" type="button" data-toggle="collapse"
              data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <?php
              if (isset($_SESSION['cart'])) {
                $count = count($_SESSION['cart']);
                echo "
                    <h4>合計：NT$$total</h4>
                    <p>購物車（$count 件)</p>
                    ";
              } else {
                header("Location: cart.php");
              }

              ?>
              <!-- <h4>合計：NT$699</h4>
              <p>購物車（?件)</p> -->

            </button>
          </div>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <!-- <div class="card-body"> -->
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">商品資料</th>
                <th scope="col">單件價格</th>
                <th scope="col">數量</th>
                <th scope="col">小計</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php

              if (isset($_SESSION['cart'])) {
                $product_id = array_column($_SESSION['cart'], 'product_id');
                $result = $db->getProductData();
                while ($row = mysqli_fetch_assoc($result)) {
                  foreach ($product_id as $id) {
                    if ($row['ProductID'] == $id) {
                      orderDetails($row['ProductID'], $row['ProductImage'], $row["ProductName"], $row["UnitPrice"]);
                    }
                  }
                }
              }

              // orderDetails('product_ipad.jpg', 'ipad', '699')
              ?>

              <!-- orderDetails($productimg, $productName, $unitPrice) -->
            </tbody>
          </table>
          <!-- </div> -->
        </div>
      </div>
    </div>
    <!-- Order -->
    <div class="container order-control">
      <form class="row" method="post" action="">
        <div class="col-12 col-md-6">
          <div class="user-info card mt-3">
            <h5 class="card-header">
              顧客資料
            </h5>
            <div class="card-body">
              <div class="form-group">
                <label for="user-name">顧客名稱</label>
                <input type="text" name="user-name" class="form-control" id="user-name"
                  value="<?= ($userName == null) ? '' : $userName ?>" placeholder="name" required>
              </div>
              <div class="form-group">
                <label for="user-email">電子信箱</label>
                <input type="email" name="user-email" class="form-control" id="user-email"
                  value="<?= ($userEmail == null) ? '' : $userEmail ?>" placeholder="email" required>
              </div>
              <div class="form-group">
                <label for="user-phone">電話</label>
                <input type="tel" name="user-phone" class="form-control" id="user-phone"
                  value="<?= ($userPhone == null) ? '' : $userPhone ?>" placeholder="phone" required>
              </div>
              <div class="form-group">
                <label for="user-address">住家地址</label>
                <input type="text" name="user-address" class="form-control" id="user-address"
                  value="<?= ($userAddress == null) ? '' : $userAddress ?>" placeholder="address" required>
              </div>

            </div>
          </div>
          <div class="card ps-info mt-3">
            <h5 class="card-header">
              訂單備註
            </h5>
            <div class="card-body">
              <textarea class="form-control" aria-label="With textarea"></textarea>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="ship-info card mt-3">
            <h5 class="card-header">
              送貨資料
            </h5>
            <div class="card-body">
              <div class="form-group">
                <label for="ship-name">收件人名稱</label>
                <input type="text" name="ship-name" class="form-control" id="ship-name" value="陳偉信" placeholder="name"
                  required>
              </div>
              <div class="form-group">
                <label for="ship-phone">電話</label>
                <input type="tel" name="ship-phone" class="form-control" id="phone" value="0973876543"
                  placeholder="phone" required>
              </div>

              <div class="form-group">
                <label for="ship-address">寄送地址</label>
                <input type="text" name="ship-address" class="form-control" id="ship-address" value="台中市南屯區公益路二段51號18樓"
                  placeholder="address" required>
              </div>

            </div>
          </div>
          <div class="card payment-info mt-3">
            <h5 class="card-header">
              付款方式
            </h5>
            <div class="card-body">
              <div class="form-group">
                <label for="ControlSelect">選擇付款方式</label>
                <select name="ship-payment" class="form-control" id="ControlSelect">
                  <option>信用卡</option>
                  <option>超商代碼付款</option>
                  <option>ATM轉帳</option>
                </select>
              </div>
            </div>
          </div>

          <div class="card order-yes mt-3 mb-3">
            <h5 class="card-header">
              確認付款
            </h5>
            <div class="card-body clearfix">
              <button class="btn btn-success ml-2" name="OrderOkBtn">提交訂單</button>
              <a href="cart.php" class="float-right">返回購物車</a>
            </div>
          </div>
        </div>
        <!-- !!!! -->
        <?php
        if (isset($_SESSION['cart'])) {
          $count = count($_SESSION['cart']);
          echo "
          <input type='hidden' name='total_price' value= $total>
          ";
          // var_dump($total);int
        } else {
          // header("Location: cart.php");
        }
        ?>
      </form>


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