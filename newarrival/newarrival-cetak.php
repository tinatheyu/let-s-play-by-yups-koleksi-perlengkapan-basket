<?php
include('../koneksi.php');
require_once("../dompdf/autoload.inc.php");

use Dompdf\Dompdf;

// Fungsi untuk mengonversi gambar menjadi base64
function encode_image($image_path) {
    if (file_exists($image_path)) {
        $type = pathinfo($image_path, PATHINFO_EXTENSION);
        $data = file_get_contents($image_path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    } else {
        return null;
    }
}

$dompdf = new Dompdf();
$query = mysqli_query($koneksi, "SELECT * FROM tb_newarrival");
$html = '<center><h3>Data Barang Masuk</h3></center><hr/><br>';
$html .= '<table border="1" width="100%">
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Tanggal Masuk</th>
            </tr>';

$no = 1;
while ($newarrival = mysqli_fetch_array($query)) {
    // Menangani gambar
    $foto_path = $newarrival['foto'];  // Asumsikan 'foto' berisi path gambar
    $foto_html = '';

    // Encode gambar menjadi base64 jika ada gambar
    $encoded_image = encode_image($foto_path);
    $foto_html = $encoded_image ? "<img src='$encoded_image' width='50'/>" : "No Image";

    // Menambahkan baris ke dalam tabel
    $html .= "<tr>
                <td>" . $no . "</td>
                <td>" . $foto_html . "</td>
                <td>" . $newarrival['nama_barang'] . "</td>
                <td>" . $newarrival['kategori'] . "</td>
                <td>" . $newarrival['tanggal_barang_masuk'] . "</td>
            </tr>";
    $no++;
}

$html .= "</table>";

$dompdf->loadHtml($html);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'portrait');

// Rendering dari HTML ke PDF
$dompdf->render();

// Melakukan output file PDF
$dompdf->stream('laporan-transaksi.pdf');
?>
