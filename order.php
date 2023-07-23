<?php
session_start();
require_once "koneksi.php";

// Cek session untuk otorisasi, jika tidak valid, redirect ke halaman Login
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

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

// Cek apakah ada data yang dikirimkan melalui form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses data yang dikirimkan dari form
    if (isset($_POST["product_id"]) && isset($_POST["quantity"])) {
        $productID = $_POST["product_id"];
        $quantity = (int)$_POST["quantity"];

        // Ambil data produk dari database
        $products = getProducts();

        // Cari produk berdasarkan ID
        $selectedProduct = null;
        foreach ($products as $product) {
            if ($product["id"] == $productID) {
                $selectedProduct = $product;
                break;
            }
        }

        // Jika produk ditemukan, tambahkan ke order summary
        if ($selectedProduct) {
            $selectedProduct["quantity"] = $quantity;
            $_SESSION["order_summary"][] = $selectedProduct;
        }
    }
}

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

// Ambil data produk dari database
$products = getProducts();

// Hapus item dari order summary jika parameter remove ada di URL
if (isset($_GET["remove"])) {
    $itemIDToRemove = $_GET["remove"];
    if (isset($_SESSION["order_summary"])) {
        foreach ($_SESSION["order_summary"] as $key => $item) {
            if ($item["id"] == $itemIDToRemove) {
                unset($_SESSION["order_summary"][$key]);
                break;
            }
        }
    }
    header("Location: order.php");
    exit();
}

?>

<!-- Berikutnya adalah bagian HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Order Produk</title>
    <link rel="icon" type="image/png" href="logo/logo_icon.png">
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
    <link rel="stylesheet" type="text/css" href="css/order.css">
</head>
<body>
    <div class="container">
        <h1>Order Produk</h1>

        <!-- Form untuk memilih produk dan memasukkan kuantitas pesanan -->
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="product">Pilih Produk:</label>
            <select name="product_id" id="product">
                <?php foreach ($products as $product) : ?>
                    <option value="<?php echo $product["id"]; ?>"><?php echo $product["nama_produk"]; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="quantity">Kuantitas:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="1">

            <input type="submit" value="Order">
        </form>

        <!-- Order Summary -->
        <h2>Order Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Kuantitas</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION["order_summary"])) {
                    foreach ($_SESSION["order_summary"] as $item) :
                        $subtotal = $item["harga_produk"] * $item["quantity"];
                ?>
                        <tr>
                            <td><?php echo $item["nama_produk"]; ?></td>
                            <td><?php echo $item["quantity"]; ?></td>
                            <td>Rp <?php echo number_format($item["harga_produk"], 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                            <td><a href="order.php?remove=<?php echo $item["id"]; ?>">Hapus</a></td>
                        </tr>
                <?php
                    endforeach;
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Pembayaran:</th>
                    <th>Rp <?php echo number_format(calculateTotalPayment(), 0, ',', '.'); ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <!-- Tombol Bayar -->
        <?php if (!empty($_SESSION["order_summary"])) : ?>
            <form method="post" action="proses.php">
                <input type="submit" name="bayar" value="Bayar">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
