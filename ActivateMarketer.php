<?

include 'database.php';

//Updates tblMarketer on the Tutti Server
//Sets Active Field to 1

$dbname=getDatabase();
$tablename = "tblMarketers";
$today = date("Y-m-d");

$serialnumber = $_POST[serialnumber];

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

//Build an update query 
$sql = "Update $tablename Set Active = '1' where SerialNumber = '$serialnumber'"; 
$result = @mysql_query($sql, $connection) or die(mysql_error());

if (mysql_errno()){
	echo "failed";
} else {
    echo "success";
}

?>
