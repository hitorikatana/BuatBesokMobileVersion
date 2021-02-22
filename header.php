<?php
session_start();
header_remove('X-Powered-By');
header('X-Powered-By: ');
header_remove('Server');
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php"); 
require_once 'check-session.php';
?>
<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from demo.designing-world.com/suha-v1.3.0/home.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 30 Apr 2020 13:28:55 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags-->
    <!-- Title-->
    <title>Buat Besok</title>
    <!-- Favicon-->
    <link rel="icon" href="img/core-img/favicon.ico">
    <!-- Stylesheet-->
    <link rel="stylesheet" href="css/style.css" async>
    <link rel="stylesheet" href="css/custom.css" async>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body>
    <div id="results"></div>
    <div id="page">
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only">Loading...</div>
      </div>
    </div>
    <!-- Header Area-->
    <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Logo Wrapper-->
        <div class="back-button"><a href="javascript:window.history.back();"><i class="lni-chevron-left"></i></a></div>
        <!-- Search Form-->
        <div class="top-search-form"><img src="https://bb0.buatbesok.com/logo.png" width="110" />
          <!--<form action="#" method="POST">
            <input class="form-control" type="search" placeholder="Enter your keyword">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>-->
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex justify-content-between flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
      </div>
    </div>
    <!-- Sidenav Black Overlay-->
    <div class="sidenav-black-overlay"></div>
    <!-- Side Nav Wrapper-->
    <div class="suha-sidenav-wrapper" id="sidenavWrapper">
      <!-- Sidenav Profile-->
      <div class="sidenav-profile">
        <div class="user-profile"><img src="https://bb0.buatbesok.com/logo-icon.png" /></div>
        <div class="user-info">
          <h6 class="user-name mb-0"><?php echo $_SESSION['partner_name'] ?></h6>
        </div>
      </div>
      <!-- Sidenav Nav-->
      <ul class="sidenav-nav">
        <li><a href="home"><i class="lni-alarm lni-tada-effect"></i>Pesan Barang</a></li>
        <li><a href="cart"><i class="lni-cart"></i>Keranjang Saya</a></li>
        <li><a href="info"><i class="lni-heart-filled"></i>Info Terbaru</a></li>
        <li><a href="profile"><i class="lni-user"></i>Profil Saya</a></li>        
        <li><a href="profile-pin"><i class="lni-lock"></i>Ganti PIN</a></li>
        <li><a href="payment-confirmation"><i class="lni-lock"></i>Konfirmasi Bayar</a></li>
        <li><a href="logout"><i class="lni-power-switch"></i>Keluar</a></li>
      </ul>
      <!-- Go Back Button-->
      <div class="go-home-btn" id="goHomeBtn"><i class="lni-arrow-left"></i></div>
    </div>