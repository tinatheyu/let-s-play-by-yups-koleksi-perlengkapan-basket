<?php
session_start();

// if (!isset($_SESSION['logged_in_user']) && !isset($_COOKIE['username'])) {
//     header("Location: login.php");
//     exit;
// }

// $username = isset($_SESSION['logged_in_user']['email']) ? $_SESSION['logged_in_user']['email'] : htmlspecialchars($_COOKIE['username']);

$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'letsplaybyyups';

$koneksi = mysqli_connect($host, $user, $password, $database);
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$query = "SELECT * FROM tb_newarrival"; // Adjust table name if necessary
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<style>
.table-data {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 18px;
    text-align: left;
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border: 1px solid #ddd; /* Menambahkan border pada seluruh tabel */
}

.table-data th, .table-data td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

.table-data th {
    background-color: #87CEEB;
    color: #ffffff;
}

.table-data td {
    background-color: #ffffff;
}

.table-data tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table-data td a {
    text-decoration: none;
    padding: 5px 10px;
    margin-right: 10px;
    display: inline-block;
}

/* Style for the button container */
.btn {
    background-color: #3281ab; /* Green background */
    color: white; /* White text */
    padding: 10px 20px; /* Padding for the button */
    border: none; /* Remove default border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    text-align: center; /* Center text */
    display: inline-block; /* Inline block to allow margin/padding */
    text-decoration: none; /* Remove link underline */
    font-size: 16px; /* Text size */
    transition: background-color 0.3s, transform 0.3s; /* Smooth transition on hover */
}

/* Style for the button on hover */
.btn:hover {
    background-color: #3281ab; /* Darker green on hover */
    transform: scale(1.05); /* Slightly grow the button */
}

/* Style for the button inside the <button> tag */
.btn a {
    color: white; /* Make sure the link text is white */
    text-decoration: none; /* Remove underline */
}

/* Style for the button when it's focused (for accessibility) */
.btn:focus {
    outline: none; /* Remove default focus outline */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Blue shadow on focus */
}

/* Optional: Style for the button container if needed */
.btn-tambah {
    margin-top: 20px; /* Add space above the button */
}

/* Edit button style */
.btn-edit {
    background-color: #4CAF50; /* Green background */
    color: white; /* White text */
    padding: 8px 16px; /* Padding for the button */
    border: none; /* Remove default border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    text-align: center; /* Center text */
    display: inline-block; /* Inline block to allow margin/padding */
    text-decoration: none; /* Remove link underline */
    font-size: 14px; /* Text size */
    transition: background-color 0.3s, transform 0.3s; /* Smooth transition on hover */
}

/* Hover effect for the Edit button */
.btn-edit:hover {
    background-color: #45a049; /* Darker green on hover */
    transform: scale(1.05); /* Slightly grow the button */
}

/* Delete button style */
.btn-delete {
    background-color: #f44336; /* Red background */
    color: white; /* White text */
    padding: 8px 16px; /* Padding for the button */
    border: none; /* Remove default border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    text-align: center; /* Center text */
    display: inline-block; /* Inline block to allow margin/padding */
    text-decoration: none; /* Remove link underline */
    font-size: 14px; /* Text size */
    transition: background-color 0.3s, transform 0.3s; /* Smooth transition on hover */
}

/* Hover effect for the Delete button */
.btn-delete:hover {
    background-color: #d32f2f; /* Darker red on hover */
    transform: scale(1.05); /* Slightly grow the button */
}

/* Optional: Space between buttons */
.btn-edit, .btn-delete {
    margin-right: 10px;
}


</style>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
        <li>
            <a href="../admin.php">
                <img src="https://img.icons8.com/ios-glyphs/30/ffffff/home.png" alt="Dashboard Icon"/>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="../product/./product.php">
                <img src="https://img.icons8.com/?size=100&id=82774&format=png&color=FFFFFF" width="20" height="20" alt="Products Icon"/>
                <span class="menu-text">Products</span>
            </a>
        </li>
        <li> 
            <a href="newarrival.php">
                <img src="https://img.icons8.com/?size=100&id=FSj4IS5Y13G3&format=png&color=FFFFFF" alt="Reports Icon" width="30" height="30"/>
                <span class="menu-text">New Arrival</span>
            </a>
        </li>
        <li>
            <a href="../admin.php">
                <img src="https://img.icons8.com/ios-glyphs/30/ffffff/settings.png" alt="Orders Icon"/>
                <span class="menu-text">Orders</span>
            </a>
        </li>
        <li>
            <a href="../admin.php">
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
            <h1>New Arrival</h1>
        </div>
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class="bx bx-menu sidebarBtn"></i>
                </div>
            </nav>
            <div>
                <button type="button" class="btn btn-tambah">
                    <a href="tambah-newarrival.php">Tambah</a>
                </button>
                <button type="button" class="btn btn-cetak">
                    <a href="newarrival-cetak.php">Cetak</a>
                </button>
                <table class="table-data">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Tanggal Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                                $foto_path = $row['foto'];
                                $nama_barang = $row['nama_barang'];
                                $kategori = $row['kategori'];
                                $tanggal_barang_masuk = $row['tanggal_barang_masuk'];
                        ?>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td><img src="<?php echo $foto_path; ?>" alt="Product Image" width="50"></td>
                                    <td><?php echo $nama_barang; ?></td>
                                    <td><?php echo $kategori; ?></td>
                                    <td><?php echo $tanggal_barang_masuk; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='7'>Tidak ada produk ditemukan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>

<?php
mysqli_close($koneksi);
?>
