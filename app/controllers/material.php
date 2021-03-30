<?php

class Material extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('material','Read');
        if ($check){
            $data['title'] = 'Master Material';
            $data['menu']  = 'Master Material';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $data['material'] = $this->model('Barang_model')->getListBarang();   
            $data['kurs']     = $this->model('Barang_model')->getusdtoidr();

            $data['showprice'] = $this->model('Barang_model')->checkauthdisplayprice();

            // echo json_encode($data['showprice']);
            $this->view('templates/header_a', $data);
            $this->view('material/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('material','Create');
        if ($check){
            $data['title'] = 'Tambah Master Material';
            $data['menu']  = 'Tambah Master Material';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();       
            
            $data['showprice'] = $this->model('Barang_model')->checkauthdisplayprice();
            $data['mattype']   = $this->model('Barang_model')->getListMatType();

            $this->view('templates/header_a', $data);
            $this->view('material/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }         
    }

    public function edit($params){
        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $material = $params['material'];
        $check = $this->model('Home_model')->checkUsermenu('material','Update');
        if ($check){
            $data['title'] = 'Edit Master Material';
            $data['menu']  = 'Edit Master Material';

            // Wajib di semua route ke view
            $data['setting']  = $this->model('Setting_model')->getgensetting();
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         

            $data['material'] = $this->model('Barang_model')->getBarangByKode($material);
            $data['altuom']   = $this->model('Barang_model')->getBarangBaseUomByKode($material, $data['material']['matunit']);
            $data['showprice'] = $this->model('Barang_model')->checkauthdisplayprice();
            $data['mattype']   = $this->model('Barang_model')->getListMatType();
            $data['cmattype']  = $this->model('Barang_model')->geMatTypeById($data['material']['mattype']);

            $this->view('templates/header_a', $data);
            $this->view('material/edit', $data);
            $this->view('templates/footer_a');
        }else{
            // echo json_encode("no authorization!");
            $this->view('templates/401');
        }         
    }

    public function save(){
        // echo json_encode($_POST);
        if( $this->model('Barang_model')->save($_POST) > 0 ) {
			Flasher::setMessage('Material Berhasil disimpan','','success');
			header('location: '. BASEURL . '/material');
			exit;			
		}else{
			Flasher::setMessage('Gagal menyimpan data material,','','danger');
			header('location: '. BASEURL . '/material');
			exit;	
		}
    }

    public function updatekursusdidr($newvalue){
        if( $this->model('Barang_model')->updatekursusdidr($newvalue) > 0 ) {
			echo json_encode("OK");
			exit;			
		}else{
			echo json_encode("OK");
			exit;	
		}
    }
    
    public function update(){
        if( $this->model('Barang_model')->update($_POST) > 0 ) {
			Flasher::setMessage('Material Berhasil di update','','success');
			header('location: '. BASEURL . '/material');
			exit;			
		}else{
			Flasher::setMessage('Material Berhasil di update','','success');
			header('location: '. BASEURL . '/material');
			exit;
		}
	}

    public function delete($params){

        $url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
        $material = $params['material'];

        $check = $this->model('Home_model')->checkUsermenu('material','Delete');
        if ($check){
            if( $this->model('Barang_model')->delete($material) > 0 ) {
                Flasher::setMessage('Material Berhasil di hapus','','success');
                header('location: '. BASEURL . '/material');
                exit;			
            }else{
                Flasher::setMessage('Gagal menyimpan data material,','','danger');
                header('location: '. BASEURL . '/material');
                exit;	
            }
        }else{
            // echo json_encode("no authorization!");
            $this->view('templates/401');
        }         
    }
}