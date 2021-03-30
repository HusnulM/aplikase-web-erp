<?php

class Approvepo extends Controller{

	public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
		$check = $this->model('Home_model')->checkUsermenu('approvepo','Read');
        if ($check){
			$data['title'] = 'Approve Purchase Order';
			$data['menu']  = 'Approve Purchase Order';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   
			
			$data['podata']  = $this->model('Approvepo_model')->getOpenPO();
	
			$this->view('templates/header_a', $data);
			$this->view('approvepo/index', $data);
			$this->view('templates/footer_a');            
        }else{
            $this->view('templates/401');
        }  
    }
    
    public function detail($params){

		$url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
		$ponum = $params['ponum'];

		$check = $this->model('Home_model')->checkUsermenu('approvepo','Read');
        if ($check){
			$data['title'] = 'Detail Purchase Request';
			$data['menu']  = 'Detail Purchase Request';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------  

			$data['pohead']   = $this->model('Po_model')->getPOheader($ponum);
			$data['poitem']   = $this->model('Po_model')->getPODetail($ponum);

			$data['ponum'] = $ponum;
	
			$this->view('templates/header_a', $data);
			$this->view('approvepo/detail', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
		}
    }
    
    public function approve($params){
		$url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
		$ponum = $params['ponum'];

        if( $this->model('Approvepo_model')->approvepo($ponum) > 0 ) {
			Flasher::setMessage('PO', $ponum . ' Approved' ,'success');
			header('location: '. BASEURL . '/approvepo');
			exit;			
		}else{
			Flasher::setMessage('Approve PR', $ponum . ' Failed','danger');
			header('location: '. BASEURL . '/approvepo');
			exit;	
		}
    }

    public function reject($ponum){
        if( $this->model('Approvepo_model')->rejectpo($ponum) > 0 ) {
			Flasher::setMessage('PR', $ponum . ' Rejected' ,'success');
			header('location: '. BASEURL . '/approvepo');
			exit;			
		}else{
			Flasher::setMessage('Reject PR', $ponum . ' Failed','danger');
			header('location: '. BASEURL . '/approvepo');
			exit;	
		}
    }
}