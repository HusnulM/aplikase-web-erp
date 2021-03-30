<?php

class Bank extends Controller{
    public function __construct(){
		if($_SESSION['usr']['userlevel'] == "Admin" ){

		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
		$data['title'] = 'Master Bank';
		$data['menu']  = 'Master Bank';
		$data['menu-dsc'] = '';

		$data['setting'] = $this->model('Setting_model')->getgensetting();
		$data['bank']    = $this->model('Bank_model')->getBankAccount();

		$this->view('templates/header_a', $data);
		$this->view('bank/index', $data);
		$this->view('templates/footer_a');
	}
	
	public function create(){
		$data['title'] = 'Add Bank Account';
		$data['menu']  = 'Add Bank Account';
		$data['menu-dsc'] = '';

		$data['setting']   = $this->model('Setting_model')->getgensetting();
		$data['banklist']  = $this->model('Bank_model')->getBankList();
		$data['user']      = $this->model('User_model')->userList();

		$this->view('templates/header_a', $data);
		$this->view('bank/create', $data);
		$this->view('templates/footer_a');
	}
	
	public function edit($id){
		$data['title'] = 'Edit Master Bank';
		$data['menu']  = 'Edit Master Bank';
		$data['menu-dsc'] = '';

		$data['setting'] = $this->model('Setting_model')->getgensetting();
		$data['bank']    = $this->model('Bank_model')->getBankAccount();
		$data['bankdata'] = $this->model('Bank_model')->getBankAccountById($id);
		$data['banklist']  = $this->model('Bank_model')->getBankList();
		$data['user']      = $this->model('User_model')->userList();
		
		$this->view('templates/header_a', $data);
		$this->view('bank/edit', $data);
		$this->view('templates/footer_a');
	}
	
	public function save(){
		// $this->model('Bank_model')->save($_POST);
		var_dump($_POST);
		if( $this->model('Bank_model')->save($_POST) > 0 ) {
			// Flasher::setMessage('Bank Account','Created','success');
			header('location: '. BASEURL . '/bank');
			exit;			
		  }else{
			// Flasher::setMessage('error,','','danger');
			header('location: '. BASEURL . '/bank');
			exit;	
		  }
	}

	public function update(){
		if( $this->model('Bank_model')->update($_POST) > 0 ) {
			// Flasher::setMessage('Bank Account','Updated','success');
			header('location: '. BASEURL . '/bank');
			exit;			
		  }else{
			// Flasher::setMessage('Error,','','danger');
			header('location: '. BASEURL . '/bank');
			exit;	
		  }
	}

	public function delete($id){
		if( $this->model('Bank_model')->delete($id) > 0 ) {
			// Flasher::setMessage('Bank Account','Deleted','success');
			header('location: '. BASEURL . '/bank');
			exit;			
		  }else{
			// Flasher::setMessage('Error,','','danger');
			header('location: '. BASEURL . '/bank');
			exit;	
		  }
	}
}