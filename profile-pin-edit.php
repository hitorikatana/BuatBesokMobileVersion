<?php
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");

$pin1       = input_data(filter_var($_POST['old_pin'],FILTER_SANITIZE_STRING));
$pin2       = input_data(filter_var($_POST['new_pin'],FILTER_SANITIZE_STRING));

if($pin1 == "" || $pin2 == "") {
  echo "<script>";
  echo 'swal("Maaf,", "Mohon isi seluruh form", "error");';
  echo "</script>";
  exit();
}

if(strlen($pin1)<>6 || strlen($pin2)<>6) {
  echo "<script>";
  echo 'swal("Maaf,", "PIN harus 6 digit", "error");';
  echo "</script>";   
}

/*if($pin2 <> $pin3) {
  echo "<script>";
  echo 'swal("Maaf,", "Antara PIN baru dan konfirmasi PIN baru nggak cocok", "error");';
  echo "</script>";
  exit();
}*/

//apakah PIN lama benar?
$pin1 = hash("sha256", $pin1);
$sql  = "SELECT partner_email_address, partner_name, partner_pin FROM tbl_partner WHERE partner_pin = '".$pin1."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)==0) {
  echo "<script>";
  echo 'swal("Maaf,", "PIN Anda saat ini salah", "error");';
  echo "</script>";
  exit(); 
}

$row 	= mysqli_fetch_assoc($h);

//create PIN
$pin5 	= hash("sha256",$pin2);
$sql2           = "UPDATE tbl_partner SET partner_pin = '".$pin5."' WHERE partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
mysqli_query($conn,$sql2);

$msg            = 'Halo, Anda telah merubah PIN pada aplikasi Buat Besok Dotcom. Jika Anda merasa tidak melakukan perubahan PIN, segera hubungi customer service kami.<br/><br/>Silahkan login kembali dengan PIN baru Anda.<br/><br/>Salam Sukses,<br/>Buat Besok Dotcom';
//email
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/components/classes/class.phpmailer.php");
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPSecure= 'tls';
$mail->Host     = "buatbesok.com"; //hostname masing-masing provider email
$mail->SMTPDebug= 2;
$mail->Port     = 587;
$mail->SMTPAuth = true;
$mail->Username = "no-reply@buatbesok.com"; //user email
$mail->Password = "L7x623*8"; //password email
$mail->SetFrom("no-reply@buatbesok.com","Buat Besok Dotcom"); //set email pengirim
$mail->Subject  = "Informasi Perubahan PIN Aplikasi Buat Besok"; //subyek email
$mail->AddAddress($row['partner_email_address'], $row['partner_name']); //tujuan email
$mail->MsgHTML($msg);
$mail->Send();

echo "<script>";
echo "swal({title: 'Sukses',text: 'PIN berhasil diganti. Akan efektif berlaku pada login berikutnya',type: 'success'}).then(function() {window.location = 'home';});";
echo "</script>";

?>