<?php
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";

$product_id			=	input_data(filter_var($_POST[1],FILTER_SANITIZE_STRING));
$order_code			=	input_data(filter_var($_POST[2],FILTER_SANITIZE_STRING));

if($product_id=="" || $order_code == "") {
  echo "<script>";
  echo 'swal("Maaf,", "Mohon pilih produk yang mau dihapus", "error");';
  echo "</script>";
  exit();
}

$sql2 	= "DELETE FROM tbl_order_detail  WHERE product_id = '".$product_id."' AND order_code = '".$order_code."'";
mysqli_query($conn,$sql2);

//jika data di tbl_order_detail sudah habis harusnya tbl_order jg dihapus utk order code tsb
$sql3 	= "SELECT order_code FROM tbl_order_detail WHERE order_code = '".$order_code."' LIMIT 1";
$h3 	= mysqli_query($conn,$sql3);
if(mysqli_num_rows($h3)==0) {
	$sql5 	= "DELETE FROM tbl_order  WHERE order_code = '".$order_code."' LIMIT 1";
	mysqli_query($conn,$sql5);
}

echo "<script>";
echo "swal({title: 'Sukses',text: 'Produk berhasil dihapus dari keranjang',type: 'success'}).then(function() {window.location = 'cart';});";
echo "</script>";

?>