<?php
// __DIR__ resolves pathing issue
require_once __DIR__ . '/../SQL/connect_database.php';
class Expensebase extends Connect_Database
{
  protected function expense_create($title, $description, $expense_items, $expense_costs, $expense, $user_id, $image_path)
  {
    $query = "INSERT INTO `expensebase` (title, description, expense_items, expense_costs, expense, user_id, image_path) VALUE (:title, :description, :expense_items, :expense_costs, :expense, :user_id, :image_path)";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":expense_items", $expense_items);
    $stmt->bindParam(":expense_costs", $expense_costs);
    $stmt->bindParam(":expense", $expense);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":image_path", $image_path);
    $stmt->execute();
  }

  protected function expense_view($user_id)
  {

    $query = "SELECT * FROM `expensebase` WHERE `user_id` = :user_id ORDER BY `updated_at` DESC";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
    $fetch = $stmt->fetchAll();
    return $fetch;
  }

  protected function expense_single_view($expense_id, $user_id)
  {
    $query = "SELECT * FROM `expensebase` WHERE `id` = :expense_id AND `user_id` = :user_id";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(":expense_id", $expense_id);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
    $fetch = $stmt->fetch();
    return $fetch;
  }

  protected function expense_single_edit($title, $description, $expense_items, $expense_costs, $expense, $user_id, $image_path, $expense_id)
  {
    $query = "UPDATE `expensebase` SET title = :title, description = :description, expense_items = :expense_items, expense_costs = :expense_costs, expense = :expense, image_path = :image_path WHERE user_id = :user_id AND id = :expense_id";

    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":expense_items", $expense_items);
    $stmt->bindParam(":expense_costs", $expense_costs);
    $stmt->bindParam(":expense", $expense);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":image_path", $image_path);
    $stmt->bindParam(":expense_id", $expense_id);
    $stmt->execute();
  }
}