<?php
session_start();
ini_set('display_errors',1);  error_reporting(E_ALL);
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");

$email  		= input_data(filter_var($_POST['txt_username'],FILTER_SANITIZE_STRING));
$pin    		= input_data(filter_var($_POST['txt_password'],FILTER_SANITIZE_STRING));
$fcm    		= input_data(filter_var(@$_POST['fcm'],FILTER_SANITIZE_STRING));
$device_name    = input_data(filter_var(@$_POST['device_name'],FILTER_SANITIZE_STRING));
$battery_level  = input_data(filter_var(@$_POST['battery_level'],FILTER_SANITIZE_STRING));
$lat   			= input_data(filter_var(@$_POST['lat'],FILTER_SANITIZE_STRING));
$lng    		= input_data(filter_var(@$_POST['lng'],FILTER_SANITIZE_STRING));
$token_fcm    	= input_data(filter_var(@$_POST['token_fcm'],FILTER_SANITIZE_STRING));

if($email=='' || $pin == "") {
?>
  <?php
  echo "<script>";
  echo 'swal("Maaf,", "Mohon isi email dan PIN", "error");';
  echo "</script>";
  exit();
}

$pin    = hash("sha256", $pin);
$sql    = "SELECT partner_id,partner_photo, partner_key, partner_email_address, partner_name, partner_timezone, partner_level FROM tbl_partner WHERE partner_email_address = '".$email."' AND partner_pin = '".$pin."' AND active_status = 1 LIMIT 1";
$h            = mysqli_query($conn,$sql) or die(mysqli_error());
if(mysqli_num_rows($h)==0) {
  echo "<script>";
  echo 'swal("Maaf,", "Login salah, silahkan ulangi", "error");';
  echo "</script>";
  exit();
}

$row          = mysqli_fetch_assoc($h);
$partner_level          = $row['partner_level'];
$partner_key            = $row['partner_key'];
$partner_id             = $row['partner_id'];
$partner_email_address  = $row['partner_email_address'];
$partner_name           = $row['partner_name'];
$partner_photo          = $row['partner_photo'];
$partner_timezone       = $row['partner_timezone'];
$sql          = "update tbl_partner SET last_login = UTC_TIMESTAMP(), device_name = '".$device_name."', battery_level = '".$battery_level."', lat = '".$lat."', lng = '".$lng."', token_fcm = '".$token_fcm."' where partner_id='".$partner_id."' limit 1";
$h2           = mysqli_query($conn,$sql);

//cara nampilin time berdasarkan timezone
//date_default_timezone_set($row['user_timezone']);
//echo 'date and time is ' . date('Y-m-d H:i:s');

$sql2   = "INSERT INTO tbl_partner_log(partner_id, partner_log_action, created_date, ip_address) VALUES ('".$partner_id."', 'LOGIN', UTC_TIMESTAMP(), '".$ip_address."'";
$h2     = mysqli_query($conn,$sql2);

$_SESSION['partner_level']          = $partner_level;
$_SESSION['partner_key']            = $partner_key;
$_SESSION['partner_id']             = $partner_id;
$_SESSION['partner_name']           = $partner_name;
$_SESSION['partner_email_address']  = $partner_email_address;
$_SESSION['partner_photo']          = $partner_photo;
$_SESSION['partner_timezone']       = $partner_timezone;

//timezone
$serverTimezoneOffset       = (date("O") / 100 * 60 * 60);
$clientTimezoneOffset       = $_POST["timezoneoffset"];
$serverTime                 = time();
$serverClientTimeDifference = $clientTimezoneOffset-$serverTimezoneOffset;
$clientTime                 = $serverTime+$serverClientTimeDifference;
$_SESSION['selisih']        = ($serverClientTimeDifference/(60*60));

echo "<script>";
echo "swal({text: 'Selamat datang $partner_name!',type: 'success'}).then(function() {window.location = 'home';});";
echo "</script>";
?>