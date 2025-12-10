<?php
// __DIR__ resolves pathing issue
require_once __DIR__ . '/../models/Expensebase.php';
// session_start();
// reset on visit
$_SESSION['error'] = "";
// necessary in order to call the right function
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// needed for profile.php to import a proper component
$_SESSION['request'] = $request;



class Expensebase_controller extends Expensebase
{
  private string $title;
  private string $description;
  private string $expense_items;
  private string $expense_costs;
  private int $expense_total = 0;
  private int $user_id;
  private string $image_path;

  private function validate_text(string $value, $key)
  {
    if (gettype($value) === "string") {
      if (!empty($value)) {
        if ($key === "title")
          return $this->title = $value;
        else
          return $this->description = $value;
      } else {
        Header('Location: /create-expense');
        exit();
      }
    } else {
      Header('Location: /create-expense');
      exit();
    }
  }

  private function validate_expense_list(array $expense_items, array $expense_costs)
  {

    if (!empty($expense_items) && !empty($expense_costs)) {
      $this->expense_items = implode(',', $expense_items);
      $this->expense_costs = implode(',', $expense_costs);
    } else {
      Header('Location: /create-expense');
      exit();
    }

    return [$this->expense_items, $this->expense_costs];
  }

  private function upload_expense_image(int $id)
  {

    if (isset($_FILES['file']['name'])) {
      $year = date("Y");
      $month = date("m");
      $date = date("d");
      $upload_dir = "images/users/$id/expenses/$year/$month/$date/";

      if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }

      $this->image_path = $target_file = $upload_dir . $_FILES['file']['name'];

      move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
    } else {
      Header('Location: /create-expense');
      exit();
    }
  }

  private function update_expense_image(int $id, string $path, array $state)
  {
    if (!$path) {
      return $this->image_path = $state['image_path'];
    }
    // otherwise
    unlink($state['image_path']);
    if (isset($_FILES['file']['name'])) {
      $year = date("Y");
      $month = date("m");
      $date = date("d");
      $upload_dir = "images/users/$id/expenses/$year/$month/$date/";

      if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }

      $this->image_path = $target_file = $upload_dir . $_FILES['file']['name'];

      move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
    }
  }

  private function validate_expense_total()
  {
    $expense_total = explode(",", $this->expense_costs);
    foreach ($expense_total as $expense) {
      $this->expense_total += $expense;
    }

    return $this->expense_total;
  }

  public function validate_expense_create()
  {
    // id, title, description, expense_items, expense_costs, expense(expense_total), user_id, image_path
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION["user"])) {
      $this->validate_expense_list($_POST["items"], $_POST["costs"]);
      $this->validate_text($_POST["title"], 'title');
      $this->validate_text($_POST["description"], 'description');
      $this->upload_expense_image($_SESSION["user"]["id"]);
      $this->validate_expense_total();
      $this->user_id = $_SESSION["user"]["id"];
      $this->expense_create($this->title, $this->description, $this->expense_items, $this->expense_costs, $this->expense_total, $this->user_id, $this->image_path);

      Header("Location: /profile");
      exit();
    } else {
      Header("Location: /profile");
      exit();
    }
  }

  public function validate_expense_view()
  {
    $expenses = $this->expense_view($_SESSION["user"]["id"]);
    return require_once "expensly/expensly_view_expense.php";
  }

  public function validate_single_view()
  {
    $expense = $this->expense_single_view($_GET["id"], $_SESSION["user"]["id"]);
    if (!$expense) {
      Header("Location: /view-expense");
      exit();
    }

    return require_once "expensly/expensly_single_view.php";
  }

  public function validate_expense_edit()
  {
    $expense = $this->expense_single_view($_GET["id"], $_SESSION["user"]["id"]);
    return require_once "expensly/expensly_create_expense.php";
  }

  public function validate_expense_modify()
  {
    $expense_id = $_GET["id"];
    $this->validate_expense_list($_POST["items"], $_POST["costs"]);
    $this->validate_text($_POST["title"], 'title');
    $this->validate_text($_POST["description"], 'description');

    $current_expense_state = $this->expense_single_view($expense_id, $_SESSION["user"]["id"]);
    $this->update_expense_image($_SESSION["user"]["id"], $_FILES['file']['name'], $current_expense_state);

    $this->validate_expense_total();
    $this->user_id = $_SESSION["user"]["id"];
    $this->expense_single_edit($this->title, $this->description, $this->expense_items, $this->expense_costs, $this->expense_total, $this->user_id, $this->image_path, $expense_id);

    Header("Location: /view-expense");
  }
}


$expensebase_controller = new Expensebase_controller();

switch ($request) {
  case '/register-expense':
    $expensebase_controller->validate_expense_create();
    break;
  case '/view-expense':
    $expensebase_controller->validate_expense_view();
    break;
  case '/edit-expense':
    $expensebase_controller->validate_expense_edit();
    break;
  case '/modify-expense':
    $expensebase_controller->validate_expense_modify();
    break;
  case '/single-expense':
    $expensebase_controller->validate_single_view();
    break;
  default:
    require_once "../index.php";
}