<?php

class Approvepr extends Controller{

	public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
		$check = $this->model('Home_model')->checkUsermenu('approvepr','Read');
        if ($check){
			$data['title'] = 'Approve Purchase Request';
			$data['menu']  = 'Approve Purchase Request';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   
			
			$data['prdata']  = $this->model('Approvepr_model')->getOpenPR();
	
			$this->view('templates/header_a', $data);
			$this->view('approvepr/index', $data);
			$this->view('templates/footer_a');            
        }else{
            $this->view('templates/401');
        }  
    }
    
    public function detail($prnum){
		$check = $this->model('Home_model')->checkUsermenu('approvepr','Read');
        if ($check){
			$data['title'] = 'Detail Purchase Request';
			$data['menu']  = 'Detail Purchase Request';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------  

			$data['prhead']   = $this->model('Pr_model')->getPRheader($prnum);
			$data['pritem']   = $this->model('Pr_model')->getPRitem($prnum);
			$data['project']  = $this->model('Project_model')->projectList();
			$data['whs']      = $this->model('Warehouse_model')->getWarehouseByAuth();  

			$data['_prj']      = $this->model('Project_model')->getprojectbyid($data['prhead']['idproject']);
			$data['_whs']      = $this->model('Warehouse_model')->getById($data['prhead']['warehouse']);

			$data['prnum'] = $prnum;
	
			$this->view('templates/header_a', $data);
			$this->view('approvepr/detail', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
		}
    }
    
    public function approve($prnum){
        if( $this->model('Approvepr_model')->approvepr($prnum) > 0 ) {
			Flasher::setMessage('PR', $prnum . ' Approved' ,'success');
			header('location: '. BASEURL . '/approvepr');
			exit;			
		}else{
			Flasher::setMessage('Approve PR', $prnum . ' Failed','danger');
			header('location: '. BASEURL . '/approvepr');
			exit;	
		}
    }

    public function reject($prnum){
        if( $this->model('Approvepr_model')->rejectpr($prnum) > 0 ) {
			Flasher::setMessage('PR', $prnum . ' Rejected' ,'success');
			header('location: '. BASEURL . '/approvepr');
			exit;			
		}else{
			Flasher::setMessage('Reject PR', $prnum . ' Failed','danger');
			header('location: '. BASEURL . '/approvepr');
			exit;	
		}
    }
}