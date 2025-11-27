<?php
include "connection.php";


$nim = mysqli_real_escape_string($conn, $_POST['nim']);
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
$nohp = mysqli_real_escape_string($conn, $_POST['nohp']);
$email = mysqli_real_escape_string($conn, $_POST['email']);


$query = "INSERT INTO mahasiswa (nim, nama, alamat, nohp, email) 
          VALUES ('$nim', '$nama', '$alamat', '$nohp', '$email')";

mysqli_query($conn, $query);
mysqli_close($conn);


header("location:mahasiswa.php");
?>