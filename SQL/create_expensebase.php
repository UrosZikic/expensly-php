<?php
require_once 'connect_database.php';
require __DIR__ . '/../environment/config/bootstrap.php';
class Create_Expensebase extends Connect_Database
{
  private $stmt;
  private $query;

  public function __construct()
  {
    // initiate $pdo
    parent::__construct();
    // create userbase table
    $this->query = "CREATE TABLE IF NOT EXISTS `expensebase`(  
  id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(50) NOT NULL,
  description VARCHAR(300) NULL,
  expense_items TEXT NOT NULL,
  expense_costs TEXT NOT NULL,
  expense int NOT NULL,
  user_id int UNSIGNED NOT NULL,
  soft_deleted TINYINT NULL DEFAULT 0,
  image_path VARCHAR(200) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `userbase`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB";

    $this->create_expensebase();

    // re-direct to home
    Header("Location: /");
  }


  private function create_expensebase()
  {
    $this->stmt = $this->get_pdo()->exec($this->query);

    if ($this->stmt === false) {
      $error = $this->get_pdo()->errorInfo();
      die("Table creation failed: " . $error[2]);
    }

    echo "Table created successfully!";
  }
}
$create_expensebase = new Create_Expensebase();
;