<?
include 'database.php';

//returns serial number and access key to Tutti
//called during registration process

$dbname = getDatabase();
$tablename = "tblRegistration";

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

$serialnumber = $_GET[serialnumber];

//Build an insert query 
$sql = "SELECT accesskey FROM `registration` where serialnumber = $serialnumber"; 

$result = @mysql_query($sql, $connection) or die(mysql_error());
while($row = mysql_fetch_array($result))
$response = $row['accesskey'];

echo $response;
?>


