<?php
include("config.php");
if (isset($_POST["save_buku"])) {
  // isset digunakan untuk mengecek apakah ketika mengakses file ini, dikirimkan data dengan nama "save_siswa" dg method post
  // kita tampung data yang dikirimkan
  $action = $_POST["action"];
  $kode_buku = $_POST["kode_buku"];
  $judul = $_POST["judul"];
  $penulis = $_POST["penulis"];
  $tahun = $_POST["tahun"];
  $harga = $_POST["harga"];
  $stok = $_POST["stok"];

  // menampung file image
  // if (isset($_FILES["image"])) {
  if(!empty($_FILES["image"])){
    // mendapat deskripsi info gambar
    $path = pathinfo($_FILES["image"]["name"]);
    // mengambil ekstensi gambar
    $extension = $path["extension"];
    // rangkai file name
    $filename = $kode_buku."-".rand(1,1000).".".$extension;
    // generate nama file
    // contoh = 111-985.jpg
    // rand() random nilai 1-1000
  }

  // cek aksi-nya
  if ($action == "insert") {
    // sintak untuk insert
    $sql = "insert into buku values ('$kode_buku', '$judul', '$penulis', '$tahun', '$harga', '$stok', '$filename')";
    // proses upload file
    move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");
    // eksekusi perintah sql
    mysqli_query($connect, $sql);
  }else if($action == "update"){
    if (empty($_FILES["image"]["name"])) {
      // mendapat deskripsi info gambar
      $path = pathinfo($_FILES["image"]["name"]);
      // mengambil ekstensi gambar
      $extension = $path["extension"];
      // rangkai file name
      $filename = $kode_buku."-".rand(1,1000).".".$extension;
      // generate nama file
      // contoh = 111-985.jpg
      // rand() random nilai 1-1000

      // ambil data yg di edit
      $sql = "select * from buku where kode_buku = '$kode_buku'";
      $query = mysqli_query($connect,$sql);
      $hasil = mysqli_fetch_array($query);

      if (file_exists("image/".$hasil["image"])) {
        // menghapus gambar yg terdahulu
        unlink("image/".$hasil["image"]);
      }
      // upload gambar
      move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");
      // sintak untuk update
      $sql = "update buku set judul ='$judul',
      penulis='$penulis', tahun = '$tahun', harga='$harga', stok='$stok' image = '$filename' where kode_buku = '$kode_buku'";
    }else {
      // sintak untuk update
      $sql = "update buku set judul ='$judul',
      penulis='$penulis', tahun = '$tahun', harga='$harga', stok='$stok' image = '$filename' where kode_buku = '$kode_buku'";
    }
  // eksekusi
  mysqli_query($connect, $sql);
}
  // header("location:siswa.php");
  header("location:buku.php");
}

if (isset($_GET["hapus"])) {

  $kode_buku = $_GET["kode_buku"];
  $sql = "select * from buku where kode_buku = '$kode_buku'";
  $query = mysqli_query($connect, $sql);
  $hasil = mysqli_fetch_array($query);
  if (file_exists("image/".$hasil["image"])) {
    unlink("image/".$hasil["image"]);
  }
  $sql = "delete from buku where kode_buku='$kode_buku'";


  mysqli_query($connect, $sql);

  // direct ke halaman siswa
  header("location:buku.php");
}
 ?>
