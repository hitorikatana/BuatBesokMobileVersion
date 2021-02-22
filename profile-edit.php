<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");

$partner_name	=	input_data(filter_var($_POST['partner_name'],FILTER_SANITIZE_STRING));
$partner_address=	input_data(filter_var($_POST['partner_address'],FILTER_SANITIZE_STRING));
$partner_phone_number	=	input_data(filter_var($_POST['partner_phone_number'],FILTER_SANITIZE_STRING));
$province_id	=	input_data(filter_var($_POST['province_id'],FILTER_SANITIZE_STRING));
$kabupaten_id	=	input_data(filter_var($_POST['kabupaten_id'],FILTER_SANITIZE_STRING));
$kecamatan_id	=	input_data(filter_var($_POST['kecamatan_id'],FILTER_SANITIZE_STRING));
$partner_nomor_ktp	=	input_data(filter_var($_POST['partner_nomor_ktp'],FILTER_SANITIZE_STRING));

if($partner_name=="" || $partner_address == "" || $province_id == "" || $kabupaten_id == "" || $kecamatan_id == "" || $partner_nomor_ktp == "") {
echo "<script>";
echo 'swal("Maaf,", "Mohon isi seluruh form", "error");';
echo "</script>";
  exit(); 
}

$sql2 	= "UPDATE tbl_partner SET partner_name='".$partner_name."',partner_address='".$partner_address."',province_id='".$province_id."',kabupaten_id='".$kabupaten_id."',kecamatan_id='".$kecamatan_id."', partner_phone_number = '".$partner_phone_number."', partner_nomor_ktp = '".$partner_nomor_ktp."'  WHERE partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
mysqli_query($conn,$sql2);

echo "<script>";
echo 'swal("Sukses", "Data berhasil dirubah", "success");';
echo "</script>";
?>