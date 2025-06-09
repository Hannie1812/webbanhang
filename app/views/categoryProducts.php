<?php include_once 'd:/laragon/www/webbanhang/app/views/shares/header.php'; ?>

<div class="container mt-5">

    <div class="row">
        <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="/webbanhang/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                    class="card-img-top" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h5>
                    <p class="card-text text-danger"><?php echo number_format($product->price, 0, ',', '.'); ?> đ</p>
                    <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="btn btn-primary">Xem chi
                        tiết</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>Không có sản phẩm nào trong danh mục này.</p>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'd:/laragon/www/webbanhang/app/views/shares/footer.php'; ?>