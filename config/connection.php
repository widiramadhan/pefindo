<?php
/*$config_serverName = '172.16.0.233\SFI_DWH_INSTANCE';
$config_db = 'H2H_PEFINDO';
$config_uid = 'sa';
$config_pwd = 'user.100';*/

$config_serverName = '172.16.1.172';
$config_db = 'H2H_PEFINDO';
$config_uid = 'sa';
$config_pwd = 'P@ssw0rd';


$connectionInfo = array( "Database"=>$config_db, "UID"=>$config_uid, "PWD"=>$config_pwd );

$conn = sqlsrv_connect($config_serverName, $connectionInfo);

/* TEST CONNECTION */
/*
 if( $conn ) {
      echo "<script>alert('Connection Success.')</script>";
 }else{
      echo "<script>alert('Connection Fail.')</script>";
      die( print_r( sqlsrv_errors(), true));
 }
 */
?> 

