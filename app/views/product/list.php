<?php include_once __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-4">
    <h3 class="mb-3">Danh sách sản phẩm</h3>
    <form class="form-inline mb-3" method="get" action="">
        <input type="text" name="search" class="form-control mr-2" placeholder="Tìm kiếm tên sản phẩm"
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>
    <form method="post" action="/webbanhang/Product/delete-multiple"
        onsubmit="return confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn?');">
        <?php if (SessionHelper::isAdmin()): ?>
        <a href="/webbanhang/Product/add" class="btn btn-success mb-3">Thêm sản phẩm mới</a>
        <?php endif; ?>
        <button type="submit" class="btn btn-danger mb-3">Xóa các sản phẩm đã chọn</button>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th><input type="checkbox" id="checkAllProducts"></th>
                        <th>#</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $index => $product): ?>
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="<?php echo $product->id; ?>"></td>
                        <td><?php echo $index + 1; ?></td>
                        <td>
                            <?php if (isset($product->image) && $product->image): ?>
                            <img src="/webbanhang/<?php echo $product->image; ?>" alt="Ảnh sản phẩm"
                                style="max-width:60px;max-height:60px;object-fit:cover;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ</td>
                        <td>
                            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>"
                                class="btn btn-sm btn-warning">Sửa</a>
                            <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/../shares/footer.php'; ?>
<script>
document.getElementById('checkAllProducts').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="ids[]"]');
    for (const cb of checkboxes) {
        cb.checked = this.checked;
    }
});
</script>