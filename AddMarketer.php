<?

include 'database.php';

//Insert a new marketer record into tblMarketer when user registers
//Only Internal Version

//establish a database connection to scoretrak
$dbname=getDatabase();
$tablename = "tblMarketers";

//adjust time to Pacific Time
date_default_timezone_set("America/Los_Angeles");
$today = date("Y-m-d H:i:s");

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

$Name = $_POST['Name'];
$SerialNumber = $_POST['SerialNumber'];

//Build an insert query 
$sql = "INSERT INTO ".$tablename."(Name, SerialNumber, Active, DateRegistered) VALUES('$Name', '$SerialNumber', '1', '$today')";

//process query
$result = @mysql_query($sql, $connection);
echo "Success";

?>
