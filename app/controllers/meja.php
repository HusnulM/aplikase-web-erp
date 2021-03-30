<?php

class Meja extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
    }

    public function index(){
		$check = $this->model('Home_model')->checkUsermenu('quotation','Read');
        if ($check){
			$data['title'] = 'Data No Mesin / Meja';
			$data['menu']  = 'Data No Mesin / Meja';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   

			$data['meja']  = $this->model('Meja_model')->listnomeja();
	
			$this->view('templates/header_a', $data);
			$this->view('master-data/meja/index', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
    }

	public function getmejabyreffid($reffid){
		$data = $this->model('Meja_model')->getmejabyreffid($reffid);
		echo json_encode($data);
	}

	public function listmejaproces($nomeja){
		$data = $this->model('Meja_model')->listmejaproces($nomeja);
		echo json_encode($data);
	}

	public function listmejaprocesbyreffid($reffid){
		$data = $this->model('Meja_model')->listmejaprocesbyrefid($reffid);
		echo json_encode($data);
	}
    
    public function save(){
		if( $this->model('Meja_model')->save($_POST) > 0 ) {
			Flasher::setMessage('No Mesin / Meja disimpan','','success');
			header('location: '. BASEURL . '/meja');
			exit;			
		}else{
			Flasher::setMessage('Error','','success');
			header('location: '. BASEURL . '/meja');
			exit;	
		}
	}

	public function saveprocess(){
		if( $this->model('Meja_model')->saveprocess($_POST) > 0 ) {
			$return = array(
				"msgtype" => "1",
				"message" => "Proses Created"
			);
			echo json_encode($return);
			exit;			
		}else{
			$return = array(
				"msgtype" => "2",
				"message" => "Error"
			);
			echo json_encode($return);
			exit;	
		}
	}

	public function deletemejaproces($nomeja,$idprocess){
		if( $this->model('Meja_model')->deleteprocess($nomeja,$idprocess) > 0 ) {
			$return = array(
				"msgtype" => "1",
				"message" => "Proses Deleted"
			);
			echo json_encode($return);
			exit;			
		}else{
			$return = array(
				"msgtype" => "2",
				"message" => "Error"
			);
			echo json_encode($return);
			exit;	
		}
	}

	public function update(){
		if( $this->model('Meja_model')->update($_POST) > 0 ) {
			Flasher::setMessage('No Mesin / Meja disimpan','','success');
			header('location: '. BASEURL . '/meja');
			exit;			
		}else{
			Flasher::setMessage('Error','','success');
			header('location: '. BASEURL . '/meja');
			exit;	
		}
	}

	public function delete($id){
		if( $this->model('Meja_model')->delete($id) > 0 ) {
			Flasher::setMessage('No Mesin / Meja dihapus','','success');
			header('location: '. BASEURL . '/meja');
			exit;			
		}else{
			Flasher::setMessage('Error','','success');
			header('location: '. BASEURL . '/meja');
			exit;	
		}
	}
}