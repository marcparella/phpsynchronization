<?

//Return the current data and time
function returnServerDateTime(){
date_default_timezone_set("America/Los_Angeles");
$today = date("Y-m-d H:i:s ");	
echo $today;
}

//This PHP function returns an advanced date when a number of days to advance is //passed in. 
function dateadd($numberofdays){

$date = date("mdY");
$day = substr($date, 2, 2);
$month = substr($date, 0, 2);
$year = substr($date, 4, 4);
$addday = $numberofdays;

$newday = date("Y-m-d", mktime(0, 0, 0, $month, $day + $addday, $year));
return $newday;
}

function datesubtract($array, $numberofdays){

$day = $array[2];
$month = $array[1];
$year = $array[0];
$subtract = $numberofdays;

$newday = date("Y-m-d", mktime(0, 0, 0, $month, $day - $subtract, $year));
return $newday;
}

//This PHP function formats a date and is used in the task table
function formatdate($datestring)
{
return date('m-d-Y',strtotime($datestring));
}

function formatdate2($datestring)
{
$parsedate=substr($datestring,0,3);
$parsedate .= " ";
$parsedate .= substr($datestring,4,2);
$parsedate .= " ";
$parsedate .= substr($datestring,7,4);

$newdate = date('Y-m-d',strtotime($parsedate));
return $newdate;
}

function formatdate3($array)
{

   $day = $array[1];
   $month = $array[0];
   $year = $array[2];

   $newDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
   return $newDate;
}

function formattime($time){
   $hour = substr($time,0,2);
   $minute = substr($time, 4, 2);
   $newtime = date("h:i", mktime($hour, $minute, 0, 7, 1, 2009));
   if ($hour == 0 && $minute == 0){
      return null;
   }
   else {
      if ($hour < 12) { 
         $meridian = "AM";
      }
      else {
         $meridian = "PM"; 
      } 
      return $newtime . " " . $meridian;
   }
}

function checkCookie($cookiename){
//be sure cookie exists before submitting form

if (isset($_COOKIE[$cookiename]))
  return true;
else
 return false;
}

function returnfilename($file){
//strip off relative path and return just the file name
    $pos = strrpos($file, "/");
    $newstring = substr($file, $pos+1);
    return $newstring;
}

function uuid()
//Return a unique long integer used for id fields
{
    // version 4 UUID
    return sprintf(
        '%08x-%04x-%04x-%02x%02x-%012x',
        mt_rand(),
        mt_rand(0, 65535),
        bindec(substr_replace(
            sprintf('%016b', mt_rand(0, 65535)), '0100', 11, 4)
        ),
        bindec(substr_replace(sprintf('%08b', mt_rand(0, 255)), '01', 5, 2)),
        mt_rand(0, 255),
        mt_rand()
    );
}
//Returns 1 if record already exists in DB
function returnNumberOfRecordsFromOrgs($id, $tablename){
	$dbname=getDatabase();
	$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") or die(mysql_error());
	$db = @mysql_select_db($dbname, $connection) or die(mysql_error());
	//Determine if record exists if yes update, if no insert. 
    $sql = "Select ContactID from $tablename where ContactID=".$id;
    $result = @mysql_query($sql, $connection) or die(mysql_error());
    $numofrows = mysql_num_rows($result);
	return $numofrows;
}

function returnNumberOfRecordsFromTasks($replicationid, $tablename){
	$dbname=getDatabase();
	$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") or die(mysql_error());
	$db = @mysql_select_db($dbname, $connection) or die(mysql_error());
	
	if ($replicationid == Null){ 
        $replicationid = 0; }
	
    //Determine if record exists if yes update, if no insert.  
    $sql = "Select TasksID from $tablename where ReplicationID=$replicationid";
	$result = @mysql_query($sql, $connection) or die(mysql_error());
    $numofrows = mysql_num_rows($result);
    return $numofrows;
}

function returnNumberOfRecordsFromPersonnel($replicationid, $tablename){
	$dbname=getDatabase();
	$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") or die(mysql_error());
	$db = @mysql_select_db($dbname, $connection) or die(mysql_error());
	//Determine if record exists if yes update, if no insert.  
    
	if ($replicationid == ""){
		return 0;
	}
	
	$sql = "Select ReplicationID from $tablename where ReplicationID=$replicationid";
	$result = @mysql_query($sql, $connection) or die(mysql_error());
    $numofrows = mysql_num_rows($result);
    return $numofrows;
}

function getMarketerID($name, $serialnumber){
	$dbname=getDatabase();
	$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") or die(mysql_error());
	$db = @mysql_select_db($dbname, $connection) or die(mysql_error());
    $tablename = "tblMarketers"; 
	
	$sql = "Select ID from $tablename where Name='$name' and SerialNumber='$serialnumber'";
	$result = @mysql_query($sql, $connection) or die(mysql_error());
    $marketerID = mysql_num_rows($result);
    return $marketerID;
}

function getUserManagementRole($username){
	//returns Management Role Value
	$dbname=getDatabase();
	$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") or die(mysql_error());
	$db = @mysql_select_db($dbname, $connection) or die(mysql_error());
    $tablename = "tblMarketers"; 
	
	$sql = "Select Management from $tablename where Name='$username'";
	$result = @mysql_query($sql, $connection) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$management = $row['Management'];
	}
    return $management;
}
?>
