<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";

$order_code                  = input_data(filter_var($_POST['order_code'],FILTER_SANITIZE_STRING));
$payment_confirmation_date   = input_data(filter_var($_POST['payment_confirmation_date'],FILTER_SANITIZE_STRING));
$payment_confirmation_amount = input_data(filter_var($_POST['payment_confirmation_amount'],FILTER_SANITIZE_STRING));
$payment_confirmation_amount2= str_replace(',', '', $payment_confirmation_amount);

if($order_code=="" || $payment_confirmation_date =="" || $payment_confirmation_amount =="") {
  echo "<script>";
  echo 'swal("Maaf", "Mohon pilih tanggal pesan, tanggal bayar dan jumlah pembayaran", "error");';
  echo "</script>";
  exit();
}

if($_FILES['payment_confirmation_file']=="") {
  echo "<script>";
  echo 'swal("Maaf", "Mohon pilih foto bukti pembayaran", "error");';
  echo "</script>";
  exit();
}

if ($_FILES['payment_confirmation_file']['size'] > 3000000) {
  echo "<script>";
  echo 'swal("Maaf", "Ukuran file foto kegedean, maksimal 3 MB", "error");';
  echo "</script>";
  exit();
}

$temp         = explode(".", $_FILES["payment_confirmation_file"]["name"]);
$name         = $_FILES['payment_confirmation_file']['name'];
$target_dir     = "../im7/inv/";
$permitted_chars  = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$newfilename    = substr(str_shuffle($permitted_chars), 0, 16).'.'.end($temp);
$target_file    = $target_dir.$newfilename;
@$imageFileType    = strtolower($temp[1]);
$extensions_arr   = array("jpg","jpeg","png","gif");

// Check extension
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "pdf" && $imageFileType != "gif" && $imageFileType != "jpeg") {
  echo "<script>";
  echo 'swal("Mohon maaf,", "ini bukan foto", "error");';
  echo "</script>";
  exit();
}

function compressImage($source_image, $compress_image) {
$image_info = getimagesize($source_image);
if ($image_info['mime'] == 'image/jpeg') {
  $source_image = imagecreatefromjpeg($source_image);
  imagejpeg($source_image, $compress_image, 50);
} elseif ($image_info['mime'] == 'image/gif') {
  $source_image = imagecreatefromgif($source_image);
  imagegif($source_image, $compress_image, 50);
} elseif ($image_info['mime'] == 'image/png') {
  $source_image = imagecreatefrompng($source_image);
  imagepng($source_image, $compress_image, 5);
}
return $compress_image;
}

move_uploaded_file($_FILES["payment_confirmation_file"]["tmp_name"], $target_file);
$source_image = $target_file;
$image_destination = $target_dir.$newfilename;
compressImage($source_image, $image_destination);

$date_y   = substr($payment_confirmation_date,6,4);
$date_m   = substr($payment_confirmation_date,3,2);
$date_d   = substr($payment_confirmation_date,0,2);
$date_f   = $date_y.'-'.$date_m.'-'.$date_d;

// Insert record
$query = "UPDATE tbl_order SET payment_confirmation_file = '".$newfilename."', payment_confirmation_date = '".$date_f."', payment_confirmation_amount = '".$payment_confirmation_amount2."' WHERE order_code = '".$order_code."' AND partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
mysqli_query($conn,$query);
echo "<script>";
echo "swal({title: 'Sukses',text: 'Data berhasil diunggah. Kami akan melakukan validasi pembayaran.',type: 'success'}).then(function() {window.location = 'home';});";
echo "</script>";