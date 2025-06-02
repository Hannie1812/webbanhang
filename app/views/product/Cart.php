<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Giỏ hàng</h2>
    <?php if (!empty($cart)): ?>
    <?php $total = 0; ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Xoá</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $id => $item): ?>
                <?php $item_total = $item['price'] * $item['quantity']; $total += $item_total; ?>
                <tr>
                    <td>
                        <?php if ($item['image']): ?>
                        <img src="/webbanhang/<?php echo $item['image']; ?>" alt="Product Image"
                            style="max-width: 80px;">
                        <?php endif; ?>
                    </td>
                    <td class="align-middle"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="align-middle text-danger font-weight-bold">
                        <?php echo number_format($item['price'], 0, ',', '.'); ?> VND
                    </td>
                    <td class="align-middle">
                        <form action="/webbanhang/Product/updateCartQuantity" method="post" class="d-inline">
                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                            <button type="submit" name="action" value="decrease"
                                class="btn btn-sm btn-outline-secondary">-</button>
                        </form>
                        <span
                            class="mx-2"><?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <form action="/webbanhang/Product/updateCartQuantity" method="post" class="d-inline">
                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                            <button type="submit" name="action" value="increase"
                                class="btn btn-sm btn-outline-secondary">+</button>
                        </form>
                    </td>
                    <td class="align-middle text-primary font-weight-bold">
                        <?php echo number_format($item_total, 0, ',', '.'); ?> VND</td>
                    <td class="align-middle">
                        <form action="/webbanhang/Product/removeFromCart" method="post"
                            onsubmit="return confirm('Xoá sản phẩm này?');">
                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Tổng tiền:</th>
                    <th class="text-danger font-weight-bold"><?php echo number_format($total, 0, ',', '.'); ?> VND</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="mt-3">
        <a href="/webbanhang/Product" class="btn btn-secondary">Tiếp tục mua sắm</a>
        <a href="/webbanhang/Product/checkout" class="btn btn-primary ml-2">Thanh Toán</a>
    </div>
    <?php else: ?>
    <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div>
    <div class="mt-3">
        <a href="/webbanhang/Product" class="btn btn-secondary">Tiếp tục mua sắm</a>
        <button class="btn btn-primary ml-2" disabled>Thanh Toán</button>
    </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>