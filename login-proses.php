<?php
session_start();
include 'koneksi.php'; // Pastikan file ini memuat $koneksi

// Ambil data dari form login
$email = $_POST['email-login'];
$password = $_POST['password-login'];

// Validasi input kosong
if (empty($email) || empty($password)) {
    echo "
        <script>
            alert('Email dan password harus diisi!');
            window.location = 'login.php';
        </script>
    ";
    exit;
}

// Ambil data pengguna dari database berdasarkan email
$stmt = $koneksi->prepare("SELECT * FROM tb_admin WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $row['password'])) {
        // Login berhasil
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        header('Location: dashboard.php'); // Arahkan ke halaman admin
        exit;
    } else {
        // Password salah
        echo "
            <script>
                alert('Email atau password salah. Silakan coba lagi.');
                window.location = 'login.php';
            </script>
        ";
    }
} else {
    // Email tidak ditemukan
    echo "
        <script>
            alert('Email tidak ditemukan. Silakan coba lagi.');
            window.location = 'login.php';
        </script>
    ";
}

// Tutup statement
$stmt->close();
?>
