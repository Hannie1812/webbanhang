<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category";
    
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCategories()
    {
        $query = "SELECT id, name, description FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getCategoryById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    public function addCategory($name)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên danh mục không được để trống';
        }

        $query = "INSERT INTO " . $this->table_name . "(name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        
        $name = htmlspecialchars(strip_tags($name));
        
        $stmt->bindParam(':name', $name);
        
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    
    public function deleteCategory($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function searchCategories($keyword)
    {
        // Loại bỏ dấu tiếng Việt và chuyển về chữ thường để tìm kiếm
        $keyword = $this->vn_str_filter($keyword);
        $query = "SELECT id, name, description FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $filtered = [];
        foreach ($result as $cat) {
            $catNameFiltered = strtolower($this->vn_str_filter($cat->name));
            if (strpos($catNameFiltered, strtolower($keyword)) !== false) {
                $filtered[] = $cat;
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