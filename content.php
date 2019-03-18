<?php
$current_page = 'home';

if(array_key_exists('page',$_GET)) {
    $current_page = $_GET['page'];
}

switch ($current_page) {
	
	case 'home':
	require_once('home.php');
	break;
	
	case 'individual':
	require_once('individual.php');
	break;
	
	case 'company':
	require_once('company.php');
	break;
	
	case 'scoring-individual':
	require_once('scoring-individual.php');
	break;
	
	case 'scoring-company':
	require_once('scoring-company.php');
	break;
	
	case 'history':
	require_once('pages/history.php');
	break;

	case 'pefindonodata':
	require_once('pages/pefindonodata.php');
	break;
	
	case 'slik-result':
	require_once('pages/slik-result.php');
	break;
	
	case 'slik-detail':
	require_once('pages/slik-detail.php');
	break;
		
	case 'test':
	require_once('test.php');
	break;
	
	case 'error':
	require_once('error.php');
	break;
		
	default:
	require_once('404.php');
}

?>