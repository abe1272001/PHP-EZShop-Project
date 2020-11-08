<?php
// echo "hello"
?>

<?php
session_start();

require_once("createDb.php");
require_once("component.php");

$db = new CreateDb("ezshopdb", "products");

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
  <link rel="stylesheet" href="CSS/member.css" />
  <title>EZ Shop</title>
</head>

<body>

  <!-- header container-fluid -->
  <?php require_once('header.php') ?>

  <!--------------------------------------- MAIN BODY --------------------------------------------->
  <div class="container mt-5">
    <h3>我的檔案</h3>
    <div class="row mt-3 mb-3">
      <div class="col-md-2">
        <div class="list-group sticky-top " id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home"
            role="tab" aria-controls="home">個人檔案</a>
          <a class="list-group-item list-group-item-action  active" id="list-profile-list" data-toggle="list"
            href="#list-profile" role="tab" aria-controls="profile">歷史訂單</a>
          <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
            href="#list-messages" role="tab" aria-controls="messages">通知總覽</a>
          <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
            href="#list-settings" role="tab" aria-controls="settings">設定</a>
        </div>
      </div>
      <div class="col-md-10">
        <div class="tab-content mt-2 " id="nav-tabContent">
          <div class="tab-pane fade show " id="list-home" role="tabpanel" aria-labelledby="list-home-list">
            <form class="card" method="post" action="">
              <div class="card-header">
                我的檔案
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-9 border-right">
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
                    <div class="form-group">
                      <label for="user-sex" class="mr-2">性別</label>
                      <input type="radio" class="" id="male" name="sex">
                      <label class="mr-2" for="male">男性</label>

                      <input type="radio" class="" id="female" name="sex">
                      <label class="mr-2 " for="female">女性</label>


                      <input type="radio" class="" id="homo" name="sex">
                      <label class="" for="homo">其他</label>

                    </div>
                    <div class="form-group">
                      <label for="user-birthday">生日</label>
                      <input type="date" class="form-control" id="user-birthday" name="user-birthday" value=""
                        min="1920-01-01" max="2020-10-08">
                    </div>

                    <hr>
                    <button class="btn btn-success" type="submit" name="btnOK">確認</button>
                  </div>
                  <div class="col-md-3">
                    <div class="avatar">
                      <img style="border-radius: 50%;" class="img-fluid" src="images/cat2.jpg" alt="">
                    </div>
                    <input class="mt-3" type="file" name="avatar" id="avatar">

                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- 訂單顯示 -->
          <div class="tab-pane active" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
            <!-- 從這裡剪掉 -->
            <?php
            // 取得order數量
            $sql = "SELECT COUNT(*) m FROM `orders` where CustomerID = {$_SESSION['userid']}";
            $result = mysqli_query($db->link, $sql);
            $row = mysqli_fetch_assoc($result);
            $order_count = (int)$row['m'];
            if ($order_count > 0) {
              //取得客戶的訂單數量記得改CustomerID
              $eleCombine = '';
              $sql = "SELECT * FROM `orders` where CustomerID = {$_SESSION['userid']}";
              $result = mysqli_query($db->link, $sql);
              $orderID_ary = array();
              //將訂單(str)取得推進ary
              //有幾筆就做幾次
              while ($row = mysqli_fetch_assoc($result)) {
                for ($i = 0; $i < $order_count; $i++) {
                  $orderID_ary[$i] = $row["OrderID"];
                };
                //-----------------------------------------------------生成上半部
                // echo $row["OrderID"] . "<br>";
                $element1 =
                  "
                <div class='accordion container mt-1' id='accordionExample'>
                            <div class='card'>
                              <div class='card-header' id='headingOne'>
                                <div class='mb-0'>
                                  <button class='btn btn-link btn-block text-center text-decoration-none' type='button'
                                    data-toggle='collapse' data-target='#order_{$row['OrderID']}' aria-expanded='true'
                                    aria-controls='collapseOne'>
                        
                                    <h5>訂單編號：#{$row['OrderID']}</h5>
                                    
                                  </button>
                                </div>
                              </div>
                              
                              <div id='order_{$row['OrderID']}' class='collapse' aria-labelledby='headingOne'
                                data-parent='#accordionExample'>
                                <!-- <div class='card-body'> -->
                                <table class='table'>
                                  <thead class='thead-light'>
                                    <tr>
                                      <th scope='col'>商品資料</th>
                                      <th scope='col'>單件價格</th>
                                      <th scope='col'>數量</th>
                                      <th scope='col'>小計</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  ";
                $eleCombine .= $element1;
                // echo $element1;
                //-------------------------------------生成下半部
                // echo "訂單" . $row['OrderID'] . "訂單<br>";
                $sql_2 = "SELECT o.OrderID, o.CustomerID,od.ProductID, pd.UnitPrice, od.Quantity, pd.ProductName, pd.ProductImage FROM orders o join orderdetails od on o.OrderID = od.OrderID 
                JOIN products pd ON pd.ProductID = od.ProductID
                WHERE o.OrderID = {$row['OrderID']}";
                $result_2 = mysqli_query($db->link, $sql_2);
                while ($row_2 = mysqli_fetch_assoc($result_2)) {
                  $element2 = "
                      <tr>
                        <form action='' method='post' class='order-items'>
                          <th scope='row'>
                            <img class='img-fluid' src='images/{$row_2['ProductImage']}.jpg' style='width: 5rem;' alt=''>
                            <h5 class='d-inline ml-3'>{$row_2['ProductName']}</h5>
                          </th>
                          <td>{$row_2['UnitPrice']}</td>
                          <td>
                            {$row_2['Quantity']}
                          </td>
                          <td>{$row_2['UnitPrice']}</td>
                        </form>
                      </tr>
                    ";
                  $eleCombine .= $element2;
                }
                //-------------------------生成關鍵下半部
                // echo $element1 .= $element2;
                $element3 = "
                                </tbody>
                              </table>
                            </div>
                          </div>
                      </div>
                  ";
                $eleCombine .= $element3;

                // echo $element1 . $element2 . $element3;



                //組合
              }
              echo $eleCombine;
              // var_dump($orderID_ary);
            } else {
              echo "<h3>尚無訂單</h3>";
            };

            ?>
            <!-- 到這裡 -->
          </div>
          <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
          <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">...</div>
        </div>
      </div>
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