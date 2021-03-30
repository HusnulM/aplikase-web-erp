<?php

class Customer extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
		$check = $this->model('Home_model')->checkUsermenu('customer','Read');
        if ($check){
			$data['title'] = 'Master Customer';
			$data['menu']  = 'Master Customer';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   

			$data['cust']  = $this->model('Customer_model')->customerList();
	
			$this->view('templates/header_a', $data);
			$this->view('customer/index', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
    }

    public function create(){
		$check = $this->model('Home_model')->checkUsermenu('customer','Create');
        if ($check){
			$data['title'] = 'Create Customer';
			$data['menu']  = 'Create Customer';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   

			$this->view('templates/header_a', $data);
			$this->view('customer/create', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
    }

    public function edit($id){
		$check = $this->model('Home_model')->checkUsermenu('customer','Update');
        if ($check){
			$data['title'] = 'Edit Customer';
			$data['menu']  = 'Edit Customer';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   

			$data['cust']  = $this->model('Customer_model')->getCustomerById($id);
	
			$this->view('templates/header_a', $data);
			$this->view('customer/edit', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
    }

    public function save(){
		if( $this->model('Customer_model')->save($_POST) > 0 ) {
			Flasher::setMessage('New Customer','Created','success');
			header('location: '. BASEURL . '/customer');
			exit;			
		}else{
			Flasher::setMessage('error,','','danger');
			header('location: '. BASEURL . '/customer');
			exit;	
		}
	}

	public function update(){
		if( $this->model('Customer_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Customer ','Updated','success');
			header('location: '. BASEURL . '/customer');
			exit;			
		}else{
			Flasher::setMessage('Error,','','danger');
			header('location: '. BASEURL . '/customer');
			exit;	
		}
	}

	public function delete($id){
		if( $this->model('Customer_model')->delete($id) > 0 ) {
			Flasher::setMessage('Customer ','Deleted','success');
			header('location: '. BASEURL . '/customer');
			exit;			
		}else{
			Flasher::setMessage('Error,','','danger');
			header('location: '. BASEURL . '/customer');
			exit;	
		}
	}
}