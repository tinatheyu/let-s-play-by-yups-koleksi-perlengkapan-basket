<?php
session_start();
$error_message = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : null;
unset($_SESSION['login_error']); // Hapus error setelah ditampilkan
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css"/>
</head>

<style>
@keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
}

@keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 0; opacity: 0;}
}
</style>

<body>
<div class="login-container">
      <h2>LOGIN</h2>
      <?php if (isset($error_message)) : ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
      <?php endif; ?>
      <form id="login-form" method="POST" action="login-proses.php">
         <input type="email" name="email" placeholder="Email" required />
         <input type="password" name="password" placeholder="Password" required />
         <button type="submit">Login</button>
      </form>
      <div class="links">
        <a href="#">Don't have an account yet?</a>
        <br />
        <a href="signup.php">Register</a>
      </div>
      <div class="social-signin">
        <p>Or sign in with:</p>
        <button class="social-btn google-btn">Sign in with Google</button>
        <button class="social-btn apple-btn">Sign in with Apple</button>
        <button class="social-btn facebook-btn">Sign in with Facebook</button>
    </div>
</div>

<div id="toast">Login Di Proses</div>

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
