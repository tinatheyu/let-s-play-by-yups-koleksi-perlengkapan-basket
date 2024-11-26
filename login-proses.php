<?php
session_start();

// Cek apakah form login sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);

    // Cek apakah email valid
    if (!$email) {
        $_SESSION['login_error'] = "Invalid email format!";
        header("Location: login.php");
        exit;
    }

    // Simulasi data pengguna (seharusnya data pengguna ada di database)
    $users = [
        'ueka@gmail.com' => [
            'name' => 'Eka kakakakkakk',
            'password' => password_hash('123', PASSWORD_DEFAULT), // Password terenkripsi
        ],
    ];

    // Validasi pengguna dan password
    if (isset($users[$email])) {
        if (password_verify($password, $users[$email]['password'])) {
            // Login berhasil: Set session untuk pengguna yang login
            $_SESSION['logged_in_user'] = [
                'email' => $email,
                'name' => $users[$email]['name'],
            ];

            // Set cookie jika diperlukan
            setcookie('username', $email, time() + 3600, "/"); // Cookie 1 jam

            // Redirect ke dashboard setelah login sukses
            header("Location: dashboard.php");
            exit;
        } else {
            // Password salah
            $_SESSION['login_error'] = "Invalid email or password!";
            header("Location: login.php");
            exit;
        }
    } else {
        // Email tidak ditemukan
        $_SESSION['login_error'] = "User not found!";
        header("Location: login.php");
        exit;
    }
} else {
    // Akses langsung ke file login-process.php tanpa POST
    header("Location: login.php");
    exit;
}
?>
