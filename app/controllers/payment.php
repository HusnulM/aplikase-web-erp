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
		
		// Wajib di semua route ke view--------------------------------------------
		$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
		$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
		//-------------------------------------------------------------------------

		$data['grdata']   = $this->model('Invoice_model')->listpotoinvoice();

		$this->view('templates/header_a', $data);
		$this->view('invoice/index', $data);
		$this->view('templates/footer_a');
	}
	
	public function process($ponum,$vendor){
		$data['title']    = 'Payment Process';
		$data['menu']     = 'Payment Process';
		
		// Wajib di semua route ke view--------------------------------------------
		$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
		$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
		//-------------------------------------------------------------------------

		$data['pohead']   = $this->model('Invoice_model')->getPoHeader($ponum);
		$data['vendor']   = $this->model('Vendor_model')->getVendorByKode($vendor);
		$data['podata']   = $this->model('Invoice_model')->getpodata($ponum);
		$data['banklist'] = $this->model('Bank_model')->getBankAccount();
		$data['ponum']	  = $ponum;

		if(sizeof($data['podata']) > 0){
			$this->view('templates/header_a', $data);
			$this->view('invoice/process', $data);
			$this->view('templates/footer_a');
		}else{
			Flasher::setMessage('PO', $ponum . ' already process','danger');
			header('location:'. BASEURL . '/payment');
		}
	}

	public function approvepayment($ivnum, $ponum, $vendor){
		$data['title']    = 'Approve Payment';
		$data['menu']     = 'Approve Payment';
		
		// Wajib di semua route ke view--------------------------------------------
		$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
		$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
		//-------------------------------------------------------------------------

		$data['podata']   = $this->model('Invoice_model')->getpodata($ponum);
		$data['vendor']   = $this->model('Vendor_model')->getVendorByKode($vendor);
		$data['paymenthead'] = $this->model('Invoice_model')->paymentheader($ivnum);
		$data['ivnum']    = $ivnum;
		$data['ponum']    = $ponum;

		$this->view('templates/header_a', $data);
		$this->view('invoice/approvepayment', $data);
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

	public function _approvepayment($ponum,$ivnum){
		if( $this->model('Invoice_model')->_approvepayment($ponum, $ivnum) > 0 ) {
			$result = ["msg"=>"sukses", $ponum];
			echo json_encode('Approved');
			exit;			
		}else{
			$result = ["msg"=>"error"];
			echo json_encode($result);
			exit;	
		}		
	}
}