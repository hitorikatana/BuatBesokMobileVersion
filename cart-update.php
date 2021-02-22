<?php
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";

$order_code					=	input_data(filter_var($_POST['order_code'],FILTER_SANITIZE_STRING));
$product_id					=	input_data(filter_var($_POST['product_id'],FILTER_SANITIZE_STRING));
$order_detail_qty			=	input_data(filter_var($_POST['order_detail_qty'],FILTER_SANITIZE_STRING));

if($order_code=="" || $product_id == "" || $order_detail_qty =="" || $order_detail_qty <1 ) {
  echo "<script>";
  echo 'swal("Maaf,", "Jumlah pemesanan tidak boleh kosong atau 0", "error");';
  echo "</script>";
  exit();
}

//show nama produk
//dapatkan seluruh data produk
$sql 	= "SELECT * FROM tbl_product WHERE product_id = '".$product_id."' LIMIT 1";
$h 		= mysqli_query($conn,$sql);
$row 	= mysqli_fetch_assoc($h);

if($order_detail_qty<$row['product_minimum_order']) {
  echo "<script>";
  echo 'swal("Maaf,", "Minimum order adalah '.$row['product_minimum_order'].'", "error");';
  echo "</script>";
	exit();	
}

$order_detail_sub_total	= $order_detail_qty*$row['product_price'];

$sql2 	= "DELETE FROM tbl_order_detail  WHERE product_id = '".$product_id."' AND order_code = '".$order_code."'";
mysqli_query($conn,$sql2);

$sql3 	= "INSERT INTO tbl_order_detail (order_code,product_id,product_name,product_unit,product_price,order_detail_qty,order_detail_sub_total,partner_id, order_detail_status, created_date) VALUES ('".$order_code."','".$product_id."','".$row['product_name']."','".$row['product_unit_name']."','".$row['product_price']."','".$order_detail_qty."','".$order_detail_sub_total."','".$_SESSION['partner_id']."','PENDING',UTC_TIMESTAMP())";
mysqli_query($conn,$sql3);

echo "<script>";
echo "swal({title: 'Sukses',text: 'Jumlah pesanan berhasil diperbaharui',type: 'success'}).then(function() {window.location = 'cart';});";
echo "</script>";

?>