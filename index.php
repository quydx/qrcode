<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="background.css">
  <link rel="stylesheet" type="text/css" href="select2-4.0.3/dist/css/select2.css">
	<title>QR code</title>
</head>
<body>
<script type="text/javascript">
  <script language=" JavaScript" >
<!-- 
    // function LoadOnce() 
    // { 
    // window.location.reload(); 
    // } 
</script>
<!-- -Author : Dung Tran vs Quydx -->
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
          <!-- <input class="col-xs-6" type="text" name="table__name"  style="color:black;"> -->
          <select class="col-xs-6" style="height: 40px;border-radius: 5px;background-color: #fff;color: #000;" name="table__name">
            <option selected="">No tables</option>
          </select>
        </div>
        <div class="form-group row">
          <label class="control-label col-xs-2">Select which columns to create qrCode </label>
          <select class="select2 col-xs-6" id="qrCodeColumns" name="qrCodeColumns[]" style="color:black;" multiple="">
            <option selected="">No select</option>
          </select>
        </div>
        <div class="form-group row">
          <label class="control-label col-xs-2">Select which columns to label each qrCode </label>
          <select class="select2 col-xs-6" id="labelColumns" name="labelColumns[]" style="color:black;" multiple="">
            <option selected="">No select</option>
          </select>
        </div>
        <div class="form-group row">
          <label class="control-label col-xs-2">Number of qrcode in a line </label>
          <input class="col-xs-6" type="number" name="__num" style="color:black;" min="1" max="7">
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
    .select2  {
      color: black !important;
    }
  </style>
<!-- Handle file -->

<script type="text/javascript" src="jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="select2-4.0.3/dist/js/select2.js"></script>
<script type="text/javascript">
  $('.select2').select2();
</script>
<script type="text/javascript"> 
    $('input[name=database__name]').on('change', function (){
      var databaseName = $(this).val();
      $.ajax({
        url : "getTables.php/?database=" + databaseName  , 
        type : "GET" , 
        success : function () {
          
        }
      }).done(function(res ) {
        if (res == "false") alert("Database is not exist");
        else {
          $('select[name=table__name]').html("<option selectd> no tables selected</option>"+res);
        }
      });
    });
    $('select[name=table__name]').on('change', function (){
      var databaseName = $('input[name=database__name]').val();
      var table = $(this).val();
      $.ajax({
        url : "getTables.php/?database=" + databaseName +"&table=" + table  , 
        type : "GET" , 
        success : function () {
          
        }
      }).done(function(res ) {
        if (res == "false") alert("Error");
        else {
          $('#qrCodeColumns , #labelColumns ').html(res);
        }
      });
      
    });
</script>


</body>
</html>