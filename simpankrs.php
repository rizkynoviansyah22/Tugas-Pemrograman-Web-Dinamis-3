<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['nim'])) {
    die("Akses tidak sah.");
}

$nim = mysqli_real_escape_string($conn, $_POST['nim']);
$id_semester = mysqli_real_escape_string($conn, $_POST['id_semester']);

if (!isset($_POST['kode_mk']) || empty($_POST['kode_mk'])) {
     header("Location: krsmhs.php?nim=$nim&id_semester=$id_semester");
     exit;
}

$matakuliah_dipilih = $_POST['kode_mk']; 

$query_parts = array();
foreach($matakuliah_dipilih as $kode_mk) {
    $kode_mk_safe = mysqli_real_escape_string($conn, $kode_mk);
    
    $query_parts[] = "('$nim', '$kode_mk_safe', '$id_semester')";
}

$values_string = implode(", ", $query_parts);

$sql = "INSERT IGNORE INTO krs (nim, kode_mk, id_semester) VALUES $values_string";

mysqli_query($conn, $sql);

mysqli_close($conn);

header("Location: krsmhs.php?nim=$nim&id_semester=$id_semester");
exit;
?>