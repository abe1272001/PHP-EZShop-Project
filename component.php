<?php
function component($productName, $unitPrice, $productID, $productimg, $catagory, $categoryName)
{
  $element = "
  <div class='col mt-4 mb-4'>
    <form action='index.php' method='post'>
      <div class='card text-center h-100 border-0 shadow bg-white rounded'>
        <a href='product.php?pid=$productID'>
        <img src='images/$productimg.jpg' class='img-fluid card-img-top' alt='...' /> </a>
        <div class='card-body'>
          <h5 class='card-title'>$productName</h5>
          <span class='badge badge-$catagory badge-pill'>$categoryName</span>
          <div class='card-cta d-flex'>
            <div class='price-control d-flex justify-content-center align-items-center flex-grow-1'>
              <h4 class='card-title'>
              $$unitPrice
              </h4>
            </div>
            <div class='button-group mt-2'>
              <button type='submit' name='add' class='btn btn-outline-success' id='cta-add'>
              <i class='fas fa-cart-arrow-down fa-lg'></i>
              </button>
              <input type='hidden' name='product_id' value='$productID'>
              <input type='hidden' name='product_price' value=$unitPrice>
              <a href='product.php?pid=$productID' type='button' class='btn btn-outline-success' id='cta-buy'>
              購買
              </a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  ";
  echo $element;
}

function product($productName, $unitPrice, $productID, $productImg, $catagory, $categoryName)
{
  $element = "
  <form action='' method='post'>
      <div class='row'>
        <div class='col-md-6'>
          <div class='w-100'>
            <img src='images/$productImg.jpg' alt='' class='img-fluid p-5'>
          </div>
        </div>
        <div class='col-md-6'>
          <div class='product-desc mt-5'>
            <h3>$productName</h3>
            <span class='badge badge-$catagory badge-pill'>$categoryName</span>
            <h5 class='mt-3'>$$unitPrice</h5>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vero animi unde sequi itaque voluptatum
              voluptatibus facere ex fugit, exercitationem maxime, aspernatur alias delectus voluptas repellat enim
              perspiciatis eveniet harum officiis.</p>
            <div class='product-btn-group'>
              <button type='submit' name='add' class='btn btn-outline-success' id='cta-add'>
                <i class='fas fa-cart-arrow-down fa-lg'></i>
              </button>
              <input type='hidden' name='product_id' value='$productID'>
            </div>
          </div>
        </div>
      </div>
    </form>
  ";
  echo $element;
}

function cartElement($productimg, $prodoctname, $productprice, $productID)
{
  $element = "
  <form action='cart.php?action=remove&id=$productID' method='post' class='cart-items'>
            
              <div class='row bg-white border rounded'>
                <div class='col-md-3 col-sm-12 p-0 image-control border-right'>
                  <img src='images/$productimg.jpg' alt='image1' class='img-fluid rounded'>
                </div>
                <div class='col-6 col-md-4 col-sm-6 align-self-center'>
                  <h5 class='pt-2'>$prodoctname</h5>
                  
                  <h5 class='pt-2'>$$productprice</h5>
                  
                  <button type='submit' class='btn btn-danger mb-3' name='remove'><i class='fas fa-trash-alt'></i></button>
                </div>
                <div class='col-6 col-md-5 col-sm-6 py-5 align-self-center text-center'>
                  <button type='button' class='minus-btn btn bg-light border rounded-circle'> <i class='fas fa-minus'></i>
                  </button>
                  <input type='number' value='1' class='item_count form-control w-25  d-inline' min='1' max='20'>
                  <button type='button' class='plus-btn btn bg-light border rounded-circle'> <i class='fas fa-plus'></i>
                  </button>
                  <div id = item-price>小計：</div>
                </div>
              </div>
            
          </form>
  
  
  ";
  echo $element;
}

// <button type='submit' class='btn btn-warning mb-3 mr-2'>Save for later</button>

function userList($userid, $username, $useremail, $userpassword, $userphone, $useraddress)
{
  $element = "
  <form action='backdoor.php?action=delete&id=$userid' method='post'>
    <tr>
      <th scope='row'>$userid</th>
      <td>$username</td>
      <td>$useremail</td>
      <td> $userpassword</td>
      <td> $userphone</td>
      <td> $useraddress</td>
      <td> <button type='submit' class='btn btn-danger mb-3' name='delete'><i class='fas fa-trash-alt'></i></button></td>
    </tr>
  </form>
  ";

  echo $element;
}

function orderDetails($productID, $productimg, $productName, $unitPrice)
{
  $element = "
  <tr>
    <form action='finishorder.php?action=remove&id=$productID' method='post' class='cart-items'>
      <th scope='row'>
        <img class='img-fluid' src='images/$productimg.jpg' style='width: 6rem;' alt=''>
        <h5 class='d-inline ml-3'>$productName</h5>
      </th>
      <td>$unitPrice</td>
      <td>
        1
      </td>
      <td>$unitPrice</td>
      <td><button type='submit' class='btn btn-danger mb-3' name='remove'><i
      class='fas fa-trash-alt'></i></button></td>
    </form>
  </tr>
  ";
  echo $element;
}

function orderFromServer($productimg, $productName, $unitPrice)
{
  $element = "
  <tr>
    <form action='' method='post' class='order-items'>
      <th scope='row'>
        <img class='img-fluid' src='images/$productimg.jpg' style='width: 6rem;' alt=''>
        <h5 class='d-inline ml-3'>$productName</h5>
      </th>
      <td>$unitPrice</td>
      <td>
        1
      </td>
      <td>$unitPrice</td>
    </form>
  </tr>
  ";
  echo $element;
}


// 關鍵function
function membersOrder($OrderID, $ProductName, $UnitPrice, $ProductImage, $Quantity)
{

  $element1 =
    "
  <div class='accordion container mt-1' id='accordionExample'>
              <div class='card'>
                <div class='card-header' id='headingOne'>
                  <div class='mb-0'>
                    <button class='btn btn-link btn-block text-center text-decoration-none' type='button'
                      data-toggle='collapse' data-target='#collapseOne' aria-expanded='true'
                      aria-controls='collapseOne'>
          
                      <h4>訂單編號：#OrderID</h4>
                      
                    </button>
                  </div>
                </div>
                <!--  -->
                <div id='collapseOne' class='collapse show' aria-labelledby='headingOne'
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

  $element2 = "
                      <tr>
                        <form action='' method='post' class='order-items'>
                          <th scope='row'>
                            <img class='img-fluid' src='images/ProductImage.jpg' style='width: 5rem;' alt=''>
                            <h5 class='d-inline ml-3'>'ProductName'</h5>
                          </th>
                          <td>'UnitPrice'</td>
                          <td>
                            'Quantity'
                          </td>
                          <td>'UnitPrice'</td>
                        </form>
                      </tr>
                    ";

  //element3
  $element3 = "
              </tbody>
            </table>
          </div>
        </div>
    </div>
          ";


  echo $element1 . $element2 . $element3;
}