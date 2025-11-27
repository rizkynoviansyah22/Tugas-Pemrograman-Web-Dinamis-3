<?php
include "connection.php";

if (!isset($_GET['nim']) || !isset($_GET['id_semester']) || !isset($_GET['kode_mk'])) {
    die("Parameter tidak lengkap. Tidak bisa menghapus.");
}

$nim = mysqli_real_escape_string($conn, $_GET['nim']);
$id_semester = mysqli_real_escape_string($conn, $_GET['id_semester']);
$kode_mk = mysqli_real_escape_string($conn, $_GET['kode_mk']);

$sql = "DELETE FROM krs 
        WHERE nim = '$nim' 
        AND id_semester = '$id_semester' 
        AND kode_mk = '$kode_mk'";

mysqli_query($conn, $sql);

mysqli_close($conn);

header("Location: krsmhs.php?nim=$nim&id_semester=$id_semester");
exit;
?>
