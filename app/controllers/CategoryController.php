<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/ProductModel.php');

class CategoryController
{
    private $categoryModel;
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
        $this->productModel = new ProductModel($this->db); // Khởi tạo ProductModel
    }

    public function index()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        if ($search) {
            $categories = $this->categoryModel->searchCategories($search);
        } else {
            $categories = $this->categoryModel->getCategories();
        }
        include 'app/views/admin/category/list.php';
    }
    public function list()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        if (!empty($search)) {
            $categories = $this->categoryModel->searchCategoriesByName($search);
        } else {
            $categories = $this->categoryModel->getAllCategories();
        }

        include 'app/views/admin/category/list.php';
    }
    public function show($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        
        if ($category) {
            include 'app/views/admin/category/show.php';
        } else {
            echo "Không thấy danh mục.";
        }
    }

    public function add()
    {
        include_once 'app/views/admin/category/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            
            $result = $this->categoryModel->addCategory($name);
            if (is_array($result)) {
                $errors = $result;
                include 'app/views/admin/category/add.php';
            } else {
                header('Location: /webbanhang/Category');
            }
        }
    }

    public function delete($id)
    {
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: /webbanhang/Category');
        } else {
            echo "Đã xảy ra lỗi khi xóa danh mục.";
        }
    }
    
    public function deleteMultiple()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids']) && is_array($_POST['ids']) && count($_POST['ids']) > 0) {
            $ids = $_POST['ids'];
            $errors = [];
            foreach ($ids as $id) {
                $id = intval($id); // Đảm bảo id là số nguyên
                if (!$this->categoryModel->deleteCategory($id)) {
                    $errors[] = $id;
                }
            }
            if (empty($errors)) {
                header('Location: /webbanhang/Category/');
                exit;
            } else {
                echo "Không thể xóa các danh mục có id: " . implode(', ', $errors) . ". Có thể do ràng buộc dữ liệu.";
            }
        } else {
            echo "Không có danh mục nào được chọn để xóa.";
        }
    }
    public function showProductsByCategory($category_id)
    {
        $category = $this->categoryModel->getCategoryById($category_id);
        if (!$category) {
            echo "Không tìm thấy danh mục.";
            exit;
        }

        $products = $this->productModel->getProductsByCategory($category_id);
        include 'app/views/categoryProducts.php';
    }
}
?>