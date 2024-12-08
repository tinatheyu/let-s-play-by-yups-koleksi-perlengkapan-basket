<?php

// Memasukkan file koneksi.php untuk koneksi database
include '../koneksi.php';  // Pastikan path-nya benar

// Ambil ID produk dari parameter URL
$id = $_GET['id'];

// Pastikan ID ada dan valid
if (isset($id) && is_numeric($id)) {
    // Query untuk menghapus data produk
    $sql = "DELETE FROM tb_produk WHERE id_produk = '$id'";  // Pastikan nama kolom di database sesuai
    $result = mysqli_query($koneksi, $sql);  // Eksekusi query

    // Cek apakah query berhasil
    if ($result) {
        echo "
            <script>
                alert('Data Berhasil Dihapus');
                window.location = 'product.php';
            </script>
        ";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "ID produk tidak valid!";
}

?>
