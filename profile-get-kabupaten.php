<?php
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");

$id = $_GET['province_id'];
$result = mysqli_query($conn, "SELECT id, province_id, name FROM tbl_kabupaten_kota WHERE province_id = '$id'");
	echo '<option value="">-- Pilih --</option>';
while($row = mysqli_fetch_array($result)) {
	echo '<option value ='.$row['id'].'>'.$row['name'].'</option>';
}
?>