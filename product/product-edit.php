<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'letsplaybyyups';

$koneksi = mysqli_connect($host, $user, $password, $database);
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Cek jika ada ID produk untuk edit
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Ambil data produk berdasarkan ID
    $query = "SELECT * FROM tb_produk WHERE id_produk = '$id_produk'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $produk = mysqli_fetch_assoc($result);
    } else {
        echo "Produk tidak ditemukan!";
        exit;
    }
}

// Proses pembaruan data produk
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    
    // Validasi harga
    if (!is_numeric($harga)) {
        echo "Harga harus berupa angka.";
        exit;
    }

    // Proses upload gambar jika ada
    $target_dir = "assets/";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $file_name = basename($_FILES["foto"]["name"]);
        $file_name = preg_replace("/[^a-zA-Z0-9\-_\.]/", "_", $file_name);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                // Menggunakan foto baru jika di-upload
                $foto = $target_file;
            } else {
                echo "Gagal mengupload gambar.";
                exit;
            }
        } else {
            echo "Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.";
            exit;
        }
    } else {
        // Jika tidak ada file foto, gunakan foto yang sudah ada
        $foto = $produk['foto'];
    }

    // Update data produk ke database
    $query_update = "UPDATE tb_produk SET 
                        foto = '$foto', 
                        nama_barang = '$nama_barang', 
                        kategori = '$kategori', 
                        keterangan = '$keterangan', 
                        harga = '$harga' 
                    WHERE id_produk = '$id_produk'";

if (mysqli_query($koneksi, $query_update)) {
    header("Location: product.php"); // Redirect setelah berhasil
    exit();
} else {
    echo "Error: " . mysqli_error($koneksi);
}
}

mysqli_close($koneksi);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<style>
        /* Styling for card */
        .card {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .card-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            background-color: #87CEEB;
            color: #fff;
            padding: 10px;
            border-radius: 6px 6px 0 0;
            text-align: left;
        }

        .card-body {
            padding: 15px;
        }

        form label {
    display: block;
    margin: 10px 0 5px;
    font-size: 14px;
    font-weight: bold;
    text-align: left; /* Membuat teks label rata kiri */
}

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Button styles */
        form button {
            background-color: #87CEEB;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #4c9ed9;
        }

        /* Style for file input */
        input[type="file"] {
            display: inline-block;
            padding: 10px;
            margin-bottom: 15px;
        }

        .foto-preview {
            max-width: 150px;
            margin-top: 10px;
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
            <a href="./product/product.php">
                <img src="https://img.icons8.com/?size=100&id=82774&format=png&color=FFFFFF" width="20" height="20" alt="Products Icon"/>
                <span class="menu-text">Products</span>
            </a>
        </li>
        <li> 
            <a href="../newarrival/./newarrival.php">
                <img src="https://img.icons8.com/?size=100&id=FSj4IS5Y13G3&format=png&color=FFFFFF" alt="Reports Icon" width="30" height="30"/>
                <span class="menu-text">New Arrival</span>
            </a>
        </li>
        <li>
            <a href="../index.php">
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
            <h1>Edit Product</h1>
        </div>

        <div class="card">
            <div class="card-header">Edit Produk</div>
            <div class="card-body">
            <form action="product-edit.php?id=<?php echo $produk['id_produk']; ?>" method="post" enctype="multipart/form-data">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                    <?php if ($produk['foto']) { ?>
                        <img src="<?php echo $produk['foto']; ?>" class="foto-preview" alt="Foto Produk">
                    <?php } ?>

                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" value="<?php echo $produk['nama_barang']; ?>" required>

                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" value="<?php echo $produk['kategori']; ?>" required>

                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" value="<?php echo $produk['keterangan']; ?>" required>

                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" value="<?php echo $produk['harga']; ?>" required>

                    <button type="submit" class="btn btn-simpan">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<!-- mysqli_close($koneksi);  // Pastikan ini hanya dipanggil sekali
?> -->