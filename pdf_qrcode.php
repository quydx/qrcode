<?php
//======================================
//author : Dung Tran
//target : create qrcode from csv file
//======================================
$path =  $_FILES['fileToUpload']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
if ($ext == 'csv'){

move_uploaded_file($_FILES['fileToUpload']['tmp_name'], '../html'.$_FILES['fileToUpload']['name']);
					
$file_handle = fopen('../html'.$_FILES['fileToUpload']['name'], "r");

//read till the end of the file

	
	include "source/tcpdf.php";
//create new PDF document
	$pdf = new tcpdf();
	
//set document infomation
	$pdf -> SetAuthor('Dung Tran');
	$pdf -> SetTitle('Qrcode');

//set default header data
	$pdf -> SetHeaderData(0,0, "Dung Tran", "Qrcode");

//set header and footer fonts
	$pdf -> setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf -> setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set margins
	$pdf -> SetMargins($margin_left = 10, $margin_top=20, $margin_right =10); // left top right
	$pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf -> SetFooterMargin(10);

// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, 50); // auto margin bottom

//set font 
	$pdf -> setFont('Times','', $font_size =16);

//-------------------------------------------------------

//add a page
	$pdf -> AddPage('','Letter');
//set cell
	// $pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
	// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
	$pdf->SetFillColor(255, 255, 255);// white

/**
* @param $row (int) row excel
* @param $line_of_text : get file to handle
* @param $token (str) is data that encrypted code
**/
// define somes integer
	$numqr_of_row 	= 4 ; // so qr tren 1 donng
	$count 			= 1; // bien dem so qr tren 1 dong
	$current_column = 0; // cot hien tai
	$numof_column 	= 1; // num of column need to get qrcode
	$x 				= 10; // toa do x cua png
	$y 				= 20; // to do y cua png
	$array_code 	= array();		// array of qr code str
	$qrcode_size 	= 36 ; // kich thuoc qr png
	$qrcode_gap 	= 18 ; // k/c giua cac qr
	$font_size 		= 16 ; //font size
	$qr_width		= 48 ; // width qr
	$qr_height		= 72 ; // height qr

//duyet tu file csv

	require_once (dirname(__FILE__).'/phpqrcode/qrlib.php');
	require_once (dirname(__FILE__).'/create_qrcode.php');

	while(!feof($file_handle)){
		while($line_of_text = fgetcsv($file_handle, 1024)){
			//take data from column 0
			   	$data = $line_of_text[0];
		  	//convert string to code 
			   
				$token = new Converts();	
				$token -> ConvertStrtoCode($data);
				$code = $token->code; 
				$array_code [] = $code ;
			}
	}
	fclose($file_handle);
	$i = 0 ;$j=0; // 2 bien dem
	foreach ($array_code as $value) {
		$code = new Converts();	
		$code -> ConvertStrtoCode($value);
		$str = $code->code; 
		Qrcode::png($str, 'upload/img/'.str_replace('<br>' , '' , $str ).'.png'); 
		$pdf -> image('upload/img/'.str_replace('<br>' , '' , $str ).'.png', $x,$y, $qrcode_size , $qrcode_size  , 'PNG'); 
		// $pdf -> Ln();
		$pdf->writeHTMLCell($qr_width, $qr_height, $x-5,$y,'<br><br><br><br><br><br>this is a sentence bla bla...' , 0, 0, 0, true, 'C', true);
		$i++;
		$x += $qr_width;
		if ($i%4 == 0) {
			$j++; 
			if ($j%3==0 && $j > 0){
				$pdf -> AddPage('','Letter');
				$x = 10;$y = 20;
			}
			else {
				$pdf->Ln();
				$x = 10;
				$y += $qr_height;
			}
		}
	}
	$pdf -> Output('Qrcode.pdf');
}
else if($ext == 'sql'){
	// echo "day la file sql";
	move_uploaded_file($_FILES['fileToUpload']['tmp_name'], '../html'.$_FILES['fileToUpload']['name']);
					
	$file_handle = fopen('../html'.$_FILES['fileToUpload']['name'], "r");

	while(!feof($file_handle)){
		echo fgets($file_handle);
		//
	}
}


?>
