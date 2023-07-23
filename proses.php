<?php
session_start();
require_once "koneksi.php";

// Fungsi untuk menghitung total pembayaran
function calculateTotalPayment() {
    $total = 0;
    if (isset($_SESSION["order_summary"])) {
        foreach ($_SESSION["order_summary"] as $item) {
            $total += $item["harga_produk"] * $item["quantity"];
        }
    }
    return $total;
}

// Fungsi untuk membuat nomor order secara acak
function generateOrderNumber() {
    // Generate nomor order dengan format tertentu, misalnya timestamp + angka acak
    return time() . mt_rand(1000, 9999);
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

// Set session order_id sebagai default value
$order_id = null;

// Simpan informasi pesanan ke database (tabel order dan order_detail)
if (isset($_POST["bayar"]) && !empty($_SESSION["order_summary"])) {
    // Koneksi ke database
    $conn = connectDB();

    // Insert data pesanan ke tabel order
    $username = $_SESSION["username"];
    $namaLengkap = getFullName($username);
    $total_pembayaran = calculateTotalPayment();
    $order_number = generateOrderNumber();

    $sql = "INSERT INTO `order` (order_number, username, total_pembayaran) VALUES ('$order_number', '$username', '$total_pembayaran')";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        // Insert data detail pesanan ke tabel order_detail
        foreach ($_SESSION["order_summary"] as $item) {
            $product_id = $item["id"];
            $quantity = $item["quantity"];
            $harga_satuan = $item["harga_produk"];
            $subtotal = $harga_satuan * $quantity;

            $sql = "INSERT INTO `order_detail` (order_id, product_id, quantity, harga_satuan, subtotal) VALUES ('$order_id', '$product_id', '$quantity', '$harga_satuan', '$subtotal')";
            $conn->query($sql);
        }

        // Hapus data pesanan dari session order_summary karena pesanan telah berhasil disimpan ke database
        unset($_SESSION["order_summary"]);

        // Set order_id ke dalam session untuk digunakan di halaman order_success.php
        $_SESSION["order_id"] = $order_id;

        // Redirect ke halaman order_success dengan mengirimkan id order
        header("Location: order_success.php");
        exit();
    }

    $conn->close();
}
?>
