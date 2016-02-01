<?
//query tblNotes and return the latest DateTime Stamp for the ArtistID (initials) provided

include 'database.php';

$tablename = $_GET['tablename'];
$username = $_GET['UserName'];
$serialnumber = $_GET['SerialNumber'];
$dbname=getDatabase();
$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

//Build an insert query 
if ($tablename == "tblNotes"){
	//$sql = "Select Max(DateModified) as maxofdatemodified from ".$tablename." where UserName='$username'";
	$sql = "SELECT Max(DateModified) as maxofdatemodified FROM `tblNotes` 
		    Inner Join tblArtists on tblNotes.ArtistID = tblArtists.Initials
			Inner Join tblArtistMarketer_Assoc on tblArtistMarketer_Assoc.ArtistsID = tblArtists.ArtistsID
			Inner Join tblMarketers on tblMarketers.ID = tblArtistMarketer_Assoc.MarketerID
			Where tblMarketers.SerialNumber = '$serialnumber'";
} elseif ($tablename == "tblTasks") {
    //$sql = "Select Max(ModifiedDateStamp) as maxofdatemodified from ".$tablename." where UserStamp ='$username'";    
	$sql = "SELECT Max(ModifiedDateStamp) as maxofdatemodified FROM `tblTasks` 
	        Inner Join tblArtists on tblTasks.ArtistsID = tblArtists.Initials
			Inner Join tblArtistMarketer_Assoc on tblArtistMarketer_Assoc.ArtistsID = tblArtists.ArtistsID
			Inner Join tblMarketers on tblMarketers.ID = tblArtistMarketer_Assoc.MarketerID
		    Where tblMarketers.SerialNumber = '$serialnumber'";
} else {
    $sql = "Select Max(ModifiedDateStamp) as maxofdatemodified from ".$tablename; 
} 

//Process the Query
$result = @mysql_query($sql, $connection) or die(mysql_error());

while($row = mysql_fetch_array($result))
{
	if (is_null($row['maxofdatemodified']) == true){
		echo "01-01-2001 00:00:00";
	} else {
		echo $row['maxofdatemodified'];
	}
}
?>
