<?php
if (!isset($_COOKIE['auth']))
  Header("Location: /sign-in");

// validate logged session and user session
if (!isset($_SESSION['logged']) || !isset($_SESSION['user']))
  Header("Location: /sign-in");
?>
<main>
  <!-- error bubble -->
  <?php if (isset($_SESSION['error']) && $_SESSION['error'] !== "") { ?>
    <div class="error_bubble">
      <p>Error occured...</p>
      <p><?php echo $_SESSION['error'];
      unset($_SESSION['error']);
      ?></p>
    </div>
  <?php }
  ; ?>
  <!-- success bubble -->
  <?php if (isset($_SESSION['success'])) { ?>
    <div class="error_bubble success_bubble">
      <p>Success</p>
    </div>
  <?php }
  ;
  unset($_SESSION['success'])
    ?>

  <?php if (!auth() || $request === '/expense-settings') { ?>
    <h1 style="font-weight: 300; margin: 0 0 20px 10px">Manage your profile: <?php echo $user['name'];
    ?></h1>
    <div class="flex_default flex_column border_bubble success_bubble load_bubble">
      <p style="margin: 0 0 0 10px">Create a new expense</p>
      <a href="/create-expense" class="submit_color success_color" style="margin: 0 0 0 10px">Proceed</a>
    </div>
    <div class="flex_default flex_column border_bubble success_bubble load_bubble"
      style="background-color: var(--view-bubble-color)">
      <p style="margin: 0 0 0 10px">View your expense history</p>
      <a href="/view-expense" class="submit_color"
        style="margin: 0 0 0 10px; background-color: var(--view-color);">Proceed</a>
    </div>
  <?php }
  ; ?>
</main>
<script src="../javascript/DOM.js"></script>