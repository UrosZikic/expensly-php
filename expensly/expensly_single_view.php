<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php
$user = $_SESSION['user'];
if (!isset($_COOKIE['auth']))
  Header("Location: /sign-in");

// validate logged session and user session
if (!isset($_SESSION['logged']) || !isset($_SESSION['user']))
  Header("Location: /sign-in");

$expense_items = explode(",", $expense["expense_items"]);
$expense_costs = explode(",", $expense["expense_costs"]);

// get the clipped version of the month when the cost was created
$date = explode('-', substr($expense["created_at"], 0, 10));
$date_obj = DateTime::createFromFormat('!m', $date[1]);
$month_name = $date_obj->format('M');


?>
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
  <div class="expense_single flex_default flex_justify_center gap_xl">
    <div class="flex_default flex_column">
      <div>
        <a href="/edit-expense?id=<?php echo $_GET["id"] ?>">
          <ion-icon name="pencil-outline" style="font-size: 3.5rem"></ion-icon>
        </a>
        <a href="/delete-expense">
          <ion-icon name="trash-outline" style="font-size: 3.5rem"></ion-icon>
        </a>
      </div>
      <h1><?php echo $expense["title"]; ?></h1>
      <div class="flex_default flex_justify_start">
        <div class="date_styles flex_default flex_column flex_justify_center flex_align_center">
          <p><?php echo $month_name ?></p>
          <p><?php echo substr($date[2], 1, 1); ?></p>
        </div>
        <p><?php echo $expense["description"]; ?></p>
      </div>
      <img src="<?php echo $expense["image_path"]; ?>" alt="<?php echo $expense["title"]; ?>" width="50%">
    </div>
    <div>
      <table>
        <tr>
          <th>
            item
          </th>
          <th>cost</th>
        </tr>
        <?php foreach ($expense_items as $key => $item) { ?>
          <tr>
            <td><?php echo $item; ?></td>
            <td><?php echo $expense_costs[$key]; ?></td>
          </tr>
        <?php }
        ; ?>
      </table>
      <hr>
      <p>Total spendings: <?php echo array_sum($expense_costs) ?></p>
    </div>
  </div>
</main>