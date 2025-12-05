const add_item_btn = document.querySelector(".add_item");
const items_stored = document.querySelector(".items_stored");

add_item_btn.addEventListener("click", (e) => {
  e.preventDefault();
  add_new_item();
});

function add_new_item() {
  // core part: container
  const new_item_container = document.createElement("div");
  // core part: container styles
  new_item_container.classList.add("item_stored");
  new_item_container.classList.add("form_layout");
  new_item_container.classList.add("flex_default");
  new_item_container.classList.add("flex_column");
  new_item_container.classList.add("expensly_layout");
  //  core part: item input
  const new_item = document.createElement("input");
  new_item.name = "items[]";
  new_item.type = "text";
  //  core part: item label
  const new_item_label = document.createElement("label");
  new_item_label.htmlFor = "items[]";
  new_item_label.textContent = "Item";
  // core part: cost input
  const new_cost = document.createElement("input");
  new_cost.name = "costs[]";
  new_cost.type = "number";
  // core part: cost label
  const new_cost_label = document.createElement("label");
  new_cost_label.htmlFor = "costs[]";
  new_cost_label.textContent = "Cost";
  //  sub-support container
  const item_container = document.createElement("div");
  const cost_container = document.createElement("div");
  // item part of sub-support
  item_container.appendChild(new_item_label);
  item_container.appendChild(new_item);
  // cost part of sub-support
  cost_container.appendChild(new_cost_label);
  cost_container.appendChild(new_cost);

  // sub-main container
  new_item_container.appendChild(item_container);
  new_item_container.appendChild(cost_container);
  // main container
  items_stored.appendChild(new_item_container);
  return true;
}

let uploaded = false;
const upload_input = document.querySelector("#file");
const upload_modal = document.querySelector(".upload_modal");
upload_input.addEventListener("change", () => {
  uploaded = true;
  upload_modal.classList.add("success_trigger");
  upload_modal.classList.remove("failure_trigger");
});

const submit_file = document.querySelector("#submit_file");
submit_file.addEventListener("click", (e) => {
  if (!uploaded) {
    upload_modal.classList.add("failure_trigger");
    e.preventDefault();
  }
});
