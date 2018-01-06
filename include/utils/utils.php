<?php
/**
 * DirUtils class
 *
 * @package Utils
 *
 * @class Utils
 *
 * @since July, 2012
 *
 * @author Aleksandra Hubert
 */

class Utils{


	/**
	 * pares the parameters from the comand line interface
	 * eg: you call in cli php script.php -bar=1 -foo=2
	 * parseParamsFromCli() return array('bar' => '1', 'foo' => '2');
	 *
	 * @return $array
	 */
	public static function parseParamsFromCli($param = null){
		$args = $_SERVER['argv'];
		$re = array();
		foreach( $args as $arg ) {

			if(substr($arg,0,1) == '-') {

				$arg = substr($arg,1);

				$arg = explode('=',$arg);
				// /-args="bestellungHashKey,48ea2d13-3293-416a-9978-e9d9812934

				$tmp = $arg[1];

				$re[$arg[0]] = $arg[1];

				$etmp1 = explode(";", $arg[1]);

				if($etmp1 && !empty($etmp1)) {

					foreach($etmp1 as $val){

						$etmp2 = explode(",", $val);

						if($etmp2 && !empty($etmp2) && count($etmp2) == 2){

							if(!is_array($re[$arg[0]])) $re[$arg[0]] = array();

							array_push($re[$arg[0]], array($etmp2[0] => $etmp2[1]));
						}
					}
				}else{
					$re[$arg[0]] = $tmp;
				}
			} else {
				$re[] = $arg;
			}
		}
		if(isset($re[$param])) return $re[$param];
		return $re;
	}

	public function dos2unix($filepath){

		try{

			$time = time();

			exec("cp '$filepath' /tmp/tmpfile-dosnix-$time && dos2unix /tmp/tmpfile-dosnix-$time && cp /tmp/tmpfile-dosnix-$time '$filepath' && rm /tmp/tmpfile-dosnix-$time", $out, $ext);

			if($ext > 0){

				Throw new Exception("Unable to convert file in unix form", 1);

			}
		}catch(Exception $e){

			print $e->getMessage();

			exit($e->getCode());

		}

	}

	public function isFilesDiff($file1, $file2){

		try{

			if(md5_file($file1) == md5_file($file2)) {

				return 0;
			}

			return 1;

		}catch(Exception $e){

			print $e->getMessage();

			exit($e->getCode());

		}

	}

	public function unzip($in, $out = "/tmp"){

		try{

			$ext = 1;

			$r = exec("unzip -n $in -d $out", $out, $ext);

			if(empty($r)){

				Throw new Exception("Unable to extract the file '$in' using 'unzip'", 1);

			}

			if($ext > 0){

				Throw new Exception("Unable to extract the file '$in' using 'unzip'", 1);

			}

			print "File is unziped\n";

		} catch (Exception $e) {

			print $e->getMessage();

			exit($e->getCode());

		}

	}

}
