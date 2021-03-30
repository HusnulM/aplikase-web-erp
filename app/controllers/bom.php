<?php

class Bom extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('bom', 'Read');
        if ($check){
            $data['title'] = 'Master BOM';
            $data['menu']  = 'Master BOM';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['bomdata'] = $this->model('Bom_model')->bomList();

            $this->view('templates/header_a', $data);
            $this->view('bom/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('bom', 'Create');
        if ($check){
            $data['title'] = 'Create BOM';
            $data['menu']  = 'Create BOM';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['bomdata'] = $this->model('Bom_model')->bomList();
            $data['cust']       = $this->model('Customer_model')->customerList();

            $this->view('templates/header_a', $data);
            $this->view('bom/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function detail($bomid){
        $check = $this->model('Home_model')->checkUsermenu('bom', 'Update');
        if ($check){
            $data['title'] = 'Detail BOM';
            $data['menu']  = 'Detail BOM';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['bomhead']    = $this->model('Bom_model')->bomHeader($bomid);
            $data['bomdata']    = $this->model('Bom_model')->bomDetail($bomid);
            $data['cust']       = $this->model('Customer_model')->customerList();
            $data['_cust']      = $this->model('Customer_model')->getCustomerById($data['bomhead']['cust_id']);
            $data['bomdtl']  = json_encode($data['bomdata']);
            $data['bomid']   = $bomid;

            $this->view('templates/header_a', $data);
            $this->view('bom/detail', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function calculate($bomid){
        $check = $this->model('Home_model')->checkUsermenu('bom', 'Update');
        if ($check){
            $data['title'] = 'Calculate Material Requirement';
            $data['menu']  = 'Calculate Material Requirement';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['bomhead'] = $this->model('Bom_model')->bomHeader($bomid);
            $data['bomdata'] = $this->model('Bom_model')->bomDetail($bomid);
            $data['kursusdidr'] = $this->model('Bom_model')->getusdtoidr();
            $data['bomdtl']  = json_encode($data['bomdata']);
            $data['kurs']    = json_encode($data['kursusdidr']);
            $data['bomid']   = $bomid;

            $data['showprice'] = $this->model('Barang_model')->checkauthdisplayprice();

            $this->view('templates/header_a', $data);
            $this->view('bom/calculate', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function bomcalculation($bomid,$qty){
        $data = $this->model('Bom_model')->bomcalculation($bomid,$qty);
        echo json_encode($data);
    }

    public function convertbomtopr($bomid,$qty){
        $nextNumb = $this->model('Pr_model')->getNextNumber('PR');
        $data     = $this->model('Bom_model')->bomcalculation($bomid,$qty);
		if( $this->model('Bom_model')->convertbomtopr($data, $nextNumb['nextnumb']) > 0 ) {
		
            $return = array(
                "msgtype" => "1",
                "message" => "PR Created!",
                "prnum"   => $nextNumb['nextnumb']
            );
            echo json_encode($return);
			exit;			
		}else{
			$return = array(
                "msgtype" => "2",
                "message" => "Error!"
            );
            echo json_encode($return);
			exit;	
		}
	}

    public function save(){
        if( $this->model('Bom_model')->save($_POST) > 0 ) {
			$return = array(
                "msgtype" => "1",
                "message" => "BOM Created!"
            );
            echo json_encode($return);
			exit;			
		}else{
			$return = array(
                "msgtype" => "2",
                "message" => "Error Create BOM!"
            );
            echo json_encode($return);
			exit;	
        }
    }

    public function update(){
        if( $this->model('Bom_model')->update($_POST) > 0 ) {
			$return = array(
                "msgtype" => "1",
                "message" => "BOM Updated!"
            );
            echo json_encode($return);
			exit;			
		}else{
			$return = array(
                "msgtype" => "2",
                "message" => "Error Update BOM!"
            );
            echo json_encode($return);
			exit;	
        }
    }

    public function delete($bomid){
        if($_SESSION['usr']['userlevel'] == "SysAdmin"){
            if( $this->model('Bom_model')->delete($bomid) > 0 ) {
    			Flasher::setMessage('BOM','Deleted!','success');
    			header('location: '. BASEURL . '/bom');
    			exit;			
    		}else{
    			Flasher::setMessage('Error','','success');
    			header('location: '. BASEURL . '/bom');
    			exit;	
            }
        }else{
            $this->view('templates/401');
        } 
    }

    public function exportbom($bomid,$inputqty,$strdate,$enddate,$qtycct){
        $bomheader = $this->model('Bom_model')->bomHeader($bomid);
        $bomdetail = $this->model('Bom_model')->bomcalculation($bomid,$inputqty);

        $excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("BOM Calculation")
             ->setSubject("BOM Calculation")
             ->setDescription("BOM Calculation")
             ->setKeywords("BOM Calculation");
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
		
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "BOM MATERIAL");
		$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		
		$excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('D4')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('E4')->getFont()->setBold(TRUE);

		// $objDrawing = new PHPExcel_Worksheet_Drawing();
        // $objDrawing->setName('Logo ');
        // $objDrawing->setDescription('Logo ');
        // $objDrawing->setPath('./images/aws-logo.png');
        // $objDrawing->setResizeProportional(true);
        // $objDrawing->setWidth(100);
        // $objDrawing->setCoordinates('E1');
        // $objDrawing->setWorksheet($excel->getActiveSheet());

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "CUSTOMER");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', ":");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', $bomheader['customer']);
        
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "PART NAME");
		$excel->setActiveSheetIndex(0)->setCellValue('B4', ":");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', $bomheader['partname']);
        
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "PART NUMBER");
		$excel->setActiveSheetIndex(0)->setCellValue('B5', ":");
        $excel->setActiveSheetIndex(0)->setCellValue('C5', $bomheader['partnumber']);
        
        $excel->setActiveSheetIndex(0)->setCellValue('A6', "QUANTITY PLANNING");
		$excel->setActiveSheetIndex(0)->setCellValue('B6', ":");
        $excel->setActiveSheetIndex(0)->setCellValue('C6', $inputqty, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $excel->setActiveSheetIndex(0)->setCellValue('A7', "JUMLAH CCT");
		$excel->setActiveSheetIndex(0)->setCellValue('B7', ":");
        $excel->setActiveSheetIndex(0)->setCellValue('C7', $qtycct);
        
        $excel->setActiveSheetIndex(0)->setCellValue('A8', "TANGGAL");
		$excel->setActiveSheetIndex(0)->setCellValue('B8', ":");
		$excel->setActiveSheetIndex(0)->setCellValue('C8', $strdate . " s/d " . $enddate);

		
        $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(TRUE);

        $excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('C4')->getFont()->setBold(TRUE);
        
        $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE);

		$excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('B6')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('C6')->getFont()->setBold(TRUE);

		$excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);

        $excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('B8')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('C8')->getFont()->setBold(TRUE);

        $excel->getActiveSheet()->getStyle('A9')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('B9')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('C9')->getFont()->setBold(TRUE);
		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A10', "NO"); // 
		$excel->setActiveSheetIndex(0)->setCellValue('B10', "Component"); // 
		// $excel->setActiveSheetIndex(0)->setCellValue('C9', "Description"); // 
		$excel->setActiveSheetIndex(0)->setCellValue('C10', "Quantity"); // 
		$excel->setActiveSheetIndex(0)->setCellValue('D10', "Total Requirement"); // 
		$excel->setActiveSheetIndex(0)->setCellValue('E10', "Unit"); // 
		
		$excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B10')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E10')->applyFromArray($style_col);
		// $excel->getActiveSheet()->getStyle('F9')->applyFromArray($style_col);
		// Set height baris ke 1, 2 dan 3
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		// Buat query untuk menampilkan semua data siswa
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 11; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($bomdetail as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['component'],PHPExcel_Cell_DataType::TYPE_STRING);
			// $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['matdesc'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['quantity']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['Total']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['unit']);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			// $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			
			$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(15); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
		// $excel->getActiveSheet()->getColumnDimension('F')->setWidth(10); // Set width kolom F
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("BOM Calculation");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="BOM-'. $bomheader['partnumber'] .'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
    }
}