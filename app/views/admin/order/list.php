<?php include_once __DIR__ . '/../../shares/header.php'; ?>

<div class="container mt-4">
    <h3 class="mb-3">Danh sách đơn hàng</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Ngày đặt</th>
                    <th>Username</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $index => $order): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($order->created_at)), ENT_QUOTES, 'UTF-8'); ?>
                    <td><?php echo htmlspecialchars($order->fullname, ENT_QUOTES, 'UTF-8'); ?></td>
                    </td>
                    <td><?php echo htmlspecialchars($order->name, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($order->phone, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($order->address, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="text-danger font-weight-bold"><?php echo number_format($order->total, 0, ',', '.'); ?>
                        VNĐ
                    </td>

                    <td><?php echo translateStatus($order->status); ?></td>
                    <td>
                        <?php if ($order->status === 'pending'): ?>
                        <a href="/webbanhang/Order/updateOrderStatusAdmin/<?php echo $order->id; ?>/confirmed"
                            class="btn btn-sm btn-success">Xác nhận</a>
                        <a href="/webbanhang/Order/updateOrderStatusAdmin/<?php echo $order->id; ?>/cancelled"
                            class="btn btn-sm btn-danger">Hủy</a>
                        <?php endif; ?>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once __DIR__ . '/../../shares/footer.php'; ?><?php
function translateStatus($status)
{
    switch ($status) {
        case 'pending':
            return 'Đang chờ xử lý';
        case 'confirmed':
            return 'Đã xác nhận';
        case 'cancelled':
            return 'Đã hủy';
        default:
            return 'Không xác định';
    }
}
?>