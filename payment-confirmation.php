<?php 
require 'header.php';
?>
<!--separator credit limit-->
<script type='text/javascript'>
function Comma(Num)
 {
       Num += '';
       Num = Num.replace(/,/g, '');
       x = Num.split('.');
       x1 = x[0];
       x2 = x.length > 1 ? '.' + x[1] : '';

         var rgx = /(\d)((\d{3}?)+)$/;

       while (rgx.test(x1))
       x1 = x1.replace(rgx, '$1' + ',' + '$2');    
       return x1 + x2;              
 }
</script> 
<!--end separator credit limit-->

  <div class="page-content-wrapper">
    <div class="container">
      <!-- Checkout Wrapper-->
      <div class="checkout-wrapper-area py-3">
        <div class="credit-card-info-wrapper">
          <div class="bank-ac-info">
            <p>Kirim konfirmasi pembayaran atas order Anda.
              <br/><br/><span class="text-danger">Anda harus lakukan konfirmasi pembayaran agar dapat melakukan order kembali</span>
            </p>
            <form id="form">
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">Tanggal Pesan
                  <span>
                    <select class="input" required name="order_code" style="text-align: right">
                      <option value="">-- Pilih Tanggal Pesan --</option>
                      <?php
                      $sql1  = "SELECT date_format(order_date, '%d-%m-%Y') as order_date, order_code FROM tbl_order WHERE partner_id = '".$_SESSION['partner_id']."' AND order_status = 'TERKIRIM' AND payment_confirmation_file = '' ORDER BY order_date DESC";
                      $h1    = mysqli_query($conn,$sql1);
                      while($row1 = mysqli_fetch_assoc($h1)) {
                      ?>
                      <option value="<?php echo $row1['order_code'] ?>"><?php echo $row1['order_date'] ?></option>
                      <?php } ?>
                    </select>
                  </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Struk<span><input style="text-align: right" type="file" class="input" placeholder="Pilih foto disini" name="payment_confirmation_file" id="payment_confirmation_file" /></span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Tanggal Bayar<span style="text-align: right"><input style="text-align: right" type="text" class="input" placeholder="(contoh: 31-05-2020)" name="payment_confirmation_date" id="payment_confirmation_date" /></span></li>                
                <li class="list-group-item d-flex justify-content-between align-items-center">Nominal<span>
                  <input style="text-align: right" type="text" class="input" placeholder="(ketik angka saja)" name="payment_confirmation_amount" autocomplete="off" onkeyup = "javascript:this.value=Comma(this.value);"  />
                </span></li>
              </ul>
              <button type="button" class="btn btn-warning btn-lg w-100" id="submit">Simpan Data</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once 'footer.php' ?>

<script>  
$(document).ready(function(){  
  $('#submit').click(function(){  
      $('#form').submit(); 
      $("#results").html('<div class=text-center><img src=img/loading.gif><br/>Mohon tunggu, data sedang diunggah...</div>'); 
      $("#page").fadeOut();
  });  
  $('#form').on('submit', function(event){  
      event.preventDefault();  
      $.ajax({  
        url:"payment-confirmation-add",  
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

  $("#payment_confirmation_date").attr("maxlength", 10);
  $("#payment_confirmation_date").keyup(function(){
      if ($(this).val().length == 2){
          $(this).val($(this).val() + "-");
      }else if ($(this).val().length == 5){
          $(this).val($(this).val() + "-");
      }
  });

});  
</script> 