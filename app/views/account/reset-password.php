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
                        <h3 class="text-center text-primary mb-4 font-weight-bold">Đặt lại mật khẩu</h3>
                        <p class="text-center text-muted mb-4">Vui lòng nhập mật khẩu mới của bạn</p>

                        <?php if(isset($message)): ?>
                            <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form action="/webbanhang/account/updatePassword" method="post">
                            <input type="hidden" name="username" value="<?php echo $username; ?>">
                            
                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock mr-1"></i> Mật khẩu mới</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="passwordInput"
                                        class="form-control form-control-lg" placeholder="Nhập mật khẩu mới" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white" style="cursor: pointer;"
                                            onclick="togglePassword('passwordInput', 'toggleIcon')">
                                            <i class="fas fa-eye text-secondary" id="toggleIcon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword"><i class="fas fa-lock mr-1"></i> Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <input type="password" name="confirmPassword" id="confirmPasswordInput"
                                        class="form-control form-control-lg" placeholder="Xác nhận mật khẩu mới" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white" style="cursor: pointer;"
                                            onclick="togglePassword('confirmPasswordInput', 'toggleIconConfirm')">
                                            <i class="fas fa-eye text-secondary" id="toggleIconConfirm"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">Đặt lại mật khẩu</button>

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

<script>
// Toggle password visibility
function togglePassword(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const toggleIcon = document.getElementById(iconId);
    const isPassword = passwordInput.type === "password";
    passwordInput.type = isPassword ? "text" : "password";
    toggleIcon.classList.toggle("fa-eye");
    toggleIcon.classList.toggle("fa-eye-slash");
}
</script>

<?php include 'app/views/shares/footer.php'; ?>