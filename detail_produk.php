<?php
session_start();

require_once "koneksi.php";

// Cek session untuk otorisasi, jika tidak valid, redirect ke halaman Login
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}
// Cek apakah parameter ID produk diterima
if (isset($_GET['id'])) {
    $idProduk = $_GET['id'];

    // Koneksi ke database
    $conn = connectDB();

    // Query untuk mendapatkan informasi produk berdasarkan ID
    $sql = "SELECT * FROM produk WHERE id = $idProduk";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $produk = $result->fetch_assoc();
    } else {
        // Produk tidak ditemukan, bisa ditangani dengan redirect atau pesan kesalahan
        header("Location: master_data_produk.php");
        exit();
    }

    $conn->close();
} else {
    // ID produk tidak ditemukan, bisa ditangani dengan redirect atau pesan kesalahan
    header("Location: master_data_produk.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk</title>
    <link rel="icon" type="image/png" href="logo/logo_icon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/detail_produk.css">
</head>
<body>
    <div class="container">
        <div class="product-details">
            <div class="product-image">
                <img src="uploads/<?php echo $produk['gambar_produk']; ?>" alt="Product Image">
            </div>
            <div class="product-info">
                <h1><?php echo $produk['nama_produk']; ?></h1>
                <p>Harga: Rp <?php echo number_format($produk['harga_produk'], 0, ',', '.'); ?></p>
                <p>Deskripsi Produk:</p>
                <p><?php echo $produk['deskripsi_produk']; ?></p>
                <!-- <button>Add to Cart</button> -->
            </div>
        </div>
        <a href="javascript:void(0);" onclick="goBack();">Kembali</a>
    </div>
    
    <script>
        function goBack() {
            history.back();
        }
    </script>
</body>
</html>
