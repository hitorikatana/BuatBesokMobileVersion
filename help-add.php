<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";

$help_category_id   = input_data(filter_var($_POST['help_category_id'],FILTER_SANITIZE_STRING));
$help_q             = input_data(filter_var($_POST['help_q'],FILTER_SANITIZE_STRING));

if($help_category_id=="" || $help_q =="") {
  echo "<script>";
  echo 'swal("Maaf", "Mohon isi form", "error");';
  echo "</script>";
  exit();
}

// Insert record
$query = "INSERT INTO tbl_help SET help_category_id = '".$help_category_id."', help_q = '".$help_q."', created_date = UTC_TIMESTAMP(), partner_id = '".$_SESSION['partner_id']."'";
mysqli_query($conn,$query);
echo "<script>";
echo "swal({title: 'Sukses',text: 'Bantuan berhasil diunggah. Tunggu respon kami ya.',type: 'success'}).then(function() {window.location = 'home';});";
echo "</script>";