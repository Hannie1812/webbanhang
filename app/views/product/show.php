<?php include_once __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <?php if ($product->image): ?>
                        <img src="/webbanhang/<?php echo $product->image; ?>" class="card-img-top p-3"
                            alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php else: ?>
                        <img src="https://via.placeholder.com/300x300?text=No+Image" class="card-img-top p-3"
                            alt="No Image">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h3 class="card-title text-primary">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p class="card-text mb-2"><strong>Mô tả:</strong>
                                <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="card-text mb-2"><strong>Giá:</strong> <span
                                    class="text-danger font-weight-bold"><?php echo number_format($product->price, 0, ',', '.'); ?>
                                    VNĐ</span></p>
                            <?php if (isset($product->category_name)): ?>
                            <p class="card-text mb-2"><strong>Danh mục:</strong>
                                <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                            <?php endif; ?>
                            <div class="d-flex align-items-center gap-2">
                                <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>"
                                    class="btn btn-success">
                                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                                </a>
                                <a href="/webbanhang/Product/" class="btn btn-secondary mx-2">Quay lại danh sách</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../shares/footer.php'; ?>