<?php include_once __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thêm sản phẩm mới</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <form method="POST" action="/webbanhang/Product/save" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea id="description" name="description" class="form-control" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá</label>
                            <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Danh mục</label>
                            <select id="category_id" name="category_id" class="form-control" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>">
                                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Hình ảnh:</label>
                            <input type="file" id="image" name="image" class="form-control"
                                onchange="previewImage(event)">
                            <div id="preview-container" class="mt-2">
                                <img id="preview" src="#" alt="Product Image" style="display:none; max-width: 100px;">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                        <a href="/webbanhang/Product/list" class="btn btn-secondary ml-2">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    var preview = document.getElementById('preview');
    var file = event.target.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}
</script>

<?php include_once __DIR__ . '/../shares/footer.php'; ?>