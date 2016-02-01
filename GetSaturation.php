<?
include 'common.php';
include 'database.php';

//establish a database connection to scoretrak
$dbname=getDatabase();

//adjust time to Pacific Time
date_default_timezone_set("America/Los_Angeles");

$today = date("Y-m-d H:i:s");
$tablename= $_GET['tablename'];
$selectlastdateonly = $_GET['SelectLastDateOnly'];
$contactid = $_GET['ContactID'];
$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

if ($tablename == 'tblNotes' && $selectlastdateonly == 'True'){
	$sql = "Select Max(DateModified) as maxofdatemodified From $tablename where ContactID = '$contactid'";
	$result = @mysql_query($sql, $connection) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
       if (is_null($row['maxofdatemodified'])){
          echo 'Null';
       } else {
          echo $row['maxofdatemodified'];
       }
	}
return;
}

if ($tablename == 'tblNotes' && $selectlastdateonly == 'False'){
   $sql = "Select ReplicationID, Notes, DateModified, UserName, ArtistID from $tablename where ContactID = '$contactid'  
           Order by DateModified DESC";	
}

if ($tablename == 'tblTasks'){
   $sql = "Select T.Status, T.ReplicationID, T.TaskType, T.TaskDescription, T.DateAssigned, T.DateCompleted, T.ArtistsID, T.UserStamp, T.Priority
   		   From $tablename as T  
		   Where T.ContactID = '$contactid' and T.DateAssigned > Date_Sub(CurDate(), INTERVAL 180 Day) and T.Status <> 4
		   Order by T.Status, T.Priority DESC, T.DateAssigned DESC";	
}

$result = @mysql_query($sql, $connection) or die(mysql_error());
// We find the fields number

$numofrows = mysql_num_rows($result);
if ($numofrows != 0){
  $numfields=mysql_num_fields($result);
  echo ("numofrecords=".$numofrows."\n");
 // Now we put the names of fields in a Array
 for($i=0;$i<$numfields;$i++){
     $fieldname[$i]=mysql_field_name($result, $i);
 }

 while($row=mysql_fetch_object($result)){
    //Finally we assign the new variables
    for($i=0;$i<$numfields;$i++){
      $$fieldname[$i]=$row->$fieldname[$i];
      echo $fieldname[$i]."=".$$fieldname[$i]."\n";
    }
    echo "|\n"; //show pipe charcter at end of each record
 }
    echo "End of File";
} else {
	echo "No Records";
}
?>
