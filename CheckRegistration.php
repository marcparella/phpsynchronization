<?

include 'database.php';

//checks to see if registration exists on the Tutti database
$dbname=getDatabase();

$tablename = "tblRegistration";
$serialnumber = $_GET[serialnumber];

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

//Build an insert query 
$sql = "Select * from " . $tablename . " where serialnumber=$serialnumber";

$result = @mysql_query($sql, $connection) or die(mysql_error());
while($row = mysql_fetch_array($result))

{
//If copy has been purchased, fulllicense field must be set to 1
  if ($row['fulllicense']==1) 
    {
    $response = "Not Yet Registered";
    }
  elseif ($row['fulllicense']==0)  
    {
    $response = "Demo Version";
    }
  else  
    {
    $response = "Deny Access";
    }
}
echo $response;
?>
