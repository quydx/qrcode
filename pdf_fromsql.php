<?php

/**
 author : quydx 
 last modify 27/10/2016
 content : create qrcode from mysql records
*/
$connect = NULL;
function connectDatabase ( $databaseName ,$userName , $password , $option ) { // connect database by PDO class
	try {
    	global $connect;
    	$connect = new PDO("mysql:host=localhost;dbname=$databaseName", $userName, $password ,$option);
	}
	catch(PDOException $e) {
		echo '<h3>ERORR !</h3>';
		echo 'Không thể kết nối database :'.$e->getMessage();
		exit();
	}
}

function executeQuery ( $queryStr ) { // execute sql query return a array of records
	global $connect;
	$results = $connect->prepare($queryStr);
    $results->setFetchMode(PDO::FETCH_ASSOC);
    $results->execute();
    while($row = $results->fetch()){
    	$data[] = $row ;
    }
    return $data;
}
function createData ( $selectedColumns , $table) { // implode selected into string separate by ","
	$queryStr = "SELECT ";
	foreach($selectedColumns as $sc ) {
		$queryStr .= "$sc,";
	}
	$queryStr = rtrim($queryStr,",");
	$queryStr .= " FROM $table";
	$data = executeQuery ($queryStr);
	foreach ($data as $data) {
	 	$code = implode(',', $data);
	 	$arrayCode[] = $code ;
	}
	return $arrayCode;
}
if (isset($_POST['sql__submit'])){ 

	// database infomation 
	$databaseName 	= $_POST['database__name'];
	$table		= $_POST['table__name'];
    $userName 		= 'root'; 
    $userPassword 	= ''; 
    $options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);

    // connect database 
    connectDatabase ( $databaseName ,$userName , $userPassword , $options ) ;

   	//columns 
    $selectedColumns = $_POST['qrCodeColumns'];
    $labelColumns = $_POST['labelColumns'];

    //create array code and label
	$arrayCode 	= createData( $selectedColumns , $table);
	$arrayLabel = createData( $labelColumns , $table);

	//required source
	require_once (dirname(__FILE__).'/phpqrcode/qrlib.php');
	require_once (dirname(__FILE__).'/source/tcpdf.php');
   	require_once (dirname(__FILE__).'/create_qrcode.php');

	// define somes integer
	   	$num 	= $_POST['__num'];

	//create new PDF document
		$pdf = new tcpdf();
		
	//set document infomation
		$pdf -> SetAuthor('quydx');
		$pdf -> SetTitle('Qrcode');

	//set default header data
		$pdf -> SetHeaderData(0,0, "Quydx", "Create Qrcode from MySQL");

	//set header and footer fonts
		$pdf -> setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf -> setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set margins
		$pdf -> SetMargins($margin_left = 10, $margin_top = 20, $margin_right = 10); // left top right
		$pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf -> SetFooterMargin(10);

	// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 50); // auto margin bottom

	//set font 
		$pdf -> setFont('Times','', 28 - 3*$num);

	//add a page
	$pdf -> AddPage('','Letter');

	$column = 0 ;$line=0;
	$x = 10;$y = 20;// x va y la toa do tren trang pdf

	if ($num == 1 ) $numOfLine = 1 ;
	else $numOfLine = ($num > 3) ? 3 : 2 ; 

	$width = 192/$num ;
	$height = $width + 30;

	for ($count = 0 ; $count < count($arrayLabel) ; $count++) {

		$code = new Converts();	
		$code -> ConvertStrtoCode($arrayCode[$count]);
		$str = $code->code; 

		Qrcode::png($str, "upload/".$arrayLabel[$count].".png"); 

		$pdf -> image("upload/".$arrayLabel[$count].".png", $x , $y , $width -5, $width -5 , 'PNG'); 
		$pdf -> Ln();
		$pdf->writeHTMLCell($width -5, 20 , $x , $y + $width -5, $arrayLabel[$count] , 0, 0, 0, true, 'C', true);

		$column++;
		$x += $width;
		if ($column % $num == 0) {
			$line++;
			if ($line > 0 && $line % $numOfLine==0){
				$pdf -> AddPage('','Letter');
				$x = 10;$y = 20;
			}
			else{
				$pdf->Ln();
				$x = 10;
				$y += $width -5 + 30;
			}
		}
	}
	$pdf -> Output('Qrcode.pdf');
}
?>
