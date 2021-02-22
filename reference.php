<?php 
require 'header.php';
?>
  <div class="page-content-wrapper">
    <div class="container">
      <!-- Checkout Wrapper-->
      <div class="checkout-wrapper-area py-3">
        <div class="credit-card-info-wrapper">
          <div class="bank-ac-info">
            <p>Anda dapat memiliki Mitra baru di bawah Anda. Agar Mitra baru bisa tercatat di bawah Anda, proses registrasinya adalah dengan cara mengirimkan link pendaftaran kepada email mereka.<br/><br/>Untuk itu, isilah alamat email calon Mitra baru Anda di bawah ini, sistem akan mengirimkan link pendaftaran ke email mereka.
            </p>
            <form id="form">
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">Alamat E-mail<span><input style="text-align: right" type = "email" maxlength = "30" class="input" placeholder="e-mail calon Mitra" name="ae" /></span></li>
              </ul>
              <button type="button" class="btn btn-warning btn-lg w-100" id="submit">Kirim Link</button>
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
        url:"reference-process",  
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