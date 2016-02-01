<?
include 'database.php';
//establish a database connection to scoretrak

$dbname=getDatabase();
$serialnumber = $_GET['SerialNumber'];

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

$sql = "Select Active from tblMarketers where SerialNumber = $serialnumber";	

$result = @mysql_query($sql, $connection) or die(mysql_error());
// We find the fields number

while($row = mysql_fetch_array($result)){
   $response = $row['Active'];
}
if ($response == ''){
	echo "0";
} else {
	echo $response;
}
?>



