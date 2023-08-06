<?php
session_start();

require_once "koneksi.php";

// Cek session untuk otorisasi, jika tidak valid, redirect ke halaman Login
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Ambil nama pengguna dari database
$username = $_SESSION["username"];
$conn = connectDB();
$sql = "SELECT nama FROM users WHERE username = '$username'";
$result = $conn->query($sql);
$nama = "";
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nama = $row["nama"];
}
$conn->close();

function getOrder($username) {
    $conn = connectDB();
    $sql = "SELECT * FROM `order` WHERE username = '$username' ORDER BY `tanggal_order` DESC";
    $result = $conn->query($sql);
    $order = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $order[] = $row;
        }
    }

    $conn->close();
    return $order;
}
$order = getOrder($username);
// Proses logout
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="logo/logo_icon.png">
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
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
                                <a class="logo" href="#"><img src="logo/logo2.png" alt="Logo"></a>
                            </div>
                        </td>
                        <td>
                            <ul class="menu">
                                <li><a href="master_data_produk.php">Product</a></li>
                                <li><a href="order.php">Pesanan</a></li>
                                <?php
                                    if ($username == 'admin') {
                                ?>
                                <li><a href="create_product.php">Input Product</a></li>
                                <?php
                                    } 
                                ?>
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


    <main>
        <section class="banner">
            <div class="container">
                <h1>Selamat Datang, <?php echo $nama; ?></h1>
                <p>Disini kamu dapat berbelanja apapun yang kamu mau.</p>
            </div>
        </section>

        <?php
                $totalPesanan = 0
                ?>
        <section class="content">
            <div class="container">
                <!-- Content section -->
                <h2>Daftar Pesanan</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                        <th>Tanggal Order</th>
                        <th>Nomor Order</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($order) {
                    foreach ($order as $item) {
                        $totalPesanan += $item["total_pembayaran"];
                ?>
                        <tr>
                            <td><?php echo $item["order_id"]; ?></td>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($item["tanggal_order"])); ?></td>
                            <td><a href="order_success.php?id=<?php echo $item["order_id"]; ?>"><?php echo $item["order_number"]; ?></a></td>
                            <!-- <td><?php echo $item["order_number"]; ?></td> -->
                            <td>Rp <?php echo number_format($item["total_pembayaran"], 0, ',', '.'); ?></td>
                        </tr>
                <?php
                    } 
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th/>
                        <th colspan="2">Total :</th>
                        <th class="total_akhir">Rp <?php echo number_format($totalPesanan, 0, ',', '.'); ?></th>
                    </tr>
                </tfoot>
                </table>
            </div>
        </section>
    </main>

    <footer>
        <!-- Footer -->
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Kelompok 3 Y6C.</p>
            <!-- Date and Time -->
            <div class="datetime" id="datetime"></div>
        </div>
    </footer>
    <script>
        // Update date and time every second
        setInterval(updateDateTime, 1000);

        function updateDateTime() {
            var dateTimeElement = document.getElementById("datetime");
            var currentDateTime = new Date().toLocaleString();
            dateTimeElement.textContent = currentDateTime;
        }
    </script>
</body>
</html>
