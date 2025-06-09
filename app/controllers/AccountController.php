<?php

require_once('app/config/database.php');
require_once('app/models/AccountModel.php');

class AccountController {
    private $accountModel;
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }
    public function list()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        if (!empty($search)) {
            $accounts = $this->accountModel->searchAccountsByName($search);
        } else {
            $accounts = $this->accountModel->getAllAccounts();
        }

        include 'app/views/admin/account/list.php';
    }

    public function edit($id)
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập trang này.";
            exit;
        }

        $account = $this->accountModel->getAccountById($id);
        if ($account) {
            include 'app/views/admin/account/edit.php';
        } else {
            echo "Không tìm thấy tài khoản.";
        }
    }
    public function update()
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập trang này.";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $role = $_POST['role'];
            $password = $_POST['password'] ?? null;

            if (!empty($password)) {
                // Mã hóa mật khẩu mới
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
            }

            $result = $this->accountModel->updateAccountWithPassword($id, $username, $fullname, $role, $password);

            if ($result) {
                header('Location: /webbanhang/Account/list');
            } else {
                echo "Đã xảy ra lỗi khi cập nhật tài khoản.";
            }
        }
    }
    public function delete($id)
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập trang này.";
            exit;
        }

        if ($this->accountModel->deleteAccount($id)) {
            header('Location: /webbanhang/Account/list');
        } else {
            echo "Đã xảy ra lỗi khi xóa tài khoản.";
        }
    }
    function register(){
        include_once 'app/views/account/register.php';
    }
    
    public function login() {
        include_once 'app/views/account/login.php';
    }
    
    function save(){
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            
            $errors =[];
            if(empty($username)){
                $errors['username'] = "Vui long nhap userName!";
            }
            if(empty($fullName)){
                $errors['fullname'] = "Vui long nhap fullName!";
            }
            if(empty($password)){
                $errors['password'] = "Vui long nhap password!";
            }
            if($password != $confirmPassword){
                $errors['confirmPass'] = "Mat khau va xac nhan chua dung";
            }
            //kiểm tra username đã được đăng ký chưa?
            $account = $this->accountModel->getAccountByUsername($username);
            
            if($account){
                $errors['account'] = "Tai khoan nay da co nguoi dang ky!";
            }
            
            if(count($errors) > 0){
                include_once 'app/views/account/register.php';
            }else{
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->save($username, $fullName, $password);
            
                if($result){
                    header('Location: /webbanhang/account/login');
                }
            }
        } 
    }
    
    function logout(){
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        
        header('Location: /webbanhang/Product');
    }
    
    public function checkLogin(){
        // Kiểm tra xem liệu form đã được submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $account = $this->accountModel->getAccountByUserName($username);
            if ($account) {
                $pwd_hashed = $account->password;
                //check mat khau
                if (password_verify($password, $pwd_hashed)) {
                    session_start();
                    
                    $_SESSION['user_id'] = $account->id;
                    $_SESSION['username'] = $account->username; 
                    $_SESSION['role'] = $account->role;

                    // Đồng bộ giỏ hàng từ session vào database
                    $this->syncCartFromSessionToDb($account->id);
                    
                    header('Location: /webbanhang/Product');
                    exit;
                }
                else {
                    echo "Password incorrect.";
                }
            } else {
                echo "Bao loi khong tim thay tai khoan";
            }
        }
    }
    private function syncCartFromSessionToDb($user_id)
    {
        // Nếu có giỏ hàng trong session, đồng bộ vào database
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart']))
        {
            require_once('app/models/CartModel.php');
            $cartModel = new CartModel((new Database())->getConnection());
            $cart_id = $cartModel->createCart($user_id);

            foreach ($_SESSION['cart'] as $product_id => $item)
            {
                $cartModel->addItem($cart_id, $product_id, $item['quantity']);
            }

            // Xóa giỏ hàng trong session sau khi đã đồng bộ
            unset($_SESSION['cart']);
        }
    }

    public function forgotPassword()
    {
        include_once 'app/views/account/forgot-password.php';
    }
    
    public function processForgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            
            // Kiểm tra xem username có tồn tại không
            $account = $this->accountModel->getAccountByUserName($username);
            
            if ($account) {
                // Username tồn tại, chuyển đến trang đặt lại mật khẩu
                include_once 'app/views/account/reset-password.php';
            } else {
                // Username không tồn tại, hiển thị thông báo lỗi
                $message = "Tên đăng nhập không tồn tại trong hệ thống.";
                $message_type = "danger";
                include_once 'app/views/account/forgot-password.php';
            }
        }
    }
    
    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';
            
            // Kiểm tra mật khẩu và xác nhận mật khẩu
            if ($password !== $confirmPassword) {
                $message = "Mật khẩu và xác nhận mật khẩu không khớp.";
                $message_type = "danger";
                include_once 'app/views/account/reset-password.php';
                return;
            }
            
            // Mã hóa mật khẩu
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            
            // Cập nhật mật khẩu
            $result = $this->accountModel->updatePassword($username, $hashedPassword);
            
            if ($result) {
                // Cập nhật thành công, chuyển đến trang đăng nhập
                $message = "Mật khẩu đã được cập nhật thành công. Vui lòng đăng nhập bằng mật khẩu mới.";
                $message_type = "success";
                include_once 'app/views/account/login.php';
            } else {
                // Cập nhật thất bại
                $message = "Có lỗi xảy ra khi cập nhật mật khẩu. Vui lòng thử lại.";
                $message_type = "danger";
                include_once 'app/views/account/reset-password.php';
            }
        }
    }
    public function editProfile()
    {
        if (!SessionHelper::isLoggedIn()) {
            echo "Bạn cần đăng nhập để chỉnh sửa thông tin tài khoản.";
            exit;
        }

        $username = $_SESSION['username'];
        $account = $this->accountModel->getAccountByUsername($username);

        if ($account) {
            include 'app/views/user/account/editProfile.php';
        } else {
            echo "Không tìm thấy tài khoản.";
        }
    }
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $password = $_POST['password'];

            // Kiểm tra xem tài khoản có tồn tại
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $account = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$account) {
                echo "Tài khoản không tồn tại.";
                exit;
            }

            // Cập nhật thông tin tài khoản
            $query = "UPDATE users SET fullname = :fullname" . (!empty($password) ? ", password = :password" : "") . " WHERE username = :username";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);

            if (!empty($password)) {
                // Mã hóa mật khẩu mới
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            }

            $stmt->execute();
// Thêm thông báo thành công
        $_SESSION['success_message'] = "Thông tin tài khoản đã được cập nhật thành công.";
            header('Location: /webbanhang/account/editProfile');
            exit;
        } else {
            echo "Phương thức không hợp lệ.";
            exit;
        }
    }
}