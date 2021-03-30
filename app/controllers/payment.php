<?php

class Payment extends Controller{

    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }
    
    public function index(){
		$data['title']    = 'Payment';
		$data['menu']     = 'Payment';
		$data['menu-dsc'] = '';
		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['grdata']   = $this->model('Invoice_model')->listgrtoinvoice();

		$this->view('templates/header_a', $data);
		$this->view('invoice/index', $data);
		$this->view('templates/footer_a');
	}
	
	public function process($grnum, $year, $vendor){
		$data['title']    = 'Payment Process';
		$data['menu']     = 'Payment Process';
		$data['menu-dsc'] = '';
		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['grdata']   = $this->model('Invoice_model')->grdata($grnum, $year);
		$data['grnum']    = $grnum;
		$data['year']     = $year;
		$data['vendor']   = $this->model('Vendor_model')->getVendorByKode($vendor);
		$data['grheader'] = $this->model('Invoice_model')->getGrHeader($grnum, $year);
		$data['banklist'] = $this->model('Bank_model')->getBankAccount();
		$data['file']     = $this->model('Invoice_model')->getFile($grnum);

		$this->view('templates/header_a', $data);
		$this->view('invoice/process', $data);
		$this->view('templates/footer_a');
	}

	public function grdata($grnum, $year){
		$data  = $this->model('Invoice_model')->grdata($grnum, $year);
		echo json_encode($data);
	}

	public function post(){
		$saldo = $this->model('Setoran_model')->getsaldobyakun($_POST['header'][0]['bankacc']);
		if($saldo['saldo_akhir'] > $_POST['header'][0]['totalinv']){
			$nextNumb = $this->model('Pr_model')->getNextNumber('IV');
			if( $this->model('Invoice_model')->postdata($_POST, $nextNumb['nextnumb']) > 0 ) {
				$result = ["msg"=>"sukses", $nextNumb];
				echo json_encode($nextNumb['nextnumb']);
				exit;			
			}else{
				$result = ["msg"=>"error"];
				echo json_encode($result);
				exit;	
			}
		}else{
			$result = ["msg"=>"error", "text"=>"Saldo tidak mencukupi!"];
			echo json_encode($result);
			exit;
		}
	}
}