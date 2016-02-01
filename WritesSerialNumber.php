<?
//Executes when user downloads copy of Tutti from Server
//Creates a new unused registration record and populates
//unique serial number and access key
//Values are written back to client via obtainserialnumber.php

include 'database.php';

$dbname = getDatabase();
$tablename = "tblRegistration";

$connection = mysql_connect("localhost", "pricerub_priceru", "prp95") 
or die(mysql_error());

$db = @mysql_select_db($dbname, $connection)
or die(mysql_error());

$serial = rand();
$access = rand(0,9).chr(rand(97,122)).chr(rand(97,122)).rand(0,9);
echo $access;

//Write Generated Serial Number to Server DB 
$sql = "Insert Into $tablename (serialnumber, accesskey) Values ('$serial', '$access')"; 
$result = @mysql_query($sql, $connection) or die(mysql_error());
?>
