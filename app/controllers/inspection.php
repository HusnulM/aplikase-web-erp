<?php

class Inspection extends Controller{
    public function __construct(){
		if( isset($_SESSION['usr']) ){

		}else{
			header('location:'. BASEURL);
		}
	}

    public function index(){
		$check = $this->model('Home_model')->checkUsermenu('quotation','Read');
        if ($check){
			$data['title'] = 'Data Entry Inspection';
			$data['menu']  = 'Data Entry Inspection';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   

			// $data['quotation']  = $this->model('Quotation_model')->listquotation();
			$data['meja']     = $this->model('Meja_model')->listnomeja();
			$data['userlist'] = $this->model('User_model')->userList();
			$data['activity'] = $this->model('Activity_model')->activityList();
			$data['defect']   = $this->model('Inspection_model')->jenisDefect();
			$data['section']  = $this->model('Inspection_model')->defectSection();
	
			$this->view('templates/header_a', $data);
			$this->view('inspection/index', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
	}

	public function report(){
		$check = $this->model('Home_model')->checkUsermenu('quotation','Read');
        if ($check){
			$data['title'] = 'Laporan Inspection';
			$data['menu']  = 'Laporan Inspection';
			
			// Wajib di semua route ke view--------------------------------------------
            $data['setting']  = $this->model('Setting_model')->getgensetting();    //--
            $data['appmenu']  = $this->model('Home_model')->getUsermenu();         //--
			//-------------------------------------------------------------------------   
	
			$this->view('templates/header_a', $data);
			$this->view('inspection/report', $data);
			$this->view('templates/footer_a');
		}else{
			$this->view('templates/401');
		}
	}
	
	public function save(){
		if( $this->model('Inspection_model')->save($_POST) > 0 ) {
			Flasher::setMessage('Inspection','Created!','success');
			header('location: '. BASEURL . '/inspection');
			exit;			
		}else{
			Flasher::setMessage('Error','','success');
			header('location: '. BASEURL . '/inspection');
			exit;	
		}
	}

	public function defectprocess($idsection){
		$data = $this->model('Inspection_model')->defectProcess($idsection);
		echo json_encode($data);
	}

	public function defectlist($idsection){
		$data = $this->model('Inspection_model')->defectList($idsection);
		echo json_encode($data);
	}

	public function reportDefect($strdate, $enddate){
		$data = $this->model('Inspection_model')->reportDefect($strdate, $enddate);
		echo json_encode($data);
	}

	public function exportdata($strdate, $enddate){
		$data['defect'] = $this->model('Inspection_model')->reportDefect($strdate, $enddate);

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator($_SESSION['usr']['user'])
             ->setLastModifiedBy($_SESSION['usr']['user'])
             ->setTitle("Inspection")
             ->setSubject("Inspection")
             ->setDescription("Inspection")
             ->setKeywords("Inspection");
		
		$style_col = array(
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
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

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Inspection");
		$excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai F1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Defect");
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "Jumlah NG");
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);

		$no = 1;
		$numrow = 4;
		foreach($data['defect'] as $i => $h){
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['defect']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $h['jmlng']);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);

			$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			// $excel->getColumnDimension(chr($numrow))->setAutoSize(true);
			
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		$dataSeriesLabels1 = array(
			new PHPExcel_Chart_DataSeriesValues('String','Laporan Inspection!$C$3',NULL,1),
		);

		$xAxisTickValues1 = array(
			new PHPExcel_Chart_DataSeriesValues(
				'String',
				'Laporan Inspection!$B$4:$B$5',
				NULL,
				3)
		);

		$dataSeriesValues1 = array(
			new PHPExcel_Chart_DataSeriesValues(
				'Number',
				'Laporan Inspection!$C$4:$C$5',
				NULL,
				3),
		);

		$series1 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_PIECHART, // Tipe Chart
			NULL, // Grouping (Pie charts tidak ada grouping)
			range(0, count($dataSeriesValues1)-1), // Urutan Chart
			$dataSeriesLabels1, // Data Label
			$xAxisTickValues1,  // Data Sumbu X
			$dataSeriesValues1  // Nilai Data
		);

		// Pengaturan tampilan objek (layout) untuk diagram Pie.
		$layout1 = new PHPExcel_Chart_Layout();
		$layout1->setShowVal(TRUE);
		$layout1->setShowPercent(TRUE);
		
		// Masukkan seri data dalam area plot.
		// Area plot akan mengambil data layout dan di gabung dengan data seri
		// yang sebelumnya sudah di tentukan.
		$plotArea1 = new PHPExcel_Chart_PlotArea(
			$layout1,
			array($series1)
		);
		
		// Tentukan legend chart
		$legend1 = new PHPExcel_Chart_Legend(
			PHPExcel_Chart_Legend::POSITION_RIGHT,
			NULL,
			false
		);
		
		// Tentukan judul chart
		$title1 = new PHPExcel_Chart_Title('GRAFIK NG');
		
		// Pembuatan chart
		$chart1 = new PHPExcel_Chart(
			'grafik-ng', // Nama chart
			$title1,    // Judul chart
			$legend1,   // Legend chart
			$plotArea1, // Area plot
			true, // plotVisibleOnly
			0,    // displayBlanksAs
			NULL, // Label sumbu X
			NULL  // Label sumbu Y - Diagram pie tidak ada sumbu Y
		);
		
		// Set posisi titik kiri atas dan kanan bawah chart
		// Fungsinya untuk menentukan lokasi dibuatnya chart
		$chart1->setTopLeftPosition('F4');
		$chart1->setBottomRightPosition('M20');
		
		// Tambahkan chart ke dalam Worksheet

		$objWorksheet = $excel->getActiveSheet();
		$objWorksheet->addChart($chart1);

		$chart1->setWorksheet($excel->getActiveSheet());
		

		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(13); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(10); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(35); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(10); // Set width kolom B

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Laporan Inspection");
		$excel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Inspection.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->setIncludeCharts(TRUE);
		$write->save('php://output');
	}


	public function testchart($strdate, $enddate){

		$arraydata = [];
		$data['defect'] = $this->model('Inspection_model')->reportDefect($strdate, $enddate);
		
		$data['header'] = [
			"isnpecdate"=> "No",
			"defect"=> "Defect",
			"jmlng"=> "Jumlah NG"
		];

		array_push($arraydata, $data['header']);

		for($i = 0; $i < sizeof($data['defect']); $i++){
			// $data['header']
			array_push($arraydata, $data['defect'][$i]);
		}

		// echo json_encode($arraydata);
		$objPHPExcel = new PHPExcel();
		$objWorksheet = $objPHPExcel->getActiveSheet();


		$objWorksheet->fromArray(
			$arraydata
			// array($data['defect']
			//   array('', 2010, 2011, 2012),
			//   array('Q1', 12, 15, 21),
			//   array('Q2', 56, 73, 86),
			//   array('Q3', 52, 61, 69),
			//   array('Q4', 30, 32, 0),
			// )
		);

		$dataSeriesLabels1 = array(
			new PHPExcel_Chart_DataSeriesValues(
				'String',
				'Worksheet!$B$2',
				NULL,
				1),
		);

		$xAxisTickValues1 = array(
			new PHPExcel_Chart_DataSeriesValues(
				'String',
				'Worksheet!$B$2:$B$'. sizeof($arraydata),
				NULL,
				50)
		);

		$dataSeriesValues1 = array(
			new PHPExcel_Chart_DataSeriesValues(
				'Number',
				'Worksheet!$C$2:$C$'. sizeof($arraydata),
				NULL,
				50),
		);

		$series1 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART, // Tipe Chart
			NULL, // Grouping (Pie charts tidak ada grouping)
			range(0, count($dataSeriesValues1)-1), // Urutan Chart
			$dataSeriesLabels1, // Data Label
			$xAxisTickValues1,  // Data Sumbu X
			$dataSeriesValues1  // Nilai Data
		);

		// Pengaturan tampilan objek (layout) untuk diagram Pie.
		$layout1 = new PHPExcel_Chart_Layout();
		$layout1->setShowVal(false);
		$layout1->setShowPercent(false);
		
		// Masukkan seri data dalam area plot.
		// Area plot akan mengambil data layout dan di gabung dengan data seri
		// yang sebelumnya sudah di tentukan.
		$plotArea1 = new PHPExcel_Chart_PlotArea(
			$layout1,
			array($series1)
		);
		
		// Tentukan legend chart
		$legend1 = new PHPExcel_Chart_Legend(
			PHPExcel_Chart_Legend::POSITION_RIGHT,
			NULL,
			true
		);
		
		// Tentukan judul chart
		$title1 = new PHPExcel_Chart_Title('GRAFIK NG');
		
		// Pembuatan chart
		$chart1 = new PHPExcel_Chart(
			'nama-chartnya', // Nama chart
			$title1,    // Judul chart
			NULL,   // Legend chart
			$plotArea1, // Area plot
			true, // plotVisibleOnly
			0,    // displayBlanksAs
			NULL, // Label sumbu X
			NULL  // Label sumbu Y - Diagram pie tidak ada sumbu Y
		);
		
		// Set posisi titik kiri atas dan kanan bawah chart
		// Fungsinya untuk menentukan lokasi dibuatnya chart
		$chart1->setTopLeftPosition('F4');
		$chart1->setBottomRightPosition('M20');
		
		// Tambahkan chart ke dalam Worksheet
		$objWorksheet->addChart($chart1);

		// Tentukan index sheet aktif ke sheet paling awal
		// supaya ketika file di buka, maka sheet ini yang
		// akan di tampilkan pertama kali. (opsional)
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Bersihkan kode dari output buffer untuk menghindari
		// pesan error yang dapat mencegah proses download.
		ob_clean();
		
		// Redirect output to a client’s web browser (Excel2007)
		// Redirect hasil output ke web browser (Excel 2007)
		// Anda dapat mengubah nama file yang akan di download
		// pada bagian filename:
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Laporan '.date('d/m/Y').'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit;
	}
}