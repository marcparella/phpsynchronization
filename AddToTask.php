<?

include 'common.php';
include 'database.php';

//establish a database connection to scoretrak
$dbname=getDatabase();
$tablename = "tblTasks";

//adjust time to Pacific Time
date_default_timezone_set("America/Los_Angeles");
$today = date("Y-m-d H:i:s");

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

$TasksID = explode("^", $_POST['TasksID']); 
$ReplicationID = explode("^", $_POST['ReplicationID']); 
$ContactID = explode("^", $_POST['ContactID']);
$ArtistsID = explode("^", $_POST['ArtistsID']);
$PersonnelID = explode("^", $_POST['PersonnelID']);
$TaskType = explode("^", $_POST['TaskType']);
$TaskDescription = explode("^", $_POST['TaskDescription']);
$DateAssigned = explode("^", $_POST['DateAssigned']);
$DateCompleted = explode("^", $_POST['DateCompleted']);
$Priority = explode("^", $_POST['Priority']);
$Status = explode("^", $_POST['Status']);
$TaskSource = explode("^", $_POST['TaskSource']);
$DateStamp = explode("^", $_POST['DateStamp']);
$ModifiedDateStamp = explode("^", $_POST['ModifiedDateStamp']);
$UserStamp = explode("^", $_POST['UserStamp']);
$ModifiedUserStamp = explode("^", $_POST['ModifiedUserStamp']);

$numofarray=count($ContactID);

for ($i = 0; $i < $numofarray; $i++) {
   $numofrows = returnNumberOfRecordsFromTasks($ReplicationID[$i], $tablename);
   if ($numofrows == 0){

//Set ReplicationID if ReplicationID is null or 0
   if($ReplicationID[$i]=='0' || $ReplicationID[$i] == Null){
  	 $uuid = uniqid(rand(), true);
     $ReplicationID[$i] =  substr($uuid, 0, 9);	
   }
   //Build an insert query 

   $sql = "INSERT INTO ".$tablename."(TasksID, ReplicationID, ContactID, ArtistsID, PersonnelID, TaskType, TaskDescription, DateAssigned, DateCompleted, Priority, Status, TaskSource, DateStamp, UserStamp, ModifiedDateStamp, ModifiedUserStamp, RemoteIPAddress) VALUES('$TasksID[$i]', '$ReplicationID[$i]', '$ContactID[$i]', '$ArtistsID[$i]', '$PersonnelID[$i]', '$TaskType[$i]', '$TaskDescription[$i]', '$DateAssigned[$i]', '$DateCompleted[$i]', '$Priority[$i]', '$Status[$i]', '$TaskSource[$i]', '$DateStamp[$i]', '$UserStamp[$i]', '$ModifiedDateStamp[$i]', '$ModifiedUserStamp[$i]', '$REMOTE_ADDR')";

} else {

   $sql = "Update ".$tablename." Set TasksID='$TasksID[$i]', ReplicationID='$ReplicationID[$i]', ContactID = '$ContactID[$i]', ArtistsID = '$ArtistsID[$i]', PersonnelID = '$PersonnelID[$i]', TaskType = '$TaskType[$i]', TaskDescription = '$TaskDescription[$i]', DateAssigned = '$DateAssigned[$i]', DateCompleted = '$DateCompleted[$i]', Priority = '$Priority[$i]', Status = '$Status[$i]', TaskSource = '$TaskSource[$i]', ModifiedDateStamp='$ModifiedDateStamp[$i]',  ModifiedUserStamp = '$UserStamp[$i]', RemoteIPAddress = '$REMOTE_ADDR' WHERE ReplicationID='$ReplicationID[$i]' and ContactID='$ContactID[$i]' and ArtistsID='$ArtistsID[$i]' and DateAssigned='$DateAssigned[$i]'";
}

//process query
$result = @mysql_query($sql, $connection);
}

if ($i == 1){
echo "Success: ".$i." task was sent to the server.";
} else {
echo "Success: ".$i." tasks were sent to the server.";
}

?>











