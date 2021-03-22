<?php

class Unrelease extends Controller {

    public function unreleasepr(){
        $check = $this->model('Home_model')->checkUsermenu('unrelease/unreleasepr', 'Read');
        if ($check){
            $data['title'] = 'Cancel Approve PR';
            $data['menu']  = 'Cancel Approve PR';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['prdata'] = $this->model('Unrelease_model')->prlist();

            $this->view('templates/header_a', $data);
            $this->view('unrelease/unreleasepr', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function unreleasepo(){
        $check = $this->model('Home_model')->checkUsermenu('unrelease/unreleasepo', 'Read');
        if ($check){
            $data['title'] = 'Cancel Approve PO';
            $data['menu']  = 'Cancel Approve PO';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['podata'] = $this->model('Unrelease_model')->polist();

            $this->view('templates/header_a', $data);
            $this->view('unrelease/unreleasepo', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function cancelpr($prnum){
        if( $this->model('Unrelease_model')->unrelpr($prnum) > 0 ) {
			Flasher::setMessage('Approval PR '. $prnum, ' di Cancel', 'success');
			header('location: '. BASEURL . '/unrelease/unreleasepr');
			exit;			
		}else{
			$result = ["msg"=>"error"];
			header('location: '. BASEURL . '/unrelease/unreleasepr');
			exit;	
        }
    }

    public function cancelpo($params){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
		$ponum = $params['ponum'];
        if( $this->model('Unrelease_model')->unrelpo($ponum) > 0 ) {
			Flasher::setMessage('Approval PO '. $ponum, ' di Cancel', 'success');
			header('location: '. BASEURL . '/unrelease/unreleasepo');
			exit;			
		}else{
			$result = ["msg"=>"error"];
			header('location: '. BASEURL . '/unrelease/unreleasepo');
			exit;	
        }
    }
}