<?php include 'app/views/shares/header.php'; ?>
<style>
.btn-lg {
    font-size: 1.1rem;
    padding: 0.75rem 1.5rem;
}

.rounded-circle {
    width: 40px;
    height: 40px;
    text-align: center;
    padding: 0.5rem 0;
    font-size: 1rem;
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
                        <h3 class="text-center text-primary mb-4 font-weight-bold">Đăng ký</h3>
                        <p class="text-center text-muted mb-4">Vui lòng nhập thông tin để tạo tài khoản</p>

                        <?php
                        if (isset($errors)) {
                            echo "<ul class='text-left'>";
                            foreach ($errors as $err) {
                                echo "<li class='text-danger'>$err</li>";
                            }
                            echo "</ul>";
                        }
                        ?>

                        <form action="/webbanhang/account/save" method="post">
                            <div class="form-group">
                                <label for="username"><i class="fas fa-user mr-1"></i> Tên đăng nhập</label>
                                <input type="text" class="form-control form-control-lg" id="username" name="username"
                                    placeholder="Nhập tên đăng nhập" required>
                            </div>
                            <div class="form-group">
                                <label for="fullname"><i class="fas fa-user-tag mr-1"></i> Họ tên</label>
                                <input type="text" class="form-control form-control-lg" id="fullname" name="fullname"
                                    placeholder="Nhập họ tên" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock mr-1"></i> Mật khẩu</label>
                                <input type="password" class="form-control form-control-lg" id="password"
                                    name="password" placeholder="Nhập mật khẩu" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmpassword"><i class="fas fa-lock mr-1"></i> Nhập lại mật khẩu</label>
                                <input type="password" class="form-control form-control-lg" id="confirmpassword"
                                    name="confirmpassword" placeholder="Nhập lại mật khẩu" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">Đăng ký</button>

                            <p class="text-center mt-4 mb-0">Đã có tài khoản?
                                <a href="/webbanhang/account/login" class="text-primary font-weight-bold">Đăng nhập</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>