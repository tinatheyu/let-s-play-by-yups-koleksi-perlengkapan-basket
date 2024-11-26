<?php
session_start();

// Validasi login melalui sesi atau cookie
if (!isset($_SESSION['logged_in_user']) && !isset($_COOKIE['username'])) {
    header("Location: login.php"); // Redirect ke login jika tidak ada sesi atau cookie
    exit;
}

// Ambil data pengguna dari sesi atau cookie
$username = isset($_SESSION['logged_in_user']['email']) 
    ? $_SESSION['logged_in_user']['email'] 
    : $_COOKIE['username'];

// Jika menggunakan data sesi, ambil nama pengguna
$user_name = isset($_SESSION['logged_in_user']['name']) 
    ? $_SESSION['logged_in_user']['name'] 
    : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<div class="sidebar">
    <h2>Dashboard</h2>
    <ul>
        <li><a href="dashboard.php"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/home.png"/> Home</a></li>
        <li><a href="#"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/user.png"/> Profile</a></li>
        <li><a href="categories.php"><img src="https://img.icons8.com/?size=100&id=82774&format=png&color=FFFFFF" width="20" height="20"/> Categories</a></li>
        <li><a href="#"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/settings.png"/> Settings</a></li>
        <li><a href="#"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/message-group.png"/> Messages</a></li>
        <li><a href="logout.php"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/exit.png"/> Logout</a></li>
    </ul>
</div>

<div class="content">
    <div class="header">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1> <!-- Tampilkan nama pengguna -->
    </div>

    <div class="main-content">
        <div class="card">
            <h3>Profile Overview</h3>
            <p>Check your profile.</p>
        </div>
        <div class="card">
            <h3>New Messages</h3>
            <p>Check your messages.</p>
        </div>
        <div class="card">
            <h3>Account Settings</h3>
            <p>Manage your preferences here.</p>
        </div>
    </div>
</div>

</body>
</html>
