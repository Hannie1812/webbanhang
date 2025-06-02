<?php 

class CartModel
{
    private $conn;
    private $carts_table = 'carts';
    private $cart_items_table = 'cart_items';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createCart($user_id)
    {
        $query = "SELECT id FROM " . $this->carts_table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id'];
        } else {
            $query = "INSERT INTO " . $this->carts_table . " (user_id) VALUES (:user_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            return $this->conn->lastInsertId();
        }
    }

    public function addItem($cart_id, $product_id, $quantity = 1)
    {
        $query = "SELECT quantity FROM " . $this->cart_items_table . " WHERE cart_id = :cart_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $quantity += $row['quantity'];
            $query = "UPDATE ". $this->cart_items_table. " SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            return $stmt->execute();
        }
        else
        {
            $query = "INSERT INTO ". $this->cart_items_table. " (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
    public function updateItemQuantity($cart_id, $product_id, $quantity)
    {
        if ($quantity <= 0)
        {
            return $this->removeItem($cart_id, $product_id);
        }

        $query = "UPDATE " . $this->cart_items_table . " SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function removeItem($cart_id, $product_id)
    {
        $query = "DELETE FROM " . $this->cart_items_table . " WHERE cart_id = :cart_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getCartItems($cart_id)
    {
        $query = "SELECT ci.*, p.name, p.price, p.image FROM " . $this->cart_items_table . " ci JOIN product p ON p.id = ci.product_id WHERE ci.cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->execute();

        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $items[$row['product_id']] = [
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'image' => $row['image']
            ];
        }
        return $items;
    }

    public function clearCart($cart_id)
    {
        $query = "DELETE FROM " . $this->cart_items_table . " WHERE cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function getTotalCartQuantity($cart_id)
    {
        $query = "SELECT SUM(quantity) as total FROM " . $this->cart_items_table . " WHERE cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ? (int)$row['total'] : 0;
    }
}

?>