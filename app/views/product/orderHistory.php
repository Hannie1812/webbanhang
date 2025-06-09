<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Lịch sử đơn hàng</h2>
    <?php if (!empty($orders)): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Ngày đặt</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $index => $order): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($order->created_at)), ENT_QUOTES, 'UTF-8'); ?>
                    </td>
                    <td><?php echo htmlspecialchars($order->name, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($order->phone, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($order->address, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="text-danger font-weight-bold"><?php echo number_format($order->total, 0, ',', '.'); ?>
                        VNĐ</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>