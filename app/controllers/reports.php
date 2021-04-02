<?php

class Reports extends Controller{

	public function __construct(){
		if( isset($_SESSION['usr']) ){
			
		}else{
			header('location:'. BASEURL);
		}
    }

	public function index(){
		header('location:'. BASEURL);
	}

    public function reportpr(){
		$check = $this->model('Home_model')->checkUsermenu('reports/reportpr','Read');
        if ($check){
			$data['title']    = 'Report Purchase Request';
			$data['menu']     = 'Report Purchase Request';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 

			$this->view('templates/header_a', $data);
			$this->view('reports/laporanpr', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }          
    }

    public function reportprview($strdate, $enddate, $status){
		$check = $this->model('Home_model')->checkUsermenu('reports/reportpr','Read');
        if ($check){
			$data['title']    = 'Report Purchase Request';
			$data['menu']     = 'Report Purchase Request';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
	
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;
			$data['status']  = $status;
	
			// $data['prdata']  = $this->model('Laporan_model')->getPR($strdate, $enddate, $status);
	
			$this->view('templates/header_a', $data);
			$this->view('reports/laporanprview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }          
	}
	
	public function laporanprdata($strdate, $enddate, $status){
		$data = $this->model('Laporan_model')->getPR($strdate, $enddate, $status);
		echo json_encode($data);
    }

    public function reportpo(){
		$check = $this->model('Home_model')->checkUsermenu('reports/reportpo','Read');
        if ($check){
			$data['title']    = 'Report Purchase Order';
			$data['menu']     = 'Report Purchase Order';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
	
			$this->view('templates/header_a', $data);
			$this->view('reports/laporanpo', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }          
    }

    public function reportpoview($strdate, $enddate){
		$check = $this->model('Home_model')->checkUsermenu('reports/reportpo','Read');
        if ($check){
			$data['title']    = 'Report Purchase Order';
			$data['menu']     = 'Report Purchase Order';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
	
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;
	
			$this->view('templates/header_a', $data);
			$this->view('reports/laporanpoview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }          
	}
	
	public function laporanpodata($strdate, $enddate){
		$data = $this->model('Laporan_model')->getDataPO($strdate, $enddate);
		echo json_encode($data);
    }

    public function grpo(){
		$check = $this->model('Home_model')->checkUsermenu('reports/grpo','Read');
        if ($check){
			$data['title']    = 'Report Receipt PO';
			$data['menu']     = 'Report Receipt PO';
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 

			$this->view('templates/header_a', $data);
			$this->view('reports/laporangr', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }  
	}
	
	public function grpoview($strdate, $enddate){
		$check = $this->model('Home_model')->checkUsermenu('reports/grpo','Read');
        if ($check){
			$data['title']    = 'Laporan Barang Masuk';
			$data['menu']     = 'Laporan Barang Masuk';
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
	
			$data['grdata']   = $this->model('Laporan_model')->getDataGR($strdate, $enddate);
	
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;
	
			$this->view('templates/header_a', $data);
			$this->view('reports/laporangrview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}
	
	public function laporangrdata($strdate, $enddate){
		$data = $this->model('Laporan_model')->getDataGR($strdate, $enddate);
		echo json_encode($data);
    }

	public function rservice(){
		$check = $this->model('Home_model')->checkUsermenu('reports/rservice','Read');
        if ($check){
			$data['title']    = 'Report Service';
			$data['menu']     = 'Report Service';
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
	
			$this->view('templates/header_a', $data);
			$this->view('reports/rservice', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}

	public function rserviceview($strdate, $enddate, $whs){
		$check = $this->model('Home_model')->checkUsermenu('reports/rservice','Read');
        if ($check){
			$data['title']    = 'Report Service';
			$data['menu']     = 'Report Service';
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
			
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;
			$data['whs']     = $whs;

			$this->view('templates/header_a', $data);
			$this->view('reports/rserviceview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}

	public function rserviceheader($strdate, $enddate, $whs){
		$data['data'] = $this->model('Laporan_model')->getHeaderService($strdate, $enddate, $whs);
		echo json_encode($data);
	}

	public function rcost(){
		$check = $this->model('Home_model')->checkUsermenu('reports/rcost','Read');
        if ($check){
			$data['title']    = 'Report Cost';
			$data['menu']     = 'Report Cost';
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
	
			$this->view('templates/header_a', $data);
			$this->view('reports/rcost', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}

	public function rcostview($strdate, $enddate, $whs){
		$check = $this->model('Home_model')->checkUsermenu('reports/rcost','Read');
        if ($check){
			$data['title']    = 'Report Cost';
			$data['menu']     = 'Report Cost';
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
			
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;
			$data['whs']     = $whs;

			$this->view('templates/header_a', $data);
			$this->view('reports/rcostview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}

	public function rcostheader($strdate, $enddate){
		$data['data'] = $this->model('Laporan_model')->getHeaderServiceCost($strdate, $enddate);
		echo json_encode($data);
	}

	public function rcostdetail($servicenum){
		$data = $this->model('Laporan_model')->getServiceCostItem($servicenum);
		echo json_encode($data);
	}

	public function rservicedetail($servicenum){
		$data = $this->model('Laporan_model')->getDetailService($servicenum);
		echo json_encode($data);
	}

    public function stock(){
		$check = $this->model('Home_model')->checkUsermenu('reports/stock','Read');
        if ($check){
			$data['title']    = 'Laporan Stok Barang';
			$data['menu']     = 'Laporan Stok Barang';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------  

			$data['whs'] = $this->model('Warehouse_model')->getWarehouseByAuth();   

			// $data['whsauth'] = $this->model('Laporan_model')->getWhsAuth();
			// echo json_encode($data['whsauth']);
			$this->view('templates/header_a', $data);
			$this->view('reports/rstock', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }        
	}

	public function stockview($material = null,$warehouse = null, $zerostock){
		$check = $this->model('Home_model')->checkUsermenu('reports/stock','Read');
        if ($check){
			$data['title']    = 'Report Material Stock';
			$data['menu']     = 'Report Material Stock';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------  
	
			$data['stock'] = $this->model('Laporan_model')->getStock($material,$warehouse,$zerostock);   
			// echo json_encode($data['stock']);
			$this->view('templates/header_a', $data);
			$this->view('reports/rstockview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}

	public function allstockview(){
		$check = $this->model('Home_model')->checkUsermenu('reports/allstockview','Read');
        if ($check){
			$data['title']    = 'Report Material Stock';
			$data['menu']     = 'Report Material Stock';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------  
	
			// $data['stock'] = $this->model('Laporan_model')->getStock($material,$warehouse);   
			// echo json_encode($data['stock']);
			$this->view('templates/header_a', $data);
			$this->view('reports/rtotalstock', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}

	public function batchstock(){
		$check = $this->model('Home_model')->checkUsermenu('reports/batchstock','Read');
        if ($check){
			$data['title']    = 'Report Batch Stock';
			$data['menu']     = 'Report Batch Stock';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------  
			
			$data['whs'] = $this->model('Warehouse_model')->getWarehouseByAuth();   

			$this->view('templates/header_a', $data);
			$this->view('reports/rbatchstock', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}

	public function batchstockview($material = null,$warehouse = null){
		$check = $this->model('Home_model')->checkUsermenu('reports/batchstock','Read');
        if ($check){
			$data['title']    = 'Report Batch Stock';
			$data['menu']     = 'Report Batch Stock';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------  
	
			$data['stock'] = $this->model('Laporan_model')->getBatchStock($material,$warehouse);   
			// echo json_encode($data['stock']);
			$this->view('templates/header_a', $data);
			$this->view('reports/rbatchstockview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}

	public function materialstock(){
		$data['data'] = $this->model('Laporan_model')->getAllStock();
		// $myArray[] = '';
		// $arrayobj = new ArrayObject();
		// foreach($data['data'] as $key => $value){
		// 	$object = new stdClass();
		// 	$object->material = $value['material'];
		// 	$object->matdesc  = $value['matdesc'];
		// 	$object->qty      = $value['qty'];
		// 	$object->matunit  = $value['matunit'];
		// 	$myArray[] = $object;
		// 	$arrayobj->append($object);
		// 	// array_push($myArray);
		// 	// echo json_encode($value);   
		// 	// $data['data']['qty'] = 20;
		// }
		echo json_encode($data);   
	}

	public function materialstockbykode($params){
		$url   = parse_url($_SERVER['REQUEST_URI']);
        $data  = parse_str($url['query'], $params);
		$matnr = $params['material'];

		$data = $this->model('Laporan_model')->breakdownstock($matnr);
		echo json_encode($data);   
	}
	
	public function movement(){
		$check = $this->model('Home_model')->checkUsermenu('reports/movement','Read');
        if ($check){
			$data['title']    = 'Inventory Movement';
			$data['menu']     = 'Inventory Movement';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
	
			$this->view('templates/header_a', $data);
			$this->view('reports/rmovement', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }        
	}
	
	public function movementview($strdate, $enddate, $movement){
		$check = $this->model('Home_model')->checkUsermenu('reports/movement','Read');
        if ($check){
			$data['title']    = 'Inventory Movement';
			$data['menu']     = 'Inventory Movement';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
	
			$data['mvdata']   = $this->model('Laporan_model')->getMovementData($strdate, $enddate, $movement);
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;
			$data['movement'] = $movement;
			// echo json_encode($data['mvdata']);
			$this->view('templates/header_a', $data);
			$this->view('reports/rmovementview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }        
	}

	public function reservasi(){
		$check = $this->model('Home_model')->checkUsermenu('reports/reservasi','Read');
        if ($check){
			$data['title']    = 'Report Reservation';
			$data['menu']     = 'Report Reservation';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
	
			$this->view('templates/header_a', $data);
			$this->view('reports/rreservasi', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }     
	}
	
	public function reservasiview($strdate, $enddate){
		$check = $this->model('Home_model')->checkUsermenu('reports/reservasi','Read');
        if ($check){
			$data['title']    = 'Report Reservation';
			$data['menu']     = 'Report Reservation';
			
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 

			$data['mvdata']   = $this->model('Laporan_model')->getReservasiData($strdate, $enddate);
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;

			$this->view('templates/header_a', $data);
			$this->view('reports/rreservasiview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }  
	}

	public function payment(){
		$check = $this->model('Home_model')->checkUsermenu('reports/payment','Read');
        if ($check){
			$data['title']    = 'Report Payment';
			$data['menu']     = 'Report Payment';
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 
	
			$this->view('templates/header_a', $data);
			$this->view('reports/rpayment', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}

	public function paymentview($strdate, $enddate){
		$check = $this->model('Home_model')->checkUsermenu('reports/payment','Read');
        if ($check){
			$data['title']    = 'Report Payment';
			$data['menu']     = 'Report Payment';
			// Wajib di semua route ke view--------------------------------------------
			$data['setting']  = $this->model('Setting_model')->getgensetting();    //--
			$data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//------------------------------------------------------------------------- 

			// $data['ivdata']   = $this->model('Laporan_model')->getHeaderInvoice($strdate, $enddate);
			$data['strdate'] = $strdate;
			$data['enddate'] = $enddate;
	
			$this->view('templates/header_a', $data);
			$this->view('reports/rpaymentview', $data);
			$this->view('templates/footer_a');
		}else{
            $this->view('templates/401');
        }
	}

	public function rpaymentheader($strdate, $enddate){
		$data['data'] = $this->model('Laporan_model')->getHeaderInvoice($strdate, $enddate);
		echo json_encode($data);
	}

	public function rpaymentdetail($ivnum){
		$data = $this->model('Laporan_model')->getDetailInvoice($ivnum);
		echo json_encode($data);
	}

	public function exportpo_excel($params){

		$url = parse_url($_SERVER['REQUEST_URI']);
        $data = parse_str($url['query'], $params);
		$ponum = $params['ponum'];

		$data['setting']  = $this->model('Setting_model')->getgensetting();
		$data['header']   = $this->model('Po_model')->getPOHeader($ponum);
		$data['poitem']   = $this->model('Po_model')->getPOitemPrint($ponum);

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Purchase Requisition")
             ->setSubject("Purchase Requisition")
             ->setDescription("Purchase Requisition")
             ->setKeywords("Purchase Requisition");
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_aligment_left = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			)
		);

		// Header		
		$excel->setActiveSheetIndex(0)->setCellValue('A1', $data['setting']['company']);
		$excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Purchase Order"); 
		$excel->getActiveSheet()->mergeCells('A2:G2'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo ');
        $objDrawing->setDescription('Logo ');
        $objDrawing->setPath('./images/aws-logo.png');
        $objDrawing->setResizeProportional(true);
        $objDrawing->setWidth(100);
        $objDrawing->setCoordinates('G1');
        $objDrawing->setWorksheet($excel->getActiveSheet());

		$excel->setActiveSheetIndex(0)->setCellValue('B5', "Purchase Order");
		$excel->setActiveSheetIndex(0)->setCellValue('C5', $data['header']['ponum'],PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValue('F5', "PO Note");
		$excel->setActiveSheetIndex(0)->setCellValue('G5', $data['header']['note']);

		$excel->setActiveSheetIndex(0)->setCellValue('B6', "Vendor");
		$excel->setActiveSheetIndex(0)->setCellValue('C6', $data['header']['namavendor']);
		$excel->setActiveSheetIndex(0)->setCellValue('F6', "PO Date");
		$excel->setActiveSheetIndex(0)->setCellValue('G6', $data['header']['podat']);

		$excel->setActiveSheetIndex(0)->setCellValue('B7', "Alamat Vendor");
		$excel->setActiveSheetIndex(0)->setCellValue('C7', $data['header']['alamat']);
		$excel->setActiveSheetIndex(0)->setCellValue('F7', "Created Date");
		$excel->setActiveSheetIndex(0)->setCellValue('G7', $data['header']['createdon']);

		$excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE);

		$excel->getActiveSheet()->getStyle('B6')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('C6')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('F6')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('G6')->getFont()->setBold(TRUE);

		$excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('F7')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('G7')->getFont()->setBold(TRUE);

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A9', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B9', "Material"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C9', "Description"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D9', "Quantity"); 
		$excel->setActiveSheetIndex(0)->setCellValue('E9', "Unit"); 
		$excel->setActiveSheetIndex(0)->setCellValue('F9', "Unit Price"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G9', "Amount"); 
		// $excel->setActiveSheetIndex(0)->setCellValue('H8', "Item Remark"); 

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A9')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B9')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C9')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D9')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E9')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F9')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G9')->applyFromArray($style_col);
		// $excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);

		// Set height baris ke 1, 2 dan 3
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		// Buat query untuk menampilkan semua data siswa
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 10; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($data['poitem'] as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['material']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['partnumber']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['quantity']);	
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['unit']);			
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "Rp. ". number_format($h['price']));
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "Rp. ". number_format($h['price']*$h['quantity']));
			
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(13); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(10); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(35); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(10); // Set width kolom B

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Data Purchase Order");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="PO-'. $ponum . '.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}