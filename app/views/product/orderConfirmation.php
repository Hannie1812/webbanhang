<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow text-center">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Xác nhận đơn hàng</h4>
                </div>
                <div class="card-body">
                    <p class="lead mb-4">Cảm ơn bạn đã đặt hàng.<br>Đơn hàng của bạn đã được xử lý thành công.</p>
                    <?php if (isset($order) && !empty($order)): ?>
                    <div class="text-left mb-4">
                        <h5 class="mb-3">Thông tin hóa đơn</h5>
                        <ul class="list-group mb-3">
                            <li class="list-group-item"><strong>Mã đơn hàng:</strong>
                                <?php echo htmlspecialchars($order['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?></li>
                            <li class="list-group-item"><strong>Khách hàng:</strong>
                                <?php echo htmlspecialchars($order['customer_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></li>
                            <li class="list-group-item"><strong>Số điện thoại:</strong>
                                <?php echo htmlspecialchars($order['customer_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            </li>
                            <li class="list-group-item"><strong>Địa chỉ:</strong>
                                <?php echo htmlspecialchars($order['customer_address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            </li>
                            <li class="list-group-item"><strong>Ngày đặt:</strong>
                                <?php echo htmlspecialchars($order['created_at'] ?? date('d/m/Y H:i'), ENT_QUOTES, 'UTF-8'); ?>
                            </li>
                        </ul>
                        <h6>Danh sách sản phẩm:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; if (!empty($order['items'])): foreach ($order['items'] as $item): $item_total = $item['price'] * $item['quantity']; $total += $item_total; ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td><?php echo number_format($item_total, 0, ',', '.'); ?> đ</td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Tổng tiền:</th>
                                        <th class="text-danger"><?php echo number_format($total, 0, ',', '.'); ?> đ</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>

                    <a href="/webbanhang/Product/" class="btn btn-primary">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>