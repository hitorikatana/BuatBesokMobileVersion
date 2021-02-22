<?php 
require 'header.php';
?>

<div class="page-content-wrapper">
  <div class="blog-details-post-thumbnail">
    <?php if($param[1]==1) { ?>
      <img src="img/info01.jpg" alt="">
    <?php }elseif($param[1]==3) { ?>
      <img src="img/info03.jpg" alt="">      
    <?php }else{ ?>
      <img src="img/info02.jpg" alt="">
    <?php } ?>
  </div>
  <div class="product-description pb-3">

    <div class="product-title-meta-data bg-white mb-3 py-3">
      <div class="container">
        <h5 class="post-title"><?php if($param[1]==1) { ?>Tata cara aktivasi dan pesan barang<?php }elseif($param[1]==3){ ?>Ada Kabar Gembira Buat Mitra! <?php }else{ ?>Informasi jam tutup pesanan<?php } ?></h5>
      </div>
    </div>
    <div class="post-content bg-white py-3 mb-3">
      <div class="container">
        <?php if($param[1]==1) { ?>
          <p>Halo Mitra, selamat bagi Anda yang baru saja mendaftar dan berhasil login pada aplikasi ini. Sebelum Anda bisa memesan barang disini, ada baiknya Anda melengkapi data diri berupa Nomor KTP, Alamat termasuk Propinsi, Kabupaten/Kota hingga Kecamatan.<br/><br/>
          Selain itu, Anda unggah dua foto: Foto KTP dan Foto Anda sambil pegang KTP.<br/><br/>
          Kenapa harus gitu ya? Ini biar kita berdua sama-sama enak ya :)<br/><br/>
          Kita bermitra tentunya atas dasar saling percaya dan saling komitmen. Kami berkomitmen untuk memberikan modal berupa barang dagangan yang dikirim ke alamat Anda secara cuma-cuma dan baru Anda bayarkan kemudian. Untuk itulah kami butuh komitmen dari Anda sebagai mitra. Jadi enak kan? :)
          <br/><br/>
          Untuk melengkapi data diatas, yuk <a href="profile">klik halaman ini</a> untuk mulai mengunggah data Anda. Setelah itu, kami akan lakukan validasi data maksimal 2 hari kerja. Anda akan mendapatkan email persetujuan setelah kami selesai validasi data Anda. Lalu setelah Anda terverifikasi, Anda dapat mulai memesan barang disini.
          <br/><br/>
          <a href="profile" class="btn_1 btn btn-warning full-width">Mulai verifikasi data</a>
          </p>
        <?php }elseif($param[1]==3) { ?>
          <p>Alhamdulillah, ada kabar gembira nih dari Buat Besok buat Mitra semuanya...
            <br/>
            <br/>Harga jual kami turunkan, biar Mitra bisa dapat keuntungan lebih besar lagi<br/>
            <br/>Mitra boleh menjual dengan harga yang ditentukan sendiri, tidak ada patokan harga jual dari kami<br/>
            <br/>Minimum pemesanan adalah 10 kg untuk total produk, supaya kita bisa sama-sama tidak rugi ya :)<br/>
            <br/>Mitra boleh menjual kemana saja yang menurut Mitra memiliki prospek penjualan yang bagus<br/>
            <br/>
            Semoga semakin sukses dan barokah ya jualannya :)
        <?php }else{ ?>
          <p>Untuk saat ini, kami membatasi jam tutup pesanan untuk memberikan pelayanan yang optimal kepada Anda. Jam tutup pesanan adalah setiap hari Jumat jam 16:00 WIB. Pesanan yang dilakukan diatas jam tersebut akan diproses pada Jumat berikutnya.
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php require_once 'footer.php' ?>