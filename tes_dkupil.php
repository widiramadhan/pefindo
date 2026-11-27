<?php
/*
$resultDukcapil = json_decode($jsonDukcapil, true);

if (isset($resultDukcapil['content'][0]['RESPON'])) {
    echo $resultDukcapil['content'][0]['RESPON'];
}
else
{
	foreach($resultDukcapil['content'] as $contentdata)
	{
	  //print_r($contentdata);	//, "<br />";
		echo $contentdata['NIK']."<br />";

		echo $contentdata['NAMA_LGKP']."<br />";

		echo "<br />";
	}
}
*/

$param_arr = '
{
 "nik":"1207021011930009",
 "user_id":"singlesuzukifinance",
 "password":"s3Jsm8K9",
 "IP_USER":"NOVRIKAWATI"
}';

$curlDkUpil = curl_init();

	curl_setopt_array($curlDkUpil, array(
	  CURLOPT_URL => "http://172.16.160.128:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_NIK",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 60,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "$param_arr",
	  CURLOPT_HTTPHEADER => array(
		"Authorization: Basic " . base64_encode("singlesuzukifinance:s3Jsm8K9"),
	    "Content-Type: application/json",
	    "Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
	    "cache-control: no-cache"
	  ),
	));

	$responseDkUpil = curl_exec($curlDkUpil);
	$errDkUpil = curl_error($curlDkUpil);

	//print_r($responseDkUpil);

	curl_close($curlDkUpil);


	$resultDukcapil = json_decode($responseDkUpil, true);

	if (isset($resultDukcapil['content'][0]['RESPON'])) {
	    echo $resultDukcapil['content'][0]['RESPON'];
	    echo "<br /><br />111";
	}
	else
	{
		echo "<br /><br />222";
		foreach($resultDukcapil['content'] as $contentdata)
		{
		  //print_r($contentdata);	//, "<br />";
			echo "<br /><br /><br />";
			//echo $contentdata['NIK']."<br />";
			echo "NIK : ".number_format($contentdata['NIK'], 0, '', '');
			echo "<br />Nama Lengkap : ".$contentdata['NAMA_LGKP'];
			echo "<br />Jenis Kelamin : ".$contentdata['JENIS_KLMIN'];
			echo "<br />Tempat Lahir : ".$contentdata['TMPT_LHR'];
			echo "<br />Tanggal Lahir : ".$contentdata['TGL_LHR'];
			echo "<br />Status Kawin : ".$contentdata['STATUS_KAWIN'];
			echo "<br />Nama Ibu Kandung : ".$contentdata['NAMA_LGKP_IBU'];
			echo "<br />Jenis Pekerjaan : ".$contentdata['JENIS_PKRJN'];
			echo "<br />Alamat : ".$contentdata['ALAMAT'];
			echo "<br />RT : ".$contentdata['NO_RT'];
			echo "<br />RW : ".$contentdata['NO_RW'];
			echo "<br />Kode Provinsi : ".$contentdata['NO_PROP'];
			echo "<br />Nama Provinsi : ".$contentdata['PROP_NAME'];
			echo "<br />Kode Kabupaten : ".$contentdata['NO_KAB'];
			echo "<br />Nama Kabupaten : ".$contentdata['KAB_NAME'];
			echo "<br />Kode Kecamatan : ".$contentdata['NO_KEC'];
			echo "<br />Nama Kecamatan : ".$contentdata['KEC_NAME'];
			echo "<br />Kode Kalurahan : ".$contentdata['NO_KEL'];
			echo "<br />Nama Kelurahan : ".$contentdata['KEL_NAME'];
			
			echo "<br />";
			//echo "---";
		}
	}

	 echo "<br /><br /><br />";
	if(empty($resultDukcapil))
	{
		echo "empty json";
	}
	else
	{
		echo "not empty json";
	}



// $arr = array('nik' => "3602146604010001", 'user_id' => "devsuzukif", 'password' => 3, 'd' => 4, 'IP_USER' => "10.162.130.2");

// echo json_encode($arr);
// echo "<br />";
// echo $param_arr;

?>