<?php 
require 'header.php';

$sql    = "SELECT partner_id, partner_name, partner_address, partner_phone_number, partner_email_address, province_id, kabupaten_id, kecamatan_id, partner_photo, partner_nomor_ktp, partner_photo_ktp, partner_ktp FROM tbl_partner WHERE partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
$h      = mysqli_query($conn, $sql);
$row    = mysqli_fetch_assoc($h);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>  
$(document).ready(function() {
    $('#province_id').change(function() {
        var province_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "profile-get-kabupaten.php",
            data: "province_id="+province_id+"&kabupaten_id="+<?php echo $row['kabupaten_id'] ?>,
            success: function(response){
                $("#kabupaten_id").html(response);                     
            }
        });
    });

    $('#kabupaten_id').change(function() {
        var kabupaten_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "profile-get-kecamatan.php",
            data: "kabupaten_id="+kabupaten_id,
            success: function(response){
                $("#kecamatan_id").html(response);                     
            }
        });
    });

});        
</script>
  <div class="page-content-wrapper">
    <div class="container">
      <!-- Checkout Wrapper-->
      <div class="checkout-wrapper-area py-3">
        <div class="credit-card-info-wrapper">
          <div class="bank-ac-info">
            <p>Perbaharui profil Anda disini. Profil yang lengkap diperlukan sebelum Anda dapat memesan barang.
              <br/><br/><span class="text-danger">Ada 3 data yang harus Anda lengkapi di bawah:</span>
              <br/><br/>
              <b>1. Lengkapi data Alamat</b></p>
            <form id="form_profile">
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">Nama<span><input style="text-align: right" type="text" class="input" placeholder="Nama Anda" name="partner_name" value="<?php echo $row['partner_name'] ?>" /></span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Alamat<span><input style="text-align: right" type="text" class="input" placeholder="Alamat" name="partner_address"  value="<?php echo $row['partner_address'] ?>" /></span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Nomor KTP<span><input style="text-align: right" type="text" class="input" placeholder="Nomor KTP" name="partner_nomor_ktp"  value="<?php echo $row['partner_nomor_ktp'] ?>" maxlength=16 /></span></li>                
                <li class="list-group-item d-flex justify-content-between align-items-center">Propinsi<span>
                  <select class="dropdown" required name="province_id" id="province_id" style="text-align: right">
                    <option value=ALL>-- Pilih Propinsi --</option>
                    <?php
                    $sql1  = "SELECT * FROM tbl_province ORDER BY name";
                    $h1    = mysqli_query($conn,$sql1);
                    while($row1 = mysqli_fetch_assoc($h1)) {
                        if($row1['id']==$row['province_id']) {
                    ?> 
                    <option value="<?php echo $row1['id'] ?>" selected="selected"><?php echo $row1['name'] ?></option>
                    <?php }else{ ?>
                    <option value="<?php echo $row1['id'] ?>"><?php echo $row1['name'] ?></option>
                    <?php }} ?>
                  </select>
                </span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Kota/Kabupaten<span>
                  <select class="dropdown" name="kabupaten_id" id="kabupaten_id" style="text-align: right">
                    <?php
                    $sql1 = "SELECT id, province_id, name FROM tbl_kabupaten_kota WHERE id = '".$row['kabupaten_id']."' LIMIT 1";
                    $result = mysqli_query($conn, $sql1);
                    echo $sql1;
                      $row1 = mysqli_fetch_array($result);
                      echo '<option value ='.$row1['id'].'>'.$row1['name'].'</option>';
                    ?>                    
                  </select>                  
                </span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Kecamatan<span>
                  <select class="dropdown" name="kecamatan_id" id="kecamatan_id" style="text-align: right">
                    <?php
                    $sql1 = "SELECT id, regency_id, name FROM tbl_kecamatan WHERE id = '".$row['kecamatan_id']."' LIMIT 1";
                    $result = mysqli_query($conn, $sql1);
                    echo $sql1;
                      $row1 = mysqli_fetch_array($result);
                      echo '<option value ='.$row1['id'].'>'.$row1['name'].'</option>';
                    ?>                    
                  </select>                  
                </span></li>
              </ul>
              <button type="button" class="btn btn-warning btn-lg w-100" id="submit_profile">Simpan Data</button>
            </form>

            <br/><br/>
            <p>
              <b>2. Unggah foto KTP Anda.</b><br/>Pastikan foto KTP terlihat dengan jelas.
            <?php if($row['partner_ktp']<>'') { ?>
              Foto yang sudah ada:<br/>
              <img width="50" src="<?php echo $img_url.$row['partner_ktp'] ?>" />
            <?php } ?>
            </p>
            <!-- upload ktp -->
            <form id="form_submit1">
              <input type="hidden" name="p_type" value="2">
              <ul class="list-group mb-3"> 
                <li class="list-group-item d-flex justify-content-between align-items-center">Foto KTP<span><input type="file" class="form-control" placeholder="Ambil Foto KTP" name="partner_ktp" id="partner_ktp" accept="image/*" capture="camera" />
                </span></li>
              </ul>
            </form>

            <br/><br/>
            <p>
              <b>3. Unggah foto Anda sambil pegang KTP</b><br/>Pastikan foto terlihat dengan jelas.
            <?php if($row['partner_photo_ktp']<>'') { ?>
              Foto yang sudah ada:<br/>
              <img width="50" src="<?php echo $img_url.$row['partner_photo_ktp'] ?>" />
            <?php } ?>
            </p>                       
            <!-- upload ktp + orangnya -->
            <form id="form_submit2">
              <input type="hidden" name="p_type" value="3">
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">Foto Anda Pegang KTP<span><input type="file" class="form-control" placeholder="Ambil Foto KTP" name="partner_photo_ktp" id="partner_photo_ktp" /></span></li>
              </ul>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once 'footer.php' ?>

<script>  
$(document).ready(function(){  
  $('#submit_profile').click(function(){  
      $('#form_profile').submit(); 
      $("#results").html('<div class=text-center><img src=img/loading.gif><br/>Mohon tunggu, data sedang diunggah...</div>'); 
      $("#page").fadeOut();
  });  
  $('#form_profile').on('submit', function(event){  
      event.preventDefault();  
      $.ajax({  
        url:"profile-edit",  
        method:"POST",  
        data:new FormData(this),  
        contentType:false,  
        processData:false,  
        success:function(data){ 
          $("#page").fadeIn();
          $('#results').html(data);  
            $('#submit_profile').val('');  
        }  
      });  
  });  
});

$(document).ready(function(){  
  $('#partner_ktp').change(function(){  
      $('#form_submit1').submit(); 
      $("#results").html('<div class=text-center><img src=img/loading.gif><br/>Mohon tunggu, foto sedang diunggah...</div>'); 
      $("#page").fadeOut();
  });  
  $('#form_submit1').on('submit', function(event){  
      event.preventDefault();  
      $.ajax({  
        url:"profile-photo-add",  
        method:"POST",  
        data:new FormData(this),  
        contentType:false,  
        processData:false,  
        success:function(data){ 
          $("#page").fadeIn();
          $('#results').html(data);  
            $('#partner_ktp').val('');  
        }  
      });  
  });  
});

$(document).ready(function(){  
  $('#partner_photo_ktp').change(function(){  
      $('#form_submit2').submit(); 
      $("#results").html('<div class=text-center><img src=img/loading.gif><br/>Mohon tunggu, foto sedang diunggah...</div>'); 
      $("#page").fadeOut();
  });  
  $('#form_submit2').on('submit', function(event){  
      event.preventDefault();  
      $.ajax({  
        url:"profile-photo-add",  
        method:"POST",  
        data:new FormData(this),  
        contentType:false,  
        processData:false,  
        success:function(data){ 
          $("#page").fadeIn();
          $('#results').html(data);  
            $('#partner_photo_ktp').val('');  
        }  
      });  
  });  
});  
</script> 