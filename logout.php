<!-- // logout.php -->
<?php
session_start();
if (isset($_GET["confirm"])) {
    if ($_GET["confirm"] === "true") {
        // Proses logout
        session_destroy();
        header("Location: index.php");
        exit();
    } else {
        // Jika pengguna membatalkan, kembalikan ke halaman dashboard
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <link rel="stylesheet" type="text/css" href="css/logout.css">
</head>
<body>
    <h1>Apakah Anda yakin ingin logout?</h1><br/>
    <p></p>
    <a class="logout" href="logout.php?confirm=true">Ya, Logout</a>
    <a href="logout.php?confirm=false">Batal</a>
</body>
</html>
