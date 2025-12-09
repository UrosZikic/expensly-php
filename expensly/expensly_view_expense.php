<?php
$user = $_SESSION['user'];
if (!isset($_COOKIE['auth']))
  Header("Location: /sign-in");

// validate logged session and user session
if (!isset($_SESSION['logged']) || !isset($_SESSION['user']))
  Header("Location: /sign-in");
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
  <div>
    <?php
    $total_expense = 0;
    $pages_to_list = ceil((count($expenses)) / 5);

    $paginate = 1;
    if (isset($_GET["p"]))
      $paginate = $_GET["p"];
    ;
    // if the user tries to manipulate the query, this will prevent the attempt
    if ($paginate > $pages_to_list || $paginate <= 0) {
      $paginate = 1;
    }

    $max_post_to_list = 5 * $paginate;
    $min_post_to_list = $max_post_to_list - 4;
    foreach ($expenses as $key => $expense) {
      if ($key + 1 >= $min_post_to_list && $key + 1 <= $max_post_to_list) {
        ?>
        <div class="flex_default flex_justify_start" style="border: 0.5px solid black">
          <div class="profile_image">
            <img src="<?php echo $expense["image_path"] ?>" alt="<?php echo $expense["title"] ?>">
          </div>
          <div class="flex_default flex_column flex_align_center">
            <p><?php echo $expense["title"] ?></p>
            <p><?php echo substr($expense["description"], 0, 5) ?>...</p>
            <p><?php echo $expense["expense"] ?>Din</p>

          </div>
          <div>
            <p><?php echo $expense["updated_at"] ?></p>
            <a href="/edit-expense?id=<?php echo $expense['id'] ?>">Edit</a>
          </div>
        </div>

        <?php
        $total_expense += $expense["expense"];
      }
    }
    ?>
    <p>Total spending: <?php echo $total_expense; ?></p>

    <div class="paginate_container" style="margin: 50px 0 0 10px">
      <?php
      for ($i = 1; $i <= $pages_to_list; $i++) {
        ?>
        <a class="submit_color" href="/view-expense?p=<?php echo $i ?>"><?php echo $i ?></a>
      <?php }
      ; ?>
    </div>
  </div>
</main>