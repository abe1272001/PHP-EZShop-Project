<?php
if (isset($_SESSION["user"])) {
  $sUserName = $_SESSION["user"];
  // echo "session yes";
} else {
  $sUserName = "Guest";
  // echo "session no";
}

if (isset($_GET["logout"])) {
  unset($_SESSION['user']);
  unset($_SESSION['userid']);
  // header("Location: index.php");
  exit();
}


?>


<header id="header" class="header-control bg-light sticky-top">
  <nav class="navbar navbar-light  container">
    <a class="navbar-brand" href="index.php">
      <img src="images/cashier.svg" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy" />
      <h3 class="d-inline-block">EZ Shop</h3>
    </a>
    <div class="extra-header d-flex">
      <a href="cart.php" class="shoppingCart d-flex text-decoration-none ">
        <h5>
          <i class="fas fa-shopping-cart "></i> Cart
          <?php
          if (isset($_SESSION['cart'])) {
            if (count($_SESSION['cart']) == 0) {
              unset($_SESSION['cart']);
              exit();
            }
            $count = count($_SESSION['cart']);
            echo "<span id='cart_count' class='text-white bg-danger'>$count</span>";
            // echo "<span class='badge badge-primary badge-pill'>$count</span>";
          } else {
            // echo "<span id='cart_count' class='text-white bg-danger'>0</span>";
          }
          ?>
          <!-- <span id="cart_count" class="text-white bg-danger">0</span> -->
        </h5>
      </a>
      <!-- class="user-control" data-toggle="modal" data-target="#"  -->

      <div class="dropdown">
        <a class="dropdown-toggle text-decoration-none" type="button" data-toggle="dropdown"><i class="fa fa-user "></i>
        </a>
        <ul class="dropdown-menu">
          <?php if ($sUserName == "Guest") : ?>
          <li><a href="login.php">登入</a></li>
          <div class="dropdown-divider"></div>
          <li><a href="signup.php">註冊</a></li>
          <div class="dropdown-divider"></div>
          <?php elseif ($sUserName == "admin") : ?>
          <li><a href="backdoor.php">後台管理</a></li>
          <div class="dropdown-divider"></div>
          <li><a href="member.php">我的帳戶</a></li>
          <div class="dropdown-divider"></div>
          <li><a href="login.php?logout=1">登出</a></li>
          <div class="dropdown-divider"></div>
          <?php else : ?>
          <li><a href="member.php">我的帳戶</a></li>
          <div class="dropdown-divider"></div>
          <li><a href="login.php?logout=1">登出</a></li>
          <div class="dropdown-divider"></div>
          <?php endif; ?>
          <li><?php echo "Welcome! " . $sUserName ?></li>
        </ul>
      </div>
      <!-- <a href="login.php" class="text-decoration-none">
        <h5>
        <i class="fa fa-user "></i>
        </h5>
      </a> -->
    </div>
  </nav>
</header>