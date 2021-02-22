<?php require 'header.php'; ?>
<div class="page-content-wrapper">
  <div class="container">
    <!-- Cart Wrapper-->
    <div class="cart-wrapper-area py-3">
      <div class="cart-table card mb-3">
        <div class="table-responsive card-body">
          <table class="table mb-0">
            <tbody>

            <?php
              $sql = "SELECT order_detail_id, product_id, order_code, sum(order_detail_qty) as qty, sum(order_detail_sub_total) as sub, a.product_name, a.product_unit, a.product_price, b.product_minimum_order FROM tbl_order_detail a INNER JOIN tbl_product b USING (product_id) WHERE partner_id = '".$_SESSION['partner_id']."' AND order_detail_status = 'PENDING' GROUP BY a.product_id ORDER BY a.product_name";
              $h = mysqli_query($conn, $sql);

              $sql_tot   = "SELECT sum(order_detail_sub_total) as total FROM tbl_order_detail WHERE order_detail_status = 'PENDING' AND partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
              $h_tot     = mysqli_query($conn, $sql_tot);
              $row_tot   = mysqli_fetch_assoc($h_tot);

              if(mysqli_num_rows($h)==0) {
              ?>
                <div class="alert alert-info ks-solid text-center" role="alert">Belum ada pesanan.<br/><br/><a href="home" class="btn btn-danger">Ayo order barang disini</a></div>
            <?php 
              }else{
              while($row = mysqli_fetch_assoc($h)) {
                $order_code = $row['order_code'];
            ?>
              <tr>
                <th scope="row">
                  <a class="remove-product" href="#" id="delete-link-<?php echo $row['product_id']; ?>"><i class="lni-close"></i></a>
                </th>
                <form id="form-<?php echo $row['product_id'] ?>">
                  <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>" />
                  <input type="hidden" name="order_code" value="<?php echo $row['order_code'] ?>" />
                <td>
                  <b><?php echo $row['product_name'] ?></b><br/><span><?php echo $row['qty'].' '.$row['product_unit'].' x Rp. '.number_format($row['product_price'],0,",",".") ?><br/>
                    Minimum order <?php echo $row['product_minimum_order'].' '.$row['product_unit'] ?></span>
                  <br/><br/>
                  <div class="quantity">Ubah jumlah
                    <input class="qty-text" name="order_detail_qty" type="text" value="<?php echo $row['qty'] ?>" /> <?php echo $row['product_unit'] ?> <button class="btn btn-warning"  id="submit-<?php echo $row['product_id'] ?>">ubah</button>
                  </div>
                </td>

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
                        url:"cart-update",  
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
                </form>

                <script type="text/javascript">
                  $(document).ready(function(){
                      $(document).on('click', '#delete-link-<?php echo $row['product_id']; ?>', function(e){             
                        swal("Anda akan menghapus <?php echo $row['product_name'] ?> dari keranjang", {
                          buttons: {
                            cancel: "Nggak jadi",
                            catch: {
                              text: "Iya, lanjut",
                              value: "lanjut",
                            },
                          },
                        })
                        .then((value) => {
                          switch (value) {
                         
                            case "lanjut":
                              $("#results").html('<div class=text-center><img src=img/loading.gif><br/>Mohon tunggu, data sedang diunggah...</div>'); 
                              $("#page").fadeOut();

                              $.ajax({
                                url:"cart-delete",  
                                method:"POST",  
                                data: '1='+<?php echo $row['product_id'] ?>+'&2='+<?php echo $row['order_code'] ?>, 
                                success:function(data){ 
                                  $("#page").fadeIn();
                                  $('#results').html(data);  
                                  $('#submit').val('');  
                                }  
                              });
                              break;
                         
                            default:
                              return false;
                          }
                        });
                      });
                    });                 
                </script>

              </tr>
            <?php } ?>    
            </tbody>
          </table>
          
        </div>
      </div>

      <div class="card cart-amount-area">
        <div class="card-body d-flex align-items-center justify-content-between">
          <h5 class="total-price mb-0"><?php echo 'Rp. '.number_format($row_tot['total'],0,",",".") ?></h5><a class="btn btn-danger" href="#" id="finish">Selesaikan</a>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php require_once 'footer.php' ?>

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', '#finish', function(e){             
      swal("Anda akan menyelesaikan pesanan.\n\nPastikan NAMA BARANG dan JUMLAH PESANAN sudah sesuai.\n\nPesanan yang sudah masuk ke sistem TIDAK DAPAT DIUBAH KEMBALI", {
        buttons: {
          cancel: "Saya mau revisi",
          catch: {
            text: "Iya, lanjut",
            value: "lanjut",
          },
        },
      })
      .then((value) => {
        switch (value) {
       
          case "lanjut":
            $("#results").html('<div class=text-center><img src=img/loading.gif><br/>Mohon tunggu, data sedang diunggah...</div>'); 
            $("#page").fadeOut();

            $.ajax({
              url:"cart-confirm",  
              method:"POST",  
              data: '1='+<?php echo $order_code ?>, 
              success:function(data){ 
                $("#page").fadeIn();
                $('#results').html(data);  
                $('#submit').val('');  
              }  
            });
            break;
       
          default:
            return false;
        }
      });
    });
  });                 
</script>