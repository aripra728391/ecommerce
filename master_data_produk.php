<?php
session_start();

require_once "koneksi.php";

// Cek session untuk otorisasi, jika tidak valid, redirect ke halaman Login
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Koneksi ke database
$conn = connectDB();

// Proses pencarian berdasarkan nama produk
$searchKeyword = "";
if (isset($_GET['search'])) {
    $searchKeyword = $_GET['search'];
    $searchQuery = "SELECT * FROM produk WHERE nama_produk LIKE '%$searchKeyword%' ORDER BY `nama_produk` ASC";
    $result = $conn->query($searchQuery);
} else {
    $result = $conn->query("SELECT * FROM produk ORDER BY `nama_produk` ASC");
}

// Tampilkan data produk
$dataProduk = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dataProduk[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produk</title>
    <link rel="icon" type="image/png" href="logo/logo_icon.png">
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
    <link rel="stylesheet" type="text/css" href="css/master_data_produk.css">
</head>
<body>
    <header>
        <!-- Navbar -->
        <nav>
            <div class="container1">
                <!-- Menu -->
                
                <table>
                    <tr>
                        <td>
                            <div class="logo-container">
                                <!-- Logo -->
                                <a class="logo" href="dashboard.php"><img src="logo/logo2.png" alt="Logo"></a>
                            </div>
                        </td>
                        <td>
                            <ul class="menu">
                                <li><a href="#">Product</a></li>
                                <li><a href="order.php">Pesanan</a></li>
                            </ul>
                        </td>
                        <td>
                            <!-- Logout Button -->
                            <a class="logout" href="dashboard.php?logout=true">Logout</a>
                            <!-- <a class="logout" href="logout.php">Logout</a> -->
                        </td>
                    </tr>
                </table>
                            
                            
            </div>
        </nav>
    </header>
    <div class="container">
        <h1>Produk</h1>

        <!-- <a href="create_product.php" class="add-product">Tambah Produk</a> -->
        <!-- Form Pencarian -->
        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="search" placeholder="Cari Nama Produk" value="<?php echo $searchKeyword; ?>">
            <button type="submit">Cari</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProduk as $produk) { ?>
                <tr>
                    <td><?php echo $produk['id']; ?></td>
                    <td><a href="detail_produk.php?id=<?php echo $produk['id']; ?>"><?php echo $produk['nama_produk']; ?></a></td>
                    <td>Rp <?php echo number_format($produk['harga_produk'], 0, ',', '.'); ?></td>
                    <td><img src="uploads/<?php echo $produk['gambar_produk']; ?>" alt="Gambar Produk"></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- <a href="dashboard.php">Kembali ke Dashboard</a> -->
    </div>
</body>
</html>
