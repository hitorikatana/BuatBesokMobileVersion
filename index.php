<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from demo.designing-world.com/suha-v1.3.0/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 30 Apr 2020 13:32:42 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags-->
    <!-- Title-->
    <title>Masuk Buat Besok</title>
    <!-- Favicon-->
    <link rel="icon" href="img/core-img/favicon.ico">
    <!-- Stylesheet-->
    <link rel="stylesheet" href="css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
  </head>
  <body>
    <div id=results></div>
    <div id="page">
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only">Loading...</div>
      </div>
    </div>
    <!-- Login Wrapper Area-->
    <div class="login-wrapper d-flex align-items-center justify-content-center text-center">
      <div class="background-shape"></div>
      <div class="container"><img src="https://bb0.buatbesok.com/logo.png" width="180" />
        <div class="register-form mt-5 px-4">

          <?php if(@$param[1]=='8ssdgni3q___349isdjfi20df9920adfj') { ?>
            <div class="text-center" style="background: #53a008 !important; color: #fff; padding: 10px; margin-bottom: 10px" role="alert">Selamat!<br/> Akun Anda berhasil diverifikasi. Silahkan login dengan alamat email dan PIN Anda.</div>
          <?php } ?>
          <?php if(@$param[1]=='8ssdgni3q___349isdjfi20df9920adfjq') { ?>
            <div class="text-center" style="background: #53a008 !important; color: #fff; padding: 10px; margin-bottom: 10px" role="alert">PIN baru telah terkirim ke email Anda. Silahkan cek inbox atau folder spam pada akun email Anda. Gunakan PIN baru tersebut untuk login.</div>
          <?php } ?>
          <?php if(@$param[1]==1) { ?>
            <div class="text-center" style="background: #53a008 !important; color: #fff; padding: 10px; margin-bottom: 10px" role="alert">Selamat bergabung! Silahkan pakai alamat email yang tadi Anda daftarkan berikut PIN untuk login di bawah ini.</div>
          <?php } ?> 

          <form id="time_form" name="time_form">
            <input type="hidden" name="device_name" value="<?php echo $_GET['deviceName'] ?>" />
            <input type="hidden" name="battery_level" value="<?php echo $_GET['batteryLevel'] ?>" />
            <input type="hidden" name="lat" value="<?php echo $_GET['latitude'] ?>" />
            <input type="hidden" name="lng" value="<?php echo $_GET['longitude'] ?>" />
            <input type="hidden" name="token_fcm" value="<?php echo $_GET['token_fcm'] ?>" />
            <script type="text/javascript">
                tzo = - new Date().getTimezoneOffset()*60;
                document.write('<input type="hidden" value="'+tzo+'" name="timezoneoffset">');
            </script>
            <div class="form-group text-left mb-4"><span>Alamat Email</span>
              <label for="username"><i class="lni-user"></i></label>
              <input class="form-control" id="username" type="email" name="txt_username" placeholder="Ketik alamat email Anda">
            </div>
            <div class="form-group text-left mb-4"><span>PIN</span>
              <label for="password"><i class="lni-lock"></i></label>
              <input class="form-control" id="password" type="password" name="txt_password" placeholder="Ketik PIN Anda" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "6">
            </div>
            <button class="btn btn-success btn-lg w-100" id="submit">Masuk</button>
          </form>
        </div>
        <div class="login-meta-data"><a class="forgot-password d-block mt-3 mb-1" href="forgot">Lupa PIN?</a>
        </div>
      </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.animatedheadline.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jarallax.min.js"></script>
    <script src="js/jarallax-video.min.js"></script>
    <script src="js/default/jquery.passwordstrength.js"></script>
    <script src="js/default/dark-mode-switch.js"></script>
    <script src="js/default/active.js"></script>
    </div>
  </body>
</html>

<script type="text/javascript">
$(document).ready(function(){  
  $('#submit').click(function(){  
      $('#time_form').submit(); 
      $("#results").html('<div class=text-center><img src=img/loading.gif><br/>proses login...</div>'); 
      $("#page").fadeOut();
  });  
  $('#time_form').on('submit', function(event){  
      event.preventDefault();  
      $.ajax({  
        url:"auth",  
        method:"POST",  
        data:new FormData(this),  
        contentType:false,  
        processData:false,  
        success:function(data){ 
          $("#page").fadeIn();
          $('#results').html(data);  
          $('#submit').val('');  
        }  
      });  
  });  
}); 
</script>