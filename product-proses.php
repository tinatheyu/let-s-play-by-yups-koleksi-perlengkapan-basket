<?php
include '../koneksi.php'; // Include the database connection

session_start();
if ($_SESSION['username'] == null) {
    header('location:../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hapus'])) {
        $id = $_POST['id'];

        // Fetch product data to delete the associated image
        $sqlSelect = "SELECT foto FROM tb_produk WHERE id = '$id'";
        $resultSelect = mysqli_query($conn, $sqlSelect);
        $product = mysqli_fetch_assoc($resultSelect);

        if ($product) {
            // Delete product image from the server if it exists
            $fotoPath = '../img_products/' . $product['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }

            // Delete product from the database
            $sqlDelete = "DELETE FROM tb_produk WHERE id = '$id'";
            if (mysqli_query($conn, $sqlDelete)) {
                echo "
                <script>
                    alert('Produk berhasil dihapus!');
                    window.location = 'product.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Gagal menghapus produk!');
                    window.location = 'product.php';
                </script>
                ";
            }
        } else {
            echo "
            <script>
                alert('Produk tidak ditemukan!');
                window.location = 'product.php';
            </script>
            ";
        }
    } elseif (isset($_POST['tidak'])) {
        // Redirect back if the user cancels the deletion
        header('Location: product.php');
        exit();
    }
} else {
    header('Location: product.php');
    exit();
}
?>
