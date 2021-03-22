<?php

class Approvepayment extends Controller{

	public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
		$check = $this->model('Home_model')->checkUsermenu('approvepayment','Read');
        if ($check){
			$data['title'] = 'Approve Payment';
			$data['menu']  = 'Approve Payment';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   
			
			$data['paymentdata']  = $this->model('Approvepayment_model')->getOpenPayment();
	
			$this->view('templates/header_a', $data);
			$this->view('approvepayment/index', $data);
			$this->view('templates/footer_a');            
        }else{
            $this->view('templates/401');
        }  
    }
    
    public function detail($ivnum){
		$check = $this->model('Home_model')->checkUsermenu('approvepayment','Read');
        if ($check){
			$data['title'] = 'Detail Payment';
			$data['menu']  = 'Detail Payment';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------  

			$data['ivhead']   = $this->model('Approvepayment_model')->getIVheader($ivnum);
			$data['ivitem']   = $this->model('Approvepayment_model')->getIVitem($ivnum);
			// $data['approvelevel'] = $this->model('Approvepayment_model')->getApprovalLevel($_SESSION['usr']['user']);

			$data['ivnum'] = $ivnum;
	
			$this->view('templates/header_a', $data);
			$this->view('approvepayment/detail', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
		}
    }
    
    public function approve($ivnum){
        if( $this->model('Approvepayment_model')->approvepayment($ivnum) > 0 ) {
			Flasher::setMessage('Payment', $ivnum . ' Approved' ,'success');
			header('location: '. BASEURL . '/approvepayment');
			exit;			
		}else{
			Flasher::setMessage('Approve Payment', $ivnum . ' Failed','danger');
			header('location: '. BASEURL . '/approvepayment');
			exit;	
		}
    }
}