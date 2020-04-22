<?php
session_start();
if(!isset($_SESSION["id_admin"])){
    header("location:login_admin.php");
}
// memanggil file config.php agar tidak membuat koneksi baru
include ("config.php");
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
 <style media="screen">
    .header{
      height: 500px;
      background: url("header.jpg") no-repeat;
      text-align: center;
      background-size: cover;
      align-content: center;
      background-position: center;
      box-shadow: inset 0 0 0 500px rgba(0, 0, 0, 0.5);
      text-decoration-color:white;
      color: white;
      font-family: serif;
      padding-top: 225px;
      font-size: 100px;
    }
      </style>
   <head>
     <meta charset="utf-8">
     <title>Toko Buku</title>
     <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <script src="assets/js/jquery.min.js"></script>
     <script src="assets/js/bootstrap.min.js"></script>
     <script src="assets/js/popper.min.js"></script>
     <script type="text/javascript">
       Add = () => {
         document.getElementById('action').value = "insert";
         document.getElementById('kode_buku').value = "";
         document.getElementById('judul').value = "";
         document.getElementById('penulis').value = "";
         document.getElementById('tahun').value = "";
         document.getElementById('harga').value = "";
         document.getElementById('stok').value = "";
         document.getElementById('image').value = "";
       }
       Edit = (item) => {
         document.getElementById('action').value = "update";
         document.getElementById('kode_buku').value = "";
         document.getElementById('judul').value = "";
         document.getElementById('penulis').value = "";
         document.getElementById('tahun').value = "";
         document.getElementById('harga').value = "";
         document.getElementById('stok').value = "";
       }
     </script>
   </head>
   <body>
     <?php
     // membuat perintah sql untuk menampilkan data siswa
     if (isset($_POST ["cari"])) {
       // query jika mencari
       $cari = $_POST ["cari"];
       $sql = "select * from buku where
       kode_buku like '%$cari%' or
       judul like '%$cari%' or
       penulis like '%$cari%' or
       tahun like '%$cari%'" ;
     }else {
       // query jika tidak mencari
       $sql = "select * from buku";
     }
     // eksekusi
     $query = mysqli_query($connect, $sql);
      ?>
      <nav class="navbar navbar-expand-md bg-dark
      navbar-dark sticky-top">
      <button type="button" class="navbar-toggler"
      data-toggle="collapse" data-target="#menu">
                  <span class="navbar navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="menu">
                <a href="#">
                    <img src="logo.png" width="75" alt="">
                </a>
                  <ul class="navbar-nav">
                      <li class="nav-item"><a href="buku.php" class="nav-link">Beranda</a></li>
                      <li class="nav-item"><a href="admin.php" class="nav-link">Admin</a></li>
                      <li class="nav-item"><a href="customer.php" class="nav-link">Customer</a></li>
                  </ul>
              </div>
          </nav>

          <div class="header col-12">
            <h1>TOKO BUKU</h1>
          </div>
      <div class="container">
        <!-- start card -->
        <div class="card">
          <div class="card-header bg-secondary text-white">
            <h4>Data Buku</h4>
          </div>
          <div class="card-body">

<!-- BUAT CARIAN -->
<form action="buku.php" method="post">
  <input type="text" name="cari" class="form-control" placeholder="Pencarian">
</form>

            <table class="table" border = "1">
              <thead>
                <tr>
                  <th>Kode Buku</th>
                  <th>Judul</th>
                  <th>Penulis</th>
                  <th>Tahun</th>
                  <th>Harga</th>
                  <th>Stok</th>
                  <th>Foto</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($query as $buku): ?>
                <tr>
                  <td><?php echo $buku ["kode_buku"] ?></td>
                  <td><?php echo $buku ["judul"] ?></td>
                  <td><?php echo $buku ["penulis"] ?></td>
                  <td><?php echo $buku ["tahun"] ?></td>
                  <td><?php echo $buku ["harga"] ?></td>
                  <td><?php echo $buku ["stok"] ?></td>
                  <td>
                    <img src="<?php echo 'image/'.$buku['image'];?>" alt="Foto Buku" width="200"/>
                  </td>
                  <td>
                    <button data-toggle="modal" data-target="#modal_buku" type="button" class="btn btn-sm btn-info"
                      onclick='Edit(<?php echo json_encode($siswa); ?>)'>
                      Edit
                    </button>
                    <a href="proses_buku.php?hapus=true&kode_buku=<?php echo $buku["kode_buku"]; ?>"
                    onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">
                    <button type="button" class="btn btn-sm btn-danger">
                      Hapus
                    </button></a>
                  </td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
            <button data-toggle="modal" data-target="#modal_buku" type="button"
             class="btn btn-sm btn-success"
            onclick="Add()">
              Tambah Data
            </button>
          </div>
        </div>
        <!-- end card -->

        <!-- form modal  -->
        <div class="modal fade" id="modal_buku">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="proses_buku.php"
              method="post" enctype="multipart/form-data">
                <div class="modal-header bg-secondary text-white">
                  <h4>Form Buku</h4>
                </div>
                <div class="modal-body">
                 <input type="hidden" name="action" id="action">
                 Kode Buku
                 <input type="number" name="kode_buku" id="kode_buku" class="form-control" required/>
                 Judul
                 <input type="text" name="judul" id="judul" class="form-control" required/>
                 Penulis
                 <input type="text" name="penulis" id="penulis" class="form-control" required/>
                 Tahun
                 <input type="text" name="tahun" id="tahun" class="form-control" required/>
                 Harga
                 <input type="text" name="harga" id="harga" class="form-control" required/>
                 Stok
                 <input type="number" name="stok" id="stok" class="form-control" required/>
                 Foto
                 <input type="file" name="image" id="image" class="form-control">
               </div>
                <div class="modal-footer">
                  <button type="submit" name="save_buku" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- end form modal -->
      </div>
   </body>
 </html>
