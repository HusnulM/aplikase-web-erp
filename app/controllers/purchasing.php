<?php

class Purchasing extends Controller {

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
			$data['menu'] = 'Create';
			$data['menu-dsc'] = 'Purchase Requisition';
			$data['setting'] = $this->model('Setting_model')->getgensetting();
			$this->view('templates/header_a', $data);
			$this->view('purchasing/index', $data);
			$this->view('templates/footer_a');
		}else{
			header('location: '. BASEURL);
		}
	}
	
	public function operPR(){
		if( isset($_SESSION['usr']) ){
			// $data['nama'] = $this->model('User_model')->getUser(); 
			$data['title'] = 'Purchase Requisition';
			$data['menu'] = 'Open';
			$data['menu-dsc'] = 'Purchase Requisition';
			$data['setting'] = $this->model('Setting_model')->getgensetting();
			$this->view('templates/header_a', $data);
			if ($_SESSION['usr']['userlevel'] === "2"){
				$this->view('purchasing/openpr', $data);
			}else{
				$this->view('purchasing/list-approvepr', $data);
			}			
			$this->view('templates/footer_a');
		}else{
			header('location: '. BASEURL);
		}
	}

	public function approvePR(){
		if( $this->model('Purchasing_model')->approvePR($_POST['prnum']) > 0 ) {
			$result = ["msg"=>"sukses", $_POST['prnum']];
			echo json_encode($result);
			exit;			
		}else{
			$result = ["msg"=>"error"];
            echo json_encode($result);
			exit;	
		}
	}

	public function rejectPR(){
		if( $this->model('Purchasing_model')->rejectPR($_POST['prnum']) > 0 ) {
			$result = ["msg"=>"sukses", $_POST['prnum']];
			echo json_encode($result);
			exit;			
		}else{
			$result = ["msg"=>"error"];
            echo json_encode($result);
			exit;	
		}
	}

	public function historyPR(){
		if( isset($_SESSION['usr']) ){
			$data['title'] = 'Purchase Requisition';
			$data['menu'] = 'History';
			$data['menu-dsc'] = 'Purchase Requisition';
			$data['setting'] = $this->model('Setting_model')->getgensetting();
			$this->view('templates/header_a', $data);
			$this->view('purchasing/historyPR', $data);
			$this->view('templates/footer_a');
		}else{
			header('location: '. BASEURL);
		}
	}

	public function printPR($prnum){
		$data['header'] = $this->model('Purchasing_model')->getPRHeaderByNum($prnum);
		$data['pritem'] = $this->model('Purchasing_model')->getPRBynum($prnum);
		$data['setting'] = $this->model('Setting_model')->getgensetting();
		$this->view('purchasing/printPR',$data);
	}

	public function printALLPR($strdate, $enddate){
		$data['prdata'] = $this->model('Purchasing_model')->printPRbydate($strdate, $enddate);
		$data['setting'] = $this->model('Setting_model')->getgensetting();
		$this->view('purchasing/printALL',$data);
	}
    
    public function productList(){
        $data = $this->model('Product_model')->getAllProduct();
        echo json_encode($data);
    }

    public function productGroup(){
        $data = $this->model('Product_model')->gerProductGroup();
        echo json_encode($data);
	}
	
	public function currencyList(){
		$data = $this->model('Purchasing_model')->getCurrencyList();
        echo json_encode($data);
	}

	public function departmentList(){
		$data = $this->model('Department_model')->getDeptByUser();
        echo json_encode($data);
	}

	public function openproject(){
		$data = $this->model('Project_model')->getOpenProject();
        echo json_encode($data);
	}

	public function getOpenPR(){
		$data = $this->model('Purchasing_model')->getAllOpenPR();
		echo json_encode($data);
	}

	public function getHistoryPR($strdate, $enddate){
		$data = $this->model('Purchasing_model')->getHistoryPR($strdate, $enddate);
		echo json_encode($data);
	}

	public function getPRByNum(){
		$data = $this->model('Purchasing_model')->getPRByNum($_GET['prnum']);
		echo json_encode($data);
	}

	public function getEditPRHeaderByNum($prnum){
		$data = $this->model('Purchasing_model')->getPRHeaderByNum($prnum);
		echo json_encode($data);
	}

	public function getEditPRByNum($prnum){
		$data = $this->model('Purchasing_model')->getPRByNum($prnum);
		echo json_encode($data);
	}

    public function create(){
		$prNumb = $this->model('Purchasing_model')->getNextPRNumb();
        if( $this->model('Purchasing_model')->createPR($_POST, $prNumb['prNumb']) > 0 ) {
			$result = ["msg"=>"sukses", $prNumb];
			echo json_encode($result);
			exit;			
		}else{
			$result = ["msg"=>"error"];
            echo json_encode($result);
			exit;	
		}
	}
	
	public function updatepr($prnum){
		$this->model('Purchasing_model')->deletepr($prnum);
        if( $this->model('Purchasing_model')->updatePR($_POST, $prnum) > 0 ) {
			$result = ["msg"=>"sukses", $prnum];
			echo json_encode($result);
			exit;			
		}else{
			$result = ["msg"=>"error"];
            echo json_encode($result);
			exit;	
		}
    }

    public function delete(){ 
        if( $this->model('Purchasing_model')->deleteProduct($_POST['id']) > 0 ) {
            echo json_encode("sukses");
			exit;			
		}else{
            echo json_encode("error");
			exit;	
		}
	}
	
	public function editpr($prnum){
		if( isset($_SESSION['usr']) ){
			$data['title']    = 'Purchase Requisition';
			$data['menu']     = 'Edit';
			$data['menu-dsc'] = 'Purchase Requisition';
			$data['setting']  = $this->model('Setting_model')->getgensetting();
			$data['prheader'] = $this->model('Purchasing_model')->getPRHeaderByNum($prnum);
			$data['pritem']   = $this->model('Purchasing_model')->getPRByNum($prnum);
			$this->view('templates/header_a', $data);
			$this->view('purchasing/edit-pr', $data);
			$this->view('templates/footer_a');
		}else{
			header('location: '. BASEURL);
		}
	}
}