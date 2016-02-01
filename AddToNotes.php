<?
include 'common.php';
include 'database.php';
//establish a database connection to scoretrak
$dbname=getDatabase();
$tablename = "tblNotes";

//adjust time to Pacific Time
date_default_timezone_set("America/Los_Angeles");

//Build datetime string from adjustedtime
$today = date("Y-m-d H:i:s");

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

$ContactID = explode("^", $_POST['ContactID']);
$ArtistID = explode("^", $_POST['ArtistID']);
$ReplicationID = explode("^", $_POST['ReplicationID']);
$Notes = explode("^", $_POST['Notes']);
$DateCreated = explode("^", $_POST['DateCreated']);
$DateModified = explode("^", $_POST['DateModified']);
$UserName = explode("^", $_POST['UserName']);
$numofarray=count($ContactID);

for ($i = 0; $i < $numofarray; $i++) {

//Set ReplicationID if ReplicationID is null or 0
if	($ReplicationID[$i]=='0' || $ReplicationID[$i] == Null){
	$uuid = uniqid(rand(), true);
	$ReplicationID[$i] =  substr($uuid, 0, 9);	
}

$sql = "INSERT INTO ".$tablename."(ContactID, ArtistID, ReplicationID, Notes, DateCreated, DateModified, UserName, RemoteIPAddress) VALUES('$ContactID[$i]', '$ArtistID[$i]', '$ReplicationID[$i]', '$Notes[$i]', '$DateCreated[$i]', '$DateModified[$i]', '$UserName[$i]', '$REMOTE_ADDR')";

//process query
$result = @mysql_query($sql, $connection);

}
if ($i == 1){
  echo $i." record was sent to the server.";
} else {
  echo $i." records were sent to the server.";
}
?>





