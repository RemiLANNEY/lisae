<?php

namespace App;

use Maatwebsite\Excel\Files\ExcelFile;
use Illuminate\Support\Facades\Input;

class Excel extends ExcelFile {
	
	protected $delimiter  = ',';
	protected $enclosure  = '"';
	protected $lineEnding = '\r\n';
	
	
	public function getFile()
	{
		return storage_path()."/import.csv";
	}
}
?>