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
 "nik":"12920239023	",
 "user_id":"devsuzukif",
 "password":"XNcPZp41",
 "IP_USER":"10.162.130.2"
}';

$curlDkUpil = curl_init();

	curl_setopt_array($curlDkUpil, array(
	  CURLOPT_URL => "http://172.16.160.128:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_NIK",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "$param_arr",
	  CURLOPT_HTTPHEADER => array(
		"Authorization: Basic " . base64_encode("devsuzukif:XNcPZp41"),
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
			echo number_format($contentdata['NIK'], 0, '', '');
			echo "<br />".$contentdata['NAMA_LGKP']."<br />";

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