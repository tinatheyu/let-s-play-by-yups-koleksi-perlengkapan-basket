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
            <a href="dashboard.php">
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
            <h1>Hello, Welcome Back!</h1>
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
</body>
</html>
