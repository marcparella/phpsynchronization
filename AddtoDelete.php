<?
include 'common.php';
include 'database.php';

//establish a database connection to scoretrak
$dbname=getDatabase();
$tablename = "tblDeleteRequests";

//adjust time to Pacific Time
date_default_timezone_set("America/Los_Angeles");
//$adjustedtime = getdate(time()-25200);

$today = date("Y-m-d H:i:s");

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

$tablename = explode("^", $_POST['TableName']);
$replicationid = explode("^", $_POST['ReplicationID']);
$userstamp = explode("^", $_POST['UserStamp']);
$numofarray=count($replicationid);


for ($i = 0; $i < $numofarray; $i++) {

//Build an insert query 
$sql = "INSERT INTO tblDeleteRequests (TableName, ReplicationID, UserStamp, DateStamp, RemoteIPAddress) VALUES('$tablename[$i]', $replicationid[$i], '$userstamp[$i]', '$today', '$REMOTE_ADDR')";

//process query
$result = @mysql_query($sql, $connection);

}

if ($i == 1){
  echo $i." delete record request was sent to the server.";
} else {
  echo $i." delete record requests were sent to the server.";
}

?>
