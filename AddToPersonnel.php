<?
include 'common.php';
include 'database.php';

//establish a database connection to scoretrak
$dbname=getDatabase();
$tablename = "tblPersonnel";

//adjust time to Pacific Time
date_default_timezone_set("America/Los_Angeles");
//$adjustedtime = getdate(time()-25200);

//Build datetime string from adjustedtime
//$today = $adjustedtime['year']."-".$adjustedtime['mon']."-".$adjustedtime['mday']." ".$adjustedtime['hours'].":".$adjustedtime['minutes'].":". $adjustedtime['seconds'];

$today = date("Y-m-d H:i:s");

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

$ReplicationID = explode("^", $_POST['ReplicationID']);
$ContactID = explode("^", $_POST['ContactID']);
$Name = explode("^", $_POST['Name']);
$Title = explode("^", $_POST['Title']);
$Email = explode("^", $_POST['Email']);
$Phone1 = explode("^", $_POST['Phone1']);
$Phone2 = explode("^", $_POST['Phone2']);
$Cell = explode("^", $_POST['Cell']);
$Fax = explode("^", $_POST['Fax']);
$Notes = explode("^", $_POST['Notes']);
$UserStamp = explode("^", $_POST['UserStamp']);
$numofarray=count($ReplicationID);

for ($i = 0; $i < $numofarray; $i++) {
$numofrows = returnNumberOfRecordsFromPersonnel($ReplicationID[$i], $tablename);

if ($numofrows == 0){

//Set ReplicationID if ReplicationID is null or 0
if	($ReplicationID[$i]=='0' || $ReplicationID[$i] == Null){
	$uuid = uniqid(rand(), true);
	$ReplicationID[$i] =  substr($uuid, 0, 9);	
}

//Build an insert query 
$sql = "INSERT INTO ".$tablename."(ReplicationID, ContactID, Name, Title, Email, Phone1, Phone2, Cell, Fax, Notes, DateStamp, ModifiedDateStamp, UserStamp, RemoteIPAddress) VALUES('$ReplicationID[$i]', '$ContactID[$i]', '$Name[$i]', '$Title[$i]', '$Email[$i]', '$Phone1[$i]', '$Phone2[$i]', '$Cell[$i]', '$Fax[$i]', '$Notes[$i]', '$today', '$today', '$UserStamp[$i]', '$REMOTE_ADDR')";

} else {

$sql = "Update ".$tablename." Set ReplicationID='$ReplicationID[$i]', ContactID = '$ContactID[$i]', Name = '$Name[$i]', Title = '$Title[$i]', Email = '$Email[$i]', Phone1 = '$Phone1[$i]', Phone2 = '$Phone2[$i]', Cell = '$Cell[$i]', Fax = '$Fax[$i]', Notes = '$Notes[$i]', ModifiedDateStamp = '$today', UserStamp = '$UserStamp[$i]', RemoteIPAddress = '$REMOTE_ADDR' 
WHERE ReplicationID='$ReplicationID[$i]'";
}

//process query
$result = @mysql_query($sql, $connection);
}

if ($i == 1){
  echo $i." record was sent to the server.";
} else {
  echo $i." records were sent to the server.";
}

?>





