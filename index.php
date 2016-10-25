<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="background.css">
	<title>QR code</title>
</head>
<body>

<!-- -Author : Dung Tran -->
<div class="container">
    <div class="jumbotron">
      <div class="page-header">
        <h3>Hi! Welcome to our website which will help you convert seed datas to QRcode.</h3>
        <div class="notification"></div>
      </div>
      <h4> From file exel </h4>
      <form action = "pdf_qrcode.php" method="POST" class="form-horizontal"  enctype="multipart/form-data"> <!-- -->
        
        <div class="form-group" style="margin:5px auto;">
          <label class="control-label col-xs-2">Upload file here</label>
        	<label class="input-group-btn col-xs-6">
            	<span class="btn btn-default">
          	    <input type="file" name="fileToUpload" id="fileToupload"  multiple>
       			 </span>
          </label>
          
        </div>

        
        <input type="submit" name="file_submit" id="submit" class="btn btn-success" value="Create QR code">
      </form>

      <h4>Or from your SQL database</h4>

      <form action="pdf_fromsql.php" method="post" class="form-horizontal" id="sql__form">
        <div class="form-group row">
          <label class="control-label col-xs-2">Database name </label>
          <input class="col-xs-6" type="text" name="database__name" style="color:black;">
        </div>
        <div class="form-group row">
          <label class="control-label col-xs-2">Table name </label>
          <input class="col-xs-6" type="text" name="table__name"  style="color:black;">
        </div>
        <div class="form-group row">
          <label class="control-label col-xs-2">Number of qrcode in a line </label>
          <input class="col-xs-6" type="number" name="__num" style="color:black;" min="1">
        </div>
        <button type="submit" name="sql__submit" class="btn btn-success">Create QRCode</button>
      </form>
    </div>
  </div>
  <style type="text/css">
    #sql__form input {
      height: 30px;
      border-radius: 5px;
    }
  </style>
<!-- Handle file -->

<?php
// is _Post['submit'] exist 
if(isset($_POST['file_submit'])){
	
	//is fileToUpload exist
	if(isset($_FILES['fileToUpload'])){
		
    //if not get errors, upload it
		if($_FILES['fileToUpload']['error'] > 0){
			echo "Upload fail!";
		}
		
    else { 
      $path =  $_FILES['fileToUpload']['name'];
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      if ($ext  == 'csv') {
      header("Location: pdf_qrcode.php"); /* Redirect browser */
      }
      else {
        echo 'ko dc';
      }
      // include "upload.php";
    }
	}
	else { echo "File isn't exist!!";}
}
?>
</body>
</html>