<?php

class Grpo extends Controller{

	public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
	}

    public function index(){
		$data['title']    = 'Receipt Purchase Order';
		$data['menu']     = 'Receipt Purchase Order';
		$data['menu-dsc'] = '';
		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['podata']   = $this->model('Po_model')->listpotogr();
	
		$this->view('templates/header_a', $data);
		$this->view('grpo/index', $data);
		$this->view('templates/footer_a');
    }
	
	// public function proses(){
	// 	$data['title']    = 'Penerimaan Barang';
	// 	$data['menu']     = 'Penerimaan Barang';
	// 	$data['menu-dsc'] = '';
	// 	$data['setting']  = $this->model('Setting_model')->getgensetting();

	// 	$this->view('templates/header_a', $data);
	// 	$this->view('po/create', $data);
	// 	$this->view('templates/footer_a');
	// }

	public function proses($ponum){
		$data['title']    = 'Detail Purchase Order';
		$data['menu']     = 'Detail Purchase Order';
		$data['menu-dsc'] = '';
		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['pohead']   = $this->model('Po_model')->getPOHeader($ponum);
		$data['poitem']   = $this->model('Po_model')->getPODetail($ponum);
		$data['ponum']    = $ponum;
		// $data['grqty']    = $this->model('Grpo_model')->getpoitemgrqty('2000000023','1');

		if($data['pohead']['pocomplete'] == 'X'){
			Flasher::setMessage('PO '. $ponum,'already closed!','danger');
			header('location: '. BASEURL . '/grpo');
			exit;
		}else{
			$this->view('templates/header_a', $data);
			$this->view('grpo/proses', $data);
			$this->view('templates/footer_a');
		}		
	}

	public function closepo($ponum){
		if( $this->model('Grpo_model')->pocompleted($ponum) > 0 ) {
			Flasher::setMessage('PO '. $ponum ,'Closed','success');
			header('location: '. BASEURL . '/grpo');
			exit;			
		}else{
			Flasher::setMessage('Error','','success');
			header('location: '. BASEURL . '/grpo');
			exit;	
		}
	}
	
	public function post(){
		$nextNumb = $this->model('Grpo_model')->getNextNumber('GRPO');
		// $data     = $this->model('Grpo_model')->grpo($_POST, $nextNumb['nextnumb']);
		// echo json_encode($data);
		if( $this->model('Grpo_model')->grpo($_POST, $nextNumb['nextnumb']) > 0 ) {
			$result = ["msg"=>"sukses", $nextNumb];
			echo json_encode($nextNumb['nextnumb']);
			exit;			
		}else{
			$result = ["msg"=>"error"];
            echo json_encode($result);
			exit;	
		}
	}

	public function getgrqty($ponum,$poitem){
		$data = $this->model('Grpo_model')->getpoitemgrqty($ponum,$poitem);
		echo json_encode($data);
	}

	public function uploadfile($refdoc){
		/* Getting file name */
		$filename      = $_FILES['file']['name'];
		$filename      = $filename;
		$location      = "./images/grfile/". $filename;
		$temp          = $_FILES['file']['tmp_name'];
		$fileType      = pathinfo($location,PATHINFO_EXTENSION);
		$acak          = rand(000000,999999);	

		// move_uploaded_file($temp, $location);
		$this->model('Grpo_model')->uploadfile($refdoc, $temp, $location, $filename, $fileType);
		move_uploaded_file($temp, $location);
		// /* Valid Extensions */
		// $valid_extensions = array("jpg","jpeg","png");
		// /* Check file extension */
		// if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
		// 	$uploadOk = 0;
		// }

		// if($uploadOk == 0){
		// echo 0;
		// }else{
		// /* Upload file */
		// if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
		// 	echo $location;
		// }else{
		// 	echo 0;
		// }
	}
}