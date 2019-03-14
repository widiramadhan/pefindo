<?php
/* Inquiry List */
if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bDateOfInquiry'])){
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bDateOfInquiry']<>NULL){$InquirsListDateInquiry = $array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bDateOfInquiry'];}else{$InquirsListDateInquiry=NULL;}			
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bProduct']<>NULL){$InquirsListProduct = $array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bProduct'];}else{$InquirsListProduct=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bReason']<>NULL){$InquirsListReason = $array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bReason'];}else{$InquirsListReason=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bSector']<>NULL){$InquirsListSector = $array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bSector'];}else{$InquirsListSector=NULL;}
	if($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bSubscriberInfo']<>NULL){$InquirsListSubcInfo = $array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry']['bSubscriberInfo'];}else{$InquirsListSubcInfo=NULL;}			

	$callInquiriesList = "{call SP_INSERT_INQUIRIES_LIST(?,?,?,?,?,?,?)}";
	$paramsInquiriesList = array(
						array($mappingId, SQLSRV_PARAM_IN),
						array($pefindoId,SQLSRV_PARAM_IN),
						array($InquirsListDateInquiry,SQLSRV_PARAM_IN),							
						array($InquirsListProduct,SQLSRV_PARAM_IN),
						array($InquirsListReason,SQLSRV_PARAM_IN),
						array($InquirsListSector,SQLSRV_PARAM_IN),							
						array($InquirsListSubcInfo,SQLSRV_PARAM_IN)
						);
	$execInquiriesList = sqlsrv_query($conn, $callInquiriesList, $paramsInquiriesList) or die ( print_r( sqlsrv_errors(),true));
}else{
	if(isset($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry'])){
		foreach($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bInquiryList']['bInquiry'] as $itemInquiryList){
			if($itemInquiryList['bDateOfInquiry']<>NULL){$InquirsListDateInquiry = $itemInquiryList['bDateOfInquiry'];}else{$InquirsListDateInquiry=NULL;}			
			if($itemInquiryList['bProduct']<>NULL){$InquirsListProduct = $itemInquiryList['bProduct'];}else{$InquirsListProduct=NULL;}			
			if($itemInquiryList['bReason']<>NULL){$InquirsListReason = $itemInquiryList['bReason'];}else{$InquirsListReason=NULL;}			
			if($itemInquiryList['bSector']<>NULL){$InquirsListSector = $itemInquiryList['bSector'];}else{$InquirsListSector=NULL;}		
			if($itemInquiryList['bSubscriberInfo']<>NULL){$InquirsListSubcInfo = $itemInquiryList['bSubscriberInfo'];}else{$InquirsListSubcInfo=NULL;}			
		
			$callInquiriesList = "{call SP_INSERT_INQUIRIES_LIST(?,?,?,?,?,?,?)}";
			$paramsInquiriesList = array(
								array($mappingId, SQLSRV_PARAM_IN),
								array($pefindoId,SQLSRV_PARAM_IN),
								array($InquirsListDateInquiry,SQLSRV_PARAM_IN),							
								array($InquirsListProduct,SQLSRV_PARAM_IN),
								array($InquirsListReason,SQLSRV_PARAM_IN),
								array($InquirsListSector,SQLSRV_PARAM_IN),							
								array($InquirsListSubcInfo,SQLSRV_PARAM_IN)
								);
			$execInquiriesList = sqlsrv_query($conn, $callInquiriesList, $paramsInquiriesList) or die ( print_r( sqlsrv_errors(),true));
		}
	}
}

/* Inquiry Summary */
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bSummary']['bNumberOfInquiriesLast12Months']<>NULL){$InquirsSumNumbLast12Month=$array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bSummary']['bNumberOfInquiriesLast12Months'];}else{$InquirsSumNumbLast12Month=NULL;}		
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bSummary']['bNumberOfInquiriesLast1Month']<>NULL){$InquirsSumNumbLast1Month=$array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bSummary']['bNumberOfInquiriesLast1Month'];}else{$InquirsSumNumbLast1Month=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bSummary']['bNumberOfInquiriesLast24Months']<>NULL){$InquirsSumNumbLast24Month=$array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bSummary']['bNumberOfInquiriesLast24Months'];}else{$InquirsSumNumbLast24Month=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bSummary']['bNumberOfInquiriesLast3Months']<>NULL){$InquirsSumNumbLast3Month=$array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bSummary']['bNumberOfInquiriesLast3Months'];}else{$InquirsSumNumbLast3Month=NULL;}
if($array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bSummary']['bNumberOfInquiriesLast6Months']<>NULL){$InquirsSumNumbLast6Month=$array['GetCustomReportResponse']['GetCustomReportResult']['aInquiries']['bSummary']['bNumberOfInquiriesLast6Months'];}else{$InquirsSumNumbLast6Month=NULL;}

$callInquiriesSum = "{call SP_INSERT_INQUIRIES_SUMMARY(?,?,?,?,?,?,?)}";
$paramsInquiriesSum = array(
					array($mappingId, SQLSRV_PARAM_IN),
					array($pefindoId,SQLSRV_PARAM_IN),
					array($InquirsSumNumbLast12Month,SQLSRV_PARAM_IN),							
					array($InquirsSumNumbLast1Month,SQLSRV_PARAM_IN),
					array($InquirsSumNumbLast24Month,SQLSRV_PARAM_IN),
					array($InquirsSumNumbLast3Month,SQLSRV_PARAM_IN),
					array($InquirsSumNumbLast6Month,SQLSRV_PARAM_IN)		
					);
$execInquiriesSum = sqlsrv_query($conn, $callInquiriesSum, $paramsInquiriesSum) or die ( print_r( sqlsrv_errors(),true));
?>