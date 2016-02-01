<?
//read through tutti/build directory and return files attributes

$dir = "/home/pricerub/public_html/apps/tutti/build/";
$retarray = array();

// Open a known directory, and proceed to read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            $stat = stat($dir . $file);
			array_push($retarray, array($file, $stat['size'], $stat['mtime']));  
			//echo "filename: $file : filetype: " . filetype($dir . $file).
			//' Size time: ' . $stat['size']. ' Modified Date: ' . date('Y-m-d H:i:s', $stat['mtime']). "<br>";
        }
        closedir($dh);
    }
}
$numofarray=count($retarray);
for ($i=0; $i<$numofarray; $i++){
	echo($retarray[$i][0]."<br>");
	echo($retarray[$i][1]."<br>");
	//echo($retarray[$i][2]."<br>");
	echo(date('Y-m-d H:i:s', $retarray[$i][2])."<br>");
}
?>
