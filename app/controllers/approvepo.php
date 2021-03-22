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
    
    public function detail($ponum){
		$check = $this->model('Home_model')->checkUsermenu('approvepo','Read');
        if ($check){
			$data['title'] = 'Detail Purchase Request';
			$data['menu']  = 'Detail Purchase Request';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------  

			$data['pohead']   = $this->model('Approvepo_model')->getPOheader($ponum);
			$data['poitem']   = $this->model('Approvepo_model')->getOpenPOItem($ponum);
			$data['approvelevel'] = $this->model('Approvepo_model')->getApprovalLevel($_SESSION['usr']['user']);
			$data['_whs']     = $this->model('Warehouse_model')->getById($data['pohead']['warehouse']);

			$data['ponum'] = $ponum;
	
			$this->view('templates/header_a', $data);
			$this->view('approvepo/detail', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
		}
    }
    
    public function approve($ponum){
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

	public function approvepoitem($ponum){
		if( $this->model('Approvepo_model')->approvepoitem($ponum,$_POST['poitem']) > 0 ) {
			$return = array(
				"msgtype" => "1",
				"message" => "PO Approved",
				"docnum"  => $ponum
			);
			echo json_encode($return);
			exit;			
		}else{
			$return = array(
				"msgtype" => "2",
				"message" => "Failed",
				"docnum"  => ""
			);
			echo json_encode($return);
			exit;	
		}
	}

	public function rejectpritem($ponum){
		if( $this->model('Approvepo_model')->rejectpoitem($ponum, $_POST['poitem']) > 0 ) {
			$return = array(
				"msgtype" => "1",
				"message" => "PO Item Rejected",
				"docnum"  => $ponum
			);
			echo json_encode($return);
			exit;			
		}else{
			$return = array(
				"msgtype" => "2",
				"message" => "Failed",
				"docnum"  => ""
			);
			echo json_encode($return);
			exit;	
		}
	}
}