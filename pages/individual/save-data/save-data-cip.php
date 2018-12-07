<?php
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bDate'])){
	/* variable CIP */
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bDate']<>NULL){$dateCIP=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bDate'];}else{$dateCIP=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bGrade']<>NULL){$gradeCIP=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bGrade'];}else{$gradeCIP=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bProbabilityOfDefault']<>NULL){$probabilityCIP=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bProbabilityOfDefault'];}else{$probabilityCIP=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bScore']<>NULL){$scoreCIP=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bScore'];}else{$scoreCIP=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bTrend']<>NULL){$trendCIP=$array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord']['bTrend'];}else{$trendCIP=NULL;}
	
	$callCIP = "{call SP_INSERT_CIP(?,?,?,?,?,?,?)}";
	$paramsCIP = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId, SQLSRV_PARAM_IN),
					array($dateCIP, SQLSRV_PARAM_IN),
					array($gradeCIP, SQLSRV_PARAM_IN),
					array($probabilityCIP, SQLSRV_PARAM_IN),
					array($scoreCIP, SQLSRV_PARAM_IN),
					array($trendCIP, SQLSRV_PARAM_IN)
				);
	$execCIP = sqlsrv_query( $conn, $callCIP, $paramsCIP) or die( print_r( sqlsrv_errors(), true));
	
	/* Reason List */
	$callGetCIP = "{call SP_GET_ID_M_CIP(?)}";
	$paramsGetCIP = array(array($pefindoId, SQLSRV_PARAM_IN));
	$execGetCIP = sqlsrv_query( $conn, $callGetCIP, $paramsGetCIP) or die( print_r( sqlsrv_errors(), true));
	$rowGetCIP = sqlsrv_fetch_array($execGetCIP);
	$cipId = $rowGetCIP['M_CIP_ID'];
	
	if(isset($item['bReasonsList']['bReason']['bCode'])){
		if($item['bReasonsList']['bReason']['bCode']<>NULL){$reasonCodeCIP=$item['bReasonsList']['bReason']['bCode'];}else{$reasonCodeCIP=NULL;}
		if($item['bReasonsList']['bReason']['bDescription']<>NULL){$reasonDescCIP=$item['bReasonsList']['bReason']['bDescription'];}else{$reasonDescCIP=NULL;}				
			/* simpan ke table reason list */
			$callReasonList = "{call SP_INSERT_CIP_REASONS_LIST(?,?,?,?,?)}";
			$paramsReasonList = array(
							array($mappingId, SQLSRV_PARAM_IN),
							array($pefindoId, SQLSRV_PARAM_IN),
							array($cipId, SQLSRV_PARAM_IN),
							array($reasonCodeCIP, SQLSRV_PARAM_IN),
							array($reasonDescCIP, SQLSRV_PARAM_IN)
						);
			$execReasonList = sqlsrv_query( $conn, $callReasonList, $paramsReasonList) or die( print_r( sqlsrv_errors(), true));
	}else{
		if(isset($item['bReasonsList']['bReason'])){
			foreach($item['bReasonsList']['bReason'] as $data){
				if($data['bCode']<>NULL){$reasonCodeCIP=$data['bCode'];}else{$reasonCodeCIP=NULL;}
				if($data['bDescription']<>NULL){$reasonDescCIP=$data['bDescription'];}else{$reasonDescCIP=NULL;}					
				/* simpan ke table reason list */
				$callReasonList = "{call SP_INSERT_CIP_REASONS_LIST(?,?,?,?,?)}";
				$paramsReasonList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId, SQLSRV_PARAM_IN),
								array($cipId, SQLSRV_PARAM_IN),
								array($reasonCodeCIP, SQLSRV_PARAM_IN),
								array($reasonDescCIP, SQLSRV_PARAM_IN)
							);
				$execReasonList = sqlsrv_query( $conn, $callReasonList, $paramsReasonList) or die( print_r( sqlsrv_errors(), true));
			}
		}
	}
}else{
	foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aCIP']['bRecordList']['bRecord'] as $item){
		/* variable CIP */
		if($item['bDate']<>NULL){$dateCIP=$item['bDate'];}else{$dateCIP=NULL;}
		if($item['bGrade']<>NULL){$gradeCIP=$item['bGrade'];}else{$gradeCIP=NULL;}
		if($item['bProbabilityOfDefault']<>NULL){$probabilityCIP=$item['bProbabilityOfDefault'];}else{$probabilityCIP=NULL;}
		if($item['bScore']<>NULL){$scoreCIP=$item['bScore'];}else{$scoreCIP=NULL;}
		if($item['bTrend']<>NULL){$trendCIP=$item['bTrend'];}else{$trendCIP=NULL;}
		
		$callCIP = "{call SP_INSERT_CIP(?,?,?,?,?,?,?)}";
		$paramsCIP = array(
						array($mappingId, SQLSRV_PARAM_IN),
						array($pefindoId, SQLSRV_PARAM_IN),
						array($dateCIP, SQLSRV_PARAM_IN),
						array($gradeCIP, SQLSRV_PARAM_IN),
						array($probabilityCIP, SQLSRV_PARAM_IN),
						array($scoreCIP, SQLSRV_PARAM_IN),
						array($trendCIP, SQLSRV_PARAM_IN)
					);
		$execCIP = sqlsrv_query( $conn, $callCIP, $paramsCIP) or die( print_r( sqlsrv_errors(), true));
		
		/* Reason List */
		$callGetCIP = "{call SP_GET_ID_M_CIP(?)}";
		$paramsGetCIP = array(array($pefindoId, SQLSRV_PARAM_IN));
		$execGetCIP = sqlsrv_query( $conn, $callGetCIP, $paramsGetCIP) or die( print_r( sqlsrv_errors(), true));
		$rowGetCIP = sqlsrv_fetch_array($execGetCIP);
		$cipId = $rowGetCIP['M_CIP_ID'];
		
		if(isset($item['bReasonsList']['bReason']['bCode'])){
			if($item['bReasonsList']['bReason']['bCode']<>NULL){$reasonCodeCIP=$item['bReasonsList']['bReason']['bCode'];}else{$reasonCodeCIP=NULL;}
			if($item['bReasonsList']['bReason']['bDescription']<>NULL){$reasonDescCIP=$item['bReasonsList']['bReason']['bDescription'];}else{$reasonDescCIP=NULL;}				
				/* simpan ke table reason list */
				$callReasonList = "{call SP_INSERT_CIP_REASONS_LIST(?,?,?,?,?)}";
				$paramsReasonList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId, SQLSRV_PARAM_IN),
								array($cipId, SQLSRV_PARAM_IN),
								array($reasonCodeCIP, SQLSRV_PARAM_IN),
								array($reasonDescCIP, SQLSRV_PARAM_IN)
							);
				$execReasonList = sqlsrv_query( $conn, $callReasonList, $paramsReasonList) or die( print_r( sqlsrv_errors(), true));
		}else{
			if(isset($item['bReasonsList']['bReason'])){
				foreach($item['bReasonsList']['bReason'] as $data){
					if($data['bCode']<>NULL){$reasonCodeCIP=$data['bCode'];}else{$reasonCodeCIP=NULL;}
					if($data['bDescription']<>NULL){$reasonDescCIP=$data['bDescription'];}else{$reasonDescCIP=NULL;}					
					/* simpan ke table reason list */
					$callReasonList = "{call SP_INSERT_CIP_REASONS_LIST(?,?,?,?,?)}";
					$paramsReasonList = array(
									array($mappingId, SQLSRV_PARAM_IN),
									array($pefindoId, SQLSRV_PARAM_IN),
									array($cipId, SQLSRV_PARAM_IN),
									array($reasonCodeCIP, SQLSRV_PARAM_IN),
									array($reasonDescCIP, SQLSRV_PARAM_IN)
								);
					$execReasonList = sqlsrv_query( $conn, $callReasonList, $paramsReasonList) or die( print_r( sqlsrv_errors(), true));
				}
			}
		}
	}
}
?>