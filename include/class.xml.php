<?php

class Xml extends File{

	public $fileds = array();

	private $_data = array();
	private $_timeout = 0;

	public function __construct() {}

	public function parse(){

		$xml = simplexml_load_file($this->filepath);

		if (empty($xml)) {

			$errors = libxml_get_errors();

			foreach ($errors as $error) {

				echo display_xml_error($error, $xml);

			}

			libxml_clear_errors();

			Throw new Exception("Error", 1);

		}

		$this->_data = $xml;

	}

	public function csv($_file2){

		foreach($this->_data as $row){

			$tmp = array();

			foreach($_file2->fileds as $field){

				$val = $this->node($row, $field);

				if(!empty($val)){

					$tmp[$field] = $val;

				}

			}

			$data[] = $tmp;

		}

		return $data;

	}

	function &node($object, $param) {

	   $res = false;

	   $this->_timeout++;

       foreach($object as $key => $value) {

		   $key = strtolower($key);
		   $value = strtolower($value);

		   if(isset($object->$param)) {

			   $res = (string) $object->$param;

			   return $res;

		   }
		   if(is_object($object->$param) && !empty($object->$param)) {

			   $new_obj = $object->$key;

			   if($this->_timeout > 3){

				   Throw new Exception("Timeout Fn: XML::node", 1);

			   }

				 $res = $this->node($new_obj, $param);

			   $this->_timeout = 0;

		   }

       }

	   return $res;

   }
}
