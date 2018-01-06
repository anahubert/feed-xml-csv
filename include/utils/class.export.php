<?php

/**
 * Export data to csv
 */
class Export {
	
	/**
	 * @var string charset
	 */
	var $charset = 'UTF-8';

	/**
	 * @var string report name
	 */
	var $name;

	/**
	 * @var filetype string
	 */
	var $type;

	/**
	 * @var array
	 */
	var $data;

	/**
	 * @var string
	 */
	var $csvSeparator;

	/**
	 * @var string
	 */
	var $csvFieldTerminator;


	/**
	 * save report
	 */
	public function save($filename = "report.csv", $dir = null) {

		$file_path = "/tmp/" . $filename . ".csv";

		if(isset($dir) && !empty($dir)){

			$file_path =  $dir . "/" . $filename . ".csv";

		}

		$fh = fopen($file_path, 'w') or die("can't open file");
		fwrite($fh, $this->getData());
		fclose($fh);
	}

	/**
	 * set contenttype for export file
	 *
	 * @return string
	 */
	private function getContentType() {
		switch( $this->type ) {
			case 'csv':
				$type = 'text/csv';
				break;
			default:
				$type = 'text/html';
				break;
		}
		return $type;
	}

	/**
	 * set file extension
	 *
	 * @return string
	 */
	private function getFileExtension() {
		switch( $this->type ) {
			default:
				$extension = $this->type;
				break;
		}
		return $extension;
	}


	/**
	 * get data
	 */
	private function getData() {
		switch( $this->type ) {
			case 'csv':
				return $this->getCsv();
				break;
			default:
				break;
		}
	}


	/**
	 * return line with separated values
	 *
	 * @param array, int (0 or 1 - means => 0 is header line or 1 other lines)
	 * @return string
	 *
	*/
	private function getLine($row = array(), $rc = 0){

		$re = array();

		foreach( $row as $key => $val ) {

			$tmpval = $val;
			if(!$rc) $tmpval = $key;

			$re[] = "{$this->csvFieldTerminator}{$tmpval}{$this->csvFieldTerminator}";

		}

		$str = sprintf("%s\n", implode($this->csvSeparator, $re));

		unset($re);

		return $str;
	}

	/**
	 * return csv data without seprator at the end of each line
	 *
	 * @return string
	 */
	private function getCsv () {
		$rc = 0;
		$csv = array();

		foreach( $this->data as $row ) {
			$csv[] = $this->getLine($row, $rc);
			$rc = 1;
		}

		$tmp = implode("", $csv);

		return $tmp;
	}

}

?>
