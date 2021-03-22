<?php

class Product extends Controller {

	public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
	}
	
	public function index()
	{
		if( isset($_SESSION['usr']) ){
			// $data['nama'] = $this->model('User_model')->getUser();
			$data['title'] = 'Purchase Requisition';
			$data['menu'] = 'Manage Product';
			$data['menu-dsc'] = '';
			$data['setting'] = $this->model('Setting_model')->getgensetting();
			$this->view('templates/header_a', $data);
			$this->view('product/index', $data);
			$this->view('templates/footer_a');
		}else{
			$data['title'] = 'Purchase Requisition';
			// $this->view('templates/header_a', $data);
			$this->view('home/index', $data);
			// $this->view('templates/footer_a');
		}
    }
    
    public function productList(){
        $data = $this->model('Product_model')->getAllProduct();
        echo json_encode($data);
    }

    public function productGroup(){
        $data = $this->model('Product_model')->gerProductGroup();
        echo json_encode($data);
    }

    public function create(){
        
        if( $this->model('Product_model')->createProduct($_POST) > 0 ) {
            echo json_encode("sukses");
			// Flasher::setMessage('New Product Successfully','Created','success');
			// header('location: '. BASEURL . '/department');
			exit;			
		}else{
			// Flasher::setMessage('Failed,','Check your input','danger');
            // header('location: '. BASEURL . '/department');
            echo json_encode("error");
			exit;	
		}
    }

    public function delete(){        
        // echo $_POST['id'];
        if( $this->model('Product_model')->deleteProduct($_POST['id']) > 0 ) {
            echo json_encode("sukses");
			exit;			
		}else{
            echo json_encode("error");
			exit;	
		}
    }
}