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
        echo "<script>window.location = 'cart.php'</script>";
      }
    }
  }
}

$user = (isset($_SESSION['user'])) ? $_SESSION['user'] : '';
// echo $user;
$session_cart_ary_id = (isset($_SESSION['cart'])) ? array_column($_SESSION['cart'], "product_id") : '';

$session_cart_ary_price = (isset($_SESSION['cart'])) ? array_column($_SESSION['cart'], "product_price") : '';

// if (isset($_SESSION['cart'])) {
//   foreach ($session_cart_ary_price as $key => $value) {
//     echo $key . "::";
//     echo $value . "<br>";
//   };
// }


// echo $session_cart;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
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
        <div class="col-md-4 col-sm-12 py-2  text-center text-success step active border bg-light">
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

    <div class="row px-5">
      <div class="col-md-8">
        <div class="shopping-cart">
          <?php
          if (isset($_SESSION['cart'])) {
            $count = count($_SESSION['cart']);
            echo "<h5>購物車 ($count 件)</h5>";
          } else {
            echo "<h5>購物車</h5>";
          }
          ?>
          <!-- <h5>購物車</h5> -->
          <hr>
          <?php

          $total = 0;
          if (isset($_SESSION['cart'])) {
            $product_id = array_column($_SESSION['cart'], 'product_id');
            $result = $db->getProductData();
            while ($row = mysqli_fetch_assoc($result)) {
              foreach ($product_id as $id) {
                if ($row['ProductID'] == $id) {
                  cartElement($row['ProductImage'], $row["ProductName"], $row["UnitPrice"], $row["ProductID"]);
                  $total = $total + (int)$row["UnitPrice"];
                }
              }
            }
            // $_SESSION['total'] = $total;
          } else {
            echo "
            <div class='mt-4 d-flex flex-column align-items-center justify-content-center'>
            <h5>你的購物車是空的</h5>
            <small class='mb-2'>記得加入商品到你的購物車</small>
            <i class='fas fa-shopping-cart fa-4x my-3'></i>
            <a href='index.php' class='btn btn-success d-block w-25'>繼續購物</a>
            </div>
            ";
          }

          //保險
          if ((isset($_SESSION['cart']) && count($_SESSION['cart']) == 0)) {
            echo "
            <div class='mt-4 d-flex flex-column align-items-center justify-content-center'>
            <h5>你的購物車是空的</h5>
            <small class='mb-2'>記得加入商品到你的購物車</small>
            <i class='fas fa-shopping-cart fa-4x my-3'></i>
            <a href='index.php' class='btn btn-success d-block w-25'>繼續購物</a>
            </div>
            ";
          }


          ?>
        </div>
      </div>
      <div class="col-md-4 offset-md-0 border rounded mt-5 bg-white h-25 sticky-top cart-detail mb-4">
        <!-- POST到哪？ -->
        <form class="pt-4 pb-2" method="post" action="finishorder.php">
          <h6>訂單資訊</h6>
          <hr>
          <div class="row price-details">
            <div class="col-md-6">
              <h6>小計：</h6>
              <h6>運費：</h6>
              <!-- <hr> -->
              <!-- <h6>合計：</h6> -->
            </div>
            <div class="col-md-6">
              <h6><?php echo $total; ?></h6>
              <h6 class="text-success">Free</h6>
              <!-- <hr> -->
              <!-- <h6>$<?php echo $total; ?></h6> -->
            </div>
            <div class="col-md-12">
              <hr>
            </div>

            <div class="col-md-6">
              <?php
              if (isset($_SESSION['cart'])) {
                $count = count($_SESSION['cart']);
                echo "<h6>合計：($count 件)</h6>";
              } else {
                echo "<h6>合計：(0 件)</h6>";
              }
              ?>
              <!-- <h6>合計：</h6> -->
            </div>
            <div class="col-md-6">
              <h6>$<?php echo $total; ?></h6>
            </div>
          </div>
          <?php
          if ((!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0)) {
          } else {
            echo "<button type='submit' name='okBtn' class='btn btn-success w-100 my-2'>前往結帳</a>";
          }
          ?>

        </form>


      </div>
    </div>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
  </script>
  <script src="JS/main.js"></script>
  <!-- <script src="JS/cart.js"></script> -->
  <script type="text/javascript">
    const cartList = document.querySelector(".shopping-cart");
    // const input = document.querySelector(".item_count")
    cartList.addEventListener("click", amountControl);

    function amountControl(e) {
      // console.log(e.target);
      const item = e.target;
      // item.

      // parseInt(e.target.nextElementSibling.value) >= 0
      if (item.classList[0] === "minus-btn" && parseInt(e.target.nextElementSibling.value) > 0) {
        // console.log("-1");
        let input = e.target.nextElementSibling
        let inputValueToNum = parseInt(input.value)
        inputValueToNum -= 1
        input.value = inputValueToNum
      }

      //限制購買數量在十個單位以內
      if (item.classList[0] === "plus-btn" && parseInt(e.target.previousElementSibling.value) < 10) {
        // console.log("+1");
        let input = e.target.previousElementSibling;
        let inputValueToNum = parseInt(input.value)
        inputValueToNum += 1
        input.value = inputValueToNum
      }
    }


    let unitprice = '<?= $user; ?>';
    // console.log(x);
    const cart = [{
      "id": 1,
      "price": 720,
      "amount": 2
    }, {
      "id": 2,
      "price": 320,
      "amount": 4
    }]
    console.log(cart[0].price)
    <?php
    $session_cart_ary_id = (isset($_SESSION['cart'])) ? array_column($_SESSION['cart'], "product_id") : '';
    $session_cart_ary_price = (isset($_SESSION['cart'])) ? array_column($_SESSION['cart'], "product_price") : '';
    $session_cart_ary_price = (isset($_SESSION['cart'])) ? array_column($_SESSION['cart'], "product_count") : '';


    if (isset($_SESSION['cart'])) {
      foreach ($session_cart_ary_price as $key => $value) {
        echo $key . "::";
        echo $value . "<br>";
      };
    }

    ?>
  </script>
</body>

</html>