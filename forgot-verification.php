<?php
include($_SERVER['DOCUMENT_ROOT']."/../bb0/config.php");

$email       = input_data(filter_var($_POST['txt_email'],FILTER_SANITIZE_STRING));

if($email == "") {
  echo "<script>";
  echo 'swal("Maaf,", "Ketik alamat email Anda", "error");';
  echo "</script>";
  exit();
}

//apakah ada di db?
$sql  = "SELECT partner_email_address FROM tbl_partner WHERE partner_email_address = '".$email."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
if(mysqli_num_rows($h)==0) {
  echo "<script>";
  echo 'swal("Maaf,", "Email ini tidak terdaftar pada sistem kami", "error");';
  echo "</script>";
  exit(); 
}

//create PIN
$kode_verifikasi= mt_rand(100000, 999999);
$kode_verifikasi2= hash("sha256",$kode_verifikasi);
$sql2           = "UPDATE tbl_partner SET partner_pin = '".$kode_verifikasi2."' WHERE partner_email_address = '".$email."' LIMIT 1";
mysqli_query($conn,$sql2);
$msg            = 'Halo, Anda telah meminta PIN baru pada aplikasi buatbesok.com. Berikut adalah PIN baru Anda:<br/><br/><b>'.$kode_verifikasi.'</b><br/><br/>Silahkan login kembali dengan PIN baru Anda.<br/><br/>Salam Sukses,<br/>Buat Besok';
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
$mail->Subject  = "Permintaan PIN Aplikasi Buat Besok"; //subyek email
$mail->AddAddress($email, $nama); //tujuan email
$mail->MsgHTML($msg);
$mail->Send();

echo "<script>";
echo "swal({text: 'PIN baru berhasil dikirim melalui email Anda',type: 'success'}).then(function() {window.location = 'forgot-success';});";
echo "</script>";
?>