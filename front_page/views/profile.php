<?php
// session_start();
$user = $_SESSION['user'];

if ($request === '/profile') {
  unset($_SESSION['error']);
  require_once "components/body_profile.php";
} else if ($request === '/profile-settings')
  require_once "components/profile_settings.php";
else if ($request === '/admin-manager')
  require_once "components/profile_settings.php";
else
  require_once "components/expense_settings.php";
