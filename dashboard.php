<?php
session_start();

// Validasi login melalui sesi
if (!isset($_SESSION['email']) || !isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect ke login jika tidak ada sesi
    exit;
}

// Ambil data sesi
$username = htmlspecialchars($_SESSION['username']); // Mencegah XSS
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
    <h2 class="sidebar-title">Dashboard</h2>
    <ul>
        <li>
            <a href="admin.php">
                <img src="https://img.icons8.com/ios-glyphs/30/ffffff/home.png" alt="Dashboard Icon"/>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="./product/product.php">
                <img src="https://img.icons8.com/?size=100&id=82774&format=png&color=FFFFFF" width="20" height="20" alt="Products Icon"/>
                <span class="menu-text">Products</span>
            </a>
        </li>
        <li> 
            <a href="newarrival/newarrival.php">
                <img src="https://img.icons8.com/?size=100&id=FSj4IS5Y13G3&format=png&color=FFFFFF" alt="Reports Icon" width="30" height="30"/>
                <span class="menu-text">New Arrival</span>
            </a>
        </li>
        <li>
            <a href="orders/orders.php">
                <img src="https://img.icons8.com/ios-glyphs/30/ffffff/settings.png" alt="Orders Icon"/>
                <span class="menu-text">Orders</span>
            </a>
        </li>
        <li>
            <a href="reports.php">
                <img src="https://img.icons8.com/ios-glyphs/30/ffffff/message-group.png" alt="Reports Icon"/>
                <span class="menu-text">Reports</span>
            </a>
        </li>
        <li>
            <a href="logout.php">
                <img src="https://img.icons8.com/ios-glyphs/30/ffffff/exit.png" alt="Logout Icon"/>
                <span class="menu-text">Logout</span>
            </a>
        </li>
    </ul>
</div>
<div class="content">
    <div class="header">
        <h1 id="text"></h1>
        <p id="date"></p>
        <p>Welcome, <?php echo $username; ?>!</p>
    </div>
    <div class="main-content">
            <div class="card">
                <h3>Profile Overview</h3>
                <p>Check your profile details here.</p>
            </div>
            <div class="card">
                <h3>New Messages</h3>
                <p>View your latest messages.</p>
            </div>
            <div class="card">
                <h3>Account Settings</h3>
                <p>Manage your preferences and settings here.</p>
            </div>
        </div>
</div>

    <script>
    function myFunction() {
        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        let date = new Date();
        let jam = date.getHours();
        let tanggal = date.getDate();
        let hari = days[date.getDay()];
        let bulan = months[date.getMonth()];
        let tahun = date.getFullYear();
        let m = date.getMinutes();
        let s = date.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById("date").innerHTML = `${hari}, ${tanggal} ${bulan} ${tahun}, ${jam}:${m}:${s}`;
        requestAnimationFrame(myFunction);
    }

    function checkTime(i) {
        return i < 10 ? "0" + i : i;
    }

    window.onload = function () {
        let date = new Date();
        let jam = date.getHours();
        let textElement = document.getElementById("text");
        if (jam >= 4 && jam <= 10) {
            textElement.textContent = "Selamat Pagi,";
        } else if (jam >= 11 && jam <= 14) {
            textElement.textContent = "Selamat Siang,";
        } else if (jam >= 15 && jam <= 18) {
            textElement.textContent = "Selamat Sore,";
        } else {
            textElement.textContent = "Selamat Malam,";
        }
        myFunction();
    };
</script>
</body>
</html>
