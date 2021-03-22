<?php

class Quotation extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
	}

    public function index(){
		$check = $this->model('Home_model')->checkUsermenu('quotation','Read');
        if ($check){
			$data['title'] = 'GENERATE QUOTATION';
			$data['menu']  = 'GENERATE QUOTATION';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   

// 			$data['quotation']  = $this->model('Quotation_model')->listquotation();
	
			$this->view('templates/header_a', $data);
			$this->view('quotation/index', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
    }
	
	public function create(){
		$check = $this->model('Home_model')->checkUsermenu('quotation','Create');
        if ($check){
			$data['title']    = 'Create Quotation';
			$data['menu']     = 'Create Quotation';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   
	
			$this->view('templates/header_a', $data);
			$this->view('quotation/create', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
    }
    
    public function partlist(){
        $data['data'] = $this->model('Bom_model')->bomList();
        echo json_encode($data);
    }

    public function previewquotation($bomid,$profit=null,$persen){
		if($profit === null){
			$profit = 0;
		}else{
			$profit = str_replace(".","",$profit);
			$profit = str_replace(",",".",$profit);
			
			if($persen === "Y"){
				$profit = $profit/100;
			}
		}

		$data['bomheader']   = $this->model('Bom_model')->bomHeader($bomid);
		$data['setting']     = $this->model('Setting_model')->getgensetting();
		$data['kursusdidr']  = $this->model('Bom_model')->getusdtoidr();
		$data['bomitem']     = $this->model('Quotation_model')->bomDetail($bomid);
		$data['cycletime']   = $this->model('Quotation_model')->totalCycleTime($bomid);
		$data['upah']		 = $this->model('Cost_model')->getUpah();

		$totaltime = $data['cycletime']['total'] / 3600;
		$totalcost = ($data['upah']['value'] / 20 / 8) * $totaltime;

		$data['costprocess'] = round($totalcost,2);
		echo json_encode($data);
	}
	
    public function generatequotation($bomid,$qdate,$profit=null,$persen){

		if($profit === null){
			$profit = 0;
		}else{
			$profit = str_replace(".","",$profit);
			$profit = str_replace(",",".",$profit);
			
			if($persen === "Y"){
				$profit = $profit/100;
			}
		}

		$data['bomheader']   = $this->model('Bom_model')->bomHeader($bomid);
		$data['setting']     = $this->model('Setting_model')->getgensetting();
		$data['kursusdidr']  = $this->model('Bom_model')->getusdtoidr();
		$data['bomitem']     = $this->model('Quotation_model')->bomDetail($bomid);
		$data['cycletime']   = $this->model('Quotation_model')->totalCycleTime($bomid);
		$data['upah']		 = $this->model('Cost_model')->getUpah();

		$totaltime = $data['cycletime']['total'] / 3600;
		$totalcost = ($data['upah']['value'] / 20 / 8) * $totaltime;

		// $costprocess = ($totaltime*$totalcost)+(($totaltime*$totalcost)*$profit);
		
		// echo json_encode($sellingprice);
        
        $partnumber = $data['bomheader']['partnumber'];

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Quotation")
             ->setSubject("Quotation")
             ->setDescription("Quotation")
             ->setKeywords("Quotation");
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

		$style_col_normal_9 = array(
			'font' => array('bold' => false, 'size' => 9), // Set font nya jadi bold
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

		$style_double_border = array(
			'font' => array('bold' => false, 'size' => 9), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				// 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				// 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_DOUBLE), // Set border bottom dengan garis tipis
				// 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_col_normal_9_left = array(
			'font' => array('bold' => false, 'size' => 9), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_col_normal_9_right = array(
			'font' => array('bold' => false, 'size' => 9), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, // Set text jadi ditengah secara horizontal (center)
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
		$excel->getActiveSheet()->mergeCells('A1:B1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Kp. Cibulao Ds. Cirende Kec. Campaka"); 
		$excel->getActiveSheet()->mergeCells('A2:B2'); // Set Merge Cell pada kolom A1 sampai F1
		// $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(7); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "Purwakarta Jawa Barat "); 
		$excel->getActiveSheet()->mergeCells('A3:B3'); // Set Merge Cell pada kolom A1 sampai F1
		// $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(7); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 


		$excel->setActiveSheetIndex(0)->setCellValue('C2', $partnumber); 
		$excel->getActiveSheet()->mergeCells('C2:F3'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('C2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('G1', 'USD'); 
		$excel->getActiveSheet()->mergeCells('G1:G2'); 
		$excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(9);
		$excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('G4', 'PL DATE'); 
		$excel->getActiveSheet()->getStyle('G4')->getFont()->setSize(9);
		$excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('G4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('H4', $qdate); 
		$excel->getActiveSheet()->getStyle('H4')->getFont()->setSize(9);

		$excel->setActiveSheetIndex(0)->setCellValue('H1', $data['kursusdidr']['kurs2']); 
		$excel->getActiveSheet()->mergeCells('H1:H2'); 
		$excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(9);
		$excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$excel->getActiveSheet()->getStyle('H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$excel->getActiveSheet()->getStyle('G1:H2')->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('G3:H3')->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col_normal_9);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo ');
        $objDrawing->setDescription('Logo ');
        $objDrawing->setPath('./images/aws-logo.png');
        $objDrawing->setResizeProportional(true);
        $objDrawing->setWidth(50);
        $objDrawing->setCoordinates('C1');
		$objDrawing->setWorksheet($excel->getActiveSheet());
		
		$excel->setActiveSheetIndex(0)->setCellValue('A5', "CUSTOMER"); 
		$excel->setActiveSheetIndex(0)->setCellValue('A6', "ASSY NAME"); 
		$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(9);
		$excel->getActiveSheet()->getStyle('A6')->getFont()->setSize(9);

		$excel->setActiveSheetIndex(0)->setCellValue('C5', $data['bomheader']['customer']); 
		$excel->setActiveSheetIndex(0)->setCellValue('C6', $partnumber); 
		$excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('C6')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(9);
		$excel->getActiveSheet()->getStyle('C6')->getFont()->setSize(9);

		$excel->setActiveSheetIndex(0)->setCellValue('F5', "NO.ASSY"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G5', $partnumber); 
		$excel->setActiveSheetIndex(0)->setCellValue('F6', "CCT QTY"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G6', $data['bomheader']['qtycct']); 
		$excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('F6')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('F5')->getFont()->setSize(9);
		$excel->getActiveSheet()->getStyle('F6')->getFont()->setSize(9);
		$excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('G6')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('G5')->getFont()->setSize(9);
		$excel->getActiveSheet()->getStyle('G6')->getFont()->setSize(9);
		
		$excel->setActiveSheetIndex(0)->setCellValue('A7', "NO."); 
		$excel->setActiveSheetIndex(0)->setCellValue('B7', "Material"); 
		$excel->setActiveSheetIndex(0)->setCellValue('C7', "Color"); 
		$excel->setActiveSheetIndex(0)->setCellValue('D7', "PRICE"); 
		$excel->setActiveSheetIndex(0)->setCellValue('E7', "Currency"); 
		$excel->setActiveSheetIndex(0)->setCellValue('F7', "PRICE (Rp)"); 
		$excel->setActiveSheetIndex(0)->setCellValue('G7', "QTY"); 
		$excel->setActiveSheetIndex(0)->setCellValue('H7', "TOTAL"); 

		// // Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A7')->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('C7')->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('D7')->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('E7')->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('F7')->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('G7')->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('H7')->applyFromArray($style_col_normal_9);

		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_double_border);
		$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_double_border);
		$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_double_border);
		$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_double_border);
		$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_double_border);
		$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_double_border);
		$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_double_border);
		$excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_double_border);
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 8; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($data['bomitem'] as $i => $h){ // Ambil semua data dari hasil eksekusi $sql
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['component']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['color']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $h['stdpriceusd']);	
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['currency']);			
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $h['value']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $h['quantity']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, "=F".$numrow."*G".$numrow);
			
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_col_normal_9);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_col_normal_9_left);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_col_normal_9);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_col_normal_9_right);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_col_normal_9);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_col_normal_9);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_col_normal_9);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_col_normal_9_right);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_col_normal_9_right);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_col_normal_9_right);
			$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(15);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		$lastrow = $numrow-1;

		
		$footer_row = $numrow+1;
		$celltotal = 'H'.$footer_row;
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$footer_row, "Total Material Cost");
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$footer_row, "=ROUND(SUM(H8:H".$lastrow."),2)");
		$excel->getActiveSheet()->getStyle('G'.$footer_row)->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('G'.$footer_row)->getFont()->setSize(10);

		$footer_row = $footer_row+1;
		$celltotalcost = 'H'.$footer_row;
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$footer_row, "Cost Process");
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$footer_row, number_format($totalcost,2));
		$excel->getActiveSheet()->getStyle('G'.$footer_row)->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('G'.$footer_row)->getFont()->setSize(10);
		$footer_row = $footer_row+1;
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$footer_row, "Selling Price");

		if($persen === "Y"){
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$footer_row, "=ROUND(".$celltotal."+".$celltotalcost."+(".$celltotal."+".$celltotalcost.")*".$profit.",2)");
		}else{
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$footer_row, "=ROUND(".$celltotal."+".$celltotalcost."+".$profit.",2)");
		}
		
		$excel->getActiveSheet()->getStyle('G'.$footer_row)->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('G'.$footer_row)->getFont()->setSize(10);

		$footer_row = $footer_row+2;
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$footer_row, "Mengetahui");
		$excel->getActiveSheet()->mergeCells('E'.$footer_row.':F'.$footer_row);
		$excel->getActiveSheet()->getStyle('E'.$footer_row.':F'.$footer_row)->applyFromArray($style_col_normal_9);
		
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$footer_row, "Dibuat");
		$excel->getActiveSheet()->mergeCells('G'.$footer_row.':H'.$footer_row);
		$excel->getActiveSheet()->getStyle('G'.$footer_row.':H'.$footer_row)->applyFromArray($style_col_normal_9);

		$footer_row     = $footer_row+1;
		$footer_row_end = $footer_row+4;
		$excel->getActiveSheet()->mergeCells('E'.$footer_row.':F'.$footer_row_end);
		$excel->getActiveSheet()->mergeCells('G'.$footer_row.':H'.$footer_row_end);
		$excel->getActiveSheet()->getStyle('E'.$footer_row.':F'.$footer_row_end)->applyFromArray($style_col_normal_9);
		$excel->getActiveSheet()->getStyle('G'.$footer_row.':H'.$footer_row_end)->applyFromArray($style_col_normal_9);
		
		$footer_row = $footer_row_end+1;
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$footer_row, "");
		$excel->getActiveSheet()->mergeCells('E'.$footer_row.':F'.$footer_row);
		$excel->getActiveSheet()->getStyle('E'.$footer_row.':F'.$footer_row)->applyFromArray($style_col_normal_9);
		
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$footer_row, $_SESSION['usr']['user']);
		$excel->getActiveSheet()->mergeCells('G'.$footer_row.':H'.$footer_row);
		$excel->getActiveSheet()->getStyle('G'.$footer_row.':H'.$footer_row)->applyFromArray($style_col_normal_9);

		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(10); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(30); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(10); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(10); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(10); // Set width kolom B

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Quotation");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Quotation-'. $partnumber . '.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}