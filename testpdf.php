<?php
require_once("config/configuration.php");
require_once("config/connection.php");
require_once __DIR__ . '/vendor/autoload.php';
 $user = $_GET['USERNAME']; 
 $order = $_GET['order'];
 
 $call = "{call SP_GET_DATA_ORDER_PEMOHON_PASANGAN_SURAT_PERNYATAAN(?)}";
$param = array(array($order, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
$data = sqlsrv_fetch_array($exec);

if($data['ID_NO_PASANGAN'] == 'PASANGAN'	){ 
$tipe= 'Pasangan';
}else{
$tipe = 'Penjamin'; 
		}
		
		
$html = '
<html>
<head>

</head>
<body>
<table style="width:100%;">
  <tr>
    <td style="font-size: 24px;" align="center">
      SURAT PERNYATAAN
	  </td>
   </tr>
     <tr>
    <td style="font-size: 16px;" align="center">
     Nomor Order : '.$order.'
	  </td>
   </tr>
</table>
<br>
<Br>

<table>

<tr>
	<td>1</td>
	<td>Nama</td>
	<td>:</td>
	<td>'.$data['PEMOHON_NAME'].'</td>
</tr>
<tr>
	<td></td>
	<td>Alamat</td>
	<td>:</td>
	<td>'.$data['CUSTOMER_ADDRESS'].'</td>
</tr>
<tr>
	<td></td>
	<td>NIK</td>
	<td>:</td>
	<td>'.$data['ID_NO_PEMOHON'].'</td>
</tr>
<tr>
	<td></td>
	<td>Dalam hal ini bertindak sebagai</td>
	<td>:</td>
	<td>Pemohon</td>
</tr>
<tr><td></td></tr>

<tr>
	<td>2</td>
	<td>Nama</td>
	<td>:</td>
	<td>'.$data['PASANGAN_NAME'].'</td>
</tr>
<tr>
	<td></td>
	<td>Alamat</td>
	<td>:</td>
	<td>'.$data['CUSTOMER_ADDRESS'].'</td>
</tr>
<tr>
	<td></td>
	<td>NIK</td>
	<td>:</td>
	<td>'.$data['ID_NO_PASANGAN'].'</td>
<tr>
	<td></td>
	<td>Dalam hal ini bertindak sebagai</td>
	<td>:</td>
	<td>'.$tipe.'</td>
</tr>
<tr><td></td></tr>


<tr><td></td></tr>
</table>
<br>
<br>
<p align="justify">
Sehubungan dengan Surat Pemesanan (SPK) yang telah diajukan kepada Dealer yang dibuktikan 
dengan pembayaran Uang Muka (DP) terlampir, maka dalam rangka pengajuan fasilitas Pembiayaan atas nama 
<u>'.$data['PEMOHON_NAME'].'</u> kepada PT SUZUKI FINANCE INDONESIA dan untuk keperluan verifikasi dan validasi data, dengan ini 
kami memberikan persetujuan kepada ke PT SUZUKI FINANCE INDONESIA untuk mengakses data pribadi 
sebagaimana tersebut diatas sebagai informasi untuk melakukan
<br>
<br>
Demikian surat pernyataan ini dibuat dengan sebenarnya, dalam keadaan sadar dan tidak ada intervensi
dari pihak manapun
</p>
<br>
<br>
<br>

<i>Surat ini dicetak secara digital dan tidak  memerlukan tandatangan basah </i>
</p>
';



$html .= '

</body>
</html>';

ob_clean(); // cleaning the buffer before Output()
$mpdf =  new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']);
$mpdf->WriteHTML($html);
$mpdf->Output();