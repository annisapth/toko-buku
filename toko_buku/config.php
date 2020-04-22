<?php
// koneksi ke
$host = "localhost";
$username = "root";
$password = "";
$db = "toko_buku";
$connect = mysqli_connect ($host, $username, $password, $db);

// cek koneksi database
if (mysqli_connect_errno()){
  // menampilkan pesan error ketika koneksi gagal
  echo mysqli_connect_error();
}else{
  echo "Koneksi Berhasil";
}
 ?>
