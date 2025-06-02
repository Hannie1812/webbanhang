<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                    FROM " . $this->table_name . " p
                    LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addProduct($name, $description, $price, $category_id, $image)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }
        
        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image) VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);
        
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateProduct($id, $name, $description, $price, $category_id, $image = null)
    {
        $query = "UPDATE " . $this->table_name . " SET name=:name, description=:description, price=:price, category_id=:category_id, image=:image WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function searchProducts($keyword)
    {
        $keyword = $this->vn_str_filter($keyword);
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                    FROM " . $this->table_name . " p
                    LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $filtered = [];
        foreach ($result as $product) {
            $nameFiltered = strtolower($this->vn_str_filter($product->name));
            if (strpos($nameFiltered, strtolower($keyword)) !== false) {
                $filtered[] = $product;
            }
        }
        return $filtered;
    }
    private function vn_str_filter($str) {
        $unicode = [
            'a'=>['á','à','ả','ã','ạ','ă','ắ','ằ','ẳ','ẵ','ặ','â','ấ','ầ','ẩ','ẫ','ậ'],
            'd'=>['đ'],
            'e'=>['é','è','ẻ','ẽ','ẹ','ê','ế','ề','ể','ễ','ệ'],
            'i'=>['í','ì','ỉ','ĩ','ị'],
            'o'=>['ó','ò','ỏ','õ','ọ','ô','ố','ồ','ổ','ỗ','ộ','ơ','ớ','ờ','ở','ỡ','ợ'],
            'u'=>['ú','ù','ủ','ũ','ụ','ư','ứ','ừ','ử','ữ','ự'],
            'y'=>['ý','ỳ','ỷ','ỹ','ỵ']
        ];
        foreach($unicode as $nonUnicode=>$uni){
            foreach($uni as $v){
                $str = str_replace($v,$nonUnicode,$str);
                $str = str_replace(mb_strtoupper($v, 'UTF-8'), mb_strtoupper($nonUnicode, 'UTF-8'), $str);
            }
        }
        return $str;
    }
}
?>