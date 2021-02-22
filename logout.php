<?php
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
unset($_SESSION['partner_email_address']);
unset($_SESSION['partner_id']);
session_destroy();
if($_GET['s']=='e') {
	header("Location:/?p=e");
}elseif($_GET['s']=='session') {
	header("Location:/?p=s");
}else{
	header("Location:/");
}
?>