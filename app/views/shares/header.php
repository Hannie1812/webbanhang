<!DOCTYPE html>
<html lang="en">
<?php
$currentPath = rtrim($_SERVER['REQUEST_URI'], '/'); // loại bỏ dấu / cuối nếu có
// Sửa điều kiện để hiển thị banner trên tất cả các trang thuộc controller Product
$isHome = (strpos($currentPath, '/webbanhang/Product') !== false);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/webbanhang/public/sticky-buttons.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <a class="navbar-brand" href="/webbanhang/Product/">
            <i class="fas fa-store"></i> Web Bán Hàng
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu trái -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="/webbanhang/Product/">
                        <i class="fas fa-home"></i> Trang chủ
                    </a>
                </li>
                <?php if (SessionHelper::isAdmin()): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="productDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-boxes"></i> Sản phẩm
                    </a>
                    <div class="dropdown-menu" aria-labelledby="productDropdown">
                        <a class="dropdown-item" href="/webbanhang/Product/list">Danh sách sản phẩm</a>
                        <a class="dropdown-item" href="/webbanhang/Product/add">Thêm sản phẩm</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="categoryDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-th-list"></i> Danh mục
                    </a>
                    <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <a class="dropdown-item" href="/webbanhang/Category/">Danh sách danh mục</a>
                        <a class="dropdown-item" href="/webbanhang/Category/add">Thêm danh mục</a>
                    </div>
                </li>
                <?php endif; ?>
            </ul>

            <!-- Tìm kiếm -->
            <form class="form-inline my-2 my-lg-0" method="get" action="/webbanhang/Product/">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Tìm sản phẩm..."
                    aria-label="Search"
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- Người dùng -->
            <ul class="navbar-nav ml-3">
                <?php if(SessionHelper::isLoggedIn()): ?>
                <li class="nav-item">
                    <a class="nav-link text-white">
                        <i class="fas fa-user-circle"></i> <?php echo $_SESSION['username']; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/webbanhang/account/logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/webbanhang/account/login">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <?php if ($isHome): ?>
    <!-- Carousel code ở đây -->
    <!-- Carousel Banner -->
    <div id="mainCarousel" class="carousel slide mt-3" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#mainCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#mainCarousel" data-slide-to="1"></li>
            <li data-target="#mainCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80"
                    class="d-block w-100" alt="Banner 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Chào mừng đến với Web Bán Hàng</h5>
                    <p>Khám phá các sản phẩm mới nhất với giá ưu đãi!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80"
                    class="d-block w-100" alt="Banner 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Đa dạng sản phẩm</h5>
                    <p>Chất lượng đảm bảo, giao hàng tận nơi.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=1200&q=80"
                    class="d-block w-100" alt="Banner 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Ưu đãi hấp dẫn</h5>
                    <p>Giảm giá lên đến 50% cho nhiều mặt hàng!</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#mainCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#mainCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <?php endif; ?>
    <!-- Sticky Cart Button & Back to Top Button -->
    <?php if (SessionHelper::isLoggedIn()): ?>

    <a href="/webbanhang/Product/cart" class="sticky-cart-btn" title="Xem giỏ hàng">
        <i class="fas fa-shopping-cart"></i>
        <?php if (SessionHelper::isLoggedIn()): ?>
        <?php 
                    require_once 'app/config/database.php';
                    require_once 'app/models/CartModel.php';
                    $database = new Database();
                    $db = $database->getConnection();
                    $cartModel = new CartModel($db);
                    $user_id = SessionHelper::getUserId();
                    $cart_id = $cartModel->createCart($user_id);
                    $totalQuantity = $cartModel->getTotalCartQuantity($cart_id);
                ?>
        <?php if ($totalQuantity > 0): ?>
        <span class="cart-badge">
            <?php echo $totalQuantity; ?>
        </span>
        <?php endif; ?>
        <?php elseif (!empty($_SESSION['cart'])): ?>
        <span class="cart-badge">
            <?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?>
        </span>
        <?php endif; ?>
    </a>
    <?php endif; ?>
    <a href="#" class="sticky-top-btn" id="backToTopBtn" title="Lên đầu trang">
        <i class="fas fa-arrow-up"></i>
    </a>
    <script>
    // Back to top button
    const backToTopBtn = document.getElementById('backToTopBtn');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 200) {
            backToTopBtn.style.display = 'flex';
        } else {
            backToTopBtn.style.display = 'none';
        }
    });
    backToTopBtn.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    // Hide on load
    backToTopBtn.style.display = 'none';
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    // Kích hoạt dropdown Bootstrap
    $(function() {
        $('.dropdown-toggle').dropdown();
    });
    </script>
</body>

</html>