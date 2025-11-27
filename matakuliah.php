<?php

include "connection.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Akademik - Data Matakuliah</title>
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
    <a class="nav-link active" aria-current="page" href="matakuliah.php">Data Matakuliah</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="krsmhs.php">KRS</a>
  </li>
</ul>
<br>
<nav class="navbar" style="background-color: #e3f2fd;">
  Daftar Matakuliah
</nav>

<?php
        echo"<table class='table table-striped'>"; 
        echo"<thead><tr>
                <th scope='col'>NO</th>
                <th scope='col'>KODE MK</th>
                <th scope='col'>NAMA MATAKULIAH</th>
                <th scope='col'>SKS</th>
                <th scope='col'>SEMESTER (Kurikulum)</th>
              </tr></thead>"; 

        
        $tampil = mysqli_query($conn,"SELECT * FROM matakuliah ORDER BY semester, kode_mk");

        $i = 1;
        echo"<tbody>";
        while($row = mysqli_fetch_array($tampil)){

          echo"<tr><th scope='row'>" . $i . "</th> 
               <td>" . $row["kode_mk"] . "</td> 
               <td>" . $row["nama_mk"] . "</td> 
               <td>" . $row["sks"] . "</td>
               <td>" . $row["semester"] . "</td>"; 
          
          echo"</tr>";
          $i++;
        }

        echo"</tbody></table>";  
?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</div>

</body>
</html>