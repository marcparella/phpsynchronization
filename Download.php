<?

include 'database.php';

//Creates a unique serial number and inserts into tblRegistration
//Redirects user to download zip file (to be deprecated)

$dbname = getDatabase();
$tablename = "tblRegistration";

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

$serial = rand();

$access = rand(0,9).chr(rand(97,122)).chr(rand(97,122)).rand(0,9);
echo $access;
//Build an insert query 
$sql = "Insert Into $tablename (serialnumber, accesskey) Values ('$serial', '$access')"; 

$result = @mysql_query($sql, $connection) or die(mysql_error());

//open zip file
header("Location: http://www.pricerubin.com/apps/tutti/installation/tutti.zip");

?>
