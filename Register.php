<?
//Writes User Account Information from the Tutti Registration Form to Server DB
include 'database.php';
$dbname=getDatabase();
$tablename = "tblRegistration";
$today = date("Y-m-d");
$name = $_GET[name];
$address1 = $_GET[address1];
$address2 = $_GET[address2];
$city = $_GET[city];
$state = $_GET[state];
$country = $_GET[country];
$postalcode = $_GET[postalcode];
$email = $_GET[email];
$telephone = $_GET[telephone];
$serialnumber = $_GET[serialnumber];


$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

//Build an insert query 
$sql = "Update $tablename Set name = '$name', address1 = '$address1', address2 = '$address2', city = '$city',  state = '$state', country = '$country', postalcode = '$postalcode', email = '$email', telephone = '$telephone', dateregistered = '$today' where serialnumber = $serialnumber";

$result = @mysql_query($sql, $connection) or die(mysql_error());

//Add Access Key to email:
//Build an insert query 
$sql = "SELECT accesskey FROM " . $tablename . " where serialnumber = $serialnumber"; 

$result = @mysql_query($sql, $connection) or die(mysql_error());
while($row = mysql_fetch_array($result))
$accesskey = $row['accesskey'];

mail('marcparella@yahoo.com', 'Tutti registration:'.$serialnumber, $name .
' registered on ' .$today . ' serial number=' . $serialnumber . ' - Access Key='.$accesskey);
echo "Registration OK";
?>
