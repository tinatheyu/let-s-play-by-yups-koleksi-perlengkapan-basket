<?php
session_start();
include 'koneksi.php'; // Pastikan file ini memuat koneksi database $koneksi

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Validasi input
if (empty($email) || empty($username) || empty($password)) {
    echo "
        <script>
            alert('Pastikan Anda mengisi semua data!');
            window.location = 'signup.php';
        </script>
    ";
    exit;
}

if ($password !== $passwordConfirmation) {
    echo "
        <script>
            alert('Password dan konfirmasi password tidak cocok!');
            window.location = 'signup.php';
        </script>
    ";
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);


$stmt = $koneksi->prepare("INSERT INTO tb_admin (email, password, username) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $hashedPassword, $username);

if ($stmt->execute()) {
    echo "
        <script>
            alert('Registrasi berhasil! Silakan login.');
            window.location = 'login.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Terjadi kesalahan saat registrasi.');
            window.location = 'signup.php';
        </script>
    ";
}

$stmt->close();
?>
