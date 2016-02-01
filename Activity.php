<?
function addActivity($SerialNumber, $UserName, $Activity, $ArtistID, $OrgID){
include 'database.php';
include 'common.php';
//establish a database connection to scoretrak
$dbname=getDatabase();
$tablename = "tblActivity";

//adjust time to Pacific Time
date_default_timezone_set("America/Los_Angeles");
$today = date("Y-m-d H:i:s");

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

//get marketerid from tblMarketers
$MarketerID = getMarketerID($UserName, $SerialNumber); 
	
//Build an insert query 
$sql = "INSERT INTO $tablename(MarketerID, OrgID, ArtistID, Activity, TimeStamp, RemoteIPAddress) VALUES('$MarketerID', '$OrgID', '$ArtistID', '$Activity', '$today', '$REMOTE_ADDR')";

//process query
$result = @mysql_query($sql, $connection);
}
/*
function getMarketerID($name, $serialnumber){
	$dbname=getDatabase();
	$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") or die(mysql_error());
	$db = @mysql_select_db($dbname, $connection) or die(mysql_error());
    $tablename = "tblMarketers"; 
	
	$sql = "Select ID from $tablename where SerialNumber='$serialnumber'";
	$result = @mysql_query($sql, $connection) or die(mysql_error());
    while($row = mysql_fetch_array($result)){
	   $marketerID = $row['ID'];;
	}
	return $marketerID;
}
*/
?>
