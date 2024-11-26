<?php
session_start();

// Menangani pengiriman form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $dob = $_POST['dob'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $terms = isset($_POST['terms']) ? $_POST['terms'] : false;

    // Cek apakah password dan konfirmasi password cocok
    if ($password !== $confirmPassword) {
        $error_message = "Kata sandi dan konfirmasi kata sandi tidak cocok!";
    } else {

        // Redirect ke halaman login setelah berhasil mendaftar
        $_SESSION['temp_user'] = $email;  // Menyimpan sementara info pengguna
        
        // Redirect ke login page setelah pendaftaran berhasil
        header('Location: login.php');
        exit();
    }
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
            
            <label for="firstname">Nama Depan:</label>
            <input type="text" id="firstname" name="firstname" required><br><br>
            
            <label for="lastname">Nama Belakang:</label>
            <input type="text" id="lastname" name="lastname" required><br><br>
            
            <label>Tanggal Lahir:</label>
            <label for="dob">Tanggal Lahir (dd/mm/yyyy):</label>
            <input type="text" id="dob" name="dob" placeholder="Contoh: 25/12/2023" required><br><br>

            <label for="password">Kata Sandi:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="confirm-password">Konfirmasi Kata Sandi:</label>
            <input type="password" id="confirm-password" name="confirm-password" required><br><br>

            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">Saya menyetujui <a href="#">kebijakan privasi</a> dan <a href="#">ketentuan penggunaan</a> Let's Play</label><br><br>

            <button type="submit">Buat Akun</button>
        </form>
        <p>Sudah memiliki akun? <a href="login.php">Masuk di sini</a></p>

        <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    </div>
</body>
</html>
