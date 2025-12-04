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
  private int $expense;
  private int $user_id;

  private function validate_expense(int $value)
  {
    if (preg_match('/\d/', $value)) {
      $this->expense = $value;
    } else {
      Header('Location: /create-expense');
      exit();
    }
  }

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
    }

    return [$this->expense_items, $this->expense_costs];
  }


  public function validate_expense_create()
  {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION["user"])) {
      $this->validate_expense_list($_POST["items"], $_POST["costs"]);
      $this->validate_text($_POST["title"], 'title');
      $this->validate_text($_POST["description"], 'description');
      $this->validate_expense($_POST['expense']);
      $this->user_id = $_SESSION["user"]["id"];
    } else {
      Header("Location: /profile");
      exit();
    }
    // if (isset($_POST["title"])) {
    //   echo $_POST['title'];
    // }
    // if (isset($_POST["description"])) {
    //   echo $_POST['description'];
    // }
    // if (isset($_POST["expense"])) {
    //   echo $_POST['expense'];
    // }
    // echo "<br>";
    // echo date("Y-m-d");
    // echo "<br>";

    // echo date("H:i:s");


  }
}


$expensebase_controller = new Expensebase_controller();

switch ($request) {
  case '/register-expense':
    $expensebase_controller->validate_expense_create();
    break;
  default:
    require_once "../index.php";
}