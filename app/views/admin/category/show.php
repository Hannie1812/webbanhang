<?php include 'app/views/shares/header.php' ?>

<div class="container-md">
    <h1>Chi tiết danh mục</h1>
    
    <h2><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></h2>
    <?php if (!empty($category->description)): ?>
        <p>Mô tả: <?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <a href="/webbanhang/Category/edit/<?php echo $category->id; ?>" class="btn btn-warning">Sửa</a>
    <a href="/webbanhang/Category/delete/<?php echo $category->id;?>" class="btn btn-danger mx-2" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
    <a href="/webbanhang/Category/" class="btn btn-secondary">Quay lại trang danh sách</a>
</div>

<?php include 'app/views/shares/footer.php'?>