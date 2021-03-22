<?php

class Jabatan extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }
    
    public function index(){
		$data['title'] = 'Master Jabatan';
		$data['menu']  = 'Master Jabatan';
		$data['menu-dsc'] = '';

		$data['setting'] = $this->model('Setting_model')->getgensetting();
		$data['jabatan'] = $this->model('Jabatan_model')->getList();

		$this->view('templates/header_a', $data);
		$this->view('jabatan/index', $data);
		$this->view('templates/footer_a');
    }

    public function create(){
        $data['title'] = 'Tambah Jabatan';
		$data['menu']  = 'Tambah Jabatan';
		$data['menu-dsc'] = '';

		$data['setting'] = $this->model('Setting_model')->getgensetting();

		$this->view('templates/header_a', $data);
		$this->view('jabatan/create', $data);
		$this->view('templates/footer_a');
	}

	public function edit($id){
        $data['title']    = 'Edit Jabatan';
		$data['menu']     = 'Edit Jabatan';
		$data['menu-dsc'] = '';

		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['jabatan']  = $this->model('Jabatan_model')->getById($id);

		$this->view('templates/header_a', $data);
		$this->view('jabatan/edit', $data);
		$this->view('templates/footer_a');
	}

	public function save(){
		if( $this->model('Jabatan_model')->save($_POST) > 0 ) {
			Flasher::setMessage('Data Jabatan Berhasil disimpan','','success');
			header('location: '. BASEURL . '/jabatan');
			exit;			
		  }else{
			Flasher::setMessage('Gagal menyimpan data jabatan,','','danger');
			header('location: '. BASEURL . '/jabatan');
			exit;	
		  }
	}

	public function update(){
		if( $this->model('Jabatan_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Data jabatan Berhasil di edit','','success');
			header('location: '. BASEURL . '/jabatan');
			exit;			
		  }else{
			Flasher::setMessage('Gagal edit data jabatan,','','danger');
			header('location: '. BASEURL . '/jabatan');
			exit;	
		  }
	}

	public function delete($kodebrg){
		if( $this->model('Jabatan_model')->delete($kodebrg) > 0 ) {
			Flasher::setMessage('Data jabatan Berhasil dihapus','','success');
			header('location: '. BASEURL . '/jabatan');
			exit;			
		  }else{
			Flasher::setMessage('Gagal menghapus data jabatan,','','danger');
			header('location: '. BASEURL . '/jabatan');
			exit;	
		  }
	}
}