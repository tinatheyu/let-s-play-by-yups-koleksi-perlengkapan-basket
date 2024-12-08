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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    
    // Validasi harga: pastikan angka
    if (!is_numeric($harga)) {
        echo "Harga harus berupa angka.";
        exit;  // Hentikan eksekusi jika validasi gagal
    }

    // Handle file upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        // Menentukan folder tujuan
        $target_dir = "assets/";
    
        // Mendapatkan nama file dan memastikan nama file valid
        $file_name = basename($_FILES["foto"]["name"]);
        // Menghapus spasi atau karakter ilegal lainnya dari nama file
        $file_name = preg_replace("/[^a-zA-Z0-9\-_\.]/", "_", $file_name);  // Menggantikan karakter non-alfanumerik dengan underscore
    
        $target_file = $target_dir . $file_name;
    
        // Memeriksa ekstensi file untuk memastikan hanya gambar yang diizinkan
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Pastikan folder assets ada dan dapat ditulis
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);  // Membuat folder jika tidak ada
            }
    
            // Memindahkan file ke folder yang dituju
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                // Menyimpan data ke database
                $query = "INSERT INTO tb_produk (foto, nama_barang, kategori, keterangan, harga) 
                          VALUES ('$target_file', '$nama_barang', '$kategori', '$keterangan', '$harga')";
    
                if (mysqli_query($koneksi, $query)) {
                    // Redirect setelah berhasil
                    header("Location: product.php");
                    exit();
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        echo "No file uploaded or there was an error with the file.";
    }
}

mysqli_close($koneksi); // Koneksi database ditutup setelah proses selesai
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
.btn-tambah {
    background-color: #87CEEB;
    color: rgb(255, 250, 250);
    border-radius: 6px;
    padding: 5px 10px;
    font-size: 14px;
    text-decoration: none;
}

.btn-edit:hover {
    background-color: #ff8c00;
}

/* Style the form container */
.card {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

/* Style the card header */
.card-header {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 15px;
    background-color: #87CEEB;
    color: #fff;
    padding: 10px;
    border-radius: 6px 6px 0 0;
}

/* Style the form labels and inputs */
form label {
    display: block; /* Ensure labels are displayed above the inputs */
    margin: 10px 0 5px; /* Add spacing above and below the label */
    font-size: 14px;
    font-weight: bold;
}

form input, form select {
    width: 100%; /* Ensure inputs take the full width */
    padding: 10px;
    margin-bottom: 15px; /* Add space between input fields */
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

form button {
    background-color: #87CEEB;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    display: inline-block;
    text-align: left;
    margin-top: 10px;
}

form button:hover {
    background-color: #4c9ed9; /* Slightly darker on hover */
}

/* Optional: Style the submit button when focused */
form button:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Optional: Style for the form container */
.card-body {
    padding: 15px;
}

/* Style for file input */
input[type="file"] {
    display: inline-block;
    padding: 10px;
}

/* Style the form container */
.card {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

/* Style the card header */
.card-header {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 15px;
    background-color: #87CEEB;
    color: #fff;
    padding: 10px;
    border-radius: 6px 6px 0 0;
}

/* Style the form container */
form {
    display: flex;
    flex-wrap: wrap; /* Allow fields to wrap to new lines */
    gap: 20px; /* Add spacing between fields */
}

/* Style each form input group (label + input) */
form .input-group {
    flex: 1 1 45%; /* 2 columns with equal width */
    min-width: 250px; /* Ensure inputs don’t become too small */
}

/* Style the form labels */
form label {
    display: block;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 5px;
    text-align: left; /* Align text to the left */
}

/* Style the form inputs */
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
    display: inline-block;
    text-align: center;
    margin-top: 10px;
}

form button:hover {
    background-color: #4c9ed9;
}

/* Optional: Style for file input */
input[type="file"] {
    display: inline-block;
    padding: 10px;
}

</style>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="dashboard.php"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/home.png"/> Home</a></li>
            <li><a href="product/product.php"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/user.png"/> Product</a></li>
            <li><a href="categories/categories.php"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/settings.png"/> Category</a></li>
            <li><a href="newarrival/newarrival.php"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/message-group.png"/> New Arrival</a></li>
            <li><a href="index.php"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/exit.png"/> Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h1>Tambah Product</h1>
        </div>

        <div class="card">
        <div class="card-header">Tambah Produk</div>
        <div class="card-body">
            <form action="tambah-product.php" method="post" enctype="multipart/form-data">
            
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" accept="image/*" required>

                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" placeholder="Nama Barang" required>

                <label for="kategori">Kategori</label>
                <input type="text" name="kategori" id="kategori" placeholder="kategori" required>

                <label for="keterangan">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" placeholder="Keterangan" required>

                <label for="harga">Harga</label>
                <input type="number" name="harga" id="harga" placeholder="Harga" required>

                <button type="submit" class="btn btn-simpan">Simpan</button>
            </form>
        </div>
    </div>
    </div>
</body>
</html>

<!-- mysqli_close($koneksi);  // Pastikan ini hanya dipanggil sekali
?> -->