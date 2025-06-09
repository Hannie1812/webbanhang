<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/CartModel.php');

class ProductController
{
    private $productModel;
    private $cartModel;
    private $db;
    
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->cartModel = new CartModel($this->db);
    }

    private function isAdmin()
    {
        return SessionHelper::isAdmin();
    }

    private function isLoggedIn()
    {
        return SessionHelper::isLoggedIn();
    }

    public function index()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        if ($search) {
            $products = $this->productModel->searchProducts($search);
        } else {
            $products = $this->productModel->getProducts();
        }
        include 'app/views/user/product/home.php';
    }

    public function list()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        if ($search) {
            $products = $this->productModel->searchProducts($search);
        } else {
            $products = $this->productModel->getProducts();
        }

        if ($this->isAdmin()) {
            include 'app/views/admin/product/list.php';
        } else {
            include 'app/views/user/product/home.php';
        }
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        
        if ($product) {
            include 'app/views/Product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập trang này.";
            exit;
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/Product/add.php';
    }

    public function save()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập trang này.";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);
            
            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/Product/add.php';
            } else {
                header('Location: /webbanhang/Product');
            }
        }
    }

    public function edit($id)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập trang này.";
            exit;
        }
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/Product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }
    
    public function update()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập trang này.";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }
            
            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            
            if ($edit) {
                header('Location: /webbanhang/Product/list');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product/list');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }
    
    private function uploadImage($file)
    {
        $target_dir = "uploads/";
        
        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }

        // Chỉ cho phép một số định dạng hình ảnh nhất định
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        
        // Lưu file
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        
        return $target_file;
    }
        
    public function addToCart($id)
    {
        if (!$this->isLoggedIn())
        {
            echo "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.";
            exit;
        }
        else
        {
            // Nếu đã đăng nhập, lưu vào database
            $user_id = SessionHelper::getUserId();
            $cart_id = $this->cartModel->createCart($user_id);
            $this->cartModel->addItem($cart_id, $id);
        }
        // $product = $this->productModel->getProductById($id);
        // if (!$product) {
        //     echo "Không tìm thấy sản phẩm.";
        //     return;
        // }
        
        // if (!isset($_SESSION['cart'])) {
        //     $_SESSION['cart'] = [];
        // }
        
        // if (isset($_SESSION['cart'][$id])) {
        //     $_SESSION['cart'][$id]['quantity']++;
        // } else {
        //     $_SESSION['cart'][$id] = [
        //         'name' => $product->name,
        //         'price' => $product->price,
        //         'quantity' => 1,
        //         'image' => $product->image
        //     ];
        // }
        
        header('Location: /webbanhang/Product/cart');
    }

    public function removeFromCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            if ($this->isLoggedIn())
            {
                // Nếu đã đăng nhập, xóa từ database
                $user_id = SessionHelper::getUserId();
                $cart_id = $this->cartModel->createCart($user_id);
                $this->cartModel->removeItem($cart_id, $product_id);
            }
            else if ($product_id && isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
        header('Location: /webbanhang/Product/cart');
        exit;
    }

    public function cart()
    {
        if ($this->isLoggedIn())
        {
            // Nếu đã đăng nhập, lấy từ database
            $user_id = SessionHelper::getUserId();
            $cart_id = $this->cartModel->createCart($user_id);
            $cart = $this->cartModel->getCartItems($cart_id);
        }
        else
        {
            echo "Bạn cần đăng nhập để xem giỏ hàng.";
            exit;
        }
        include 'app/views/Product/cart.php';
    }
    
    public function checkout()
    {
        include 'app/views/Product/checkout.php';
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            // Kiểm tra giỏ hàng
            if ($this->isLoggedIn()) {
                $user_id = SessionHelper::getUserId();
                $cart_id = $this->cartModel->createCart($user_id);
                $cart = $this->cartModel->getCartItems($cart_id);
            } else {
                $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
            }

            if (empty($cart)) {
                echo "Giỏ hàng trống.";
                return;
            }

            // Bắt đầu giao dịch
            $this->db->beginTransaction();

            try {
                // Lưu thông tin đơn hàng vào bảng orders
                $query = "INSERT INTO orders (user_id, name, phone, address, status, created_at) VALUES (:user_id, :name, :phone, :address, 'pending', NOW())";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                // Lưu chi tiết đơn hàng vào bảng order_details
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                // Lấy thông tin đơn hàng và danh sách sản phẩm để hiển thị
                $query = "SELECT * FROM orders WHERE id = :order_id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':order_id', $order_id);
                $stmt->execute();
                $order = $stmt->fetch(PDO::FETCH_ASSOC);

                $query = "SELECT p.name, od.price, od.quantity 
                        FROM order_details od 
                        INNER JOIN product p ON od.product_id = p.id 
                        WHERE od.order_id = :order_id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':order_id', $order_id);
                $stmt->execute();
                $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Xóa giỏ hàng sau khi đặt hàng thành công
                if ($this->isLoggedIn()) {
                    $this->cartModel->clearCart($cart_id);
                } else {
                    unset($_SESSION['cart']);
                }

                // Commit giao dịch
                $this->db->commit();

                // Hiển thị trang xác nhận đơn hàng
                include 'app/views/Product/orderConfirmation.php';
                exit;
            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }
    public function confirmOrder($order_id)
    {
        if (!$this->isLoggedIn()) {
            echo "Bạn cần đăng nhập để xác nhận đơn hàng.";
            exit;
        }

        // Kiểm tra đơn hàng
        $query = "SELECT * FROM orders WHERE id = :order_id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':user_id', SessionHelper::getUserId());
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$order) {
            echo "Không tìm thấy đơn hàng.";
            exit;
        }

        // Cập nhật trạng thái đơn hàng
        $updateQuery = "UPDATE orders SET status = 'confirmed' WHERE id = :order_id";
        $updateStmt = $this->db->prepare($updateQuery);
        $updateStmt->bindParam(':order_id', $order_id);
        $updateStmt->execute();

        echo "Đơn hàng đã được xác nhận thành công.";
        header('Location: /webbanhang/Product/orderHistory');
        exit;
    }

    public function updateCartQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $action = $_POST['action'] ?? '';

            if ($this->isLoggedIn())
            {
                // Nếu đã đăng nhập, cập nhật trong database
                $user_id = SessionHelper::getUserId();
                $cart_id = $this->cartModel->createCart($user_id);

                $cart_items = $this->cartModel->getCartItems($cart_id);
                $current_quantity = isset($cart_items[$product_id]) ? $cart_items[$product_id]['quantity'] : 0;

                if ($action === 'increase')
                {
                    $this->cartModel->updateItemQuantity($cart_id, $product_id, $current_quantity + 1);
                }
                else if ($action === 'decrease')
                {
                    $this->cartModel->updateItemQuantity($cart_id, $product_id, $current_quantity - 1);
                }
            }
            else if ($product_id && isset($_SESSION['cart'][$product_id])) {
                if ($action === 'increase') {
                    $_SESSION['cart'][$product_id]['quantity']++;
                } elseif ($action === 'decrease') {
                    $_SESSION['cart'][$product_id]['quantity']--;
                    if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
                        unset($_SESSION['cart'][$product_id]);
                    }
                }
            }
        }
        header('Location: /webbanhang/Product/cart');
        exit;
    }
    
    public function deleteMultiple()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids']) && is_array($_POST['ids']) && count($_POST['ids']) > 0) {
            $ids = $_POST['ids'];

            foreach ($ids as $id) {
                $id = intval($id); // Đảm bảo id là số nguyên
                $this->productModel->deleteProduct($id);
            }

            header('Location: /webbanhang/Product/list');
            exit;
        } else {
            echo "Không có sản phẩm nào được chọn để xóa.";
        }
    }
    public function orderHistory()
    {
        if (!$this->isLoggedIn()) {
            echo "Bạn cần đăng nhập để xem lịch sử đơn hàng.";
            exit;
        }

        $user_id = SessionHelper::getUserId();
        $query = "SELECT orders.id, orders.created_at, orders.name, orders.phone, orders.address, 
                        SUM(order_details.quantity * order_details.price) AS total
                FROM orders
                INNER JOIN order_details ON orders.id = order_details.order_id
                WHERE orders.user_id = :user_id
                GROUP BY orders.id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_OBJ);

        include 'app/views/Product/orderHistory.php';
    }
}
?>