<?php include_once __DIR__ . '/../../shares/header.php'; ?>

<div class="container mt-4">
    <h3 class="mb-3">Danh sách tài khoản</h3>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Tên đăng nhập</th>
                <th>Họ tên</th>
                <th>Quyền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($accounts as $index => $account): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($account->username, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($account->fullname, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($account->role, ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="/webbanhang/Account/edit/<?php echo $account->id; ?>"
                        class="btn btn-sm btn-warning">Sửa</a>
                    <a href="/webbanhang/Account/delete/<?php echo $account->id; ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once __DIR__ . '/../../shares/footer.php'; ?>