<?php  
     
     /**
      * @author Achmad Solichin
      * @website http://achmatim.net
      * @email achmatim@gmail.com
      */
     require_once("fpdf17/fpdf.php");
      
     class FPDF_AutoWrapTable extends FPDF {
           private $pdata = array();
           private $hdata = array();
           private $options = array(
               'filename' => '',
               'destinationfile' => '',
               'paper_size'=>'F4',
               'orientation'=>'L'
           );
      
           function __construct($pdata = array(), $options = array(), $hdata = array()) {
             parent::__construct();
             $this->data    = $pdata;
             $this->options = $options;
             $this->hdata   = $hdata;
         }
      
         public function rptDetailData () {
             //
             $border = 0;
             $this->AddPage();
             $this->SetAutoPageBreak(true,60);
             $this->AliasNbPages();
             $left = 25;
      
             //header
             $this->Cell(10,7,'',0,1);
             $this->SetFont("Arial", "B", 16);
             $this->SetX($left); $this->Cell(0, 10, 'PAYMENT REQUEST', 0, 1,'C');
            //  $this->Image('logo.png',480,20,90,80);

            // $this->SetFont("Arial", "B", 16);
            // $this->SetX($left); $this->Cell(0, 10, 'PENERIMAAN BARANG', 0, 1,'C');
            $this->Ln(40);
            $this->SetFont('Arial','B',10);
            $this->Cell(10,7,'',0,1);    
            $this->Cell(120,5,'Nomor Pembayaran',0);
            $this->Cell(10,5,':',0);
            $this->Cell(400,5, $this->hdata['ivnum'],0);

            $this->Cell(120,5,'Tanggal Pembayaran',0);
            $this->Cell(10,5,':',0);
            $this->Cell(75,5,$this->hdata['ivdate'],0);

            $this->Ln(10);
            $this->Cell(10,7,'',0,1);
            $this->Cell(120,5,'Note',0);
            $this->Cell(10,5,':',0);
            $this->Cell(400,5,$this->hdata['note'],0);
            
            $this->Cell(120,5,'Dibuat Oleh',0);
            $this->Cell(10,5,':',0);
            $this->Cell(100,7,$this->hdata['createdby'],0,1);

            $this->Ln(10);
            $this->Cell(120,5,'Vendor',0);
            $this->Cell(10,5,':',0);
            $this->Cell(400,7,$this->hdata['namavendor'],0);

            $this->Cell(120,5,'NPWP',0);
            $this->Cell(10,5,':',0);
            $this->Cell(100,5,$this->hdata['npwp'],0,1);

            // $this->Cell(10,7,'',0,1);
            $this->Ln(10);
            $this->Cell(120,5,'Alamat Vendor',0);
            $this->Cell(10,5,':',0);
            $this->Cell(400,7,$this->hdata['alamat'],0);

            // $this->Cell(100,7,'NPWP NO',0);
            // $this->Cell(10,5,':',0);
            // $this->Cell(100,5,'94.981.043.6-409.000',0,1);

            $this->Cell(120,5,'No. Rekening',0);
            $this->Cell(10,5,':',0);
            $this->Cell(100,7,$this->hdata['bankacc'] . " - ". $this->hdata['bankname'] . " a/n ". $this->hdata['bankaccname'] ,0,1);
            
            $this->Ln(10);
             $h = 20;
             $left = 40;
             $top = 80;
             #tableheader
             $this->SetFillColor(200,200,200);
             $left = $this->GetX();
             $this->SetFont('Arial','B',9);
             $this->Cell(25,$h,'No',1,0,'L',true);
             $this->SetX($left += 25); $this->Cell(65, $h, 'PO. Num', 1, 0, 'C',true);
             $this->SetX($left += 65); $this->Cell(50, $h, 'PO. Item', 1, 0, 'C',true);
             $this->SetX($left += 50); $this->Cell(150, $h, 'Kode Barang', 1, 0, 'C',true);
             $this->SetX($left += 150); $this->Cell(200, $h, 'Nama Barang', 1, 0, 'C',true);
             $this->SetX($left += 200); $this->Cell(65, $h, 'Quantity', 1, 0, 'C',true);
             $this->SetX($left += 65); $this->Cell(55, $h, 'Unit', 1, 0, 'C',true);
             $this->SetX($left += 55); $this->Cell(65, $h, 'Harga', 1, 0, 'C',true);
             $this->SetX($left += 65); $this->Cell(65, $h, 'Discount', 1, 0, 'C',true);
             $this->SetX($left += 65); $this->Cell(65, $h, 'Tax', 1, 0, 'C',true);
             $this->SetX($left += 65); $this->Cell(65, $h, 'Total Harga', 1, 1, 'C',true);
             //$this->Ln(20);
             $totalharga = 0;
             $discount   = 0;
             $tax        = 0;
             $taxvalue   = 0;
             $totaltax   = 0;
             $totalprice = 0;

             $this->SetFont('Arial','',8);
             $this->SetWidths(array(25,65,50,150,200,65,55,65,65,65,65,90));
             $this->SetAligns(array('C','L','L','L','L','R','C','R','R','R','R'));
             $no = 1; $this->SetFillColor(255);
             foreach ($this->data as $baris) {
                 $this->Row(
                     array($no++,
                     $baris['ponum'],
                     $baris['poitem'],
                     $baris['material'],
                     $baris['matdesc'],
                     $baris['quantity'],
                     $baris['unit'],
                     number_format($baris['price'],0,",","."),
                     number_format($baris['discount'],0,",","."),
                     number_format($baris['ppn'],0,",",".") . "%",
                     number_format($baris['totalprice'],0,",",".")                     
                 ));

                 $totalharga = $totalharga + ($baris['price']*$baris['quantity']);
                 $discount   = $discount + $baris['discount'];
                 $totalprice = (($baris['price']*$baris['quantity'])-$baris['discount']);
                 $taxvalue   = $taxvalue + ($totalprice*($baris['ppn']/100));
             }
            
            $this->SetFont('Arial','B',8);
            $this->Cell(770,15,'JUMLAH','L',0,'R');
            $this->Cell(30,15,'Rp.','',0,'R');
            $this->Cell(70,15,number_format($totalharga,0,",","."),'R',1,'R');
            $this->Cell(770,15,'DISCOUNT','L',0,'R');
            $this->Cell(30,15,'Rp.','',0,'R');
            $this->Cell(70,15,number_format($discount,0,",","."),'R',1,'R');
            $this->Cell(770,15,'PPN','L',0,'R');
            $this->Cell(30,15,'Rp.','',0,'R');
            $this->Cell(70,15,number_format($taxvalue,0,",","."),'R',1,'R');
            $this->Cell(770,15,'TOTAL','L,B',0,'R');
            $this->Cell(30,15,'Rp.','B',0,'R');
            $this->Cell(70,15,number_format($totalharga+$taxvalue-$discount,0,",","."),'R,B',1,'R');

            $check = "";
            $checkbox_size = 5; 
            $ori_font_family = 'Arial'; 
            $ori_font_size = '10'; 
            $ori_font_style = '';

            $this->Ln(20);
            $this->SetFont('Arial','B',8);
            $this->Cell(5,15,'','',0,'L');
            $this->Cell(15,15,'','',0,'L');
            $this->Cell(90,15,'','',0,'R');
            $this->Cell(600,15,'','',0,'L');
            $this->Cell(120,15,'APPROVED BY,','',1,'C');

            $this->Ln(50);
            $this->Cell(700,15,'','',0,'C');
            $this->SetLineWidth(1);  
            $this->Cell(140,15,'DIREKTUR','T',0,'C');

            $this->Ln(10);
            $this->Cell(700,15,'','',0,'C');
            $this->SetLineWidth(1);  
            $this->Cell(140,15,$this->hdata['approvedate'],'',0,'C');
         }
      
         public function printPDF () {
      
             if ($this->options['paper_size'] == "F4") {
                 $a = 8.3 * 72; //1 inch = 72 pt
                 $b = 13.0 * 72;
                 $this->FPDF('L', "pt", array($a,$b));
             } else {
                 $this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);
             }
      
             $this->SetAutoPageBreak(false);
             $this->AliasNbPages();
             $this->SetFont("helvetica", "B", 10);
             //$this->AddPage();
      
             $this->rptDetailData();
      
             $this->Output($this->options['filename'],$this->options['destinationfile']);
           }
      
           private $widths;
         private $aligns;
      
         function SetWidths($w)
         {
             //Set the array of column widths
             $this->widths=$w;
         }
      
         function SetAligns($a)
         {
             //Set the array of column alignments
             $this->aligns=$a;
         }
      
         function Row($pdata)
         {
             //Calculate the height of the row
             $nb=0;
             for($i=0;$i<count($pdata);$i++)
                 $nb=max($nb,$this->NbLines($this->widths[$i],$pdata[$i]));
             $h=15*$nb;
             //Issue a page break first if needed
             $this->CheckPageBreak($h);
             //Draw the cells of the row
             for($i=0;$i<count($pdata);$i++)
             {
                 $w=$this->widths[$i];
                 $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                 //Save the current position
                 $x=$this->GetX();
                 $y=$this->GetY();
                 //Draw the border
                 $this->Rect($x,$y,$w,$h);
                 //Print the text
                 $this->MultiCell($w,15,$pdata[$i],0,$a);
                 //Put the position to the right of the cell
                 $this->SetXY($x+$w,$y);
             }
             //Go to the next line
             $this->Ln($h);
         }
      
         function CheckPageBreak($h)
         {
             //If the height h would cause an overflow, add a new page immediately
             if($this->GetY()+$h>$this->PageBreakTrigger)
                 $this->AddPage($this->CurOrientation);
         }
      
         function NbLines($w,$txt)
         {
             //Computes the number of lines a MultiCell of width w will take
             $cw=&$this->CurrentFont['cw'];
             if($w==0)
                 $w=$this->w-$this->rMargin-$this->x;
             $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
             $s=str_replace("\r",'',$txt);
             $nb=strlen($s);
             if($nb>0 and $s[$nb-1]=="\n")
                 $nb--;
             $sep=-1;
             $i=0;
             $j=0;
             $l=0;
             $nl=1;
             while($i<$nb)
             {
                 $c=$s[$i];
                 if($c=="\n")
                 {
                     $i++;
                     $sep=-1;
                     $j=$i;
                     $l=0;
                     $nl++;
                     continue;
                 }
                 if($c==' ')
                     $sep=$i;
                 $l+=$cw[$c];
                 if($l>$wmax)
                 {
                     if($sep==-1)
                     {
                         if($i==$j)
                             $i++;
                     }
                     else
                         $i=$sep+1;
                     $sep=-1;
                     $j=$i;
                     $l=0;
                     $nl++;
                 }
                 else
                     $i++;
             }
             return $nl;
         }
     } //end of class
      
     //contoh penggunaan
     $pdata = $data['ivitem'];
     $hdata = $data['header'];
      
     //pilihan
     $options = array(
         'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
         'destinationfile' => '', //I=inline browser (default), F=local file, D=download
         'paper_size'=>'F4',	//paper size: F4, A3, A4, A5, Letter, Legal
         'orientation'=>'L' //orientation: P=portrait, L=landscape
     );
      
     $tabel = new FPDF_AutoWrapTable($pdata, $options,$hdata);
     $tabel->printPDF();
     ?>