<?php
session_start();

require_once "koneksi.php";

// Proses buat akun
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $konfirmasi_password = $_POST["konfirmasi_password"];

    // Validasi format email
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $error = "Format Username harus dalam bentuk Email";
    } elseif (strlen($username) < 6) {
        $error = "Panjang Username minimal 6 karakter";
    }

    // Validasi panjang nama
    if (strlen($nama) < 3) {
        $error = "Panjang nama minimal 3 karakter";
    }

    // Validasi kombinasi karakter password
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $password)) {
        $error = "Password harus terdiri dari setidaknya 8 karakter, dengan setidaknya satu huruf kecil, satu huruf besar, dan satu angka";
    }

    // Validasi konfirmasi password
    if ($password !== $konfirmasi_password) {
        $error = "Konfirmasi password tidak cocok";
    }

    // Jika tidak ada error, lanjutkan proses pembuatan akun
    if (!isset($error)) {
        // Koneksi ke database
        $conn = connectDB();

        // Periksa ketersediaan username
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $error = "Username sudah digunakan";
        } else {
            // Simpan data baru ke tabel users
            $sql = "INSERT INTO users (nama, username, password) VALUES ('$nama', '$username', '$password')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION["username"] = $username;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Gagal membuat akun";
            }
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buat Akun</title>
    <link rel="icon" type="image/png" href="logo/logo_icon.png">
    <link rel="stylesheet" type="text/css" href="css/buat_akun.css">
</head>
<body>
    <div class="buat">
        <!-- <h1>Buat Akun</h1> -->
        <img src="logo/logo_login.png" alt="Logo" class="logo-image">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama" required><br><br>
            <label>Username:</label>
            <input type="text" name="username" required><br><br>
            <label>Password:</label>
            <input type="password" name="password" required><br><br>
            <label>Konfirmasi Password:</label>
            <input type="password" name="konfirmasi_password" required><br><br>
            <input type="submit" value="Buat Akun">
            <br/>
            <a href="index.php"><button type="button">Batal</button></a>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
    </div>
</body>
</html>
