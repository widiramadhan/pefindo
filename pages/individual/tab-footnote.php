<?php

$prospect_no = $_GET['prospect_no'];
$id_no       = $id; // dari scoring-individual.php ($id = $_GET['id'])

$callCust = "{call SP_GET_CLICK_DATA_JSON_MAPPING(?,?)}";
$paramsCust = [
    [$prospect_no, SQLSRV_PARAM_IN],
    [$id_no, SQLSRV_PARAM_IN]
];

$execCust = sqlsrv_query($conn, $callCust, $paramsCust) or die(print_r(sqlsrv_errors(), true));
$dataCust = sqlsrv_fetch_array($execCust);

$filePath = $dataCust['JSON_FILE'];

$arrContextOptions = [
    "ssl" => [
        "verify_peer"      => false,
        "verify_peer_name" => false,
    ],
];


$jsoncontent = file_get_contents($filePath, false, stream_context_create($arrContextOptions));
$data = json_decode($jsoncontent, true);

$footPrintList   = [];
$count1Month     = 0;
$count3Months    = 0;
$count6Months    = 0;
$count12Months   = 0;


if (isset($data['responseData']['creditReport']['footPrints']) && !empty($data['responseData']['creditReport']['footPrints'])) {
    $footPrints    = $data['responseData']['creditReport']['footPrints'];
    $footPrintList = isset($footPrints['footPrint']) ? $footPrints['footPrint'] : [];
    $count1Month   = isset($footPrints['count1Month']) ? $footPrints['count1Month'] : 0;
    $count3Months  = isset($footPrints['count3Months']) ? $footPrints['count3Months'] : 0;
    $count6Months  = isset($footPrints['count6Months']) ? $footPrints['count6Months'] : 0;
    $count12Months = isset($footPrints['count12Months']) ? $footPrints['count12Months'] : 0;
}
?>
 
<div class="card">
    <div class="header">
        <div class="row">
            <div class="col-md-11">
                <p class="name pull-left">Footprint</p>
            </div>
        </div>
    </div>
    <div class="content">
 
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="content">
                        <center>
                            <div style="color:#AAA;">1 BULAN TERAKHIR</div>
                            <div style="font-size:36px;font-weight:bold;"><?php echo $count1Month; ?></div>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="content">
                        <center>
                            <div style="color:#AAA;">3 BULAN TERAKHIR</div>
                            <div style="font-size:36px;font-weight:bold;"><?php echo $count3Months; ?></div>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="content">
                        <center>
                            <div style="color:#AAA;">6 BULAN TERAKHIR</div>
                            <div style="font-size:36px;font-weight:bold;"><?php echo $count6Months; ?></div>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="content">
                        <center>
                            <div style="color:#AAA;">12 BULAN TERAKHIR</div>
                            <div style="font-size:36px;font-weight:bold;"><?php echo $count12Months; ?></div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
 
        <div class="row">
            <div class="col-md-11">
                <div class="table-responsive">
                    <p class="name">Daftar Footprint</p>
                    <table class="table table-bordered" style="width:100%;font-size:12px;">
                        <thead>
                            <tr>
                                <th class="bg-td">TANGGAL</th>
                                <th class="bg-td">LEMBAGA</th>
                                <th class="bg-td">TUJUAN</th>
                                <th class="bg-td">JENIS PERMINTAAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($footPrintList)) { ?>
                                <?php foreach ($footPrintList as $fp) { ?>
                                    <tr>
                                        <td align="center"><?php echo isset($fp['enquiryDate']) ? $fp['enquiryDate'] : ''; ?></td>
                                        <td align="left">
                                            <?php echo isset($fp['instituteDesc']) ? $fp['instituteDesc'] : ''; ?>
                                            <div class="text-default" style="font-size:11px;">
                                                <?php echo isset($fp['instituteCode']) ? $fp['instituteCode'] : ''; ?>
                                            </div>
                                        </td>
                                        <td align="left">
                                            <span class="text-custom">
                                                <?php echo isset($fp['purposeCodeDesc']) ? $fp['purposeCodeDesc'] : ''; ?>
                                            </span>
                                            <div class="text-default" style="font-size:11px;">
                                                <?php echo isset($fp['purposeCode']) ? $fp['purposeCode'] : ''; ?>
                                            </div>
                                        </td>
                                        <td align="left">
                                            <?php echo isset($fp['enquiryTypeDesc']) ? $fp['enquiryTypeDesc'] : ''; ?>
                                            <div class="text-default" style="font-size:11px;">
                                                <?php echo isset($fp['enquiryTypeCode']) ? $fp['enquiryTypeCode'] : ''; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="4" align="center">Data footprint tidak ditemukan</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
 
    </div>
</div>
 