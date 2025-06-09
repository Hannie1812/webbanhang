<?php include_once __DIR__ . '/../../shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Chỉnh sửa tài khoản</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="/webbanhang/Account/update">
                        <input type="hidden" name="id" value="<?php echo $account->id; ?>">
                        <div class="form-group">
                            <label for="username">Tên đăng nhập:</label>
                            <input type="text" id="username" name="username" class="form-control"
                                value="<?php echo htmlspecialchars($account->username, ENT_QUOTES, 'UTF-8'); ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="fullname">Họ tên:</label>
                            <input type="text" id="fullname" name="fullname" class="form-control"
                                value="<?php echo htmlspecialchars($account->fullname, ENT_QUOTES, 'UTF-8'); ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="role">Quyền:</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="user" <?php echo $account->role === 'user' ? 'selected' : ''; ?>>User
                                </option>
                                <option value="admin" <?php echo $account->role === 'admin' ? 'selected' : ''; ?>>Admin
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu mới:</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Nhập mật khẩu mới (để trống nếu không muốn thay đổi)">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        <a href="/webbanhang/Account/list" class="btn btn-secondary ml-2">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../shares/footer.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');

    togglePasswordButton.addEventListener('click', function() {
        // Toggle giữa 'password' và 'text'
        const isPassword = passwordField.type === 'password';
        passwordField.type = isPassword ? 'text' : 'password';

        // Cập nhật biểu tượng
        this.innerHTML = isPassword ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
    });
});
</script>