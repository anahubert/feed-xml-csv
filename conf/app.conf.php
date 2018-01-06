<?php

date_default_timezone_set('Europe/Belgrade');

setlocale(LC_ALL, "en_EN.UTF-8");

$_app_context = "";

if (isset($_SERVER["APP_ENV"])) {

	$_app_context = $_SERVER["APP_ENV"];

} else {

	print("Please set APP_ENV!!!\n");
	exit(1);

}

$_ENV['APP_ROOT'] = dirname(dirname(__FILE__));

switch ($_app_context) {
	case "development":
	case "integration":
		$_ENV["DATA"]["DIR"] = "";
		$_ENV['DOC_TMP_DOWNLOAD'] = "/tmp";
		break;
	case "production":
		$_ENV["DATA"]["DIR"] = "";
		$_ENV['DOC_TMP_DOWNLOAD'] = "/tmp";
		break;
	default:
		$_ENV["DATA"]["DIR"] = "";
		$_ENV['DOC_TMP_DOWNLOAD'] = "/tmp";
}


?>
