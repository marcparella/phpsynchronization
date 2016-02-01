<?
include 'database.php';

//set fulllicense to 1 (true) when client successfully enters accesskey
//and activates license.

$dbname = getDatabase();
$tablename = "tblRegistration";

$serialnumber = $_GET[serialnumber];
$prp = $_GET[prp];

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

//Add Flag to Registration Table indicating that user is full license user
$sql = "Update $tablename Set fulllicense = 1 where serialnumber = $serialnumber";
$result = @mysql_query($sql, $connection) or die(mysql_error());

$tablename = "tblMarketers";
//Update the serial number in the tblMarketers table 

if ($prp == '1'){
	$sql = "Update $tablename Set active = '1' where serialnumber = $serialnumber";
	$result = @mysql_query($sql, $connection) or die(mysql_error());
}
echo "Update OK";
?>
