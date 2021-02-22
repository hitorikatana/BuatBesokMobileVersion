<?php
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";

$product_id					=	input_data(filter_var($_POST['product_id'],FILTER_SANITIZE_STRING));
//$order_qty					=	input_data(filter_var($_POST['order_qty'],FILTER_SANITIZE_STRING));
$s							=	input_data(filter_var(@$_POST['s'],FILTER_SANITIZE_STRING));
$txt_search					=	input_data(filter_var(@$_POST['txt_search'],FILTER_SANITIZE_STRING));
$page						=	input_data(filter_var(@$_POST['page'],FILTER_SANITIZE_STRING));
$order_qty = 1;

if ($page =='') { $page = 1; }

if($product_id=="" || $order_qty == "") {
  echo "<script>";
  echo 'swal("Maaf,", "Mohon isi jumlah", "danger");';
  echo "</script>";
	exit();
}

//dapatkan seluruh data produk
$sql 					= "SELECT * FROM tbl_product WHERE product_id = '".$product_id."' LIMIT 1";
$h 						= mysqli_query($conn,$sql);
$row 					= mysqli_fetch_assoc($h);
$product_name = $row['product_name'];
/*
if($order_qty<$row['product_minimum_order']) {
  	echo "<script>";
  	echo "alert('Mohon perhatikan minimum kuantiti order'); window.location.href=history.back()";
  	echo "</script>";
	exit();	
}
*/
//get order code yg pending
$sql_oc    = "SELECT order_code FROM tbl_order WHERE partner_id = '".$_SESSION['partner_id']."' AND order_status = 'PENDING' LIMIT 1";
$h_oc      = mysqli_query($conn, $sql_oc);
if(mysqli_num_rows($h_oc)==0) {
  $_SESSION['order_code'] = $_SESSION['partner_id'].date('ydhis');
  $order_code             = $_SESSION['order_code'];
}else{
  $row_oc = mysqli_fetch_assoc($h_oc);
  $order_code             = $row_oc['order_code'];
}

$order_detail_sub_total	= $order_qty*$row['product_price'];

//cek apakah order code sudah ada? kalau ada tidak perlu insert
$sqlc	= "SELECT order_code FROM tbl_order WHERE order_code = '".$order_code."' AND order_status = 'PENDING' LIMIT 1";
$hc 	= mysqli_query($conn,$sqlc);
if(mysqli_num_rows($hc)==0) {

	$sql1 	= "INSERT INTO tbl_order (order_date,order_code,order_status,created_date,partner_id) VALUES (UTC_TIMESTAMP(),'".$order_code."','PENDING',UTC_TIMESTAMP(),'".$_SESSION['partner_id']."')";
	mysqli_query($conn,$sql1);

	$sql2 	= "INSERT INTO tbl_order_detail (order_code,product_id,product_name,product_unit,product_price,order_detail_qty,order_detail_sub_total,partner_id, order_detail_status, created_date) VALUES ('".$order_code."','".$product_id."','".$row['product_name']."','".$row['product_unit_name']."','".$row['product_price']."','".$order_qty."','".$order_detail_sub_total."','".$_SESSION['partner_id']."','PENDING',UTC_TIMESTAMP())";
}else{
	$sql2 	= "INSERT INTO tbl_order_detail (order_code,product_id,product_name,product_unit,product_price,order_detail_qty,order_detail_sub_total,partner_id, order_detail_status, created_date) VALUES ('".$order_code."','".$product_id."','".$row['product_name']."','".$row['product_unit_name']."','".$row['product_price']."','".$order_qty."','".$order_detail_sub_total."','".$_SESSION['partner_id']."','PENDING',UTC_TIMESTAMP())";
}

mysqli_query($conn,$sql2);
echo "<script>";
echo 'swal("Sukses", "Produk '.$product_name.' berhasil ditambahkan ke keranjang. Periksa keranjang Anda untuk memastikan pesanan.", "success");';
echo "</script>";