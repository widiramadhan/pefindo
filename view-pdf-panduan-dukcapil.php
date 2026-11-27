<?php
require_once("config/connection.php");
// fetch PDF binary from DB


$file = 'assets/pdf/MODUL_PENGECEKAN_DUKCAPIL_.pdf';

if (file_exists($file)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="MODUL_PENGECEKAN_DUKCAPIL_.pdf"');
    readfile($file);
    exit;
} else {
    echo "File not found.";
}
?>
