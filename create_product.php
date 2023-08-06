<?php
session_start();

require_once "koneksi.php";

// Cek session untuk otorisasi, jika tidak valid, redirect ke halaman Login
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Proses form input produk
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaProduk = $_POST["nama_produk"];
    $hargaProduk = $_POST["harga_produk"];
    $deskripsiProduk = $_POST["deskripsi_produk"];
    $gambarProduk = $_FILES["gambar_produk"]["name"];

    // Cek apakah file gambar telah diupload
    if ($_FILES["gambar_produk"]["error"] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["gambar_produk"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        // Cek tipe file gambar (hanya gambar yang diperbolehkan)
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $allowedTypes)) {
            // Pindahkan file gambar ke folder uploads
            move_uploaded_file($_FILES["gambar_produk"]["tmp_name"], $targetFile);

            // Koneksi ke database
            $conn = connectDB();

            // Insert data produk ke tabel produk
            $sql = "INSERT INTO produk (nama_produk, harga_produk, gambar_produk, deskripsi_produk) VALUES ('$namaProduk', '$hargaProduk', '$gambarProduk', '$deskripsiProduk')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Produk berhasil ditambahkan.');</script>";
            } else {
                echo "<script>alert('Gagal menambahkan produk.');</script>";
            }

            $conn->close();
        } else {
            echo "<script>alert('Hanya gambar dengan format JPG, JPEG, PNG, dan GIF yang diperbolehkan.');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload gambar produk.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Create Product</h1>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
            <label>Nama Produk:</label>
            <input type="text" name="nama_produk" required><br><br>
            <label>Harga Produk:</label>
            <input type="text" name="harga_produk" required><br><br>
            <label>Deskripsi Produk:</label>
            <textarea name="deskripsi_produk" rows="4" cols="50" required></textarea><br><br>
            <label>Gambar Produk:</label>
            <input type="file" name="gambar_produk" required><br><br>
            <input type="submit" value="Submit">
        </form>
        <!-- Tombol Kembali ke Dashboard -->
        <a href="dashboard.php" class="back-to-dashboard">Kembali ke Dashboard</a>
    </div>
</body>
</html>
