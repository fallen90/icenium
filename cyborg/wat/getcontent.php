<?php
if(!isset($_GET['wattcode']) && !isset($_GET['accesscode'])){
	exit();
}


ini_set('max_execution_time', 300);
//set the dirs if not exists
$wattpadcode = $_GET['wattcode'];
$accesscode = $_GET['accesscode'];
$bookid = getID($wattpadcode);

	$builds = "./". $accesscode . "/builds/" . $bookid . "/";
	$temp = "./". $accesscode . "/temp/" . $bookid . "/";
	$jar = "./". $accesscode . "/jar/" . $bookid . "/";

	if (!file_exists($builds)) {
		mkdir($builds, 0777, true);
	}
	if (!file_exists($temp)) {
		mkdir($temp, 0777, true);
	}
	if (!file_exists($jar)) {
		mkdir($jar, 0777, true);
	}

	// download the jar file
	//extract
	//get the contents
	//put into a file
	//return the contents of the file
	//url = http://m.wattpad.com/offline/Wattpad_MIDP1-10791479.jar

	// if (!file_exists($builds . $wattpadcode . "/")) {
		// mkdir($builds . $wattpadcode, 0777, true);
	// }
	$url = "http://m.wattpad.com/offline/Wattpad_MIDP1-" . $wattpadcode . ".jar";

	$filename = $wattpadcode . ".jar";

	doDownload($url, $jar, $filename);

	if (!file_exists($jar . $filename)) {
		doDownload($url, $jar, $filename);
	}

	if (extractx($jar . $filename, $wattpadcode)) {

		merge_files($wattpadcode);

		if (file_exists($builds . $wattpadcode . ".txt")) {
			echo "CHAPTER_OK";
		} else {
			echo "NOT_FOUND";
		}
	} else {
		echo "ERROR_DOWNLOAD";
	}




//after downloading...
//merge the files from the builds > bookid folder

function merge_files($wattpadcode) {
	
	global $builds,$temp;
	if(file_exists($builds . "/" . $wattpadcode  . ".txt")) {
		@unlink($builds . "/" . $wattpadcode  . ".txt");
	}
	$dest = $builds;
	$working = $temp . $wattpadcode . "/";
	$contents= "";
	if(file_exists($working.$wattpadcode.".t")){
			$contents .= "\n*******************************************\n";
			$contents.=file_get_contents($working.$wattpadcode.".t") . "\n";
			$contents .= "\n*******************************************\n";
	}
	$contents .= file_get_contents($working . $wattpadcode);
	
	for ($i = 1; $i <= 50; $i++) {
		
		if (file_exists($working . $wattpadcode . '-' . $i . '0000')) {
			$contents .= file_get_contents($working . $wattpadcode . '-' . $i . '0000');
		}
	}
	if (!file_exists($dest . $wattpadcode . ".txt")) {
		file_put_contents($dest . $wattpadcode . ".txt", $contents);
	} else {
		unlink($dest . $wattpadcode . ".txt");
		file_put_contents($dest . $wattpadcode . ".txt", $contents);
	}
}

function extractx($file, $wattpadcode) {
	global $temp; 
	// dest /my/destination/dir/
	$dest = $temp . $wattpadcode;
	if (!file_exists($dest)) {
		mkdir($dest, 0777, true);
	}
	$zip = new ZipArchive;
	if ($zip -> open($file) === TRUE) {
		if ($zip -> locateName($wattpadcode) !== false) {
			$zip -> extractTo($dest, $wattpadcode);
		}

		if ($zip -> locateName($wattpadcode . '-10000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-10000');
		}
		if ($zip -> locateName($wattpadcode . '-20000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-20000');
		}

		if ($zip -> locateName($wattpadcode . '-30000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-30000');
		}

		if ($zip -> locateName($wattpadcode . '-40000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-40000');
		}
		if ($zip -> locateName($wattpadcode . '-50000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-50000');
		}
		if ($zip -> locateName($wattpadcode . '60000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-60000');
		}
		if ($zip -> locateName($wattpadcode . '-70000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-70000');
		}
		if ($zip -> locateName($wattpadcode . '-80000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-80000');
		}
		if ($zip -> locateName($wattpadcode . '-90000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-90000');
		}
		if ($zip -> locateName($wattpadcode . '-100000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-100000');
		}
		if ($zip -> locateName($wattpadcode . '-110000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-110000');
		}
		if ($zip -> locateName($wattpadcode . '-120000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-120000');
		}
		if ($zip -> locateName($wattpadcode . '-130000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-130000');
		}
		if ($zip -> locateName($wattpadcode . '-140000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-140000');
		}
		if ($zip -> locateName($wattpadcode . '-150000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-150000');
		}
		if ($zip -> locateName($wattpadcode . '-160000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-160000');
		}
		if ($zip -> locateName($wattpadcode . '-170000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-170000');
		}
		if ($zip -> locateName($wattpadcode . '-180000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-180000');
		}
		if ($zip -> locateName($wattpadcode . '-190000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-190000');
		}
		if ($zip -> locateName($wattpadcode . '-200000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-200000');
		}
		if ($zip -> locateName($wattpadcode . '-210000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-210000');
		}
		if ($zip -> locateName($wattpadcode . '-220000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-220000');
		}
		if ($zip -> locateName($wattpadcode . '-230000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-230000');
		}
		if ($zip -> locateName($wattpadcode . '-240000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-240000');
		}
		if ($zip -> locateName($wattpadcode . '-250000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-250000');
		}
		if ($zip -> locateName($wattpadcode . '-260000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-260000');
		}
		if ($zip -> locateName($wattpadcode . '-270000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-270000');
		}
		if ($zip -> locateName($wattpadcode . '-280000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-280000');
		}
		if ($zip -> locateName($wattpadcode . '-290000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-290000');
		}
		if ($zip -> locateName($wattpadcode . '-300000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-300000');
		}
		if ($zip -> locateName($wattpadcode . '-310000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-310000');
		}
		if ($zip -> locateName($wattpadcode . '-320000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-320000');
		}
		if ($zip -> locateName($wattpadcode . '-330000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-330000');
		}
		if ($zip -> locateName($wattpadcode . '-340000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-340000');
		}
		if ($zip -> locateName($wattpadcode . '-350000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-350000');
		}
		if ($zip -> locateName($wattpadcode . '-360000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-360000');
		}
		if ($zip -> locateName($wattpadcode . '-370000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-370000');
		}
		if ($zip -> locateName($wattpadcode . '-380000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-380000');
		}
		if ($zip -> locateName($wattpadcode . '-390000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-390000');
		}
		if ($zip -> locateName($wattpadcode . '-400000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-400000');
		}
		if ($zip -> locateName($wattpadcode . '-410000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-410000');
		}
		if ($zip -> locateName($wattpadcode . '-420000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-420000');
		}
		if ($zip -> locateName($wattpadcode . '-430000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-430000');
		}
		if ($zip -> locateName($wattpadcode . '-440000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-440000');
		}
		if ($zip -> locateName($wattpadcode . '-450000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-450000');
		}
		if ($zip -> locateName($wattpadcode . '-460000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-460000');
		}
		if ($zip -> locateName($wattpadcode . '-470000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-470000');
		}
		if ($zip -> locateName($wattpadcode . '-480000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-480000');
		}
		if ($zip -> locateName($wattpadcode . '-490000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-490000');
		}
		if ($zip -> locateName($wattpadcode . '-500000') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '-500000');
		}
		if ($zip -> locateName($wattpadcode . '.t') !== false) {
			$zip -> extractTo($dest, $wattpadcode . '.t');
		} 
		$zip -> close();
		unlink($file);
		return true;
	} else {
		return false;
	}
}

function doDownload($url, $dest, $filename) {
	if (!is_dir($dest) && !file_exists($dest)) {
		mkdir($dest, 0777, true);
	}
	$fp = fopen($dest . $filename, 'w+');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 50);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}

function getID($wattpadcode) {
	$chapter_url_data = doCurl("http://m.wattpad.com/go?id=" . $wattpadcode);

	if (strpos($chapter_url_data, 'gopart.php?id=') !== false) {

		preg_match("/gopart.php.id=([0-9]+)/", $chapter_url_data, $bookid);

		if (is_array($bookid) && isset($bookid[1])) {
			//good
			$bookid = $bookid[1];
			return $bookid;
		} else {
			return false;
		}
	} else {
		return "NOT_FOUND";
	} //end check chapter url

}
function doCurl($url){
	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($ch); 
		curl_close($ch);  
		// handle error; error output
		

		  return ($output);
		
 }
?>