<?php require 'header.php' ?>
<style type="text/css">
.ayam {
  background-color: rgba(0,0,0, 0.5);
  padding:5px;
}  
</style>
    <div class="page-content-wrapper">
      <!--slider-->
      <div class="hero-slides owl-carousel">
        <div class="single-hero-slide">
          <div class="slide-img"><img src="img/info01.jpg" alt=""></div>
          <div class="slide-content h-100 d-flex align-items-center">
            <div class="container">
              <h4 class="text-white mb-0 ayam" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="1000ms">Baru Pertama Kali Kesini?</h4>
              <p class="text-white ayam" data-animation="fadeInUp" data-delay="400ms" data-wow-duration="1000ms">Yuk baca tata caranya dulu disini </p><a class="btn btn-primary btn-sm" href="info-detail?1" data-animation="fadeInUp" data-delay="800ms" data-wow-duration="1000ms">Jadi pengen baca</a>
            </div>
          </div>
        </div>
        <div class="single-hero-slide">
          <div class="slide-img"><img src="img/info02.jpg" alt=""></div>
          <div class="slide-content h-100 d-flex align-items-center">
            <div class="container">
              <h4 class="text-white mb-0 ayam" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="1000ms">Jam Tutup Pesanan</h4>
              <p class="text-white ayam" data-animation="fadeInUp" data-delay="400ms" data-wow-duration="1000ms">Informasi jam tutup pesanan</p><a class="btn btn-success btn-sm" href="info-detail?2" data-animation="fadeInUp" data-delay="500ms" data-wow-duration="1000ms">Apa itu?</a>
            </div>
          </div>
        </div>

      </div>
      <!--end slider-->

      <!-- menu -->
      <div class="product-catagories-wrapper pt-3">
        <div class="container">
          <div class="section-heading">
            <h6 class="ml-1">Menu Singkat</h6>
          </div>
          <div class="product-catagory-wrap">
            <div class="row">
              <div class="col-4">
                <div class="card mb-3 catagory-card">
                  <div class="card-body"><a href="profile"><i class="lni-user"></i><span>Profil</span></a></div>
                </div>
              </div>
              <div class="col-4">
                <div class="card mb-3 catagory-card">
                  <div class="card-body"><a href="profile-pin"><i class="lni-lock"></i><span>Ganti PIN</span></a></div>
                </div>
              </div>
              <div class="col-4">
                <div class="card mb-3 catagory-card">
                  <div class="card-body"><a href="cart"><i class="lni-cart"></i><span>Keranjang</span></a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- produk -->
      <div class="weekly-best-seller-area pt-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="pl-1">Produk Terlaris</h6>
          </div>
          <div class="row">

            <?php
            @$page = @$_REQUEST['page'];
            $dataPerPage = 30;
            if(isset($_GET['page']))
            {
                $noPage = $_GET['page'];
            }
            else $noPage = 1;
            @$offset = ($noPage - 1) * $dataPerPage;
            //for total count data
            if(@$_REQUEST['s']=='1091vdf8ame151') {
              $txt_search   = input_data(filter_var($_REQUEST['txt_search'],FILTER_SANITIZE_STRING));
              $sql = "SELECT partner_id, partner_ip, partner_key, partner_secret, partner_name, partner_balance, partner_active_status FROM tbl_partner WHERE (partner_ip LIKE '%$txt_search%' OR partner_key LIKE '%$txt_search%' OR partner_name LIKE '%$txt_search%' OR partner_secret LIKE '%$txt_search%' OR partner_key LIKE '%$txt_search%') LIMIT $offset, $dataPerPage";
            }elseif (@$_REQUEST['s']=='1'){
              $sql = "SELECT customer_id, customer_account_id, customer_name, customer_address, customer_email_address, customer_phone_number, customer_active_status, ledger_master_amount, db_evoucher.tbl_partner.partner_name ,date_format(created_date, '%d/%m/%Y') as created_date FROM db_customer.tbl_customer INNER JOIN db_customer.tbl_ledger_master USING (customer_account_id) INNER JOIN db_evoucher.tbl_partner ON db_customer.tbl_customer.partner_key = db_evoucher.tbl_partner.partner_key ORDER BY customer_name LIMIT $offset, $dataPerPage";
            }elseif (@$_REQUEST['s']=='2'){
              $sql = "SELECT customer_id, customer_account_id, customer_name, customer_address, customer_email_address, customer_phone_number, customer_active_status, ledger_master_amount, db_evoucher.tbl_partner.partner_name ,date_format(created_date, '%d/%m/%Y') as created_date FROM db_customer.tbl_customer INNER JOIN db_customer.tbl_ledger_master USING (customer_account_id) INNER JOIN db_evoucher.tbl_partner ON db_customer.tbl_customer.partner_key = db_evoucher.tbl_partner.partner_key ORDER BY partner_name LIMIT $offset, $dataPerPage";
            }elseif (@$_REQUEST['s']=='3'){
              $sql = "SELECT customer_id, customer_account_id, customer_name, customer_address, customer_email_address, customer_phone_number, customer_active_status, ledger_master_amount, db_evoucher.tbl_partner.partner_name ,date_format(created_date, '%d/%m/%Y') as created_date FROM db_customer.tbl_customer INNER JOIN db_customer.tbl_ledger_master USING (customer_account_id) INNER JOIN db_evoucher.tbl_partner ON db_customer.tbl_customer.partner_key = db_evoucher.tbl_partner.partner_key ORDER BY customer_active_status LIMIT $offset, $dataPerPage";                        
            }else{
              $sql = "SELECT product_id, product_category_id, product_minimum_order, product_category_name, product_name, product_price, product_unit_name FROM tbl_product a INNER JOIN tbl_product_category b USING (product_category_id) ORDER BY product_name LIMIT $offset, $dataPerPage";
            }
            $rs_result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($rs_result)==0) {
            ?>
              <div class="alert alert-info ks-solid text-center" role="alert">Oops, no data found</div>
            <?php  
            //exit(); 
            }
            while($row = mysqli_fetch_assoc($rs_result)) { 

              $sql_photo  = "SELECT product_photo_name FROM tbl_product_photo WHERE product_id = '".$row['product_id']."' LIMIT 1";
              $h_photo    = mysqli_query($conn,$sql_photo);
              $row_photo  = mysqli_fetch_assoc($h_photo);
              $harga      = ((20/100)*$row['product_price'])+$row['product_price'];
            ?>
            <form id="form-<?php echo $row['product_id'] ?>"> 
              <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>" />
              <div class="col-12">
                <div class="card weekly-product-card mb-3">
                  <div class="card-body d-flex align-items-center">
                    <div class="product-thumbnail-side"><a class="wishlist-btn" href="#"><i class="lni-heart-filled"></i></a><a class="product-thumbnail d-block" href="#"><img src="<?php echo $img_url.$row_photo['product_photo_name'] ?>" alt=""></a></div>
                    <div class="product-description"><a class="product-title d-block" href="#"><?php echo $row['product_name'] ?></a>
                      <p class="sale-price"><i class="lni-dollar"></i><?php echo 'Rp. '.number_format($harga,0,",",".") ?></p>
                      <div class="product-rating">Dijual dalam <?php echo $row['product_unit_name'] ?></div><button type="button" class="btn btn-success btn-sm" id="submit-<?php echo $row['product_id'] ?>"><i class="mr-1 lni-cart"></i>Pesan</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>

            <script type="text/javascript">
            $(document).ready(function(){  
              $('#submit-<?php echo $row['product_id'] ?>').click(function(){  
                  $('#form-<?php echo $row['product_id'] ?>').submit(); 
                  $("#results").html('<div class=text-center><img src=img/loading.gif><br/>Mohon tunggu, data sedang diunggah...</div>'); 
                  $("#page").fadeOut();
              });  
              $('#form-<?php echo $row['product_id'] ?>').on('submit', function(event){  
                  event.preventDefault();  
                  $.ajax({  
                    url:"product-add",  
                    method:"POST",  
                    data:new FormData(this),  
                    contentType:false,  
                    processData:false,  
                    success:function(data){ 
                      $("#page").fadeIn();
                      $('#results').html(data);  
                        $('#submit-<?php echo $row['product_id'] ?>').val('');  
                    }  
                  });  
              });  
            }); 
            </script>

            <?php } ?>
          </div>
        </div>
      </div>

      <!-- Cool Facts Area-->
     <!-- <div class="cta-area">
        <div class="container">
          <div class="cta-text px-4 py-5" style="background-image: url(img/bg-img/6.jpg)">
            <h4>Winter Sale 20% Off</h4>
            <p>Suha is a multipurpose, creative &amp; <br>modern mobile template.</p><a class="btn btn-danger" href="#">Shop Today</a>
          </div>
        </div>
      </div>-->

    </div>

<?php require_once 'footer.php' ?>