<?php 

class Grpo_model{
    private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function getNextNumber($object){
		$this->db->query("CALL sp_NextNriv('$object')");
		return $this->db->single();
    }

    public function getpoitemgrqty($ponum, $poitem){
		$this->db->query("SELECT grqty from t_po02 where ponum = '$ponum' and poitem = '$poitem'");
		return $this->db->single();
    }

    public function pocompleted($ponum){
        $query = "UPDATE t_po01 set pocomplete=:pocomplete WHERE ponum=:ponum";
        $this->db->query($query);
        $this->db->bind('ponum', $ponum);
        $this->db->bind('pocomplete', 'X');
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function grpo($data, $grnum){
        $header = $data['header'][0];
        $items  = $data['items'];

        $year       = date("Y");
        $date       = date("Y-m-d");       
        // $totalvalue = $header['totalvalue'];
        $user       = $_SESSION['usr']['user'];

        $query1 = "INSERT INTO t_inv_h(grnum,year,idsupp,nmsup,tglterima,keterangan,idproject,createdon,createdby)
                   VALUES(:grnum,:year,:idsupp,:nmsup,:tglterima,:keterangan,:idproject,:createdon,:createdby)";
        
        $this->db->query($query1);
        $this->db->bind('grnum',      $grnum);
        $this->db->bind('year',       date("Y"));
        $this->db->bind('idsupp',     $header['vendor']);
        $this->db->bind('nmsup',      $header['namavendor']);
		$this->db->bind('tglterima',  $header['tglterima']);
        $this->db->bind('keterangan', $header['note']);
        $this->db->bind('idproject',  $header['project']);
		$this->db->bind('createdon',  date("Y-m-d"));
        $this->db->bind('createdby',  $_SESSION['usr']['user']);
        $this->db->execute();
        if ($this->db->rowCount() > 0){

            // $this->kirimnotifpr($grnum);
            $num = 0;
            
            for($i = 0; $i < sizeof($items); $i++){
                $qtytostock = 0;
                $kodebrg  = $items[$i]['kodebrg'];
                $namabrg  = $items[$i]['namabrg'];
                $jmlpesan = $items[$i]['grqty'];
                $satuan   = $items[$i]['satuan'];
                $harga    = $items[$i]['harga'];
                $ponum    = $items[$i]['ponum'];
                $poitem   = $items[$i]['poitem'];
                $num = $i + 1; 

                $this->db->query("CALL sp_grpo(
                    '$grnum',
                    '$year', 
                    '$num', 
                    '$kodebrg',
                    '$jmlpesan',
                    '$satuan',
                    '$harga',
                    '$ponum',
                    '$poitem',
                    '$date',
                    '$user',
                    '$jmlpesan',
                    '$namabrg'
                )");
                $this->db->execute();

                // $this->updatepostatus($ponum,$poitem,$jmlpesan);
            }

            return $this->db->rowCount();
            // $this->save_diskon($data,$grnum);
            // $this->updatepostatus($items);
        }
    }

    public function kirimnotifpr($ivnum){
        $toemail = 'husnulmub@gmail.com'; //email penerima
        $pesan   = 'Silahkan proses pembayaran '. $ivnum ; //isi email
        
        $email    = 'erpms100@gmail.com'; //email pengirim, silahkan diganti dengan email sendiri
        $password = 's_erp.v100'; //password gmail
        
        $to_id = $toemail;
        $message = $pesan;
        $subject = 'Receipt Purchase Order '. $ivnum ;
        $mail = new PHPMailer;
        $mail->FromName = "ERP System";
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = $email;
        $mail->Password = $password;
        $mail->addAddress($to_id);
        $mail->Subject = $subject;
        // $mail->msgHTML($message);
        $mail->IsHTML(true);
        $mail->Body = "
        <html>
        <head></head>
        <body>
            <p>Dear Bapak/Ibu,</p><br>
            <p>Mohon untuk melakukan payment purchase order dengan nomor penerimaan ". $ivnum .".</p>
            <br>https://erp.pilardwijaya.com/<br>
            <p>Terimakasih,</p>
            <p>". $_SESSION['usr']['user'] ."</p>
        </body>
        </html>
        ";
        if (!$mail->send()) {
            $error = "Mailer Error: " . $mail->ErrorInfo;
            return $error; 
        }
        else {
            return "Email terkirim";
        }
    }

    public function uploadfile($refdoc, $temp, $location, $filename, $fileType){
        

        $query1 = "INSERT INTO t_file(object,refdoc,filename,filetype,path)
                   VALUES(:object,:refdoc,:filename,:filetype,:path)";
        
        $this->db->query($query1);
        $this->db->bind('object',     'GRPO');
        $this->db->bind('refdoc',     $refdoc);
        $this->db->bind('filename',   $filename);
        $this->db->bind('filetype',   $fileType);
		$this->db->bind('path',       $location);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function updatepostatus($data){
        $rowcount = 0;
        for($i = 0; $i < sizeof($data); $i++){
            $ponum  = $data[$i]['ponum'];
            $poitem = $data[$i]['poitem'];
            $grqty  = $data[$i]['grqty'];
        
            $this->db->query("CALL sp_updateGrPOStatus(
                '$ponum',
                '$poitem', 
                '$grqty'
            )");
            $this->db->execute();
        }

        return $this->db->rowCount();
    }
}