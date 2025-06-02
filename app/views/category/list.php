<?php include_once __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-4">
    <h3 class="mb-3">Danh sách danh mục</h3>
    <form class="form-inline mb-3" method="get" action="">
        <input type="text" name="search" class="form-control mr-2" placeholder="Tìm kiếm tên danh mục"
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>
    <form method="post" action="/webbanhang/Category/delete-multiple"
        onsubmit="return confirm('Bạn có chắc chắn muốn xóa các danh mục đã chọn?');">
        <a href="/webbanhang/Category/add" class="btn btn-success mb-3">Thêm danh mục mới</a>
        <button type="submit" class="btn btn-danger mb-3 ml-2">Xóa các danh mục đã chọn</button>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th><input type="checkbox" id="checkAllCategories"></th>
                        <th>#</th>
                        <th>Tên danh mục</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $index => $category): ?>
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="<?php echo $category->id; ?>"></td>
                        <td><?php echo $index + 1; ?></td>
                        <td>
                            <a href="/webbanhang/Category/show/<?php echo $category->id; ?>">
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </td>
                        <td>
                            <a href="/webbanhang/Category/delete/<?php echo $category->id; ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">Xóa</a>
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
document.getElementById('checkAllCategories').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="ids[]"]');
    for (const cb of checkboxes) {
        cb.checked = this.checked;
    }
});
</script>