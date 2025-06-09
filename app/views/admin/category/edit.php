<?php include 'app/views/shares/header.php' ?>

<div class="container-md">
    <h1>Sửa danh mục</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php htmlspecialchars($error, ENT_QUOTES, UTF-8); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="/webbanhang/Category/update" method="POST" onsubmit="return validateForm(); ">
        <input type="hidden" name="id" value="<?php echo $category->id ?>">
        <div class="form-group">
            <label for="name">Tên danh mục:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea name="description" id="description" class="form-control"><?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="/webbanhang/Category/" class="btn btn-secondary mx-2">Quay lại trang danh sách</a>
    </form>
</div>

<?php include 'app/views/shares/footer.php' ?>