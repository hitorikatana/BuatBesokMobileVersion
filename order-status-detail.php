<?php require 'header.php'; ?>
<div class="page-content-wrapper">
  <div class="container">
    <!-- Cart Wrapper-->
    <div class="cart-wrapper-area py-3">
      <h5 class="faq-heading text-center">Kode order <?php echo $param[1] ?></h5>
      <div class="cart-table card mb-3">
        <div class="table-responsive card-body">
          <table class="table mb-0">
            <tbody>

            <?php
              $sql = "SELECT order_detail_id, product_id, order_code, sum(order_detail_qty) as qty, sum(order_detail_sub_total) as sub, product_name, product_unit, product_price FROM tbl_order_detail WHERE partner_id = '".$_SESSION['partner_id']."' AND order_code = '".$param[1]."' GROUP BY product_id ORDER BY product_name";
              $h = mysqli_query($conn, $sql);

              $sql_tot   = "SELECT sum(order_detail_sub_total) as total, order_detail_status FROM tbl_order_detail WHERE order_code = '".$param[1]."' AND partner_id = '".$_SESSION['partner_id']."' LIMIT 1";
              $h_tot     = mysqli_query($conn, $sql_tot);
              $row_tot   = mysqli_fetch_assoc($h_tot);

              if(mysqli_num_rows($h)==0) {
              ?>
                <div class="alert alert-info ks-solid text-center" role="alert">Belum ada pesanan. <a href="home">Ayo order barang disini</a></div>
            <?php 
              }else{
              while($row = mysqli_fetch_assoc($h)) {
                $order_code = $row['order_code'];
            ?>
              <tr>
                <td>
                  <b><?php echo $row['product_name'] ?></b><br/><span><?php echo $row['qty'].' '.$row['product_unit'].' x Rp. '.number_format($row['product_price'],0,",",".") ?></span>
                </td>
              </tr>
            <?php }} ?>    
            </tbody>
          </table>
          
        </div>
      </div>

      <div class="card cart-amount-area">
        <div class="card-body d-flex align-items-center justify-content-between">
          <h5 class="total-price mb-0"><?php echo 'Rp. '.number_format($row_tot['total'],0,",",".") ?></h5><a class="btn btn-danger" href="#"><?php echo $row_tot['order_detail_status'] ?></a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once 'footer.php' ?>