<?php 
require 'header.php';
?>
  <div class="page-content-wrapper">
    <div class="container">
      <!-- Checkout Wrapper-->
      <div class="checkout-wrapper-area py-3">
        <div class="credit-card-info-wrapper">
          <div class="bank-ac-info">
            <p>Bantuan
              <br/><br/><span class="text-info">Ada yang kurang jelas, bingung atau butuh informasi tambahan? Silahkan ketik pertanyaan Anda disini agar kami dapat membantu Anda secepatnya.</span>
            </p>
            <form id="form">
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">Kategori<span>
                  <select class="dropdown" required name="help_category_id" style="text-align: right">
                    <option value=ALL>-- Pilih Jenis Bantuan --</option>
                    <?php
                    $sql1  = "SELECT * FROM tbl_help_category ORDER BY help_category_name";
                    $h1    = mysqli_query($conn,$sql1);
                    while($row1 = mysqli_fetch_assoc($h1)) {
                    ?>
                    <option value="<?php echo $row1['help_category_id'] ?>"><?php echo $row1['help_category_name'] ?></option>
                    <?php } ?>
                  </select>                  
                </span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Pertanyaan Anda<span>
                  <textarea style="text-align: right" class="input" name="help_q" placeholder="Ketik pertanyaan Anda disini"></textarea></span></li>
              </ul>
              <button type="button" class="btn btn-warning btn-lg w-100" id="submit">Kirim</button>
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
        url:"help-add",  
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