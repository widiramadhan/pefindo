<?php
//DEVELOPMENT
/*$config_serverName = '172.16.0.233\SFI_DWH_INSTANCE';
$config_db = 'H2H_PEFINDO';
$config_uid = 'sa';
$config_pwd = 'user.100';*/

//UAT
/*$config_serverName = '172.16.1.172';
$config_db = 'H2H_PEFINDO';
$config_uid = 'sa';
$config_pwd = 'P@ssw0rd';*/

//PRODUCTION
/*$config_serverName = '172.22.0.29\DBCORE_INSTANCE';
$config_db = 'MFIN_PATCH';
$config_uid = 'iman.santoso';
$config_pwd = 'user.123';*/

$config_serverName = '172.22.0.27';
$config_db = 'H2H_PEFINDO';
$config_uid = 'UserPefindo';
$config_pwd = 'user.1123';


$connectionInfo = array( "Database"=>$config_db, "UID"=>$config_uid, "PWD"=>$config_pwd );

$conn = sqlsrv_connect($config_serverName, $connectionInfo);

/* TEST CONNECTION */

 /*if( $conn ) {
      echo "<script>alert('Connection Success.')</script>";
 }else{
      echo "<script>alert('Connection Fail.')</script>";
      die( print_r( sqlsrv_errors(), true));
 }*/
 
?> 

