<?php
include "connection.php";

$nim_terpilih = isset($_GET['nim']) ? mysqli_real_escape_string($conn, $_GET['nim']) : null;
$id_semester_terpilih = isset($_GET['id_semester']) ? mysqli_real_escape_string($conn, $_GET['id_semester']) : null;

$nama_mahasiswa = "";
$nama_semester = "";
$total_sks_diambil = 0;
$taken_courses_list = array(); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Akademik - KRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<div class="container-sm">
<br>
<ul class="nav justify-content-end">
  <li class="nav-item">
    <a class="nav-link" href="inputmhs.php">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="mahasiswa.php">Data Mahasiswa</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href='matakuliah.php'>Data Matakuliah</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="krsmhs.php">KRS</a>
  </li>
</ul>

<nav class="navbar" style="background-color: #e3f2fd;">
  Pilih Mahasiswa dan Semester
</nav>
<form class="row g-3 mt-2" method="GET" action="krsmhs.php">
  <div class="col-md-5">
    <label for="nim" class="form-label">Mahasiswa</label>
    <select name="nim" class="form-select" required>
      <option value="">-- Pilih Mahasiswa --</option>
      <?php
        $query_mhs = mysqli_query($conn, "SELECT nim, nama FROM mahasiswa ORDER BY nama");
        while($mhs = mysqli_fetch_array($query_mhs)) {
          $selected_mhs = ($mhs['nim'] == $nim_terpilih) ? 'selected' : '';
          echo "<option value='{$mhs['nim']}' $selected_mhs>{$mhs['nim']} - {$mhs['nama']}</option>";
        }
      ?>
    </select>
  </div>
  
  <div class="col-md-5">
    <label for="id_semester" class="form-label">Semester</label>
    <select name="id_semester" class="form-select" required>
      <option value="">-- Pilih Semester --</option>
      <?php
        $query_smt = mysqli_query($conn, "SELECT id_semester, nama_semester, status FROM semester_aktif ORDER BY id_semester");
        while($smt = mysqli_fetch_array($query_smt)) {
          $selected_smt = ($smt['id_semester'] == $id_semester_terpilih) ? 'selected' : '';
          echo "<option value='{$smt['id_semester']}' $selected_smt>{$smt['nama_semester']} ({$smt['status']})</option>";
        }
      ?>
    </select>
  </div>
  
  <div class="col-md-2 d-flex align-items-end">
    <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
  </div>
</form>
<br><br>

<?php
if ($nim_terpilih && $id_semester_terpilih) {
  $detail_mhs = mysqli_fetch_array(mysqli_query($conn, "SELECT nama FROM mahasiswa WHERE nim='$nim_terpilih'"));
  $nama_mahasiswa = $detail_mhs['nama'];
  $detail_smt = mysqli_fetch_array(mysqli_query($conn, "SELECT nama_semester FROM semester_aktif WHERE id_semester='$id_semester_terpilih'"));
  $nama_semester = $detail_smt['nama_semester']; }
?>

  <nav class="navbar" style="background-color: #e3f2fd;">
    <span class="navbar-brand mb-0 h1">KRS Mahasiswa: <?php echo "$nama_mahasiswa ($nim_terpilih)"; ?></span>
    <span class="navbar-text">
      Semester: <?php echo $nama_semester; ?>
    </span>
  </nav>
  
  <h5 class="mt-3">Daftar Mata Kuliah yang Diambil</h5>
  <table class="table">
    <thead>
      <tr><th scope="col">Kode MK</th><th scope="col">Nama Mata Kuliah</th><th scope="col">SKS</th><th scope="col">Action</th></tr>
    </thead>
    <tbody>
      <?php
      $query_krs = mysqli_query($conn, "
          SELECT matakuliah.kode_mk, matakuliah.nama_mk, matakuliah.sks 
          FROM krs
          JOIN matakuliah ON krs.kode_mk = matakuliah.kode_mk
          WHERE krs.nim = '$nim_terpilih' AND krs.id_semester = '$id_semester_terpilih'
      ");

      while($krs_row = mysqli_fetch_array($query_krs)) {
        echo "<tr>";
        echo "<td>{$krs_row['kode_mk']}</td>";
        echo "<td>{$krs_row['nama_mk']}</td>";
        echo "<td>{$krs_row['sks']}</td>
        <td><a href='hapuskrs.php?nim={$nim_terpilih}&id_semester={$id_semester_terpilih}&kode_mk={$krs_row['kode_mk']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus mata kuliah ini?\")'>Hapus</a></td>";
        echo "</tr>";
        $total_sks_diambil += $krs_row['sks']; 
        $taken_courses_list[] = $krs_row['kode_mk']; 
      }

      if(mysqli_num_rows($query_krs) == 0) {
        echo "<tr><td colspan='4' class='text-center'>Belum ada mata kuliah yang diambil.</td></tr>";
      }
      ?>
      <tr class="table-group-divider fw-bold">
        <td colspan="2" class="text-end">Total SKS Diambil:</td>
        <td><?php echo $total_sks_diambil; ?></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <br>

  <h5 class="mt-3">Pilih Mata Kuliah (Batas Maksimal 24 SKS)</h5>
  <form method="POST" action="simpankrs.php">
    <input type="hidden" name="nim" value="<?php echo $nim_terpilih; ?>">
    <input type="hidden" name="id_semester" value="<?php echo $id_semester_terpilih; ?>">

    <table class="table table-hover">
      <thead>
        <tr><th scope="col">Pilih</th><th scope="col">Kode MK</th><th scope="col">Nama Mata Kuliah</th><th scope="col">SKS</th><th scope="col">Smstr</th></tr>
      </thead>
      <tbody>
        <?php
        $query_matkul = mysqli_query($conn, "SELECT * FROM matakuliah ORDER BY semester, nama_mk");
        while($matkul = mysqli_fetch_array($query_matkul)) {
          if (in_array($matkul['kode_mk'], $taken_courses_list)) {
            echo "<tr class='table-secondary text-muted'>";
            echo "<td><input class='form-check-input' type='checkbox' disabled checked></td>";
            echo "<td>{$matkul['kode_mk']}</td>";
            echo "<td>{$matkul['nama_mk']} (Sudah Diambil)</td>";
            echo "<td>{$matkul['sks']}</td>";
            echo "<td>{$matkul['semester']}</td>";
            echo "</tr>";
          } else {
            echo "<tr>";
            echo "<td><input class='form-check-input mk-checkbox' type='checkbox' name='kode_mk[]' value='{$matkul['kode_mk']}' data-sks='{$matkul['sks']}'></td>";
            echo "<td>{$matkul['kode_mk']}</td>";
            echo "<td>{$matkul['nama_mk']}</td>";
            echo "<td>{$matkul['sks']}</td>";
            echo "<td>{$matkul['semester']}</td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
    
      