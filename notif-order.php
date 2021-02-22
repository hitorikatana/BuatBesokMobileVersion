<?php
header("Content-Type: application/json");
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
$partner_id = input_data(filter_var($_POST['partner_id'],FILTER_SANITIZE_STRING));

$sql_acc    = "SELECT fcm_id FROM tbl_partner WHERE partner_id = '".trim($partner_id)."'";
$h_acc      = mysqli_query($conn, $sql_acc);

if (mysqli_num_rows($h_acc) > 0) {
    $statusFcm = "0";
    $title = "Pemesanan Barang Pada Buat Besok";
    $body = "Selamat, pemesanan melalui Buat Besok berhasil dilakukan";

    while ($row_acc = mysqli_fetch_assoc($h_acc)) {

        $TOKEN_FCM      = $row_acc['fcm_id'];
        $partner_id     = $row_acc['partner_id'];
        $url = "https://fcm.googleapis.com/fcm/send";
        $msg = [
            "title" => $title,
                "body"  => $body,
                "sound" => "default",
                "clickAction"=> ".mainActivity"
        ];

        $data = [
            "url"        => "https://mobile.buatbesok.com/cart-detail?id=1"     
        ];

        $fields = [
            'to' => $TOKEN_FCM,
            'notification' => $msg,
            "priority"=>"high",
            'data' => $data
        ];
            
        $headers = [
                'Authorization: key=AAAAr0s68oo:APA91bE9Myve98fvRTX62TuPK8_EkKEWuQ5vPdAJ43b1Zr4UGxI_XS8XDJxmAGC1ln8vr9AcEyBoDfKuiOxEMrBHFLe1dTR3G2X4NVRRZFkHia7Z3bx7iP_emE0zaWucbMCnhxLUnDFx',
                            'Content-Type: application/json'
        ];

                
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
            $result1 = curl_exec ( $ch );
            curl_close ( $ch );
            $result = json_decode($result1);
               
           if($result->success == "1")
           {
            $statusFcm = "1";
           }
        }
    }
   
    if ($statusFcm == "1") {
       $json_e = array('status' =>200, 'message' => "Sukses" );
    }else{
        $json_e = array('status' =>201, 'message' => "Pengiriman notifikasi gagal, silakan mencoba lagi" );
    }
    
    mysqli_query($conn, "INSERT into tbl_partner_notification (partner_id,title,created_date,detail,read_status) values (
                '".$partner_id."',
                '".$title."',
                UTC_TIMESTAMP(),
                '".$body."',
                '0'

            )");

}else{
   $json_e = array('status' =>201, 'message' => "ops, nomor HP pembeli tidak ditemukan / salah nih" );
}
         
echo json_encode($json_e); 
?>