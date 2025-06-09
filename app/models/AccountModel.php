<?php
class AccountModel
{
    private $conn;
    private $table_name = "users";
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getAllAccounts()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAccountById($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateAccount($id, $username, $fullname, $role)
    {
        $query = "UPDATE users SET username = :username, fullname = :fullname, role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    public function deleteAccount($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    public function updatePassword($username, $password) {
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':username', $username);
        
        return $stmt->execute();
    }
    
    function save($username, $fullname, $password, $role="user")
    {
        $query = "INSERT INTO " . $this->table_name . " (username, fullname, password, role) VALUES (:username, :fullname, :password, :role)";
        
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu
        $fullname = htmlspecialchars(strip_tags($fullname));
        $username = htmlspecialchars(strip_tags($username));
        
        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        
        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    public function updateAccountWithPassword($id, $username, $fullname, $role, $password = null)
    {
        if ($password) {
            $query = "UPDATE users SET username = :username, fullname = :fullname, role = :role, password = :password WHERE id = :id";
        } else {
            $query = "UPDATE users SET username = :username, fullname = :fullname, role = :role WHERE id = :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':role', $role);

        if ($password) {
            $stmt->bindParam(':password', $password);
        }

        return $stmt->execute();
    }
    public function searchAccountsByName($name)
    {
        $query = "SELECT * FROM users WHERE username LIKE :name";
        $stmt = $this->conn->prepare($query);
        $searchTerm = '%' . $name . '%';
        $stmt->bindParam(':name', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}