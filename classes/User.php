<?php 
declare(strict_types=1);
namespace App;

class User {
    private $pdo;
    
    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }
    
    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    public function validateName($name) {
        $name = trim($name);
        return !empty($name) && strlen($name) >= 2 && strlen($name) <= 100;
    }
    
    public function emailExists($email) {
        try {
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch() !== false;
        } catch (PDOException $e) {
            die("Error checking email: " . $e->getMessage());
        }
    }
    
    public function addUser($name, $email) {
        if (!$this->validateName($name)) {
            return ["success" => false, "message" => "Имя должно содержать от 2 до 100 символов"];
        }
        
        if (!$this->validateEmail($email)) {
            return ["success" => false, "message" => "Некорректный email адрес"];
        }
        
        if ($this->emailExists($email)) {
            return ["success" => false, "message" => "Email уже существует в базе данных"];
        }
        
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $stmt->execute([$name, $email]);
            
            return [
                "success" => true,
                "message" => "Пользователь успешно добавлен",
                "id" => $this->pdo->lastInsertId()
            ];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Ошибка при добавлении пользователя: " . $e->getMessage()];
        }
    }
    
    public function getAllUsers() {
        try {
            $stmt = $this->pdo->query("SELECT id, name, email FROM users ORDER BY id");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Error fetching users: " . $e->getMessage());
        }
    }
}

?>
