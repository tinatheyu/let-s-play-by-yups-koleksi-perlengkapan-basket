<?php
session_start();
session_destroy(); // Menghancurkan sesi
header("Location: login.php"); // Arahkan kembali ke halaman login
exit;
?>