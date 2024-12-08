<?php
session_start();
include 'koneksi.php'; // Pastikan file ini memuat koneksi database $koneksi

// Cek jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input kosong
    if (empty($email) || empty($username) || empty($password)) {
        echo "<script>
                alert('Pastikan Anda mengisi semua data!');
                window.location = 'signup.php';
              </script>";
        exit;
    }

    // Hash password sebelum disimpan
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Cek apakah email sudah terdaftar
    $stmt = $koneksi->prepare("SELECT * FROM tb_admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Email sudah terdaftar!');
                window.location = 'signup.php';
              </script>";
        exit;
    }

    // Simpan data pengguna ke database
    $stmt = $koneksi->prepare("INSERT INTO tb_admin (email, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat registrasi.');
                window.location = 'signup.php';
              </script>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signup.css"/>
</head>
<body>
    <div class="signup-container">
        <h2>Buat Akun Anda</h2>
        <form method="POST" action="signup.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Kata Sandi:</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">Saya menyetujui <a href="#">kebijakan privasi</a> dan <a href="#">ketentuan penggunaan</a> Let's Play</label><br><br>

            <button type="submit">Buat Akun</button>
        </form>
        <p>Sudah memiliki akun? <a href="login.php">Masuk di sini</a></p>

        <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    </div>
</body>
</html>
