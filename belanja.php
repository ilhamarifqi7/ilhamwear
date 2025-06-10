<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">


<!-- molla/category-list.html  22 Nov 2019 10:02:52 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>cart - ihamwear</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="assets/images/icons/site.html">
    <link rel="mask-icon" href="assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/plugins/nouislider/nouislider.css">
</head>

<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>
                        <a href="index.php" class="logo">
                            <span style="font-size: 50px; font-weight: bold; font-family: Arial, sans-serif;">IlhamWear</span>
                        </a>
                    </div><!-- End .header-left -->

                    <nav class="main-nav" style="flex: 1; text-align: center;">
                        <ul class="menu sf-arrows" style="display: inline-flex; gap: 30px; list-style: none; margin: 0; padding: 0;">
                            <li><a href="index.php" class="sf-with-ul">Beranda</a></li>
                            <li class="megamenu-container active"><a href="belanja.php" class="sf-with-ul">Belanja</a></li>
                            <li><a href="contact.php" class="sf-with-ul">Hubungi Kami</a></li>
                        </ul>
                    </nav>

                    <div class="header-right d-flex align-items-center">
                        <div class="header-search">
                            
                            <form action="belanja.php" method="get">
                                <div class="header-search-wrapper">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search produk..." required>
                                </div>
                            </form>
                        </div>

                        <?php
                        include 'admin/koneksi.php'; // File koneksi ke database

                        $cartItems = [];
                        $totalPrice = 0;

                        if (isset($_SESSION['id_user'])) {
                            $id_user = $_SESSION['id_user'];
                            $query = "
        SELECT p.id_produk, p.nm_produk, p.gambar, ps.qty, ps.size, ps.total 
        FROM tb_pesanan ps
        JOIN tb_produk p ON ps.id_produk = p.id_produk
        WHERE ps.id_user = ?";
                            $stmt = $koneksi->prepare($query);
                            $stmt->bind_param("i", $id_user);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                $cartItems[] = $row;
                                $totalPrice += $row['total'];
                            }
                        }
                        ?>

                        <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count"><?php echo count($cartItems); ?></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">
                                    <?php if (!empty($cartItems)): ?>
                                        <?php foreach ($cartItems as $item): ?>
                                            <div class="product">
                                                <div class="product-cart-details">
                                                    <h4 class="product-title">
                                                        <a href="product.php?id=<?php echo $item['id_produk']; ?>"><?php echo htmlspecialchars($item['nm_produk']); ?></a>
                                                    </h4>
                                                    <span class="cart-product-info">
                                                        <span class="cart-product-qty"><?php echo $item['qty']; ?></span>
                                                        = Rp. <?php echo number_format($item['total'] / $item['qty'], 0, ',', '.'); ?>
                                                    </span>
                                                </div><!-- End .product-cart-details -->

                                                <figure class="product-image-container">
                                                    <a href="product.php?id=<?php echo $item['id_produk']; ?>" class="product-image">
                                                        <img src="admin/produk_img/<?php echo htmlspecialchars($item['gambar']); ?>" alt="product">
                                                    </a>
                                                </figure>
                                                <a href="remove_from_cart.php?id=<?php echo $item['id_produk']; ?>" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                            </div><!-- End .product -->
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-center">Keranjang Anda Kosong.</p>
                                    <?php endif; ?>
                                </div><!-- End .dropdown-cart-products -->

                                <div class="dropdown-cart-total">
                                    <span>Total</span>
                                    <span class="cart-total-price">Rp. <?php echo number_format($totalPrice, 0, ',', '.'); ?></span>
                                </div><!-- End .dropdown-cart-total -->

                                <div class="dropdown-cart-action">
                                    <a href="cart.php" class="btn btn-primary">View Cart</a>
                                    <a href="checkout.php" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
                                </div><!-- End .dropdown-cart-action -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->
                        <?php
                        include 'admin/koneksi.php';

                        // Periksa apakah user sudah login
                        if (isset($_SESSION['id_user'])) {
                            // Ambil data user berdasarkan sesi
                            $id_user = $_SESSION['id_user'];
                            $sql = "SELECT username FROM tb_user WHERE id_user = ?";
                            $stmt = $koneksi->prepare($sql);
                            $stmt->bind_param("i", $id_user);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $user = $result->fetch_assoc();

                            // Simpan nama user
                            $username = $user['username'] ?? 'Guest';

                            // Tutup statement
                            $stmt->close();
                        } else {
                            $username = "Guest"; // Jika belum login
                        }
                        ?>
                        <div class="dropdown user-dropdown">
                            <!-- Gunakan satu elemen untuk ikon dan toggle dropdown -->
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="User">
                                <i class="icon-user"></i>
                                <!-- Tampilkan nama user -->
                                <span><?php echo htmlspecialchars($username); ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </div>

                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->
        </header><!-- End .header -->

        <main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
                <div class="container">
                    <h1 class="page-title"><span>Belanja</span></h1>
                </div><!-- End .container -->
            </div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Belanja</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="toolbox">
                                <div class="toolbox-right">
                                    <div class="toolbox-sort">
                                        <label for="sortby"></label>
                                        <div>
                                            <option value="rating"></option>
                                            <option value="date"></option>
                                            </select>
                                        </div>
                                    </div><!-- End .toolbox-sort -->
                                    <div class="toolbox-layout">
                                    </div><!-- End .toolbox-layout -->
                                </div><!-- End .toolbox-right -->
                            </div><!-- End .toolbox -->

                            <div class="products mb-3">
                                <?php
                                include 'admin/koneksi.php'; // Pastikan file koneksi ke database disertakan
                                $where = '';
                                if (isset($_GET['q']) && !empty($_GET['q'])) {
                                    $search = mysqli_real_escape_string($koneksi, $_GET['q']);
                                    $where = "WHERE p.nm_produk LIKE '%$search%'";
                                }

                                $query = "SELECT p.id_produk, p.nm_produk, p.harga, p.stok, p.ket, p.gambar, p.size, k.nm_ktg
                                            FROM tb_produk p
                                            JOIN tb_ktg k ON p.id_ktg = k.id_ktg
                                            $where";

                                $result = mysqli_query($koneksi, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <div class="product product-list">
                                        <div class="row">
                                            <div class="col-6 col-lg-3">
                                                <figure class="product-media">
                                                    <a href="product-detail.php?id=<?php echo $row['id_produk']; ?>">
                                                        <img src="admin/produk_img/<?php echo $row['gambar']; ?>" alt="Product image" class="product-image uniform-img">
                                                    </a>
                                                </figure>
                                            </div>

                                            <div class="col-6 col-lg-3 order-lg-last">
                                                <div class="product-list-action">
                                                    <div class="product-price">
                                                        Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                                                    </div>

                                                    <div class="product-action">
                                                        <a href="#" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
                                                        <a href="#" class="btn-product btn-compare" title="Compare"><span>compare</span></a>
                                                    </div>
                                                    <a href="detail_produk.php?id_produk=<?php echo $row['id_produk']; ?>" class="btn-product btn-cart"><span>Keranjang</span></a>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="product-body product-action-inner">
                                                    <div class="product-cat">
                                                        <a href="#"><?php echo $row['nm_ktg']; ?></a>
                                                    </div>
                                                    <h3 class="product-title"><a href="product-detail.php?id=<?php echo $row['id_produk']; ?>"><?php echo $row['nm_produk']; ?></a></h3>

                                                    <div class="product-content">
                                                        <p><?php echo $row['ket']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div><!-- End .products -->

                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item disabled">
                                        <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                            <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                        </a>
                                    </li>
                                    <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item-total">of 6</li>
                                    <li class="page-item">
                                        <a class="page-link page-link-next" href="#" aria-label="Next">
                                            Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div><!-- End .col-lg-9 -->
                        <aside class="col-lg-3 order-lg-first">
                            <div class="sidebar sidebar-shop">
                                <div class="widget widget-clean">
                                    <label>Filters:</label>
                                    <a href="#" class="sidebar-filter-clear">Clean All</a>
                                </div><!-- End .widget widget-clean -->

                                <?php
                                // Koneksi ke database
                                include 'admin/koneksi.php'; // Pastikan file koneksi benar

                                // Ambil semua kategori
                                $query = "SELECT k.id_ktg, k.nm_ktg, COUNT(p.id_produk) as jumlah 
          FROM tb_ktg k 
          LEFT JOIN tb_produk p ON k.id_ktg = p.id_ktg 
          GROUP BY k.id_ktg, k.nm_ktg";
                                $result = mysqli_query($koneksi, $query);
                                ?>


                                <div class="widget widget-collapsible">
                                    <h3 class="widget-title">
                                        <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                            Category
                                        </a>
                                    </h3><!-- End .widget-title -->

                                    <div class="collapse show" id="widget-1">
                                        <div class="widget-body">
                                            <div class="filter-items filter-items-count">
                                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                                    <div class="filter-item">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="cat-<?php echo $row['id_ktg']; ?>">
                                                            <label class="custom-control-label" for="cat-<?php echo $row['id_ktg']; ?>">
                                                                <?php echo htmlspecialchars($row['nm_ktg']); ?>
                                                            </label>
                                                        </div><!-- End .custom-checkbox -->
                                                        <span class="item-count"><?php echo $row['jumlah']; ?></span>
                                                    </div><!-- End .filter-item -->
                                                <?php endwhile; ?>
                                            </div><!-- End .filter-items -->
                                        </div><!-- End .widget-body -->
                                    </div><!-- End .collapse -->
                                </div><!-- End .widget -->

                                <?php
                                include 'admin/koneksi.php'; // Koneksi ke database

                                $query = "SELECT size FROM tb_produk WHERE size IS NOT NULL AND size != ''";
                                $result = mysqli_query($koneksi, $query);

                                $sizes = [];

                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Pecah ukuran berdasarkan koma
                                    $sizeArray = explode(',', $row['size']);

                                    foreach ($sizeArray as $size) {
                                        $cleanSize = trim($size); // Hilangkan spasi
                                        if ($cleanSize !== '') {
                                            $sizes[] = $cleanSize;
                                        }
                                    }
                                }

                                // Ambil ukuran unik dan urutkan
                                $uniqueSizes = array_unique($sizes);
                                sort($uniqueSizes); // Urutkan A-Z
                                ?>



                                <div class="widget widget-collapsible">
                                    <h3 class="widget-title">
                                        <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
                                            Size
                                        </a>
                                    </h3><!-- End .widget-title -->

                                    <div class="collapse show" id="widget-2">
                                        <div class="widget-body">
                                            <div class="filter-items">
                                                <?php
                                                $i = 1;
                                                foreach ($uniqueSizes as $size) :
                                                ?>
                                                    <div class="filter-item">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="size-<?php echo $i; ?>" value="<?php echo $size; ?>">
                                                            <label class="custom-control-label" for="size-<?php echo $i; ?>"><?php echo $size; ?></label>
                                                        </div><!-- End .custom-checkbox -->
                                                    </div><!-- End .filter-item -->
                                                <?php
                                                    $i++;
                                                endforeach;
                                                ?>
                                            </div><!-- End .filter-items -->
                                        </div><!-- End .widget-body -->
                                    </div><!-- End .collapse -->
                                </div><!-- End .widget -->
                            </div><!-- End .sidebar sidebar-shop -->
                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

        <footer class="footer">
            <div class="footer-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="widget widget-about">
                                <a href="index.php" class="footer-logo">Ilhamwear</a>
                                <p>Kami tahu, gaya kamu itu unik — makanya kami siap bantu cari yang paling pas! Jangan ragu hubungi kami kalau butuh saran atau bantuan sebelum checkout .Terima kasih sudah percaya [Nama Toko]. Kamu luar biasa! ✨</p>

                                <div class="social-icons">
                                        <a href="https://www.instagram.com/p/C6nojjlvDuZ/?igsh=MW04bmpjZ205dnd1eg==" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                                        <a href="https://youtube.com/@muhammadilhamarifqi?si=wttshVSdheNGRoHx" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
                                </div><!-- End .soial-icons -->
                            </div><!-- End .widget about-widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-4">
                            <div class="widget">
                                <h4 class="widget-title">Komitmen Kami</h4>
                                <p>Kami berkomitmen untuk pengadaan yang etis dan keberlanjutan. Pelajari lebih lanjut tentang praktik keberlanjutan kami.</p>
                                <a href="contact.php" class="btn btn-outline-secondary btn-sm">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="footer-bottom">
                <div class="container">
                    <p class="footer-copyright">Copyright © 2025 Ilhamwear. All Rights Reserved.</p><!-- End .footer-copyright -->
                    <figure class="footer-payments">
                        <img src="assets/images/payments.png" alt="Payment methods" width="272" height="20">
                    </figure><!-- End .footer-payments -->
                </div><!-- End .container -->
            </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="#" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
                
            </form>

         <!-- End .mobile-nav -->

            <div class="social-icons">
               <a href="https://www.instagram.com/p/C6nojjlvDuZ/?igsh=MW04bmpjZ205dnd1eg==" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
               <a href="https://youtube.com/@muhammadilhamarifqi?si=wttshVSdheNGRoHx" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form action="#">
                                        <div class="form-group">
                                            <label for="singin-email">Username or email address *</label>
                                            <input type="text" class="form-control" id="singin-email" name="singin-email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="singin-password">Password *</label>
                                            <input type="password" class="form-control" id="singin-password" name="singin-password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                            </div><!-- End .custom-checkbox -->

                                            <a href="#" class="forgot-link">Forgot Your Password?</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                    <form action="#">
                                        <div class="form-group">
                                            <label for="register-email">Your email address *</label>
                                            <input type="email" class="form-control" id="register-email" name="register-email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="register-password">Password *</label>
                                            <input type="password" class="form-control" id="register-password" name="register-password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy">I agree to the <a href="#">privacy policy</a> *</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                    </form>
                                  <!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/wNumb.js"></script>
    <script src="assets/js/bootstrap-input-spinner.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/nouislider.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>


<!-- molla/category-list.html  22 Nov 2019 10:02:52 GMT -->

</html>