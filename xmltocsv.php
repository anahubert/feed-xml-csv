<?php
	/*
	 * Converts xml feed to csv feed
	 *
	 * @author Aleksandra Hubert
	 *
	 */

require_once __DIR__ . '/conf/app.conf.php';
require_once __DIR__ . '/include/utils/class.Log.php';
require_once __DIR__ . '/include/utils/class.file.php';
require_once __DIR__ . '/include/utils/class.export.php';
require_once __DIR__ . '/include/class.csv.php';
require_once __DIR__ . '/include/class.xml.php';
require_once __DIR__ . '/include/utils/utils.php';
require_once __DIR__ . '/include/utils/dirutils.php';

try {

	$cli_params = Utils::parseParamsFromCli();

	// Provide date as command line param or define today as date
	if(!isset($cli_params["date"]) || empty($cli_params["date"])){

		$date = date("dmY");

	}else{

		$date = $cli_params["date"];

	}

	$customer_config = __DIR__ . "/conf/" . $cli_params["customer"] . ".conf.php";

	// Set customer name and parse config file of the customer 'customer'
	if (!isset($cli_params["customer"]) || empty($cli_params["customer"]) || !is_file($customer_config)) {

		throw new Exception("Please set -customer='' as command line param or check does file exist. See README for details.", 1);
	}

	$customer = $cli_params["customer"];

	require_once $customer_config;

	if(!is_dir($conf["dir"])){

		throw new Exception("Please create dir: " . $conf["dir"], 1);

	}
	
	$_file1 = new Xml();
	$_file1->dir = $conf["dir"];
	$_file1->tempname = $conf["file1"];
	$_file1->filename = $conf["file1"];
	$_file1->filepath = $_file1->dir . "/" . $_file1->filename;
	$_file1->fileds = $conf["fields1"];

	$_file2 = new Csv();
	$_file2->dir = $conf["dir"];
	$_file2->tempname = $conf["file2"];
	$_file2->filename = $conf["file2"];
	$_file2->filepath = $_file2->dir . "/" . $_file2->filename;
	$_file2->fileds = $conf["fields2"];

	Log::printLog("Converting..." . $_file1->filepath, Log::LOG_INFO);

	Utils::dos2unix($_file1->filepath);

	if(@$conf["zip"] == 1) Utils::unzip($_file1->filepath, $_file1->dir);

	$_file1->parse();

	$data = $_file1->csv($_file2);

	$_export = new Export();
	$_export->data = $data;
	$_export->name = $_file2->filename;
	$_export->type = "csv";
	$_export->csvSeparator = ";";
	$_export->csvFieldTerminator = "\"";
	$_export->save($_file2->filename, $_file2->dir);

	Log::printLog("Text file is stored in " . $_file2->dir . "/", Log::LOG_INFO);
	Log::printLog("Converted to: " . $_file2->filepath, Log::LOG_INFO);

	unset($_file1);
	$_file1 = null;

	unset($_file2);
	$_file2 = null;

} catch (Exception $e) {

	Log::printLog($e->getMessage(), Log::LOG_FATAL);

	exit($e->getCode());

}
?>
