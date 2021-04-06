<?php

class Pr_model{

	private $db;

	public function __construct()
	{
		$this->db = new Database;
    }

    public function getOpenPR(){
        $user = $_SESSION['usr']['user'];
        $this->db->query("SELECT distinct a.prnum, b.warehouse, c.deskripsi as 'whsname', b.typepr, b.prdate, b.note, b.requestby, a.approvestat From v_pr004 as a inner join t_pr01 as b on a.prnum = b.prnum left join t_gudang as c on b.warehouse = c.gudang WHERE a.approvestat = '1' and a.createdby = '$user' order by a.prnum desc");
        return $this->db->resultSet();
    }

    public function getOpenPrList(){
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        if($_SESSION['usr']['userlevel'] === 'SysAdmin'){
            $this->db->query("SELECT * From v_pr001 WHERE approvestat = '1'");
        }elseif($_SESSION['usr']['userlevel'] === 'Admin'){
            $this->db->query("SELECT * From v_pr001 WHERE approvestat = '1'");
        }else{
            $this->db->query("SELECT * From v_pr001 WHERE approvestat = '1' and createdby = '$user'");
        }
		return $this->db->resultSet();
    }

    public function getApprovedPR(){
        $user = $_SESSION['usr']['user'];
        $dept = $_SESSION['usr']['department'];
        $this->db->query("SELECT * FROM v_pr005");
		return $this->db->resultSet();
    }

    public function getNextNumber($object){
		$this->db->query("CALL sp_NextNriv('$object')");
		return $this->db->single();
    }    

    public function getPRheader($prnum){
		$this->db->query("SELECT a.*, b.deskripsi as 'whsname', fGetNamaUser(a.createdby) as 'crtby', fGetApproveDatePR(a.prnum) as 'appdate' From t_pr01 as a left join t_gudang as b on a.warehouse = b.gudang Where a.prnum = '$prnum'");
		return $this->db->single();
    }

    public function getPRitem($prnum){
		$this->db->query("Select * From t_pr02 Where prnum = '$prnum'");
		return $this->db->resultSet();
    }

    public function getPR01($prnum){
		$this->db->query("SELECT * From t_pr01 Where prnum = '$prnum'");
		return $this->db->single();
    }

    public function updatepr($data, $prnum){
        $date = $this->getPR01($prnum);
        $this->delete($prnum);
        $this->savepr($data, $prnum, $date['createdon']);
    }

    public function savepr($data, $prnum, $createdon = null){
        $no = 0;
        $matnr = $data['itm_material'];
        $maktx = $data['itm_matdesc'];
        $menge = $data['itm_qty'];
        $meins = $data['itm_unit'];
        $txz01 = $data['itm_remark'];

        $query1 = "INSERT INTO t_pr01(prnum,typepr,note,prdate,approvestat,warehouse,requestby,createdon,createdby)
                   VALUES(:prnum,:typepr,:note,:prdate,:approvestat,:warehouse,:requestby,:createdon,:createdby)
                   ON DUPLICATE KEY UPDATE typepr=:typepr,note=:note, prdate=:prdate,approvestat=:approvestat,warehouse=:warehouse,requestby=:requestby,createdon=:createdon,createdby=:createdby";
        
        if($createdon == null){
            $createdon = date('Y-m-d');
        }

        $this->db->query($query1);
		$this->db->bind('prnum',      $prnum);
        $this->db->bind('typepr',     $data['prtype']);
        $this->db->bind('note',       $data['note']);
        $this->db->bind('prdate',     $data['reqdate']);
        $this->db->bind('approvestat','1');
        $this->db->bind('warehouse',  $data['warehouse']);
        $this->db->bind('requestby',  $data['requestor']);
		$this->db->bind('createdon',  $createdon);
        $this->db->bind('createdby',  $_SESSION['usr']['user']);
        $this->db->execute();
        $rows = 0;

        $query2 = "INSERT INTO t_pr02(prnum,pritem,material,matdesc,quantity,unit,approvestat,remark,createdon,createdby)
        VALUES(:prnum,:pritem,:material,:matdesc,:quantity,:unit,:approvestat,:remark,:createdon,:createdby)
        ON DUPLICATE KEY UPDATE material=:material, matdesc=:matdesc, quantity=:quantity, unit=:unit, approvestat=:approvestat, remark=:remark";
        $this->db->query($query2);
        for($i = 0; $i < count($matnr); $i++){
            $rows = $rows + 1;
            $this->db->bind('prnum',    $prnum);
			$this->db->bind('pritem',   $rows);
			$this->db->bind('material', $matnr[$i]);
			$this->db->bind('matdesc',  $maktx[$i]);
            
            $_menge = "";
            $_menge = str_replace(".", "",  $menge[$i]);
            $_menge = str_replace(",", ".", $_menge);
            $this->db->bind('quantity', $_menge);
            $this->db->bind('unit',     $meins[$i]);
            $this->db->bind('approvestat','1');
            $this->db->bind('remark',   $txz01[$i]);
            $this->db->bind('createdon',  $createdon);
            $this->db->bind('createdby',  $_SESSION['usr']['user']);
            $this->db->execute();
        }
        return $this->db->rowCount();
    }

    public function uploadfile($refdoc, $item, $temp, $location, $filename, $fileType){
        $date       = date("Y-m-d");
        $query1 = "INSERT INTO t_files(object,refdoc,item,filename,filetype,filepath,createdby,createdon)
                   VALUES(:object,:refdoc,:item,:filename,:filetype,:filepath,:createdby,:createdon)
                   ON DUPLICATE KEY UPDATE filename=:filename,filetype=:filetype,filepath=:filepath,createdby=:createdby,createdon=:createdon";
        
        $this->db->query($query1);
        $this->db->bind('object',     'PR');
        $this->db->bind('refdoc',     $refdoc);
        $this->db->bind('item',       $item);
        $this->db->bind('filename',   $filename);
        $this->db->bind('filetype',   $fileType);
        $this->db->bind('filepath',   $location);
        $this->db->bind('createdby',  $_SESSION['usr']['user']);
        $this->db->bind('createdon',  $date);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    public function kirimnotifpr($prnum){
        $toemail = 'husnulmub@gmail.com'; //email penerima
        $pesan   = 'Silahkan approve pr '. $prnum ; //isi email
        
        $email    = 'erpms100@gmail.com'; //email pengirim, silahkan diganti dengan email sendiri
        $password = 's_erp.v100'; //password gmail
        
        $to_id = $toemail;
        $message = $pesan;
        $subject = 'Purchase Requisition '. $prnum ;
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
            <p>Mohon untuk melakukan approve/reject untuk PR ". $prnum .".</p>
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

    public function delete($prnum){
        $this->db->query('DELETE FROM t_pr01 WHERE prnum=:prnum');
        $this->db->bind('prnum',$prnum);
        $this->db->execute();
  
        return $this->db->rowCount();
    }

    public function deletepritem($prnum, $pritem){
        $this->db->query('DELETE FROM t_pr02 WHERE prnum=:prnum AND pritem=:pritem');
        $this->db->bind('prnum',  $prnum);
        $this->db->bind('pritem', $pritem);
        $this->db->execute();
  
        return $this->db->rowCount();
    }

    public function approvepr($prnum){
        $query = "UPDATE t_pr01 set status=:status, appby=:appby WHERE prnum=:prnum";
        $this->db->query($query);
      
        $this->db->bind('prnum',  $prnum);
        $this->db->bind('status', '2');
        $this->db->bind('appby',  $_SESSION['usr']['user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function rejectpr($prnum){
        $query = "UPDATE t_pr01 set status=:status WHERE prnum=:prnum";
        $this->db->query($query);
      
        $this->db->bind('prnum',  $prnum);
        $this->db->bind('status', '3');
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function close($prnum){
        $query = "UPDATE t_pr01 set status=:status WHERE prnum=:prnum";
        $this->db->query($query);
      
        $this->db->bind('prnum',  $prnum);
        $this->db->bind('status', '4');
        $this->db->execute();

        return $this->db->rowCount();
    }
}