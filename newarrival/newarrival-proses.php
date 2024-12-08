<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {
    // Retrieve form data
    $nama_barang = $_POST['detail-nama'];
    $kategori = $_POST['kategori'];
    $tanggal_barang_masuk = $_POST['tanggal_barang_masuk'];

    // Validate if all fields are filled
    if (empty($nama_barang) || empty($kategori) || empty($tanggal_barang_masuk)) {
        echo "
            <script>
                alert('Pastikan Anda Mengisi Semua Data');
                window.location = '../index.php';
            </script>
        ";
    } else {
        // Prepare SQL statement to prevent SQL injection
        $sql = "INSERT INTO tb_newarrival (nama_barang, kategori, tanggal_barang_masuk) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($koneksi, $sql)) {
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "sss", $nama_barang, $kategori, $tanggal_barang_masuk);
            
            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                echo "
                    <script>
                        alert('Transaction Berhasil');
                        window.location = '../index.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Terjadi Kesalahan');
                        window.location = '../index.php';
                    </script>
                ";
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        } else {
            echo "
                <script>
                    alert('Terjadi Kesalahan');
                    window.location = '../index.php';
                </script>
            ";
        }
    }
} else {
    header('Location: ../index.php');
}
?>
