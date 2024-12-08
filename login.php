<?php
session_start();
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi input kosong
    if (empty($email) || empty($password)) {
        echo "<script>
                alert('Email dan password harus diisi!');
                window.location = 'login.php';
              </script>";
        exit;
    }

    $stmt = $koneksi->prepare("SELECT * FROM tb_admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Login berhasil, simpan sesi
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            header('Location: dashboard.php'); // Arahkan ke halaman dashboard
            exit;
        } else {
            // Password salah
            echo "<script>
                    alert('Email atau password salah. Silakan coba lagi.');
                    window.location = 'login.php';
                  </script>";
        }
    } else {
        // Email tidak ditemukan
        echo "<script>
                alert('Email tidak ditemukan. Silakan coba lagi.');
                window.location = 'login.php';
              </script>";
    }

    // Tutup statement
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sun Furniture</title>
  <style>
    /* Global Styling */
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f0f0f0;
      box-sizing: border-box;
    }

    /* Login Container Styling */
    .login-container {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 6px 12px 4px rgba(0, 0, 0, 0.15);
      width: 90%; /* Lebar default */
      max-width: 600px; /* Maksimal lebar */
      min-width: 320px; /* Minimal lebar */
      text-align: center;
      margin: auto;
    }

    .login-container h2 {
      margin-bottom: 20px;
    }

    /* Input Fields Styling */
    input {
      display: block;
      width: 100%;
      margin: 10px 0;
      padding: 10px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    /* Links Styling */
    .links {
      margin-top: 15px;
    }

    .links a {
      color: #007bff;
      text-decoration: none;
    }

    .links a:hover {
      text-decoration: underline;
    }

    /* Error Message Styling */
    .error {
      color: red;
      margin-bottom: 10px;
    }

    /* Snackbar Styling */
    .snackbar {
      visibility: hidden;
      min-width: 250px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 2px;
      padding: 16px;
      position: fixed;
      z-index: 1;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
    }

    .snackbar.show {
      visibility: visible;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    /* Responsiveness */
    @media screen and (min-width: 768px) {
      .login-container {
        width: 50%;
      }
    }

    @media screen and (min-width: 1024px) {
      .login-container {
        width: 40%;
      }
    }

    /* Animations */
    @keyframes fadein {
      from {
        bottom: 0;
        opacity: 0;
      }
      to {
        bottom: 30px;
        opacity: 1;
      }
    }

    @keyframes fadeout {
      from {
        bottom: 30px;
        opacity: 1;
      }
      to {
        bottom: 0;
        opacity: 0;
      }
    }
  </style>
</head>
<body>
  <main>
    <div class="login-container">
      <h2>LOGIN</h2>
      <?php if (isset($error_message)) : ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
      <?php endif; ?>
      <form id="login-form" method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
      </form>
      <div class="links">
        <a href="#">Don't have an account yet?</a><br>
        <a href="signup.php">Register</a>
      </div>
    </div>
    <div id="toast" class="snackbar">Login Di Proses</div>
  </main>

  <script>
    const form = document.getElementById('login-form'); // Pastikan hanya satu deklarasi
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Mencegah default action

        const toast = document.getElementById("toast");
        toast.className = "show";

        setTimeout(() => {
            toast.className = toast.className.replace("show", "");
            form.submit(); // Kirim form secara manual setelah toast
        }, 1000); // Delay 1 detik untuk menampilkan toast
    });
</script>
</body>
</html>
