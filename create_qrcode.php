<?php 
/*
author : Dung Tran
target : encode text into adler32 and crc32
param : $data, $code
*/
//-------------------------------------------------

class Converts {

	public $code;
	private $adler;
	private $crc;
	// private $str;

// convert data to code
	public function ConvertStrtoCode($data) {
		$this->adler = hash("adler32", $data);
		$this->crc = hash("crc32", $data);
		$this->code = $this->adler."<br>".$this->crc;
	}
}

?>