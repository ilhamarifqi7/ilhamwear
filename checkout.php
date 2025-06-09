<?php
// checkout.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $harga = (int) $_POST['harga'];
    $jumlah = (int) $_POST['jumlah'];

    $subtotal = $harga * $jumlah;
    $pajak = $subtotal * 0.1; // Pajak 10%
    $total = $subtotal + $pajak;
} else {
    // Jika bukan request POST, kembalikan ke halaman produk
    header("Location: detail_produk.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    <h1>Rincian Pembayaran</h1>

    <p><strong>Produk:</strong> <?php echo htmlspecialchars($nama_produk); ?></p>
    <p><strong>Harga Satuan:</strong> Rp <?php echo number_format($harga, 0, ',', '.'); ?></p>
    <p><strong>Jumlah:</strong> <?php echo $jumlah; ?></p>
    <p><strong>Subtotal:</strong> Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></p>
    <p><strong>Pajak (10%):</strong> Rp <?php echo number_format($pajak, 0, ',', '.'); ?></p>
    <hr>
    <h3>Total Bayar: Rp <?php echo number_format($total, 0, ',', '.'); ?></h3>

    <br>
    <a href="detail_produk.php">← Kembali ke Produk</a>
</body>
</html>
