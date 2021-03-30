<?php

class Po_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function getNextPONumber($object){
		$this->db->query("CALL sp_NextNriv('$object')");
		return $this->db->single();
    }
    
    public function getPOHeader($ponum){
        $this->db->query("SELECT distinct ponum, podat, vendor, namavendor, note, approvestat, alamat, createdon, fGetNamaUser(createdby) as 'createdby', tf_price, tf_dest, tf_shipment, tf_shipdate, tf_top, tf_packing, ppn From v_po001 WHERE ponum = '$ponum'");
        return $this->db->single();
    }

    public function getPODetail($ponum){
        $this->db->query("SELECT *, ponum as 'refnum', poitem as 'refitem', '' as 'fromwhs', '-' as 'towhs' FROM t_po02 WHERE ponum = '$ponum'");
        return $this->db->resultSet();
    }

    public function getOpenPOitem($ponum){
        $this->db->query("SELECT *, ponum as 'refnum', poitem as 'refitem', '' as 'fromwhs', '-' as 'towhs' FROM t_po02 WHERE ponum = '$ponum' AND grstatus IS NULL");
        return $this->db->resultSet();
    }

    public function getOrderHeaderPrint($ponum){
        $this->db->query("SELECT a.*, b.namavendor, b.alamat FROM t_po01 as a inner join t_vendor as b on a.vendor = b.vendor WHERE ponum = '$ponum'");
        return $this->db->single();
    }

    public function getPOitemPrint($ponum){
        $this->db->query("SELECT a.*, b.partnumber FROM t_po02 as a left join t_material as b on a.material = b.material WHERE a.ponum = '$ponum'");
        return $this->db->resultSet();
    }
    
    public function listopenpo(){
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];

        if($_SESSION['usr']['userlevel'] === 'SysAdmin'){
            $this->db->query("SELECT * FROM v_po001 WHERE approvestat in('0','1')");
        }elseif($_SESSION['usr']['userlevel'] === 'Admin'){
            $this->db->query("SELECT * FROM v_po001 WHERE approvestat in('0','1') and department = '$dept'");
        }else{
            $this->db->query("SELECT * FROM v_po001 WHERE approvestat in('0','1') and createdby = '$user'");
        }
        return $this->db->resultSet();
    }

    public function updatepo($data, $ponum){
        $podata = $this->getPOHeader($ponum);
        $this->delete($ponum);
        $this->createpo($data, $ponum, $podata['podat']);
    }

    public function generatenopo($ponum){
        $this->db->query("SELECT fGeneratePONUM('$ponum') as 'ponum'");
        return $this->db->single();
    }

    public function createpo($data, $ponum, $createdon = null){
        // try {
            $no = 0;
            $date      = date("Y-m-d h:m:s");
            if($createdon == null){
                $createdon = $date;
            }

            // $ponumber = $this->generatenopo($ponum);
            $ponumber = $ponum;

            $query1 = "INSERT INTO t_po01(ponum,ext_ponum,podat,vendor,note,approvestat,currency,ppn,tf_price,tf_dest,tf_shipment,tf_top,tf_packing,tf_shipdate,createdon,createdby)
                       VALUES(:ponum,:ext_ponum,:podat,:vendor,:note,:approvestat,:currency,:ppn,:tf_price,:tf_dest,:tf_shipment,:tf_top,:tf_packing,:tf_shipdate,:createdon,:createdby)";
            
            $this->db->query($query1);
            $this->db->bind('ponum',       $ponum);
            $this->db->bind('ext_ponum',   $ponum);
            $this->db->bind('podat',       $data['podate']);
            $this->db->bind('vendor',      $data['vendor']);
            $this->db->bind('note',        $data['note']);
            if($_SESSION['usr']['jbtn'] >= 4){
                $this->db->bind('approvestat','2');
            }else{
                $this->db->bind('approvestat','1');
            }
            $this->db->bind('currency', 'IDR');
            $this->db->bind('ppn',         $data['ppnval']);
            $this->db->bind('tf_price',    $data['tf_price']);
            $this->db->bind('tf_dest',     $data['tf_dest']);
            $this->db->bind('tf_shipment', $data['tf_shipment']);
            $this->db->bind('tf_top',      $data['tf_top']);
            $this->db->bind('tf_packing',  $data['tf_packing']);
            $this->db->bind('tf_shipdate', $data['tf_shipdate']);
            $this->db->bind('createdon',   $createdon);
            $this->db->bind('createdby',   $_SESSION['usr']['user']);
            $this->db->execute();
    
            $material = $data['itm_material'];
            $matdesc  = $data['itm_matdesc'];
            $quantity = $data['itm_qty'];
            $unit     = $data['itm_unit'];
            $price    = $data['itm_price'];
            $prnum    = $data['itm_prnum'];
            $pritem   = $data['itm_pritem'];
    
            $query2 = "INSERT INTO t_po02(ponum,poitem,material,matdesc,quantity,unit,price,grqty,prnum,pritem,approvestat,createdon,createdby)
                       VALUES(:ponum,:poitem,:material,:matdesc,:quantity,:unit,:price,:grqty,:prnum,:pritem,:approvestat,:createdon,:createdby)";
            $this->db->query($query2);
            $item = 0;
            for($i = 0; $i < count($material); $i++){
                $item = $item + 1;
                $this->db->bind('ponum',       $ponum);
                $this->db->bind('poitem',      $item);
                $this->db->bind('material',    $material[$i]);
                $this->db->bind('matdesc',     $matdesc[$i]);

                $_menge = "";
                $_menge = str_replace(".", "",  $quantity[$i]);
                $_menge = str_replace(",", ".", $_menge);

                $this->db->bind('quantity',    $_menge);
                $this->db->bind('unit',        $unit[$i]);
                $_price = "";
                $_price = str_replace(".", "",  $price[$i]);
                $_price = str_replace(",", ".", $_price);
    
                $this->db->bind('price',       $_price);
                $this->db->bind('grqty',       '0');
    
                if($prnum[$i] === "NULL" || $prnum[$i] === "null" || $prnum[$i] === ""){
                    $this->db->bind('prnum',       null);
                    $this->db->bind('pritem',      null);
                }else{
                    $this->db->bind('prnum',       $prnum[$i]);
                    $this->db->bind('pritem',      $pritem[$i]);
                }
                $this->db->bind('approvestat', '1');
                $this->db->bind('createdon',   $createdon);
                $this->db->bind('createdby',   $_SESSION['usr']['user']);
                $this->db->execute();
            }
            return $this->db->rowCount();
        // }catch (Exception $e) {
        //     $message = 'Caught exception: '.  $e->getMessage(). "\n";
        //     Flasher::setErrorMessage($message,'error');
        //     return 0;
        // }
    }

    public function kirimnotifpr($ponum){
        $toemail = 'husnulmub@gmail.com'; //email penerima
        $pesan   = 'Silahkan approve pr '. $ponum ; //isi email
        
        $email    = 'erpms100@gmail.com'; //email pengirim, silahkan diganti dengan email sendiri
        $password = 's_erp.v100'; //password gmail
        
        $to_id = $toemail;
        $message = $pesan;
        $subject = 'Purchase Order '. $ponum ;
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
            <p>Mohon untuk melakukan approve/reject untuk PO ". $ponum .".</p>
            <br>https://erp.pilardwijaya.com/<br>
            <p>Terimakasih,</p>
            <p>Staff</p>
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

    public function delete($ponum){
        $this->db->query('DELETE FROM t_po01 WHERE ponum=:ponum');
        $this->db->bind('ponum',$ponum);
        $this->db->execute();
  
        return $this->db->rowCount();
    }

    public function delete_error($ponum){
        $this->db->query('DELETE FROM t_po01 WHERE ponum=:ponum');
        $this->db->bind('ponum',$ponum);
        $this->db->execute();
    }

    public function approvepo($ponum){
        $query = "UPDATE t_po01 set approvestat=:approvestat WHERE ponum=:ponum";
        $this->db->query($query);
      
        $this->db->bind('ponum',  $ponum);
        $this->db->bind('approvestat', '2');
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function rejectpo($ponum){
        $query = "UPDATE t_po01 set approvestat=:approvestat WHERE ponum=:ponum";
        $this->db->query($query);
      
        $this->db->bind('ponum',  $ponum);
        $this->db->bind('approvestat', '3');
        $this->db->execute();

        return $this->db->rowCount();
    }
}