// class="card-load"

const cardLoad = document.querySelector(".card-load");
const cardsContainer = document.querySelector(".cards-container");

function makeCard(num) {
  for (let i = 0; i < num; i++) {
    // const cardLoad = document.querySelector(".card-load");
    const div = document.createElement("div");
    div.classList.add("cardLoad");
    div.innerHTML = `<div class="col mt-4 mb-4">
                <div class="card h-100 border-0 shadow bg-white rounded">
                  <img
                    src="images/product_macbook.jpg"
                    class="card-img-top"
                    alt="..."
                  />
                  <div class="card-body">
                    <h5 class="card-title">Apple MacBook Pro 16吋</h5>
                    <span class="badge badge-primary">Primary</span>
                    <p class="card-text">
                      This is a longer card with supporting text below as a
                      natural longer.
                    </p>
                    <div class="card-cta d-flex">
                      <h4>$1,500</h4>
                      <div class="button-group">
                        <button
                          type="button"
                          class="btn btn-outline-success"
                          id="cta-add"
                        >
                          <i class="fas fa-cart-arrow-down fa-lg"></i>
                        </button>
                        <button
                          type="button"
                          class="btn btn-outline-success"
                          id="cta-buy"
                        >
                          購買
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
`;
    cardsContainer.appendChild(div);
  }
}
