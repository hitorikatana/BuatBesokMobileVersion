<?php
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";

$order_code			=	input_data(filter_var($_POST[1],FILTER_SANITIZE_STRING));

if($order_code == "") {
  	echo "<script>";
  	echo 'swal("Maaf,", "Kode order kosong", "error");';
  	echo "</script>";
	exit();
}

//cek minimum order
$sql 	= "SELECT sum(order_detail_qty) as jumlah_order FROM tbl_order_detail WHERE order_code = '".$order_code."'";
$h 		= mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($h);
if($_SESSION['partner_level']==1) { $min = 10; }else{ $min = 5; }
if($row['jumlah_order']<$min) {
  	echo "<script>";
  	echo 'swal("Maaf,", "Total pesanan Anda kurang dari '.$min.' kg", "error");';
  	echo "</script>";
	exit();	
}
/*
$sql 	= "SELECT product_id, product_name, order_detail_qty FROM tbl_order_detail WHERE order_code = '".$order_code."'";
$h 		= mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($h)) {
	$sql1 	= "SELECT product_minimum_order, product_unit_name FROM tbl_product WHERE product_id = '".$row['product_id']."'";
	$h1 	= mysqli_query($conn, $sql1);
	$row1	= mysqli_fetch_assoc($h1);
	if($row['order_detail_qty']<$row1['product_minimum_order']) {
	  echo "<script>";
	  echo 'swal("Maaf,", "Mohon periksa minimum order:\n\nMinimum order '.$row['product_name'].' adalah '.$row1['product_minimum_order'].' '.$row1['product_unit_name'].'", "error");';
	  echo "</script>";
		exit();	
	}
}*/

$sql 	= "UPDATE tbl_order_detail SET order_detail_status = 'BARU' WHERE order_code = '".$order_code."'";
mysqli_query($conn,$sql);

$sql2 	= "UPDATE tbl_order SET order_status = 'BARU' WHERE order_code = '".$order_code."'";
mysqli_query($conn,$sql2);

//insert ke table track
$sql3 	= "INSERT INTO tbl_order_track (order_code, created_date, order_status, order_notes) VALUES ('".$order_code."', UTC_TIMESTAMP(), 'BARU', 'Order telah dibuat')";
mysqli_query($conn, $sql3);

echo "<script>";
echo "swal({title: 'Sukses',text: 'Pesanan telah terkonfirmasi. Kami akan proses pesanan Anda',type: 'success'}).then(function() {window.location = 'cart-success';});";
echo "</script>";
exit();

?>