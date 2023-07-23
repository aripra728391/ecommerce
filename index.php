<?php
session_start();

require_once "koneksi.php";
if (isset($_SESSION["username"])) {
    header("Location: dashboard.php");
    exit();
}
// else {
//     header("Location: dashboard.php");
//     exit();
// }
// Proses validasi login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Koneksi ke database
    $conn = connectDB();

    // Gunakan prepared statements untuk menghindari SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Login berhasil
        $_SESSION["username"] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        // Login gagal
        echo "<script>alert('Login gagal. Periksa kembali username dan password.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="icon" type="image/png" href="logo/logo_icon.png">
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    <div  class="login">
        <img src="logo/logo_login.png" alt="Logo" class="logo-image">
    <br/>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label>Username:</label>
        <input type="text" name="username"><br><br>
        <label>Password:</label>
        <input type="password" name="password"><br><br>
        <input type="submit" value="Login">
        <a href="buat_akun.php"><button type="button">Buat Akun</button></a>
    </form>
    </div>
</body>
</html>
