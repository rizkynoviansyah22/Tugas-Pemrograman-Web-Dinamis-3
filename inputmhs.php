
<?php
include "connection.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Akademik - Input Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<div class="container-sm">
<br>

<ul class="nav justify-content-end">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="inputmhs.php">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="mahasiswa.php">Data Mahasiswa</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="matakuliah.php">Data Matakuliah</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="krsmhs.php">KRS</a>
  </li>
</ul>
<br>

<nav class="navbar" style="background-color: #e3f2fd;">
  Input Data Mahasiswa
</nav>

<form class="row g-3 mt-2" method="POST" action="simpanmhs.php">

  <div class="col-md-6">
    <label for="inputnim" class="form-label">NIM</label>
    <input type="text" class="form-control" name="nim" required
           pattern="[0-9]+" 
           title="NIM harus berupa angka" 
           oninvalid="this.setCustomValidity('Harus diisi ya NIM nya')"
           oninput="this.setCustomValidity('')">
  </div>

  <div class="col-md-6">
    <label for="inputnama" class="form-label">Nama</label>
    <input type="text" class="form-control" name="nama" 
           pattern="[A-Za-z\s]+" 
           title="Nama hanya boleh huruf dan spasi"
           oninvalid="this.setCustomValidity('Harus diisi ya Nama nya')"
           oninput="this.setCustomValidity('')" 
           required>
  </div>

  <div class="col-12">
    <label for="inputalamat" class="form-label">Alamat</label>
    <input type="text" class="form-control" name="alamat" placeholder="1234 Main St">
  </div>

  <div class="col-md-6">
    <label for="inputhp" class="form-label">Nomor HP</label>
    <input type="text" class="form-control" name="nohp" 
           pattern="[0-9]+" 
           title="Nomor HP harus angka saja" 
           required
           oninvalid="this.setCustomValidity('Harus diisi ya')"
           oninput="this.setCustomValidity('')">
  </div>

  <div class="col-md-6">
    <label for="inputemail" class="form-label">Email</label>
    <input type="email" class="form-control" name="email">
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Simpan</button>
  </div>

</form>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</div>
</body>
</html>