<?php

	include_once("CreateZipFile.inc.php");
	$wattcode=$_POST['wattcode'];
	$bookid = getID($wattcode);
		if($bookid =="NOT_FOUND"){
			$bookid = getID($wattcode);
		}
	$accesscode = $_POST['accesscode'];
	$chapters = json_decode($_POST['chapters'],true);
	$builds = "./". $accesscode . "/builds/" . $bookid . "/";
	$build_folder = "./". $accesscode . "/builds/";
	$root_folder = "./wat/" . $accesscode  . "/builds/";
	 if(!file_exists($build_folder . "packages/")){
		mkdir($build_folder . "packages/",0777,true);
	 }
	if(file_exists($builds)){
	$contents = "";
		foreach($chapters as $index=>$chapter){
			if(file_exists($builds.$chapter.".txt")){
				$contents .= file_get_contents($builds . $chapter . ".txt");
				rename($builds . $chapter . ".txt", $builds . $index . ".txt");
			} else if(file_exists($builds.$index.".txt")){
				$contents .= file_get_contents($builds . $index . ".txt");
			} else {
				echo "ONE_FILE_NOT_FOUND:" . $chapter;
				exit();
			}
		}
		file_put_contents($build_folder . "FULL_STORY_" .$bookid.".txt",$contents);
		
		$files_to_zip = glob($builds . "/*.*");
		array_push($files_to_zip,$build_folder . "FULL_STORY_" .$bookid.".txt");
		$zipped =  zipped($files_to_zip,$build_folder . "packages/",$bookid);
		//cyborg\wat\jasper\builds\packages
		$packages = "./cyborg/wat/jasper/builds/packages/";
		$build_text = "./cyborg/wat/jasper/builds/";
		

		$zip_package =  $packages . $zipped;
		$txt_package =  $build_text . "FULL_STORY_" .$bookid.".txt";
		$pack['zip'] = $zip_package;
		$pack['txt'] = $txt_package;
		$pack['bookid'] = $bookid;
		
		saveDownload($wattcode,$bookid,$zip_package,$txt_package);
		echo json_encode($pack);
	} else {
		echo "BUILDS_NOT_FOUND";
		print_r($_POST);
	}
	

	function zipped($files,$destination,$filename){
		global $root_folder;
		$createZipFile=new CreateZipFile;
		$rand=md5(microtime().rand(0,999999));
		$zipName=$destination.$rand ."_". $filename . "_FULLPACKAGED.zip";
		
		foreach($files as $file){
			$fileContents=file_get_contents($file);
			$createZipFile->addFile($fileContents, basename($file));
		}	
		$fd=fopen($zipName, "wb");
		$out=fwrite($fd,$createZipFile->getZippedfile());
		fclose($fd);
		return  basename($zipName);
		
		
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
 
 function saveDownload($wattcode,$bookid,$zip_package,$txt_package){
	mysql_connect("localhost","root","jasper90") or die(mysql_error());
	mysql_select_db("w2a");
	$sql="SELECT * FROM `downloads` WHERE bookid='$bookid'";
	$query = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($query) == 1) {
		//duplicate, update 
		$sql = "UPDATE `downloads` SET zip='$zip_package', txt='$txt_package' WHERE bookid='$bookid'";
		mysql_query($sql) or die(mysql_error());
		return true;
	} else {
		//no results/duplicates found
		//no duplicates means, we need to insert
		$sql="INSERT INTO `downloads` (`wattcode`,`bookid`,`zip`,`txt`) VALUES('$wattcode','$bookid','$zip_package','$txt_package')";
		mysql_query($sql) or die(mysql_error());
		return true;
	}
 }
	
	?>