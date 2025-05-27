<?php
// Sertakan koneksi ke database dan fungsi keamanan jika perlu

$idfinance = $_POST["idfinance"];

// Lakukan kueri SQL untuk mendapatkan data berdasarkan idfinance
// Gantilah query berikut sesuai dengan struktur tabel dan nama kolom yang sesuai
$link = mysqli_connect("localhost", "root", "", "dim");
if ($link == false) {
    die(mysqli_connect_error());
}

$query = "SELECT * FROM finance WHERE idfinance = $idfinance";
$result = mysqli_query($link, $query);

if ($row = mysqli_fetch_assoc($result)) {
    // Kirim data dalam format JSON
    echo json_encode($row);
} else {
    echo json_encode(array()); // Kirim objek kosong jika data tidak ditemukan
}

mysqli_close($link);
