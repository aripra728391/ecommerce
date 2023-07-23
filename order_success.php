<?php
session_start();
require_once "koneksi.php";

// Fungsi untuk mengambil data produk dari tabel produk di database
function getProducts() {
    $conn = connectDB();
    $sql = "SELECT * FROM produk";
    $result = $conn->query($sql);
    $products = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    $conn->close();
    return $products;
}

// Fungsi untuk mengambil detail produk berdasarkan ID
function getProductDetail($id) {
    $conn = connectDB();
    $sql = "SELECT * FROM produk WHERE id = '$id'";
    $result = $conn->query($sql);
    $product = null;

    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    }

    $conn->close();
    return $product;
}

// Fungsi untuk mengambil data pemesan berdasarkan order_id
function getOrderData($order_id) {
    $conn = connectDB();
    $sql = "SELECT * FROM `order` WHERE order_id = '$order_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $orderData = $result->fetch_assoc();
    } else {
        $orderData = null;
    }

    $conn->close();
    return $orderData;
}

// Fungsi untuk mengambil data detail pesanan berdasarkan order_id
function getOrderDetail($order_id) {
    $conn = connectDB();
    $sql = "SELECT * FROM `order_detail` WHERE order_id = '$order_id'";
    $result = $conn->query($sql);
    $orderDetail = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orderDetail[] = $row;
        }
    }

    $conn->close();
    return $orderDetail;
}
// Fungsi untuk mengambil nama lengkap dari tabel users berdasarkan username
function getFullName($username) {
    $conn = connectDB();
    $sql = "SELECT nama FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    $fullName = "";

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $fullName = $row["nama"];
    }

    $conn->close();
    return $fullName;
}
// Cek session untuk otorisasi, jika tidak valid, redirect ke halaman Login
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Cek apakah order_id tersedia di session
if ((!isset($_SESSION["order_id"]) || empty($_SESSION["order_id"])) && !isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}
if (isset($_SESSION["order_id"])) {
    $order_id = $_SESSION["order_id"];
}
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
}
// Ambil data dari session
// $order_id = $_SESSION["order_id"];
$username = $_SESSION["username"];

// Ambil data pemesan berdasarkan order_id
$orderData = getOrderData($order_id);

// Ambil data produk dari database
$products = getProducts();

// Ambil data detail pesanan berdasarkan order_id
$orderDetail = getOrderDetail($order_id);

// Ambil data nama lengkap berdasar login
$nama_lengkap = getFullName($username);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <link rel="icon" type="image/png" href="logo/logo_icon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/order_success.css">
</head>
<body>
    <div class="container">
        <h1>Invoice</h1>
        <?php if ($orderData) : ?>
            <h2>Pemesan</h2>
            <p>Nama: <?php echo $nama_lengkap; ?></p>
            <p>Nomor Pesanan: <?php echo $orderData["order_number"]; ?></p>
            <p>Tanggal Pesanan: <?php echo date('d-m-Y H:i:s', strtotime($orderData["tanggal_order"])); ?></p>

            <!-- Order Summary -->
            <h2>Detail Pesanan</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Kuantitas</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalPembayaran = 0;
                    if ($orderDetail) {
                        foreach ($orderDetail as $item) {
                            $product = getProductDetail($item["product_id"]);
                            $subtotal = $item["harga_satuan"] * $item["quantity"];
                            $totalPembayaran += $subtotal;
                    ?>
                            <tr>
                                <td><?php echo $product["nama_produk"]; ?></td>
                                <td><?php echo $item["quantity"]; ?></td>
                                <td>Rp <?php echo number_format($item["harga_satuan"], 0, ',', '.'); ?></td>
                                <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total Pembayaran:</th>
                        <th>Rp <?php echo number_format($totalPembayaran, 0, ',', '.'); ?></th>
                    </tr>
                </tfoot>
            </table>
        <?php else : ?>
            <p>Maaf, data pemesan tidak ditemukan.</p>
        <?php endif; ?>
        <!-- Tombol Kembali ke Dashboard -->
        <a href="dashboard.php">Kembali</a>
    </div>
</body>
</html>
