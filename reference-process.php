<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/../bb0/config.php");

$email       = input_data(filter_var($_POST['ae'],FILTER_SANITIZE_STRING));

if($email == "") {
  echo "<script>";
  echo 'swal("Maaf,", "Ketik alamat email Anda", "error");';
  echo "</script>";
  exit();
}

//apakah ada di db?
$sql  = "SELECT partner_email_address FROM tbl_partner WHERE partner_email_address = '".$email."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)>0) {
  echo "<script>";
  echo 'swal("Maaf,", "Email ini sudah terdaftar pada sistem kami", "error");';
  echo "</script>";
  exit(); 
}

$msg            = 'Halo, Anda telah diundang untuk menjadi Mitra buatbesok.com. Berikut adalah link pendaftaran menjadi Mitra:<br/><br/><b><a href="https://mitra.buatbesok.com/register?'.Encryption::encode($_SESSION["partner_key"]).'?'.Encryption::encode($email).'">Daftar Disini</a></b><br/><br/>Jika link diatas tidak dapat di-klik, silahkan salin alamat URL berikut ini ke dalam browser Anda:<br/><br/>https://mitra.buatbesok.com/register?'.Encryption::encode($_SESSION["partner_key"]).'?'.Encryption::encode($email).'<br/><br/>Salam Sukses,<br/>Buat Besok';
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
$mail->Subject  = "Pendaftaran Mitra baru Aplikasi Buat Besok"; //subyek email
$mail->AddAddress($email, $nama); //tujuan email
$mail->MsgHTML($msg);
$mail->Send();

echo "<script>";
echo "swal({text: 'Berhasil! Link pendaftaran baru berhasil dikirim melalui email milik calon Mitra',type: 'success'}).then(function() {window.location = 'home';});";
echo "</script>";
?>