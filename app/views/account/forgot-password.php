<?php include 'app/views/shares/header.php'; ?>
<style>
.btn-lg {
    font-size: 1.1rem;
    padding: 0.75rem 1.5rem;
}

.input-group-text {
    border-left: none;
}

.form-control-lg {
    border-right: none;
}
</style>

<section class="vh-100 d-flex align-items-center" style="
    background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow rounded border-0">
                    <div class="card-body px-4 py-5">
                        <h3 class="text-center text-primary mb-4 font-weight-bold">Quên mật khẩu</h3>
                        <p class="text-center text-muted mb-4">Vui lòng nhập tên đăng nhập của bạn để lấy lại mật khẩu</p>

                        <?php if(isset($message)): ?>
                            <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form action="/webbanhang/account/processForgotPassword" method="post">
                            <div class="form-group">
                                <label for="username"><i class="fas fa-user mr-1"></i> Tên đăng nhập</label>
                                <input type="text" name="username" id="username" class="form-control form-control-lg"
                                    placeholder="Nhập tên đăng nhập" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">Tiếp tục</button>

                            <p class="text-center mt-4 mb-0">
                                <a href="/webbanhang/account/login" class="text-primary font-weight-bold">Quay lại đăng nhập</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>