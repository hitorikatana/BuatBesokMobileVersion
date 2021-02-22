<?php require 'header.php'; ?>

<div class="page-content-wrapper">
  <div class="container">
    <!-- Support Wrapper-->
    <div class="support-wrapper py-3">
      <h4 class="faq-heading text-center">Status Pemesanan</h4>

      <!-- baru masuk-->
      <div class="accordian-area-wrapper mt-3">
        <div class="card accordian-card clearfix">
          <div class="card-body">
            <h5 class="accordian-title">Baru Masuk</h5>
            <div class="accordion" id="accordionExample">
              
              <?php
              $sql   = "SELECT order_code FROM tbl_order WHERE order_status = 'BARU' AND partner_id = '".$_SESSION['partner_id']."'";
              $h     = mysqli_query($conn, $sql);
              if(mysqli_num_rows($h)==0) { echo 'Tidak ada data'; }
              while($row   = mysqli_fetch_assoc($h)) {
              ?>              
              <div class="accordian-header" id="headingOne">
                <button class="d-flex align-items-center justify-content-between w-100 collapsed btn" type="button" aria-expanded="false" href=#><span><i class="lni-invention"></i><a href="order-status-detail?<?php echo $row['order_code'] ?>"> Kode order <?php echo $row['order_code'] ?></span><i class="lni-chevron-right"></i></a></button>
              </div>
              <?php } ?>
              
            </div>
          </div>
        </div>
      </div>

      <!-- SEDANG DIPROSES-->
      <div class="accordian-area-wrapper mt-3">
        <div class="card accordian-card seller-card clearfix">
          <div class="card-body">
            <h5 class="accordian-title">Sedang Diproses</h5>
            <div class="accordion" id="accordionExample">
              
              <?php
              $sql   = "SELECT order_code FROM tbl_order WHERE order_status = 'DIPROSES' AND partner_id = '".$_SESSION['partner_id']."'";
              $h     = mysqli_query($conn, $sql);
              if(mysqli_num_rows($h)==0) { echo 'Tidak ada data'; }              
              while($row   = mysqli_fetch_assoc($h)) {
              ?>              
              <div class="accordian-header" id="headingOne">
                <button class="d-flex align-items-center justify-content-between w-100 collapsed btn" type="button" aria-expanded="false" href=#><span><i class="lni-invention"></i>Kode order <?php echo $row['order_code'] ?></span><i class="lni-chevron-right"></i></button>
              </div>
              <?php } ?>
              
            </div>
          </div>
        </div>
      </div>

      <!-- SEDANG DIKIRIM-->
      <div class="accordian-area-wrapper mt-3">
        <div class="card accordian-card others-card clearfix">
          <div class="card-body">
            <h5 class="accordian-title">Sedang Dikirim</h5>
            <div class="accordion" id="accordionExample">
              
              <?php
              $sql   = "SELECT order_code FROM tbl_order WHERE order_status = 'DIKIRIM' AND partner_id = '".$_SESSION['partner_id']."'";
              $h     = mysqli_query($conn, $sql);
              if(mysqli_num_rows($h)==0) { echo 'Tidak ada data'; }              
              while($row   = mysqli_fetch_assoc($h)) {
              ?>              
              <div class="accordian-header" id="headingOne">
                <button class="d-flex align-items-center justify-content-between w-100 collapsed btn" type="button" aria-expanded="false" href=#><span><i class="lni-invention"></i>Kode order <?php echo $row['order_code'] ?></span><i class="lni-chevron-right"></i></button>
              </div>
              <?php } ?>
              
            </div>
          </div>
        </div>
      </div>

      <!-- SAMPAI-->
      <div class="accordian-area-wrapper mt-3">
        <div class="card accordian-card others-card clearfix">
          <div class="card-body">
            <h5 class="accordian-title">Telah Sampai</h5>
            <div class="accordion" id="accordionExample">
              
              <?php
              $sql   = "SELECT order_code FROM tbl_order WHERE order_status = 'SAMPAI' AND partner_id = '".$_SESSION['partner_id']."'";
              $h     = mysqli_query($conn, $sql);
              if(mysqli_num_rows($h)==0) { echo 'Tidak ada data'; }              
              while($row   = mysqli_fetch_assoc($h)) {
              ?>              
              <div class="accordian-header" id="headingOne">
                <button class="d-flex align-items-center justify-content-between w-100 collapsed btn" type="button" aria-expanded="false" href=#><span><i class="lni-invention"></i>Kode order <?php echo $row['order_code'] ?></span><i class="lni-chevron-right"></i></button>
              </div>
              <?php } ?>
              
            </div>
          </div>
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