<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once "check-session.php";

$p_type      = input_data(filter_var($_POST['p_type'],FILTER_SANITIZE_STRING));

if($p_type == 1) { // foto selfie

  if($_FILES['partner_photo']=="") {
    echo "<script>";
    echo "alert('Pilih file foto terlebih dahulu'); window.location.href=history.back()";
    echo "</script>";
    exit();
  }

  if ($_FILES['partner_photo']['size'] > 3000000) {
    echo "<script>";
    echo "alert('Maksimal ukuran file adalah 3 MB'); window.location.href=history.back()";
    echo "</script>";
    exit();
  }

  $temp 				= explode(".", $_FILES["partner_photo"]["name"]);
  $name 				= $_FILES['partner_photo']['name'];
  $target_dir 		= "../im7/";
  $permitted_chars 	= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $newfilename 		= substr(str_shuffle($permitted_chars), 0, 16).'.'.end($temp);
  $target_file 		= $target_dir.$newfilename;
 @$imageFileType 		= strtolower($temp[1]);
  $extensions_arr 	= array("jpg","jpeg","png","gif");

  // Check extension
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "pdf" && $imageFileType != "gif" && $imageFileType != "jpeg") {
    echo "<script>";
    echo "alert('Format file harus JPG, PNG atau GIF'); window.location.href=history.back()";
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

  move_uploaded_file($_FILES["partner_photo"]["tmp_name"], $target_file);
  $source_image = $target_file;
  $image_destination = $target_dir.$newfilename;
  compressImage($source_image, $image_destination);

  // Insert record
  $query = "UPDATE tbl_partner SET partner_photo = '".$newfilename."' WHERE partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
  mysqli_query($conn,$query);

  echo "<script>";
  echo "alert('Data berhasil disimpan'); window.location.href=history.back()";
  echo "</script>";

}elseif($p_type == 2) {

  if($_FILES['partner_ktp']=="") {
    echo "<script>";
    echo 'swal("Maaf", "Mohon pilih foto", "error");';
    echo "</script>";
    exit();
  }

  if ($_FILES['partner_ktp']['size'] > 3000000) {
    echo "<script>";
    echo 'swal("Maaf", "Ukuran file foto kegedean, maksimal 3 MB", "error");';
    echo "</script>";
    exit();
  }

  $temp         = explode(".", $_FILES["partner_ktp"]["name"]);
  $name         = $_FILES['partner_ktp']['name'];
  $target_dir     = "../im7/";
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

  move_uploaded_file($_FILES["partner_ktp"]["tmp_name"], $target_file);
  $source_image = $target_file;
  $image_destination = $target_dir.$newfilename;
  compressImage($source_image, $image_destination);

  // Insert record
  $query = "UPDATE tbl_partner SET partner_ktp = '".$newfilename."' WHERE partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
  mysqli_query($conn,$query);
  echo "<script>";
  echo "swal({title: 'Sukses',text: 'Foto berhasil diunggah',type: 'success'}).then(function() {window.location = 'profile';});";
  echo "</script>";

}else{

  if($_FILES['partner_photo_ktp']=="") {
    echo "<script>";
    echo 'swal("Maaf", "Mohon pilih foto", "error");';
    echo "</script>";
    exit();
  }

  if ($_FILES['partner_photo_ktp']['size'] > 3000000) {
    echo "<script>";
    echo 'swal("Maaf", "Ukuran file foto kegedean, maksimal 3 MB", "error");';
    echo "</script>";
    exit();
  }

  $temp         = explode(".", $_FILES["partner_photo_ktp"]["name"]);
  $name         = $_FILES['partner_photo_ktp']['name'];
  $target_dir     = "../im7/";
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

  move_uploaded_file($_FILES["partner_photo_ktp"]["tmp_name"], $target_file);
  $source_image = $target_file;
  $image_destination = $target_dir.$newfilename;
  compressImage($source_image, $image_destination);

  // Insert record
  $query = "UPDATE tbl_partner SET partner_photo_ktp = '".$newfilename."' WHERE partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
  mysqli_query($conn,$query);
  echo "<script>";
  echo "swal({title: 'Sukses',text: 'Foto berhasil diunggah',type: 'success'}).then(function() {window.location = 'profile';});";
  echo "</script>";

}