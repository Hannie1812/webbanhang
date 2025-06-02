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
                        <h3 class="text-center text-primary mb-4 font-weight-bold">Đăng nhập</h3>
                        <p class="text-center text-muted mb-4">Vui lòng nhập thông tin để tiếp tục</p>

                        <form action="/webbanhang/account/checklogin" method="post">
                            <div class="form-group">
                                <label for="username"><i class="fas fa-user mr-1"></i> Tên đăng nhập</label>
                                <input type="text" name="username" id="username" class="form-control form-control-lg"
                                    placeholder="Nhập tên đăng nhập" required>
                            </div>

                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock mr-1"></i> Mật khẩu</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="passwordInput"
                                        class="form-control form-control-lg" placeholder="Nhập mật khẩu" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white" style="cursor: pointer;"
                                            onclick="togglePassword()">
                                            <i class="fas fa-eye text-secondary" id="toggleIcon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mb-3">
                                <a href="/webbanhang/account/forgotPassword" class="text-primary small">Quên mật khẩu?</a>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">Đăng nhập</button>

                            <!-- <div class="text-center mt-4">
                                <span class="text-muted">Hoặc đăng nhập bằng</span>
                                <div class="d-flex justify-content-center mt-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm mx-1 rounded-circle">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-danger btn-sm mx-1 rounded-circle">
                                        <i class="fab fa-google"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-info btn-sm mx-1 rounded-circle">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </div>
                            </div> -->

                            <p class="text-center mt-4 mb-0">Bạn chưa có tài khoản?
                                <a href="/webbanhang/account/register" class="text-primary font-weight-bold">Đăng ký</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Toggle password visibility
function togglePassword() {
    const passwordInput = document.getElementById("passwordInput");
    const toggleIcon = document.getElementById("toggleIcon");
    const isPassword = passwordInput.type === "password";
    passwordInput.type = isPassword ? "text" : "password";
    toggleIcon.classList.toggle("fa-eye");
    toggleIcon.classList.toggle("fa-eye-slash");
}
</script>

<?php include 'app/views/shares/footer.php'; ?>