<?php
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");

$id = $_GET['kabupaten_id'];
$result = mysqli_query($conn, "SELECT id, regency_id, name FROM tbl_kecamatan WHERE regency_id = '$id'");
	echo '<option value="">-- Pilih --</option>';
while($row = mysqli_fetch_array($result)) {
	echo '<option value ='.$row['id'].'>'.$row['name'].'</option>';
}
?>