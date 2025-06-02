<?php include_once __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thêm danh mục mới</h4>
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
                    <form method="POST" action="/webbanhang/Category/save">
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                        <a href="/webbanhang/Category/list" class="btn btn-secondary ml-2">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../shares/footer.php'; ?>