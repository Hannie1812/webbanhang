<?php include_once __DIR__ . '/../shares/header.php'; ?>
<div class="container mt-5">
    <form class="form-inline mb-4" method="get" action="">
        <input type="text" name="search" class="form-control mr-2" placeholder="Tìm kiếm tên sản phẩm"
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>
    <div class="row" id="product-list">
        <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card product-card h-100">
                <?php if ($product->image): ?>
                <img src="/webbanhang/<?php echo $product->image; ?>" class="card-img-top"
                    alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">
                        <a href="/webbanhang/Product/show/<?php echo $product->id; ?>">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </h5>
                    <p class="card-text flex-grow-1">
                        <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <p class="card-text font-weight-bold text-primary">
                        Giá: <?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ
                    </p>

                    <!-- Gói 2 nút lại với flex để căn đều dưới -->
                    <div class="mt-auto d-flex flex-column gap-2">
                        <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="btn btn-primary">Xem chi tiết</a>
                        <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-success mt-2">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include_once __DIR__ . '/../shares/footer.php'; ?>