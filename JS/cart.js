const cartList = document.querySelector(".shopping-cart");
// console.log(btnClick);
cartList.addEventListener("click", amountControl);

function amountControl(e) {
  console.log(e.currentTarget);
  const item = e.target;
  // item.
  if (item.classList[0] === "minus-btn") {
    console.log("-1");
  }

  if (item.classList[0] === "plus-btn") {
    console.log("+1");
  }
}
