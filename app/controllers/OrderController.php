<?php
require_once('app/config/database.php');
class OrderController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function list()
    {
        $query = "SELECT orders.id, orders.created_at, orders.name, orders.phone, orders.address, orders.status,
                        users.username,
                        SUM(order_details.quantity * order_details.price) AS total
                FROM orders
                INNER JOIN order_details ON orders.id = order_details.order_id
                INNER JOIN users ON orders.user_id = users.id
                GROUP BY orders.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_OBJ);

        include 'app/views/admin/order/list.php';
    }
    public function updateOrderStatusAdmin($id, $status)
    {
        // Kiểm tra xem đơn hàng có tồn tại
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$order) {
            echo "Đơn hàng không tồn tại.";
            exit;
        }

        // Cập nhật trạng thái đơn hàng
        $query = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();

        header('Location: /webbanhang/Order/list');
        exit;
    }
}