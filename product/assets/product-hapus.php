<?php

include '';
$id = $_GET['id'];
$sql = "DELETE FROM categories WHERE id = '$id'";
$result = mysqli_query($koneksi, $sql);
if ($result) {
    echo "
            <script>
                alert('Data Berhasil Dihapus');
                window.location = 'categories.php';
            </script>
        ";
}


