<?php

class Cost extends Controller {

    public function index(){
        $check = $this->model('Home_model')->checkUsermenu('cost', 'Read');
        if ($check){
            $data['title'] = 'Cost Process';
            $data['menu']  = 'Cost Process';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['partlist'] = $this->model('Cost_model')->getPartList();
            $data['showcost'] = $this->model('Cost_model')->checkauthdisplaycost();
            $data['upah']     = $this->model('Cost_model')->getUpah();

            $this->view('templates/header_a', $data);
            $this->view('cost/index', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function create(){
        $check = $this->model('Home_model')->checkUsermenu('cost', 'Create');
        if ($check){
            $data['title'] = 'Create cost';
            $data['menu']  = 'Create cost';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------  

            $this->view('templates/header_a', $data);
            $this->view('cost/create', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function detail($bomid){
        $check = $this->model('Home_model')->checkUsermenu('cost', 'Update');
        if ($check){
            $data['title'] = 'Detail cost';
            $data['menu']  = 'Detail cost';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['bomhead']  = $this->model('Bom_model')->bomHeader($bomid);
            $data['costdata'] = $this->model('Cost_model')->getCostDetail($bomid);
            $data['costdtl']  = json_encode($data['costdata']);
            $data['bomid']    = $bomid;

            $this->view('templates/header_a', $data);
            $this->view('cost/detail', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function calculate($bomid){
        $check = $this->model('Home_model')->checkUsermenu('cost', 'Read');
        if ($check){
            $data['title'] = 'Cost Calculation';
            $data['menu']  = 'Cost Calculation';

            // Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
            //-------------------------------------------------------------------------   

            $data['bomhead']  = $this->model('Bom_model')->bomHeader($bomid);
            $data['costdata'] = $this->model('Cost_model')->getCostDetail($bomid);
            $upah             = $this->model('Cost_model')->getUpah();
            $data['costdtl']  = json_encode($data['costdata']);
            $data['bomid']    = $bomid;
            $data['showcost'] = $this->model('Cost_model')->checkauthdisplaycost();

            //Calculate Total Cost
            $totalwaktu      = 0;
            $totalupahperjam = 0;
            $totalcost       = 0;
            foreach($data['costdata'] as $cost){
                $totalwaktu = $totalwaktu + $cost['totaltime'];
            }

            $totalupahperjam = ($upah['value']*1)/20/8;
            $totalcost = $totalupahperjam * ($totalwaktu/3600);
            
            $data['totalwaktu'] = $totalwaktu;
            $data['costperjam'] = $totalupahperjam;
            $data['totalcost']  = $totalcost;
            $data['upah']       = $upah['value'];

            $this->view('templates/header_a', $data);
            $this->view('cost/calculate', $data);
            $this->view('templates/footer_a');
        }else{
            $this->view('templates/401');
        }        
    }

    public function save(){
        if( $this->model('Cost_model')->save($_POST) > 0 ) {
			$return = array(
                "msgtype" => "1",
                "message" => "Cost process updated!"
            );
            echo json_encode($return);
			exit;			
		}else{
			$return = array(
                "msgtype" => "2",
                "message" => "Error Update cost!"
            );
            echo json_encode($return);
			exit;	
        }
    }

    public function updateupah($newvalue){
        if( $this->model('Cost_model')->updateupah($newvalue) > 0 ) {
			echo json_encode("OK");
			exit;			
		}else{
			echo json_encode("OK");
			exit;	
		}
    }

    public function update(){
        if( $this->model('Cost_model')->update($_POST) > 0 ) {
			$return = array(
                "msgtype" => "1",
                "message" => "cost Updated!"
            );
            echo json_encode($return);
			exit;			
		}else{
			$return = array(
                "msgtype" => "2",
                "message" => "Error Update cost!"
            );
            echo json_encode($return);
			exit;	
        }
    }

    public function delete($costid){
        if($_SESSION['usr']['userlevel'] == "SysAdmin"){
            if( $this->model('Cost_model')->delete($costid) > 0 ) {
    			Flasher::setMessage('cost','Deleted!','success');
    			header('location: '. BASEURL . '/cost');
    			exit;			
    		}else{
    			Flasher::setMessage('Error','','success');
    			header('location: '. BASEURL . '/cost');
    			exit;	
            }
        }else{
            $this->view('templates/401');
        } 
    }

    public function exportcost($costid,$inputqty,$strdate,$enddate,$qtycct){
        $costheader = $this->model('Cost_model')->costHeader($costid);
        $costdetail = $this->model('Cost_model')->costcalculation($costid,$inputqty);

        $excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("cost Calculation")
             ->setSubject("cost Calculation")
             ->setDescription("cost Calculation")
             ->setKeywords("cost Calculation");
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
		
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "cost MATERIAL");
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
        $excel->setActiveSheetIndex(0)->setCellValue('C3', $costheader['customer']);
        
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "PART NAME");
		$excel->setActiveSheetIndex(0)->setCellValue('B4', ":");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', $costheader['partname']);
        
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "PART NUMBER");
		$excel->setActiveSheetIndex(0)->setCellValue('B5', ":");
        $excel->setActiveSheetIndex(0)->setCellValue('C5', $costheader['partnumber']);
        
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
		foreach($costdetail as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
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
		$excel->getActiveSheet(0)->setTitle("cost Calculation");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="cost-'. $costheader['partnumber'] .'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
    }
}