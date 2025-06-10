<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">


<!-- molla/cart.html  22 Nov 2019 09:55:06 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>keranjang - ilhamwear</title>
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
</head>

<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <div class="header-dropdown">
                            <!-- End .header-menu -->
                        </div><!-- End .header-dropdown -->
                    </div><!-- End .header-left -->

                   <!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-top -->
             <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>
                                <a href="index.php" class="logo">
                                <span style="font-size: 50px; font-weight: bold; font-family: Arial, sans-serif;">Ilhamwear</span>
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
                            <div class="dropdown cart-dropdown">
                                <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                    <i class="icon-shopping-cart"></i>
                                    <span class="cart-count">2</span>
                                </a>

                                <!-- End .dropdown-menu -->
                            </div><!-- End .cart-dropdown -->
                            <div class="dropdown user-dropdown">
                                <!-- Gunakan satu elemen untuk ikon dan toggle dropdown -->
                                <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="User">
                                    <i class="icon-user"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="logout.php">Logout</a>
                                </div>
                            </div>

            <!-- End .header-middle -->
        </header><!-- End .header -->

        <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Keranjang <span>Belanja</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Keranjang</a></li>
                        <li class="breadcrumb-item"><a href="#">Belanja</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Keranjang Belanja</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="cart">
	                <div class="container">
	                	<div class="row">
	                		<div class="col-lg-9">
                                    <?php
                                        include "admin/koneksi.php";

                                        // Pastikan user sudah login
                                        if (!isset($_SESSION['id_user'])) {
                                            echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href='user.php';</script>";
                                            exit();
                                        }

                                        $id_user = $_SESSION['id_user'];
                                        $sql = "SELECT 
                        p.id_pesanan,
                        p.qty,
                        p.size,
                        p.total,
                        pr.nm_produk,
                        pr.harga,
                        pr.gambar
                        FROM tb_pesanan p
                        JOIN tb_produk pr ON p.id_produk = pr.id_produk
                        WHERE p.id_user = ?
                        ORDER BY p.id_pesanan DESC";

                                                            $stmt = $koneksi->prepare($sql);
                                                            $stmt->bind_param("s", $id_user);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                        ?>
                                                        <form action="update_cart.php" method="post">
                                                            <table class="table table-cart table-mobile">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Produk</th>
                                                                        <th>Harga</th>
                                                                        <th>Jumlah</th>
                                                                        <th>Total</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>

                                                            <tbody>
                                                                    <?php if ($result->num_rows > 0) : ?>
                                                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                                                            <tr>
                                                                                <td class="product-col">
                                                                                    <div class="product">
                                                                                        <figure class="product-media">
                                                                                            <a href="#">
                                                                                                <img src="admin/produk_img/<?php echo htmlspecialchars($row ['gambar']); ?>" alt="Product image">
                                                                                                </a>
                                                                                            </figure>

                                                                                            <h3 class="product-title">
                                                                                                <a href="#"><?php echo htmlspecialchars($row['nm_produk']); ?></a>
                                                                                                <br><small>Ukuran: <?php echo htmlspecialchars(strtoupper($row['size'])); ?></small>
                                                                                                </h3><!-- End .product-title -->
                                                                                            </div><!-- End .product -->
                                                                                        </td>
                                                                                    <td class="price-col">Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                                                                    <td class="quantity-col">
                                                                                        <div class="cart-product-quantity"><input type="hidden" name="id_pesanan[]"value="<?php echo $row['id_pesanan']; ?>">
                                                                                            <input type="number" name="qty[]"class="form-control" value="<?php echo $row['qty']; ?>" min="1" max="10"step="1">
                                                                                                </div><!-- End .cart-product-quantity -->
                                                                                            </td>
                                                                                            <td class="total-col">Rp. <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                                                                                            <td class="remove-col">
                                                                                                <button
                                                                                                    type="button"
                                                                                                    class="btn-remove"
                                                                                                    onclick="hapusItem('<?php echo $row['id_pesanan']; ?>')">
                                                                                                    <i class="icon-close"></i>
                                                                                                </button>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php endwhile; ?>
                                                                                <?php else: ?>
                                                                                    <tr>
                                                                                        <td colspan="5" class="text-center">Keranjang Belanja Anda kosong.</td>
                                                                                    </tr>
                                                                                <?php endif; ?>
                                                                            </tbody>
                                                                        </tabel>
                                                                        <?php
                                                                        $stmt->close();
                                                                    ?>

                                                                    <div class="cart-bottom">
                                                                        <button type="submit" name="update_keranjang" class="btn btn-outline-dark-2"><span>UPDATE KERANJANG</span><i class="icon-refresh"></i></button>
                                                                    </div><!-- End .cart-buttom -->
                                                                </form>
                                                                <script>
                                                                    function hapusItem(idPesanan) {
                                                                        if (confirm("Apakah anda ingin menghapus item ini?")) {
                                                                            // Buat form secara dinamis lalu kirimkan
                                                                            var form = document.createElement("form");
                                                                            form.method = "POST";
                                                                            form.action = "cart.php";

                                                                            var input = document.createElement("input");
                                                                            input.type = "hidden";
                                                                            input.name = "hapus_pesanan";
                                                                            input.value = idPesanan;
                                                                            form.appendChild(input);

                                                                            document.body.appendChild(form);
                                                                            form.submit();
                                                                        }
                                                                    }
                                                                        </script>
                                                                        <?php
                                                                        // Sertakan file koneksi
                                                                        include 'admin/koneksi.php';

                                                                        // Periksa apakah tombol hapus diklik
                                                                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hapus_pesanan'])) {
                                                                            $idPesanan = $_POST['hapus_pesanan'];

                                                                            // Query untuk menghapus data berdasarkan id pesanan
                                                                            $sql = "DELETE FROM tb_pesanan WHERE id_pesanan = ?";

                                                                            // Siapkan statement
                                                                            $stmt = $koneksi->prepare($sql);
                                                                            if ($stmt) {
                                                                                $stmt->bind_param("s", $idPesanan); // "s" menunjukkan tipe string
                                                                                if ($stmt->execute()) {
                                                                                    echo "Item berhasil dihapus.";
                                                                                } else {
                                                                                    echo "Gagal menghapus item: " . $stmt->error;
                                                                                }
                                                                            }
                                                                            $stmt->close();   
                                                                        } else {
                                                                            echo "Gagal menyiapkan query: " . $koneksi->error;
                                                                        }        
                                                                    
                                                                    ?>

                                                                    </div><!-- End .col-lg-9 -->
                                                                    <?php
                                                                    // Hitung subtotal, diskon, dan total bayar
                                                                    $sql_total = "SELECT sum(total) AS subtotal FROM tb_pesanan WHERE id_user = ?";
                                                                    $stmt_total = $koneksi->prepare($sql_total);
                                                                    $stmt_total->bind_param("s", $id_user);
                                                                    $stmt_total->execute();
                                                                    $result_total = $stmt_total->get_result();   
                                                                    $row_total = $result_total->fetch_assoc();
                                                                    $subtotal = (int)$row_total['subtotal'];

                                                                    $diskon = 0;
                                                                    if ($subtotal > 1500000) {
                                                                        $diskon = 0.08 * $subtotal;
                                                                    } elseif ($subtotal > 800000) {
                                                                        $diskon = 0.05 * $subtotal;
                                                                    }

                                                                $total_bayar = $subtotal - $diskon;
                                                                
                                                                $stmt_total->close();
                                                                ?>

                                                                <aside class="col-lg-3">
                                                                    <div class="summary summary-cart">
                                                                        <h3 class="summary-title">Total Keranjang</h3><!-- End .summary-title -->

                                                                        <table class="table table-summary">
                                                                            <tbody>
                                                                                <tr class="summary-subtotal">
                                                                                    <td>Subtotal:</td>
                                                                                    <td>Rp. <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                                                                <tr><!-- End .summary-subtotal -->  
                                                                                <tr class="summary-subtotal">
                                                                                    <td>Diskon:</td>
                                                                                    <td>Rp. <?php echo number_format($diskon, 0, ',', '.'); ?></td>
                                                                                </tr><!-- End .summary-subtotal -->
                                                                                <tr class="summary-total">
                                                                                    <td>Total:</td>
                                                                                    <td>Rp. <?php echo number_format($total_bayar, 0, ',', '.'); ?></td>
                                                                                </tr><!-- End .summary-total -->
                                                                            </tbody>
                                                                        </table><!-- End .tabel tabel-summary -->
                                                                        
                                                                        <a href="checkout.php" class="btn btn-outline-primary-2 btn-order btn-block">PROSES CHECKOUT</a>
                                                                    </div><!-- End .summary -->
                                                                </aside><!-- End.col-lg-3 -->
                                                            </div><!-- End .row -->
                                                        </div><!-- Emd.container -->
                                                    </div><!-- End .cart -->
                                                </div><!-- End .page-ccontent -->
                                            </main><!-- End .main -->
                                                
                                            <footer class="footer">

												
											</td>
										</tr>
									</tbody>
								</table><!-- End .table table-wishlist -->

	                			<div class="cart-bottom">
			            			<div class="cart-discount">
			            				<form action="#">
			            					<div class="input-group">
				        						<input type="text" class="form-control" required placeholder="coupon code">
				        						<div class="input-group-append">
													<button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
												</div><!-- .End .input-group-append -->
			        						</div><!-- End .input-group -->
			            				</form>
			            			</div><!-- End .cart-discount -->

			            			
		            			

	                				<a href="checkout.html" class="btn btn-outline-primary-btn-order btn-block"></a>
	                			</div><!-- End .summary -->
	                		</aside><!-- End .col-lg-3 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

        <footer class="footer">
        	<div class="footer-middle">
	            <div class="container">
	            	<div class="row">
	            		<div class="col-sm-6 col-lg-3">
	            			<div class="widget widget-about">
	            				<span style="font-size: 30px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">Ilhamwear</span> 
	            				<p>🎉 Yay, produk sudah masuk ke keranjang! Checkout sekarang dan nikmati pengiriman cepat 🚚 Masih bingung? Klik tombol "proses checkout” untuk dibantu langsung 💬</p>

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
                            

	            				</ul><!-- End .widget-list -->
	            			</div><!-- End .widget -->
	            		</div><!-- End .col-sm-6 col-lg-3 -->

	            	<!-- End .widget -->
	            		<!-- End .widget -->
	            		</div><!-- End .col-sm-6 col-lg-3 -->
	            	</div><!-- End .row -->
	            </div><!-- End .container -->
	        </div><!-- End .footer-middle -->

	        <div class="footer-bottom">
	        	<div class="container">
	        		<p class="footer-copyright">Copyright © 2019 Ilhamwear Store. All Rights Reserved.</p><!-- End .footer-copyright -->
	        		<figure class="footer-payments">
	        			<img src="assets/images/payments.png" alt="Payment methods" width="272" height="20">
	        		</figure><!-- End .footer-payments -->
	        	</div><!-- End .container -->
	        </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="#" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>
            
        <!-- End .mobile-nav -->
<!-- End .social-icons -->
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
                                 <!-- .End .tab-pane -->
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
    <script src="assets/js/bootstrap-input-spinner.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>


<!-- molla/cart.html  22 Nov 2019 09:55:06 GMT -->
</html>