<?php 
require 'header.php';

$sql    = "SELECT partner_id, partner_name, partner_address, partner_phone_number, partner_email_address, province_id, kabupaten_id, kecamatan_id, partner_photo, partner_nomor_ktp, partner_photo_ktp, partner_ktp FROM tbl_partner WHERE partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
$h      = mysqli_query($conn, $sql);
$row    = mysqli_fetch_assoc($h);
?>
  <div class="page-content-wrapper">
    <div class="container">
      <!-- Checkout Wrapper-->
      <div class="checkout-wrapper-area py-3">
        <div class="credit-card-info-wrapper">
          <div class="bank-ac-info">
            <p>PIN harus berupa angka sebanyak 6 digit, tidak kurang dan tidak lebih. PIN baru akan efektif digunakan saat Anda login kembali.
              <br/><br/><span class="text-danger">PIN harus berupa angka sejumlah 6 digit</span>
            </p>
            <form id="form">
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">PIN Saat Ini<span><input style="text-align: right" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "6" class="input" placeholder="Ketik PIN saat ini" name="old_pin" /></span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">PIN Baru<span><input style="text-align: right" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "6" class="input" placeholder="Ketik PIN baru" name="new_pin" /></span></li>
              </ul>
              <button type="button" class="btn btn-warning btn-lg w-100" id="submit">Ubah PIN</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once 'footer.php' ?>

<script type="text/javascript">
$(document).ready(function(){  
  $('#submit').click(function(){  
      $('#form').submit(); 
      $("#results").html('<div class=text-center><img src=img/loading.gif><br/>Mohon tunggu, data sedang diunggah...</div>'); 
      $("#page").fadeOut();
  });  
  $('#form').on('submit', function(event){  
      event.preventDefault();  
      $.ajax({  
        url:"profile-pin-edit",  
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