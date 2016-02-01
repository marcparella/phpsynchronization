<?
include 'common.php';
include 'database.php';

//establish a database connection to scoretrak
$dbname=getDatabase();

//adjust time to Pacific Time
date_default_timezone_set("America/Los_Angeles");

$today = date("Y-m-d H:i:s");
$tablename= $_GET['tablename'];
$modifieddatestamp = $_GET['ModifiedDateStamp'];
$serialnumber = $_GET['SerialNumber'];
$username = $_GET['UserName'];
$artistsinitialsarray = explode(",", $_GET['ArtistInitials']);

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

//Build select query
if ($tablename == 'tblArtists') {
    $sql = "SELECT tblArtists.* 
			FROM tblArtists
			INNER JOIN tblArtistMarketer_Assoc ON tblArtists.ArtistsID = tblArtistMarketer_Assoc.ArtistsID
			INNER JOIN tblMarketers ON tblArtistMarketer_Assoc.MarketerID = tblMarketers.ID
			Where tblMarketers.Serialnumber = $serialnumber";
} elseif ($tablename == 'tblDeleteRequests') {
	$sql = "SELECT tblDeleteRequests.*
			FROM tblDeleteRequests
			Where ApprovedDate > '$modifieddatestamp'
			And Not Exists (Select ContactID from tblOrganization_Listings where ContactID = tblDeleteRequests.ReplicationID)
			And Not Exists ( Select ContactID from tblPersonnel where ReplicationID = tblDeleteRequests.ReplicationID)";
} elseif ($tablename == 'tblNotes') {
    $sql = "SELECT Distinct tblNotes.* 
			FROM tblNotes
			INNER JOIN tblArtists ON tblNotes.ArtistID = tblArtists.Initials
			INNER JOIN tblArtistMarketer_Assoc ON tblArtists.ArtistsID = tblArtistMarketer_Assoc.ArtistsID
			INNER JOIN tblMarketers ON tblArtistMarketer_Assoc.MarketerID = tblMarketers.ID
			WHERE DateModified > '$modifieddatestamp' AND tblMarketers.serialnumber ='$serialnumber'
			AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID = 			 	
			$tablename.ContactID)
			AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID = 	               	
			$tablename.ReplicationID)";	
			
			foreach($artistsinitialsarray as $initialvalue){
				$sql .= "OR
				tblNotes.ArtistID = '$initialvalue'
				AND tblMarketers.serialnumber = $serialnumber
				AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID = 	
					$tablename.ContactID)
				AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID = 
					$tablename.ReplicationID)";
			}
	$sql .= " Order by DateModified DESC ";	
	$sql .= " Limit 0,12500";

			unset($value);
} elseif ($tablename == 'tblTasks') {
    $sql = "SELECT Distinct tblTasks.* 
			FROM tblTasks
			INNER JOIN tblArtists ON tblTasks.ArtistsID = tblArtists.Initials
			INNER JOIN tblArtistMarketer_Assoc ON tblArtists.ArtistsID = tblArtistMarketer_Assoc.ArtistsID
			INNER JOIN tblMarketers ON tblArtistMarketer_Assoc.MarketerID = tblMarketers.ID
			WHERE ModifiedDateStamp > '$modifieddatestamp' AND tblMarketers.serialnumber ='$serialnumber'
			And tblTasks.Status = '1'
		    AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID =  
			$tablename.ContactID)
			AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID = 	               	
			$tablename.ReplicationID) ";
	
	        if (getUserManagementRole($username) > 0) { //return only high-priority tasks to managers 
				$sql .= " And $tablename.priority = '2' Or $tablename.priority > '0' 
						  and $tablename.modifieduserstamp = '$username' ";
			}
			
			//Be Sure to bring over any completed tasks
			//" OR ModifiedDateStamp > '$modifieddatestamp' and tblTasks.Status = 3";
					   
			foreach($artistsinitialsarray as $initialvalue){
				$sql .=
				" OR
				tblTasks.ArtistsID = '$initialvalue'
				AND tblMarketers.serialnumber = $serialnumber "; 
				//added 2/8/2012  Bring over only uncompleted tasks
				$sql .= "AND tblTasks.Status = '1'
				AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID = 
					$tablename.ContactID)
				AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID = 		
					$tablename.ReplicationID)";
			}
			unset($value);
	
} elseif ($tablename == 'tblPersonnel') {
	$sql = "Select * from $tablename where ModifiedDateStamp > '$modifieddatestamp'
	        AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID = 	               	
			$tablename.ReplicationID)
		    AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID = 	               	
			$tablename.ContactID)";	
			
} elseif ($tablename == 'tblTags' || $tablename == 'tblOrgTagAssoc') {
	$sql = "Select * from $tablename";
	
} else {
	//retrieve new organization listings and personnel records
	$sql = "Select * from $tablename where ModifiedDateStamp > '$modifieddatestamp'
	       AND Not Exists (Select ContactID from tblDeleteRequests where tblDeleteRequests.ReplicationID =              
	       $tablename.ContactID)";	
}

//Process the Query
$result = @mysql_query($sql, $connection) or die(mysql_error());
// We find the fields number
$numofrows = mysql_num_rows($result);
if ($numofrows != 0){
  $numfields=mysql_num_fields($result);
  echo ("numofrecords=".$numofrows."^\n");  //add ^ character for new version "^\n"
 // Now we put the names of fields in a Array
 for($i=0;$i<$numfields;$i++){
     $fieldname[$i]=mysql_field_name($result, $i);
 }

 while($row=mysql_fetch_object($result)){
    //Finally we assign the new variables
    for($i=0;$i<$numfields;$i++){
        $$fieldname[$i]=$row->$fieldname[$i];
    	echo $fieldname[$i]."=".$$fieldname[$i]."^\n"; //add ^ character for new version "^\n"
    }
    echo "|\n"; //show pipe charcter at end of each record
 }
    echo "End of File";
} else {
	echo "No Records";
}
?>
