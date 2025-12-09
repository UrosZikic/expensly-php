<?php
$user = $_SESSION['user'];
if (!isset($_COOKIE['auth']))
  Header("Location: /sign-in");

// validate logged session and user session
if (!isset($_SESSION['logged']) || !isset($_SESSION['user']))
  Header("Location: /sign-in");

// validate form's action path
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$action = '/register-expense';
if ($request === "/edit-expense") {
  // validate expense staged for edit
  if (!$expense)
    Header("Location: /view-expense");
  $action = "/modify-expense?id=" . $expense['id'];

  $expense["expense_items"] = explode(',', $expense["expense_items"]);
  $expense["expense_costs"] = explode(',', $expense["expense_costs"]);
}



?>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<main class="flex_default flex_column">
  <div class="flex_default flex_justify_start flex_align_center">
    <h1 style="font-weight: 300; margin: 0 0 20px 10px">Dashboard:
      <?php echo $user['name'];
      ?>
    </h1>
    <div class="profile_image">
      <?php
      $path_tmp = $user['image_path'];
      $path;
      if ($path_tmp) {
        $path = $path_tmp;
      } else {
        $path = "../images/logo.png";
      }

      ?>
      <img src="<?php echo $path ?>" alt="<?php $user['name'] . "'s profile image" ?>">
    </div>
  </div>
  <!-- x -->
  <div class="flex_default flex_justify_start flex_align_center">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"
      class="form_layout flex_default flex_column expensly_form">
      <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?php echo ($expense["title"]) ?? "" ?>" required>
      </div>
      <div>
        <label for="description">Description</label>
        <input type="text" name="description" id="description" value="<?php echo ($expense["description"]) ?? "" ?>"
          required>
      </div>
      <div class=" items_stored form_layout flex_default flex_column">
        <button class="add_item submit_color">add item</button>
        <?php if (isset($expense)) {
          for ($i = 0; $i < count($expense["expense_items"]); $i++) { ?>
            <div class="item_stored form_layout flex_default flex_column expensly_layout">
              <div>
                <label for="items[]">Item</label>
                <input type="text" name="items[]" value="<?php echo $expense["expense_items"][$i]; ?>" required>
              </div>
              <div>
                <label for="expenses[]">Cost</label>
                <input type="number" name="costs[]" value="<?php echo $expense["expense_costs"][$i]; ?>" required>
              </div>
            </div>
          <?php }
        } else {
          ?>
          <div class="item_stored form_layout flex_default flex_column expensly_layout">
            <div>
              <label for="items[]">Item</label>
              <input type="text" name="items[]" required>
            </div>
            <div>
              <label for="expenses[]">Cost</label>
              <input type="number" name="costs[]" required>
            </div>
          </div>
          <?php
        }
        ; ?>
      </div>

      <!-- image -->
      <div class="upload_modal flex_default flex_align_center" id="upload_image_container">
        <input type="file" name="file" id="file" value="<?php echo $expense["image_path"] ?>" hidden <?php if (!$expense) { ?>required <?php }
           ; ?>>
        <label for="file" class="flex_default flex_justify_center flex_align_center"
          style="cursor: pointer; background-color: transparent">
          <ion-icon id="image_upload_icon" name="image-outline" style="font-size: 100px; cursor: pointer;"></ion-icon>
        </label>
        <img src="<?php echo $expense["image_path"]; ?>" alt="" style="object-fit: contain" width="100%"
          class="uploaded_image">

      </div>
      <div id="submit_container">
        <button type="submit" class="submit_color" id="submit_file" style="cursor: pointer;">upload</button>
      </div>
    </form>
  </div>
</main>
<?php if (!$expense) { ?>
  <script src="../javascript/expensly_create_expense.js"></script>
<?php } else {
  ; ?>
  <script>
    const upload_input = document.querySelector("#file");
    const upload_modal = document.querySelector(".upload_modal");
    const upload_image = document.querySelector(".uploaded_image");

    upload_input.addEventListener("change", () => {
      upload_image.style.display = "none";
      upload_modal.classList.add("success_trigger");
    })

  </script>
<?php }
; ?>