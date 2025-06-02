<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thanh toán</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="/webbanhang/Product/processCheckout">
                        <div class="form-group">
                            <label for="name">Họ tên:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ:</label>
                            <textarea id="address" name="address" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Thanh toán</button>
                        <a href="/webbanhang/Product/cart" class="btn btn-secondary ml-2">Quay lại giỏ hàng</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>