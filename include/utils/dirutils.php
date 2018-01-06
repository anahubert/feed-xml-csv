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


class DirUtils extends Utils{

		/**
		 * Creates new dir or if exists do nothing
		 * @param string $dir apsolute dir path
		 * @param array $args list of arguments
		 * @return bool true | false
		 */
		public function createDir($dir, $args = array()){
			@mkdir($dir, 0777, true);
			return is_dir($dir);
		}

		/**
		 * Check if directory exists
		 * @param string $dir apsolute dir path
		 * @param array $args list of arguments
		 * @return bool true | false
		 */
		public function isDirectory($dir, $args = array()){
			return is_dir($dir);
		}

		/**
		 * Copies file from source to destination.
		 * Does nothing in case that can not find filepath
		 * @param string $source file path
		 * @param string $destination filepath
		 * @return bool true | false
		 */
		public function copyFile($source, $destination){
			return @copy($source, $destination);
		}

		/**
		 * Save contents from file pointer to file on filepath.
		 * @param string $filepath absolute file path
		 * @param string $fp resource file pointer
		 * @return int 1 | 0
		 */
		public function saveFile($filepath, $fp){

			$status = 0;

			try{

				// Open and create file for writting data
				$file_fp = fopen($filepath, 'w');

				fseek($fp, 0);

				$contents = '';

				while (!feof($fp)) { $contents .= fread($fp, 8192); }

				fwrite($file_fp, $contents);

				fclose($file_fp);

				$status = 1;

			}catch(Exception $e){

				print_r($e->getMessage());

			}

			return $status;

		}

		/**
		 * Save contents from file pointer to file on filepath.
		 * @param string $filepath absolute file path
		 * @param string $fp resource file pointer
		 * @return int 1 | 0
		 */
		public function saveToFile($filepath, $contents){

			$status = 0;

			try{

				// Open and create file for writting data
				$file_fp = fopen($filepath, 'w');

				fwrite($file_fp, $contents);

				fclose($file_fp);

				$status = 1;

			}catch(Exception $e){

				print_r($e->getMessage());

			}

			return $status;

		}


}
