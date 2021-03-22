<?php

class Setoran extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
		$data['title'] = 'Setoran';
		$data['menu']  = 'Setoran';
		$data['menu-dsc'] = '';

		$data['setting'] = $this->model('Setting_model')->getgensetting();
		$data['bank']    = $this->model('Bank_model')->getBankAccount();

		$this->view('templates/header_a', $data);
		$this->view('setoran/index', $data);
		$this->view('templates/footer_a');
	}
	
	public function create(){
		$data['title'] = 'Tambah Setoran';
		$data['menu']  = 'Tambah Setoran';
		$data['menu-dsc'] = '';

		$data['setting']   = $this->model('Setting_model')->getgensetting();

		$this->view('templates/header_a', $data);
		$this->view('setoran/create', $data);
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

		$this->view('templates/header_a', $data);
		$this->view('bank/edit', $data);
		$this->view('templates/footer_a');
	}

	public function getfile($transnum){
		$data = $this->model('Setoran_model')->getfile($transnum);	

		if($data['refdoc'] == null){
			echo json_encode($data);
		}else{
			// echo $data['refdoc'];
			$data2 = $this->model('Setoran_model')->getGrfile($data['refdoc']);
			echo json_encode($data2);
		}
	}
	
	public function save(){

		$saldo = $this->model('Setoran_model')->getsaldobyakun($_POST['fromakun']);
		if($saldo['saldo_akhir'] > $_POST['jmlsetor']){
			$nextNumb = $this->model('Grpo_model')->getNextNumber('JURNAL');
			if( $this->model('Setoran_model')->save($_POST, $nextNumb['nextnumb']) > 0 ) {
				Flasher::setMessage('Setoran Berhasil Dengan Nomor',$nextNumb['nextnumb'],'success');
				header('location: '. BASEURL . '/setoran');
				exit;			
			}else{
				// Flasher::setMessage('error,','','danger');
				header('location: '. BASEURL . '/setoran');
				exit;	
			}
		}else{
			Flasher::setMessage('Saldo tidak mencukupi!','','danger');
			header('location: '. BASEURL . '/setoran');
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