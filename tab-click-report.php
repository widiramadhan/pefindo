<?php

require_once("config/configuration.php");
require_once("config/connection.php");
$id = $_GET['id'];
$prospect_no = $_GET['prospect_no'];
$id_no = $_GET['id_no'];
$user = $_GET['USERNAME'];
$date = date("Y-m-d");

$callSP2 = "{call SP_GET_PEFINDO_ID(?)}";
$params2 = array(array($id, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query($conn, $callSP2, $params2) or die(print_r(sqlsrv_errors(), true));
$data2 = sqlsrv_fetch_array($exec2);

?>
<style>
	a {
		color: #035c7a;
	}

	th {
		text-align: center;
		font-weight: bold;
	}

	a:hover {
		color: #035c7a;
	}

	.text-default {
		color: #AAA;
	}

	.name {
		font-size: 18px;
		font-weight: bold;
	}

	.table-borderless>tbody>tr>td {
		border: none;
	}

	ul>li>a {
		color: black;
	}

	ul>li>a:hover {
		color: #035c7a;
	}

	ul>li>.active>a:focus {
		color: #035c7a;
	}

	.box-yellow {
		padding: 10px;
		font-size: 24px;
		font-weight: bold;
		background-color: #ff8b00;
		color: #FFF;
		width: 80px;
		margin-right: 10px;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	.box-green {
		padding: 10px;
		font-size: 24px;
		font-weight: bold;
		background-color: #035c7a;
		color: #FFF;
		width: 80px;
		margin-right: 10px;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	.box-red {
		padding: 10px;
		font-size: 24px;
		font-weight: bold;
		background-color: #c5071f;
		color: #FFF;
		width: 80px;
		margin-right: 10px;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	.box-white {
		padding: 10px;
		font-size: 24px;
		font-weight: bold;
		background-color: #FFF;
		color: #AAA;
		border: 1px solid #AAA;
		width: 80px;
		margin-right: 10px;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	.circle-green {
		padding: 8px 5px 5px 5px;
		font-size: 8px;
		font-weight: bold;
		background-color: #035c7a;
		color: #FFF;
		border: 0px solid #333;
		width: 28px;
		height: 28px;
		border-radius: 50%;
	}

	.circle-red {
		padding: 8px 5px 5px 5px;
		font-size: 8px;
		font-weight: bold;
		background-color: #c5071f;
		color: #FFF;
		border: 0px solid #333;
		width: 28px;
		height: 28px;
		border-radius: 50%;
	}

	.circle-yellow {
		padding: 8px 5px 5px 5px;
		font-size: 8px;
		font-weight: bold;
		background-color: #ff8b00;
		color: #FFF;
		border: 0px solid #333;
		width: 28px;
		height: 28px;
		border-radius: 50%;
	}

	.circle-default {
		padding: 8px 5px 5px 5px;
		font-size: 8px;
		font-weight: bold;
		background-color: #CCC;
		color: #FFF;
		border: 0px solid #333;
		width: 28px;
		height: 28px;
		border-radius: 50%;
	}

	.disclaimer {
		padding: 30px;
		background-color: #EEE;
	}

	.bg-td {
		background-color: #f9f9f9;
	}

	tr.header {
		cursor: pointer;
		display: table-row;
	}

	tr.child {
		display: none;
	}

	.text-custom {
		color: #035c7a;
	}
</style>
<script>
	$(document).ready(function() {
		$("#collapseOne").on("hide.bs.collapse", function() {
			$(".card-link").html('<span class="fa fa-chevron-down" style="color:#035c7a;"></span>');
		});
		$("#collapseOne").on("show.bs.collapse", function() {
			$(".card-link").html('<span class="fa fa-chevron-up" style="color:#035c7a;"></span>');
		});
		$("#collapseOne2").on("hide.bs.collapse", function() {
			$(".card-link2").html('<span class="fa fa-chevron-down" style="color:#035c7a;"></span>');
		});
		$("#collapseOne2").on("show.bs.collapse", function() {
			$(".card-link2").html('<span class="fa fa-chevron-up" style="color:#035c7a;"></span>');
		});
	});
</script>
<div class="row">
	<div class="col-md-12">
		<?php if ($data2['PEFINDO_ID'] == '0000') { ?>
			<div class="content">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-md-12">
								<center>
									<h3>DATA <?php echo $data2['CUST_TYPE']; ?> <br>TIDAK DITEMUKAN DI PEFINDO</h3><br>
								</center>
								<br><br>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		} else {
			
			?>
	<div class="content">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-md-12">
							
<?php 
	
		
/*
 * tab-click-report.php
 * Render laporan CLIK (CRIF) dari JSON (CLICK_MAPPING.JSON_FILE) dengan tampilan menyerupai PDF.
 * Di-include dari scoring-individual-click.php (butuh $conn, $prospect_no, $id_no, opsional $user).
 * Kompatibel PHP 5.3+ (tanpa ??, tanpa short array).
 */

/* ---------- Konfigurasi ---------- */
// Skala donut CB Score (hanya untuk panjang busur; angka skor tetap dari JSON). Sesuaikan dengan range resmi CRIF.
if (!defined('CLK_SCORE_MIN')) define('CLK_SCORE_MIN', 0);
if (!defined('CLK_SCORE_MAX')) define('CLK_SCORE_MAX', 1400);

/* ---------- Helper ---------- */
if (!function_exists('clk_h')) {

    function clk_h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

    // ambil nilai dengan path 'a/b/0/c'
    function clk_g($arr, $path, $def = null) {
        $cur = $arr;
        foreach (explode('/', $path) as $k) {
            if (is_array($cur) && array_key_exists($k, $cur)) $cur = $cur[$k]; else return $def;
        }
        return $cur;
    }

    function clk_a($a, $k) { return (is_array($a) && isset($a[$k])) ? $a[$k] : null; }

    function clk_v($v) {
        if ($v === null || $v === '' || $v === array()) return '-';
        return clk_h($v);
    }

    function clk_num($v) {
        if ($v === null || $v === '') return '-';
        if (!is_numeric($v)) return clk_h($v);
        return number_format((float)$v, 0, '.', ',');
    }

    function clk_date($v) {
        if ($v === null || $v === '') return '-';
        if (preg_match('/^(\d{4})(\d{2})(\d{2})$/', $v, $m)) return $m[1] . '-' . $m[2] . '-' . $m[3];
        return clk_h(substr($v, 0, 10));
    }

    // lookup tabel master M_CLK_DOMAIN_* (cache per request)
    function clk_dom($conn, $table, $code) {
        static $cache = array();
        if ($code === null || $code === '' || !$conn || !function_exists('sqlsrv_query')) return '';
        if (!preg_match('/^M_CLK_DOMAIN_\w+$/', $table)) return '';
        if (!isset($cache[$table])) {
            $cache[$table] = array();
            $q = @sqlsrv_query($conn, "SELECT LTRIM(RTRIM(CODE)) AS CODE, LABEL_EN FROM dbo.[" . $table . "] WITH (NOLOCK)");
            if ($q) {
                while ($r = sqlsrv_fetch_array($q, SQLSRV_FETCH_ASSOC)) {
                    if (!isset($cache[$table][$r['CODE']])) $cache[$table][$r['CODE']] = trim($r['LABEL_EN']);
                }
            }
        }
        $k = trim($code);
        return isset($cache[$table][$k]) ? $cache[$table][$k] : '';
    }

    // pakai desc dari JSON; kalau kosong, cari di master; kalau tetap kosong, tampilkan kode
    function clk_lbl($conn, $desc, $table, $code) {
        if ($desc !== null && $desc !== '') return $desc;
        $d = clk_dom($conn, $table, $code);
        return $d !== '' ? $d : $code;
    }

    // $pairs: array(array(label, htmlValue), ...), $per: jumlah pasangan per baris
    function clk_kv($pairs, $per) {
        $h = '<table class="clk-kv p' . $per . '">';
        $n = count($pairs);
        for ($i = 0; $i < $n; $i += $per) {
            $h .= '<tr>';
            for ($j = 0; $j < $per; $j++) {
                if (isset($pairs[$i + $j])) {
                    $h .= '<td class="l">' . clk_h($pairs[$i + $j][0]) . '</td><td class="v">' . $pairs[$i + $j][1] . '</td>';
                } else {
                    $h .= '<td class="l"></td><td class="v"></td>';
                }
            }
            $h .= '</tr>';
        }
        return $h . '</table>';
    }

    function clk_sec($title, $inner) {
        return '<div class="clk-sec"><div class="clk-sec-l">' . clk_h($title) . '</div><div class="clk-sec-r">' . $inner . '</div></div>';
    }

    function clk_addr($conn, $ad, $desc) {
        $city = clk_lbl($conn, clk_a($desc, 'cityDesc'), 'M_CLK_DOMAIN_Region', clk_a($ad, 'city'));
        $country = clk_lbl($conn, clk_a($desc, 'countryDesc'), 'M_CLK_DOMAIN_Country', clk_a($ad, 'country'));
        $parts = array(clk_a($ad, 'address'), clk_a($ad, 'subDistrict'), clk_a($ad, 'district'), $city, clk_a($ad, 'postalCode'), $country);
        $out = array();
        foreach ($parts as $p) { if ($p !== null && $p !== '') $out[] = $p; }
        return $out ? clk_h(implode(', ', $out)) : '-';
    }

    /* ----- generic renderer (untuk bagian yang tidak ada contoh datanya) ----- */
    function clk_is_list($a) { return is_array($a) && !empty($a) && array_keys($a) === range(0, count($a) - 1); }

    function clk_title($key) {
        $parts = explode('.', $key);
        $k = end($parts);
        return ucfirst(trim(preg_replace('/(?<!^)([A-Z])/', ' $1', $k)));
    }

    function clk_flat($a, $prefix, &$out, &$lists) {
        foreach ($a as $k => $v) {
            $key = ($prefix === '') ? $k : $prefix . '.' . $k;
            if (is_array($v)) {
                if (empty($v)) continue;
                if (clk_is_list($v)) $lists[$key] = $v; else clk_flat($v, $key, $out, $lists);
            } else {
                $out[$key] = $v;
            }
        }
    }

    function clk_generic($data) {
        if (!is_array($data) || empty($data)) return '';
        $h = '';
        if (clk_is_list($data)) {
            $rows = array(); $simple = true;
            foreach ($data as $it) {
                $o = array(); $l = array();
                if (is_array($it)) clk_flat($it, '', $o, $l); else $o['value'] = $it;
                if ($l) $simple = false;
                $rows[] = array($o, $l);
            }
            if ($simple) {
                $cols = array();
                foreach ($rows as $r) foreach ($r[0] as $k => $v) $cols[$k] = true;
                foreach (array_keys($cols) as $k) { if (isset($cols[$k . 'Desc'])) unset($cols[$k]); }
                $h .= '<div class="clk-scroll"><table class="clk-ht"><thead><tr>';
                foreach (array_keys($cols) as $k) $h .= '<th>' . clk_h(clk_title($k)) . '</th>';
                $h .= '</tr></thead><tbody>';
                foreach ($rows as $r) {
                    $h .= '<tr>';
                    foreach (array_keys($cols) as $k) $h .= '<td>' . (isset($r[0][$k]) ? clk_v($r[0][$k]) : '-') . '</td>';
                    $h .= '</tr>';
                }
                return $h . '</tbody></table></div>';
            }
            foreach ($data as $it) $h .= '<div class="clk-gcard">' . clk_generic($it) . '</div>';
            return $h;
        }
        $o = array(); $l = array();
        clk_flat($data, '', $o, $l);
        $pairs = array();
        foreach ($o as $k => $v) {
            if (array_key_exists($k . 'Desc', $o)) continue;
            $pairs[] = array(clk_title($k), clk_v($v));
        }
        if ($pairs) $h .= clk_kv($pairs, 3);
        foreach ($l as $k => $list) {
            $h .= '<div class="clk-gh">' . clk_h(clk_title($k)) . '</div>' . clk_generic($list);
        }
        return $h;
    }

    /* ----- satu kontrak kredit ----- */
    function clk_month_grid($pf) {
        $mn = array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
        $map = array(); $years = array();
        foreach ($pf as $p) {
            $y = (int)clk_a($p, 'referenceYear'); $m = (int)clk_a($p, 'referenceMonth');
            if (!$y) continue;
            $years[$y] = true;
            $q = clk_a($p, 'qualityCode');
            if ($q !== null && $q !== '') $map[$y][$m] = (string)$q;
        }
        if (!$years) return '';
        krsort($years);
        $h = '<table class="clk-mg"><tr><th class="e"></th>';
        foreach ($mn as $m) $h .= '<th>' . $m . '</th>';
        $h .= '</tr>';
        foreach (array_keys($years) as $y) {
            $h .= '<tr><th class="y">' . $y . '</th>';
            for ($m = 1; $m <= 12; $m++) {
                if (isset($map[$y][$m])) {
                    $q = $map[$y][$m];
                    $h .= '<td class="q' . clk_h($q) . '">' . ($q === '1' ? 'OK' : clk_h($q)) . '</td>';
                } else {
                    $h .= '<td></td>';
                }
            }
            $h .= '</tr>';
        }
        return $h . '</table>';
    }

    function clk_contract($conn, $no, $c) {
        $mn = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        $cd = clk_a($c, 'commonData'); $gc = clk_a($c, 'grantedCredit'); $mx = clk_a($c, 'maximum');
        $pf = clk_a($c, 'creditProfile'); if (!is_array($pf)) $pf = array();

        $phase = clk_lbl($conn, clk_a($cd, 'contractPhaseDesc'), 'M_CLK_DOMAIN_ContractPhase', clk_a($cd, 'contractPhase'));
        $role = clk_lbl($conn, clk_a($cd, 'roleDesc'), 'M_CLK_DOMAIN_Role', clk_a($cd, 'role'));
        $pastDue = clk_lbl($conn, clk_a($cd, 'pastDueStausDesc'), 'M_CLK_DOMAIN_Collectability', clk_a($cd, 'pastDueStausCode'));
        $cstat = clk_lbl($conn, clk_a($cd, 'contractStatusDesc'), 'M_CLK_DOMAIN_Condition', clk_a($cd, 'contractStatusCode'));

        $h = '<table class="clk-ct"><thead><tr><th>No.</th><th>CB Contract Code</th><th>Provider Contract Number</th><th>Contract Type</th><th>Contract Phase</th><th>Role</th><th>Provider</th><th>Start Date</th><th>Due Date</th></tr></thead><tbody><tr>'
            . '<td>' . $no . '</td><td>' . clk_v(clk_a($cd, 'cbcontractCode')) . '</td><td>' . clk_v(clk_a($cd, 'providerContractNo')) . '</td>'
            . '<td>' . clk_v(clk_a($cd, 'contractTypeCodeDesc')) . '</td><td>' . clk_v($phase) . '</td><td>' . clk_v($role) . '</td>'
            . '<td>' . clk_v(clk_a($cd, 'providerCodeDesc')) . '</td><td>' . clk_date(clk_a($cd, 'startDate')) . '</td><td>' . clk_date(clk_a($cd, 'dueDate')) . '</td></tr></tbody></table>';

        // Information
        $h .= '<div class="clk-info"><div class="clk-info-t">Information</div><div class="clk-card-b">'
            . clk_kv(array(
                array('Provider Type', clk_v(clk_a($cd, 'providerTypeCodeDesc'))),
                array('Provider', clk_v(clk_a($cd, 'providerCodeDesc'))),
                array('Last Update Date', clk_date(clk_a($cd, 'referenceDate')))
            ), 3) . clk_month_grid($pf) . '</div></div>';

        $h .= '<div class="clk-dt">Details of Credit / Finance</div><div class="clk-card">';

        // Details
        $h .= clk_sec('Details', clk_kv(array(
            array('Start Date', clk_date(clk_a($cd, 'startDate'))),
            array('Due Date', clk_date(clk_a($cd, 'dueDate'))),
            array('Past Due Date', clk_v($pastDue)),
            array('Contract Status', clk_v($cstat)),
            array('Contract Status Date', clk_date(clk_a($cd, 'contractStatusDate'))),
            array('Information', clk_v(clk_a($cd, 'information')))
        ), 3));

        // Historical Data
        $t = '<div class="clk-scroll"><table class="clk-ht"><thead><tr><th>Reference Date</th><th>Days Past Due</th><th>Overdue</th><th>Bad Credit Cause</th><th>Debit Balance</th><th>Current Month Realization</th><th>Contract Status</th></tr></thead><tbody>';
        foreach ($pf as $p) {
            $m = (int)clk_a($p, 'referenceMonth');
            $ps = clk_lbl($conn, clk_a($p, 'contractStatusDesc'), 'M_CLK_DOMAIN_Condition', clk_a($p, 'contractStatusCode'));
            $bc = clk_lbl($conn, clk_a($p, 'badCreditCauseDesc'), 'M_CLK_DOMAIN_ReasonLoss', clk_a($p, 'badCreditCauseCode'));
            $t .= '<tr><td>' . clk_h(clk_a($p, 'referenceYear') . ' ' . ($m >= 1 && $m <= 12 ? $mn[$m - 1] : '')) . '</td>'
                . '<td>' . clk_v(clk_a($p, 'daysPastDue')) . '</td><td>' . clk_num(clk_a($p, 'overdue')) . '</td><td>' . clk_v($bc) . '</td>'
                . '<td class="n">' . clk_num(clk_a($p, 'debitBalance')) . '</td><td>' . clk_num(clk_a($p, 'currentMonthRealization')) . '</td><td>' . clk_v($ps) . '</td></tr>';
        }
        $h .= clk_sec('Historical Data', $t . '</tbody></table></div>');

        // Granted Credit
        $gcPairs = array(
            array('Characteristic Credit', clk_v(clk_lbl($conn, clk_a($gc, 'codeCharacteristicCreditDesc'), 'M_CLK_DOMAIN_CreditCharacteristic', clk_a($gc, 'codeCharacteristicCredit')))),
            array('Agreement Credit', clk_v(clk_lbl($conn, clk_a($gc, 'codeAgreementCreditDesc'), 'M_CLK_DOMAIN_FinancingScheme', clk_a($gc, 'codeAgreementCredit')))),
            array('Original Agreement Number', clk_v(clk_a($gc, 'originalAgreementNumber'))),
            array('Original Agreement Date', clk_date(clk_a($gc, 'originalAgreementDate'))),
            array('Final Agreement Number', clk_v(clk_a($gc, 'finalAgreementNumber'))),
            array('Final Agreement Date', clk_date(clk_a($gc, 'finalAgreementDate'))),
            array('Credit Frequency', clk_v(clk_a($gc, 'frequencyOfCredit'))),
            array('Credit Start Date', clk_date(clk_a($gc, 'startDateOfCredit'))),
            array('Debtor Category', clk_v(clk_lbl($conn, clk_a($gc, 'debtorCategoryCodeDesc'), 'M_CLK_DOMAIN_DebtorCategory', clk_a($gc, 'debtorCategoryCode')))),
            array('Usage Type', clk_v(clk_lbl($conn, clk_a($gc, 'usageTypeCodeDesc'), 'M_CLK_DOMAIN_TypeOfUse', clk_a($gc, 'usageTypeCode')))),
            array('Usage Orientation', clk_v(clk_lbl($conn, clk_a($gc, 'usageOrientationCodeDesc'), 'M_CLK_DOMAIN_OrientationOfUse', clk_a($gc, 'usageOrientationCode')))),
            array('Economic Sector', clk_v(clk_lbl($conn, clk_a($gc, 'economicSectorCodeDesc'), 'M_CLK_DOMAIN_EconomicSector', clk_a($gc, 'economicSectorCode')))),
            array('City', clk_v(clk_lbl($conn, clk_a($gc, 'cityCodeDesc'), 'M_CLK_DOMAIN_Region', clk_a($gc, 'cityCode')))),
            array('Project Value', clk_num(clk_a($gc, 'projectValue'))),
            array('Type of Interest Rate', clk_v(clk_lbl($conn, clk_a($gc, 'typeOfInterestRateDesc'), 'M_CLK_DOMAIN_TypeOfInterestRate', clk_a($gc, 'typeOfInterestRate')))),
            array('Interest Rate', clk_v(clk_a($gc, 'interestRate'))),
            array('Financing Program', clk_v(clk_lbl($conn, clk_a($gc, 'financigProgramDesc'), 'M_CLK_DOMAIN_GovernmentCreditProgram', clk_a($gc, 'financigProgram'))))
        );
        $h .= clk_sec('Granted Credit', clk_kv($gcPairs, 3));

        $h .= clk_sec('Credit Limit / Debit Balance', clk_kv(array(
            array('Initial Credit Limit', clk_num(clk_a($gc, 'initialCreditLimit'))),
            array('Credit Limit', clk_num(clk_a($gc, 'creditLimit'))),
            array('Current Month Realization', clk_num(clk_a($gc, 'currentMonthRealization'))),
            array('Debit Balance', clk_num(clk_a($gc, 'debitBalance'))),
            array('Value In Original Currency', clk_num(clk_a($gc, 'valueInOriginalCurrency')))
        ), 3));

        $h .= clk_sec('Overdue', clk_kv(array(
            array('Principal Overdue Amount', clk_num(clk_a($gc, 'principalOverdueAmount'))),
            array('Interest Overdue Amount', clk_num(clk_a($gc, 'interestOverdueAmount'))),
            array('Days Past Due', clk_v(clk_a($gc, 'daysPastDue'))),
            array('Overdue Payments Number', clk_v(clk_a($gc, 'overduePaymentsNumber'))),
            array('Bad Credit Cause', clk_v(clk_lbl($conn, clk_a($gc, 'badCreditCauseDesc'), 'M_CLK_DOMAIN_ReasonLoss', clk_a($gc, 'badCreditCauseCode')))),
            array('Bad Credit Date', clk_date(clk_a($gc, 'badCreditDate'))),
            array('Penalty', clk_num(clk_a($gc, 'penalty')))
        ), 3));

        $h .= clk_sec('Restructuring', clk_kv(array(
            array('Restructuring Plan', clk_v(clk_lbl($conn, clk_a($gc, 'codeOfRestructuringDesc'), 'M_CLK_DOMAIN_RestructuringPlan', clk_a($gc, 'codeOfRestructuring')))),
            array('Initial Restructuring Date', clk_date(clk_a($gc, 'initialRestructuringDate'))),
            array('Final Restructuring Date', clk_date(clk_a($gc, 'finalRestructuringDate'))),
            array('Frequency of Restructuring', clk_v(clk_a($gc, 'frequencyOfRestructuring')))
        ), 3));

        $worst = clk_lbl($conn, clk_a($mx, 'worstStatusDesc'), 'M_CLK_DOMAIN_Collectability', clk_a($mx, 'worstStatusCode'));
        $h .= clk_sec('Credit Maximum', clk_kv(array(
            array('Max Overdue Payments Amount', clk_num(clk_a($mx, 'maxOverduePaymentsAmount'))),
            array('Max Overdue Payments Number', clk_v(clk_a($mx, 'maxOverduePaymentsNumber'))),
            array('Max Overdue Payments Number Date', clk_date(clk_a($mx, 'maxOverduePaymentsNumberDate'))),
            array('Max Days Past Due', clk_v(clk_a($mx, 'maxDaysPastDue'))),
            array('Max Days Past Due Date', clk_date(clk_a($mx, 'maxDaysPastDueDate'))),
            array('Worst Status', clk_v($worst)),
            array('Worst Status Date', clk_date(clk_a($mx, 'worstStatusDate')))
        ), 3));

        // Bagian opsional (hanya tampil bila ada datanya)
        $gcol = clk_g($c, 'collaterals/grantedCollaterals');
        if (is_array($gcol) && $gcol) $h .= clk_sec('Collaterals', clk_generic($gcol));
        $gu = clk_g($c, 'guarantors/guarantorsData');
        if (is_array($gu) && $gu) $h .= clk_sec('Guarantors', clk_generic($gu));
        $ls = clk_a($c, 'linkedSubject');
        if (is_array($ls) && $ls) $h .= clk_sec('Linked Subject', clk_generic($ls));
        $note = clk_a($c, 'note');
        if ($note !== null && $note !== '' && $note !== array()) $h .= clk_sec('Note', is_array($note) ? clk_generic($note) : '<div class="clk-pad">' . clk_h($note) . '</div>');

        return $h . '</div>';
    }

    function clk_fin_group($title, $count, $lines) {
        $h = '<div class="clk-fg"><div class="clk-fg-t"><span>' . clk_h($title) . '</span><b>' . clk_num($count) . '</b></div>';
        foreach ($lines as $l) $h .= '<div class="clk-fg-l"><span>' . clk_h($l[0]) . '</span><b>' . clk_num($l[1]) . '</b></div>';
        return $h . '</div>';
    }

    function clk_score_color($desc) {
        $d = strtolower((string)$desc);
        if (strpos($d, 'high') !== false) return '#c5071f';
        if (strpos($d, 'medium') !== false || strpos($d, 'moderate') !== false) return '#ff8b00';
        if (strpos($d, 'low') !== false) return '#16b85a';
        return '#1f4e79';
    }
}

/* ---------- Ambil data ---------- */
if (!isset($prospect_no)) $prospect_no = isset($_GET['prospect_no']) ? $_GET['prospect_no'] : '';
if (!isset($id_no) || $id_no === '') $id_no = isset($_GET['id_no']) ? $_GET['id_no'] : '';

$clkError = '';
if (!isset($clkData)) {   // $clkData bisa di-set dari luar (mis. untuk testing)
    $clkData = null;
    $callCk = "{call SP_GET_CLICK_DATA_JSON(?,?)}";
    $paramsCk = array(array($prospect_no, SQLSRV_PARAM_IN), array($id_no, SQLSRV_PARAM_IN));
    $execCk = sqlsrv_query($conn, $callCk, $paramsCk);
    $rowCk = $execCk ? sqlsrv_fetch_array($execCk) : null;
    if (!$rowCk || empty($rowCk['JSON_FILE'])) {
        $clkError = 'Data Click tidak ditemukan (PROSPECT_NO / ID_NO).';
    } else {
        $ctx = stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false)));
        $raw = @file_get_contents($rowCk['JSON_FILE'], false, $ctx);
        if ($raw === false) {
            $clkError = 'File JSON Click tidak dapat dibaca.';
        } else {
            $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
            $clkData = json_decode($raw, true);
            unset($raw);
            if (!is_array($clkData) || !isset($clkData['responseData'])) $clkError = 'Format JSON Click tidak valid.';
        }
    }
}
if ($clkError === '' && is_array($clkData)) {
    unset($clkData['responseData']['pdfdetails']);   // base64 PDF tidak dipakai di sini
    $errs = clk_g($clkData, 'responseData/error');
    if (is_array($errs) && $errs) $clkError = 'Response Click berisi error: ' . json_encode($errs);
}
$dbc = isset($conn) ? $conn : null;
?>
<style>
.clk{color:#333;font-size:12px}
.clk *{box-sizing:border-box}
.clk table{width:100%;border-collapse:collapse}
.clk th{text-align:left}
.clk-head{display:flex;justify-content:space-between;font-size:11px;color:#777;margin-bottom:6px}
.clk-title{border:4px solid #1f4e79;text-align:center;font-size:22px;font-weight:bold;color:#1f4e79;padding:8px;margin:10px 0 14px}
.clk-bar{background:#1f4e79;color:#fff;font-weight:bold;font-size:16px;padding:8px 10px}
.clk-bar.c{text-align:center}
.clk-box{border:1px solid #1f4e79;padding:10px;margin-bottom:14px}
.clk-tab{display:inline-block;background:#1f4e79;color:#fff;font-weight:bold;font-size:14px;padding:6px 10px}
.clk-card{border:1px solid #1f4e79;margin-bottom:14px;background:#fff}
.clk-card-b{padding:8px 10px}
.clk-kv td{padding:6px 8px;vertical-align:top;font-size:11.5px}
.clk-kv td.l{color:#8a8a8a}
.clk-kv td.v{font-weight:bold;color:#333;word-break:break-word}
.clk-kv.p1 td.l{width:20%}.clk-kv.p1 td.v{width:80%}
.clk-kv.p2 td.l{width:18%}.clk-kv.p2 td.v{width:32%}
.clk-kv.p3 td.l{width:13%}.clk-kv.p3 td.v{width:20%}
.clk-kv.p4 td.l{width:11%}.clk-kv.p4 td.v{width:14%}
.clk-row{display:flex;gap:14px;align-items:stretch}
.clk-col{flex:1;min-width:0}
.clk-col.w2{flex:1.45}
.clk-top{display:flex;justify-content:space-between;align-items:center;padding:14px 10px 4px}
.clk-ok{display:inline-flex;align-items:center;gap:8px;font-weight:bold;color:#555}
.clk-ok i{display:inline-block;width:16px;height:16px;border-radius:50%;background:#1aa54b}
.clk-ok i.no{background:#aaa}
.clk-score{display:flex;align-items:center;gap:24px;padding:22px 20px;min-height:170px}
.clk-score .nodata{margin:auto;font-size:18px;font-weight:bold;color:#777}
.clk-donut{position:relative;width:124px;height:124px;flex:none}
.clk-donut svg{width:124px;height:124px;transform:rotate(-90deg)}
.clk-donut span{position:absolute;left:0;top:0;width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:15px;color:#000}
.clk-score .risk{font-size:18px;font-weight:bold;color:#000}
.clk-factors{font-size:11px;color:#555;padding:0 20px 10px}
.clk-factors summary{cursor:pointer;color:#1f4e79}
.clk-fg{padding:8px 12px}
.clk-fg-t,.clk-fg-l{display:flex;justify-content:space-between;font-size:11.5px;padding:2px 0}
.clk-fg-t span{font-weight:bold}
.clk-fg-t b{margin-right:auto;margin-left:14px}
.clk-fg-l span{color:#8a8a8a}
.clk-fg-l b{min-width:90px;text-align:right}
.clk-cat{width:auto!important;margin:14px auto;font-size:11px}
.clk-cat th,.clk-cat td{padding:3px 8px;text-align:center}
.clk-cat th:first-child,.clk-cat td:first-child{text-align:left;font-weight:bold}
.clk-cat thead th{border-bottom:1px solid #999}
.clk-cat tbody tr:nth-child(odd){background:#eee}
.clk-h{color:#1f4e79;font-size:17px;border-bottom:1px solid #1f4e79;padding-bottom:3px;margin:22px 0 6px}
.clk-hist{border:1px solid #1f4e79;margin:4px 0}
.clk-hist .clk-kv td{border-bottom:1px solid #eee}
.clk-hist-t{font-weight:bold;color:#8a8a8a;font-size:11px;padding:6px 8px 0}
.clk-ct{margin-top:10px}
.clk-ct th{font-size:11.5px;padding:6px 8px;vertical-align:bottom}
.clk-ct td{font-size:11.5px;padding:6px 8px;color:#777}
.clk-info{border:1px solid #1f4e79;margin:6px 0 16px}
.clk-info-t{font-weight:bold;color:#8a8a8a;font-size:11px;padding:6px 10px 0}
.clk-mg{width:auto!important;margin:4px auto 8px}
.clk-mg th{background:#ddd;font-size:9px;color:#888;font-weight:normal;border:1px solid #999;min-width:46px;padding:1px 4px;text-align:center}
.clk-mg th.e{background:#fff;border:0}
.clk-mg td{border:1px solid #888;height:15px;font-size:9px;text-align:center;padding:1px 4px;color:#fff}
.clk-mg td.q1{background:#8fd17b}.clk-mg td.q2{background:#f2c94c}.clk-mg td.q3{background:#ff8b00}.clk-mg td.q4,.clk-mg td.q5{background:#c5071f}
.clk-dt{font-weight:bold;color:#8a8a8a;font-size:11px;margin:14px 0 4px}
.clk-sec{display:flex;border:1px solid #ddd;margin:0 0 10px}
.clk-sec-l{background:#1f4e79;color:#fff;font-weight:bold;width:150px;flex:none;display:flex;align-items:center;justify-content:center;text-align:center;padding:6px}
.clk-sec-r{flex:1;min-width:0}
.clk-scroll{overflow-x:auto}
.clk-ht th{font-size:11px;padding:10px 8px;white-space:nowrap}
.clk-ht td{font-size:11.5px;padding:9px 8px;color:#777;white-space:nowrap}
.clk-ht td.n{text-align:left}
.clk-gh{font-weight:bold;color:#1f4e79;margin:8px 8px 2px}
.clk-gcard{border-bottom:1px dashed #bbb;margin-bottom:8px}
.clk-pad{padding:10px}
.clk-err{padding:20px;text-align:center;color:#c5071f;font-weight:bold}
@media (max-width:900px){.clk-row{flex-direction:column}}
</style>
<div class="clk">
<?php
if ($clkError !== '') {
    echo '<div class="clk-err">' . clk_h($clkError) . '</div></div>';
    return;
}

$R = $clkData['responseData'];
$ed = clk_a($R, 'enquiredData');
$cr = clk_a($R, 'creditReport');
$ch = clk_a($cr, 'contractsHistory');
$ms = clk_g($cr, 'matchedSubject');
$createdOn = clk_date(clk_a($ed, 'subjectRefDate'));
$clkUser = isset($user) ? $user : '';

/* ===== header ===== */
echo '<div class="clk-head"><span>CREDIT REPORT CREATED ON ' . $createdOn . '</span><b>' .  '</b></div>';

/* ===================== SUMMARY ===================== */
$app = clk_a($ed, 'application');
$appDesc = clk_a($ed, 'applicationDesc');
$matched = (is_array($ms) && isset($ms[0]) && clk_a($ms[0], 'flagMatched') == '1');
$reportCode = clk_g($R, 'cgResponseInfo/response/detail/detailID');
if ($reportCode === null) $reportCode = clk_g($clkData, 'cgResponseInfo/response/detail/detailID');
$reqDate = clk_date(clk_a($app, 'contractRequestDate'));

echo '<div class="clk-title">Summary</div><div class="clk-bar">Summary Data</div><div class="clk-box" style="padding:0">';
echo '<div class="clk-top"><span style="color:#8a8a8a">Report Code &nbsp; <b style="color:#333">' . clk_v($reportCode) . '</b></span>'
    . '<span class="clk-ok"><i' . ($matched ? '' : ' class="no"') . '></i>' . ($matched ? 'Subject matched' : 'Subject not matched') . '</span></div>';
echo '<div class="clk-top" style="padding-top:0"><span></span><span style="color:#8a8a8a">Requested Date &nbsp; <b style="color:#333">' . $reqDate . '</b></span></div>';

// Application Summary Detail
$cred = clk_a($app, 'credit');
echo '<div class="clk-card" style="margin:0 10px 14px"><div class="clk-tab">Application Summary Detail</div><div class="clk-card-b">'
    . clk_kv(array(
        array('CB Contract Code', clk_v(clk_g($R, 'applicationCodes/cbcontractCode'))),
        array('Contract Type', clk_v(clk_lbl($dbc, clk_a($appDesc, 'contractTypeDesc'), 'M_CLK_DOMAIN_ContractTypeCategory', clk_a($app, 'contractTypeCode')))),
        array('Contract Phase', clk_v(clk_lbl($dbc, clk_a($appDesc, 'contractPhaseDesc'), 'M_CLK_DOMAIN_ContractPhase', clk_a($app, 'contractPhase')))),
        array('Requested Date', $reqDate),
        array('Application Amount', clk_num(clk_a($cred, 'applicationAmount'))),
        array('Due Date', clk_date(clk_a($cred, 'dueDate'))),
        array('Role', clk_v(clk_lbl($dbc, clk_g($ed, 'linkDesc/roleDesc'), 'M_CLK_DOMAIN_Role', clk_g($ed, 'link/role')))),
        array('Company Role', clk_v(clk_lbl($dbc, clk_g($ed, 'linkDesc/companyRoleDesc'), 'M_CLK_DOMAIN_CompanyRole', clk_g($ed, 'link/companyRole')))),
        array('Account Number', clk_v(clk_g($R, 'applicationCodes/providerApplicationNo'))),
        array('Currency', clk_v(clk_a($app, 'currency'))),
        array('Original Agreement Number', clk_v(clk_a($cred, 'originalAgreementNumber'))),
        array('Original Agreement Date', clk_date(clk_a($cred, 'originalAgreementDate')))
    ), 2) . '</div></div>';
echo '</div>';

// Score
$sd = clk_g($R, 'cbscore/cbsglocal/scoreData');
$raw = clk_a($sd, 'scoreRaw');
echo '<div class="clk-row" style="margin-bottom:14px"><div class="clk-col"><div class="clk-card" style="height:100%"><div class="clk-tab">CB Score Details</div>';
if ($raw !== null && $raw !== '') {
    $rangeTxt = clk_a($sd, 'scoreRange');
    $riskTxt = clk_g($sd, 'scoreMessage/description');
    $frac = (CLK_SCORE_MAX > CLK_SCORE_MIN) ? ((float)$raw - CLK_SCORE_MIN) / (CLK_SCORE_MAX - CLK_SCORE_MIN) : 0;
    $frac = max(0, min(1, $frac));
    $circ = 2 * M_PI * 50;
    echo '<div class="clk-score"><div class="clk-donut"><svg viewBox="0 0 124 124"><circle cx="62" cy="62" r="50" fill="none" stroke="#d9d9d9" stroke-width="14"/>'
        . '<circle cx="62" cy="62" r="50" fill="none" stroke="' . clk_score_color($riskTxt) . '" stroke-width="14" stroke-dasharray="' . round($frac * $circ, 2) . ' ' . round($circ, 2) . '"/></svg>'
        . '<span>' . clk_h(($rangeTxt !== null ? $rangeTxt . '/' : '') . $raw) . '</span></div><div class="risk">' . clk_v($riskTxt) . '</div></div>';
    $sf = clk_a($sd, 'scoreFactor');
    if (is_array($sf) && $sf) {
        echo '<details class="clk-factors"><summary>Score Factors</summary><ul>';
        foreach ($sf as $f) echo '<li>' . clk_h(clk_a($f, 'description')) . '</li>';
        echo '</ul></details>';
    }
} else {
    echo '<div class="clk-score"><div class="nodata">No data found</div></div>';
}
echo '</div></div><div class="clk-col"><div class="clk-card" style="height:100%"><div class="clk-tab">Fintech Score Details</div>';
$fraw = clk_g($R, 'finTechScore/finTech/scoreData/scoreRaw');
if ($fraw !== null && $fraw !== '') {
    echo '<div class="clk-score"><div class="risk">' . clk_h(clk_g($R, 'finTechScore/finTech/scoreData/scoreRange') . ' / ' . $fraw) . '</div></div>';
} else {
    echo '<div class="clk-score"><div class="nodata">No data found</div></div>';
}
echo '</div></div></div>';

// Contract Summary + Financial Summary + Summary by Category
$ag = clk_a($ch, 'aggregatedData');
$cat = array(
    array('Credit / Financing', 'credit'), array('Bond / Securities', 'bond'), array('Irrevocable LC', 'letterOfCredit'),
    array('Bank Guarantee', 'guarantee'), array('Other Facilities', 'otherFacilities')
);
echo '<div class="clk-row" style="margin-bottom:14px"><div class="clk-col w2">';
echo '<div class="clk-card"><div class="clk-tab">Contract Summary</div><div class="clk-card-b">' . clk_kv(array(
    array('Contract Number', clk_v(clk_a($ag, 'contractsNumber'))),
    array('Reporting Providers Number', clk_v(clk_a($ag, 'reportingProvidersNumber'))),
    array('Total Credit Limit', clk_num(clk_a($ag, 'totalCreditLimit'))),
    array('Total Potential Exposure', clk_num(clk_a($ag, 'totalPotentialExposure'))),
    array('Total Debit Balance', clk_num(clk_a($ag, 'totalDebitBalance'))),
    array('Total Overdue', clk_num(clk_a($ag, 'totalOverdue'))),
    array('Currency', clk_v(clk_lbl($dbc, clk_a($ag, 'currencyDesc'), 'M_CLK_DOMAIN_Currency', clk_a($ag, 'currency'))))
), 2) . '</div></div>';
echo '<div class="clk-card"><div class="clk-tab">Summary by Category and Phase</div><table class="clk-cat"><thead><tr><th>Contract Category</th><th>RQ</th><th>RF</th><th>RN</th><th>AC</th><th>CL</th></tr></thead><tbody>';
foreach ($cat as $cg) {
    $ns = clk_g($ch, $cg[1] . '/numbersSummary');
    echo '<tr><td>' . clk_h($cg[0]) . '</td><td>' . clk_num(clk_a($ns, 'requested')) . '</td><td>' . clk_num(clk_a($ns, 'refused')) . '</td><td>' . clk_num(clk_a($ns, 'renounced')) . '</td><td>' . clk_num(clk_a($ns, 'active')) . '</td><td>' . clk_num(clk_a($ns, 'closed')) . '</td></tr>';
}
echo '</tbody></table></div></div>';

// Financial Summary
$cA = clk_g($ch, 'credit/amountsSummary'); $bA = clk_g($ch, 'bond/amountsSummary');
$gA = clk_g($ch, 'guarantee/amountsSummary'); $lA = clk_g($ch, 'letterOfCredit/amountsSummary'); $oA = clk_g($ch, 'otherFacilities/amountsSummary');
// Catatan mapping: "Active Bank Guarantee" <- guarantee, "Active Guarantee" <- letterOfCredit (sample PDF bernilai 0, perlu verifikasi)
echo '<div class="clk-col"><div class="clk-card" style="height:100%"><div class="clk-tab">Financial Summary</div>'
    . clk_fin_group('Active Credits / Financing', clk_g($ch, 'credit/numbersSummary/active'), array(array('Credit Limit', clk_a($cA, 'creditLimit')), array('Debit Balance', clk_a($cA, 'debitBalance')), array('Overdue', clk_a($cA, 'overdue'))))
    . clk_fin_group('Active Bond / Securities', clk_g($ch, 'bond/numbersSummary/active'), array(array('Debit Balance', clk_a($bA, 'debitBalance')), array('Overdue', clk_a($bA, 'overdue'))))
    . clk_fin_group('Active Bank Guarantee', clk_g($ch, 'guarantee/numbersSummary/active'), array(array('Credit Limit', clk_a($gA, 'creditLimit')), array('Debit Balance', clk_a($gA, 'debitBalance'))))
    . clk_fin_group('Active Guarantee', clk_g($ch, 'letterOfCredit/numbersSummary/active'), array(array('Credit Limit', clk_a($lA, 'creditLimit')), array('Debit Balance', clk_a($lA, 'debitBalance'))))
    . clk_fin_group('Active Other Facilities', clk_g($ch, 'otherFacilities/numbersSummary/active'), array(array('Debit Balance', clk_a($oA, 'debitBalance')), array('Overdue', clk_a($oA, 'overdue'))))
    . '</div></div></div>';

/* ===================== CREDIT REPORT: SUBJECT DETAILS ===================== */
echo '<div class="clk-title">Credit Report</div><div class="clk-bar c">Subject Details</div><div class="clk-box">';
if (is_array($ms)) {
    foreach ($ms as $s) {
        $ind = clk_a($s, 'individual');
        if (!is_array($ind)) {
            echo clk_generic(clk_a($s, 'company'));
            continue;
        }
        echo '<div class="clk-h" style="margin-top:4px">Subject Data</div>' . clk_kv(array(
            array('CB Subject Code', clk_v(clk_a($s, 'cbsubjectCode'))),
            array('Provider Subject Number', clk_v(clk_g($ed, 'subject/providerSubjectNo'))),
            array('Last Update Date', clk_date(clk_a($ind, 'lastUpdateDate'))),
            array('Resident', clk_v(clk_lbl($dbc, clk_a($ind, 'residentDesc'), 'M_CLK_DOMAIN_Resident', clk_a($ind, 'resident')))),
            array('Name as ID', clk_v(clk_g($ind, 'individualName/nameAsId'))),
            array('Full Name', clk_v(clk_g($ind, 'individualName/fullName'))),
            array("Mother's Name", clk_v(clk_g($ind, 'individualName/mothersName'))),
            array('Gender', clk_v(clk_lbl($dbc, clk_a($ind, 'genderDesc'), 'M_CLK_DOMAIN_GenderType', clk_a($ind, 'gender')))),
            array('Date of Birth', clk_date(clk_g($ind, 'birthData/date'))),
            array('Place of Birth', clk_v(clk_g($ind, 'birthData/place'))),
            array('Marriage Status', clk_v(clk_lbl($dbc, clk_a($ind, 'marriageStatusDesc'), 'M_CLK_DOMAIN_MaritalStatus', clk_a($ind, 'marriageStatus')))),
            array('Educational Status', clk_v(clk_lbl($dbc, clk_a($ind, 'educationalStatusCodeDesc'), 'M_CLK_DOMAIN_StatusDegre', clk_a($ind, 'educationalStatusCode'))))
        ), 4);

        // Addresses
        echo '<div class="clk-h">Addresses</div>';
        $cur = array(); $his = array();
        $ah = clk_a($ind, 'addressHistory');
        if (is_array($ah)) foreach ($ah as $a) { if (clk_a($a, 'flagCurrent') == '1') $cur[] = $a; else $his[] = $a; }
        foreach ($cur as $a) echo clk_kv(array(array('Current Address', clk_addr($dbc, clk_a($a, 'address'), clk_a($a, 'addressDesc'))), array('Last Update Date', clk_date(clk_a($a, 'lastUpdateDate')))), 2);
        if ($his) {
            echo '<div class="clk-hist"><div class="clk-hist-t">Historical Address</div>';
            $i = 0;
            foreach ($his as $a) { $i++; echo clk_kv(array(array('#' . $i, clk_addr($dbc, clk_a($a, 'address'), clk_a($a, 'addressDesc'))), array('Last Update Date', clk_date(clk_a($a, 'lastUpdateDate')))), 2); }
            echo '</div>';
        }

        // Identification
        echo '<div class="clk-h">Identification Documents</div>';
        echo clk_kv(array(array('NPWP Value', clk_v(clk_g($ind, 'id/npwp'))), array('Last Update Date', clk_date(clk_g($ind, 'id/lastUpdateDate')))), 3);
        $ids = clk_a($ind, 'identificationCode');
        if (is_array($ids)) foreach ($ids as $d) {
            echo clk_kv(array(
                array('Identity Type', clk_v(clk_lbl($dbc, clk_g($d, 'identificationCodeDesc/identityTypeDesc'), 'M_CLK_DOMAIN_IdentityTypeSubjectType', clk_g($d, 'identificationCode/identityType')))),
                array('Identity Number', clk_v(clk_g($d, 'identificationCode/identityNumber'))),
                array('Last Update Date', clk_date(clk_a($d, 'lastUpdateDate')))
            ), 3);
        }

        // Contacts
        echo '<div class="clk-h">Contacts</div>';
        $cc = array(); $ch2 = array();
        $chh = clk_a($ind, 'contactHistory');
        if (is_array($chh)) foreach ($chh as $x) { if (clk_a($x, 'flagCurrent') == '1') $cc[] = $x; else $ch2[] = $x; }
        $fnC = function ($x) {
            return clk_kv(array(
                array('Phone Number', clk_v(clk_g($x, 'contacts/phoneNumber'))),
                array('Cell Phone Number', clk_v(clk_g($x, 'contacts/cellphoneNumber'))),
                array('Email Address', clk_v(clk_g($x, 'contacts/emailAddress'))),
                array('Last Update Date', clk_date(clk_a($x, 'lastUpdateDate')))
            ), 4);
        };
        foreach ($cc as $x) echo $fnC($x);
        if ($ch2) { echo '<div class="clk-hist"><div class="clk-hist-t">Historical Contacts</div>'; foreach ($ch2 as $x) echo $fnC($x); echo '</div>'; }

        // Employment
        echo '<div class="clk-h">Employment Data</div>';
        $ec = array(); $eh = array();
        $eHist = clk_a($ind, 'employmentDataHistory');
        if (is_array($eHist)) foreach ($eHist as $x) { if (clk_a($x, 'flagCurrent') == '1') $ec[] = $x; else $eh[] = $x; }
        $fnE = function ($x) use ($dbc) {
            return clk_kv(array(
                array('Occupation Code', clk_v(clk_lbl($dbc, clk_g($x, 'employmentDataDesc/occupationDesc'), 'M_CLK_DOMAIN_Job', clk_g($x, 'employmentData/occupationCode')))),
                array('Workplace', clk_v(clk_g($x, 'employmentData/workplace'))),
                array('Employer Sector Code', clk_v(clk_lbl($dbc, clk_g($x, 'employmentDataDesc/employerSectorDesc'), 'M_CLK_DOMAIN_EconomicSector', clk_g($x, 'employmentData/employerSector')))),
                array('Last Update Date', clk_date(clk_a($x, 'lastUpdateDate')))
            ), 4);
        };
        foreach ($ec as $x) echo $fnE($x);
        if ($eh) { echo '<div class="clk-hist"><div class="clk-hist-t">Historical Employment Data</div>'; foreach ($eh as $x) echo $fnE($x); echo '</div>'; }
    }
}
echo '</div>';

/* ===================== CONTRACT DETAILS ===================== */
$hasContract = false;
$blocks = array(
    array('Credit / Financing (Active, Closed, Closed in Advanced)', 'credit/grantedCredit', true),
    array('Credit / Financing (Requested, Refused, Renounced)', 'credit/notGrantedCredit', false),
    array('Bond / Securities (Active, Closed, Closed in Advanced)', 'bond/grantedBond', false),
    array('Bond / Securities (Requested, Refused, Renounced)', 'bond/notGrantedBond', false),
    array('Irrevocable LC (Active, Closed, Closed in Advanced)', 'letterOfCredit/grantedLetterOfCredit', false),
    array('Irrevocable LC (Requested, Refused, Renounced)', 'letterOfCredit/notGrantedCredit', false),
    array('Bank Guarantee (Active, Closed, Closed in Advanced)', 'guarantee/grantedGuarantee', false),
    array('Bank Guarantee (Requested, Refused, Renounced)', 'guarantee/notGrantedGuarantee', false),
    array('Other Facilities (Active, Closed, Closed in Advanced)', 'otherFacilities/grantedOtherFacilities', false),
    array('Other Facilities (Requested, Refused, Renounced)', 'otherFacilities/notGrantedOtherFacilities', false)
);
$out = '';
foreach ($blocks as $b) {
    $list = clk_g($ch, $b[1]);
    if (!is_array($list) || !$list) continue;
    $hasContract = true;
    $out .= '<div class="clk-h" style="font-size:16px">' . clk_h($b[0]) . '</div>';
    $n = 0;
    foreach ($list as $c) {
        $n++;
        if ($b[2]) $out .= '<div class="clk-box" style="margin-top:12px">' . clk_contract($dbc, $n, $c) . '</div>';
        else $out .= '<div class="clk-box">' . clk_generic($c) . '</div>';
    }
}
if ($hasContract) echo '<div class="clk-bar c" style="margin-top:20px">Contract Details</div><div class="clk-box">' . $out . '</div>';

/* ===================== NEGATIVE EVENTS / OTHER ===================== */
$extra = array(
    array('Negative Events', clk_a($cr, 'negativeEvents')),
    array('Account Receivables', clk_a($cr, 'accountReceivables')),
    array('Subject Additional Info', clk_a($cr, 'subjectAdditionalInfo'))
);
foreach ($extra as $e) {
    if (is_array($e[1]) && $e[1]) echo '<div class="clk-bar c" style="margin-top:20px">' . clk_h($e[0]) . '</div><div class="clk-box">' . clk_generic($e[1]) . '</div>';
}

/* ===================== FOOTPRINT ===================== */
$fp = clk_a($cr, 'footPrints');
echo '<div class="clk-bar c" style="margin-top:20px">Footprint</div><div class="clk-box"><div class="clk-h" style="margin-top:0">Number of Enquiries in the last months</div>'
    . clk_sec('Number of Enquiries in the last months', clk_kv(array(
        array('1 Month', clk_num(clk_a($fp, 'count1Month'))), array('3 Months', clk_num(clk_a($fp, 'count3Months'))),
        array('6 Months', clk_num(clk_a($fp, 'count6Months'))), array('12 Months', clk_num(clk_a($fp, 'count12Months')))
    ), 2));
$fpl = clk_a($fp, 'footPrint');
if (is_array($fpl) && $fpl) echo clk_generic($fpl);
echo '</div>';

/* ===================== INQUIRY ===================== */
$esub = clk_g($ed, 'subject/individual');
echo '<div class="clk-title">Inquiry</div><div class="clk-bar c">Subject Data</div><div class="clk-box">';
if (is_array($esub)) {
    echo '<div class="clk-card"><div class="clk-tab">Customer Data</div><div class="clk-card-b">' . clk_kv(array(
        array('Name as ID', clk_v(clk_g($esub, 'individualName/nameAsId'))),
        array('Full Name', clk_v(clk_g($esub, 'individualName/fullName'))),
        array("Mother's Name", clk_v(clk_g($esub, 'individualName/mothersName'))),
        array('Gender', clk_v(clk_lbl($dbc, clk_a($esub, 'genderDesc'), 'M_CLK_DOMAIN_GenderType', clk_a($esub, 'gender')))),
        array('Date of Birth', clk_date(clk_g($esub, 'birthData/date'))),
        array('Place of Birth', clk_v(clk_g($esub, 'birthData/place'))),
        array('Resident', clk_v(clk_lbl($dbc, clk_a($esub, 'residentDesc'), 'M_CLK_DOMAIN_Resident', clk_a($esub, 'resident')))),
        array('Marriage Status', clk_v(clk_lbl($dbc, clk_a($esub, 'marriageStatusDesc'), 'M_CLK_DOMAIN_MaritalStatus', clk_a($esub, 'marriageStatus')))),
        array('Educational Status', clk_v(clk_lbl($dbc, clk_a($esub, 'educationalStatusCodeDesc'), 'M_CLK_DOMAIN_StatusDegre', clk_a($esub, 'educationalStatusCode')))),
        array('Full Address', clk_addr($dbc, clk_g($esub, 'address/address'), clk_g($esub, 'address/addressDesc')))
    ), 1) . '</div></div>';
} else {
    echo '<div class="clk-card"><div class="clk-tab">Customer Data</div><div class="clk-card-b">' . clk_generic(clk_g($ed, 'subject/company')) . '</div></div>';
}
echo '<div class="clk-card"><div class="clk-tab">Application Details</div><div class="clk-card-b">' . clk_kv(array(
    array('CB Contract Code', clk_v(clk_g($R, 'applicationCodes/cbcontractCode'))),
    array('Contract Type', clk_v(clk_lbl($dbc, clk_a($appDesc, 'contractTypeDesc'), 'M_CLK_DOMAIN_ContractTypeCategory', clk_a($app, 'contractTypeCode')))),
    array('Contract Phase', clk_v(clk_lbl($dbc, clk_a($appDesc, 'contractPhaseDesc'), 'M_CLK_DOMAIN_ContractPhase', clk_a($app, 'contractPhase')))),
    array('Requested Date', $reqDate),
    array('Application Amount', clk_num(clk_a($cred, 'applicationAmount'))),
    array('Due Date', clk_date(clk_a($cred, 'dueDate'))),
    array('Role', clk_v(clk_lbl($dbc, clk_g($ed, 'linkDesc/roleDesc'), 'M_CLK_DOMAIN_Role', clk_g($ed, 'link/role')))),
    array('Company Role', clk_v(clk_g($ed, 'linkDesc/companyRoleDesc'))),
    array('Account Number', clk_v(clk_g($R, 'applicationCodes/providerApplicationNo'))),
    array('Currency', clk_v(clk_a($app, 'currency'))),
    array('Original Agreement Number', clk_v(clk_a($cred, 'originalAgreementNumber'))),
    array('Original Agreement Date', clk_date(clk_a($cred, 'originalAgreementDate')))
), 1) . '</div></div>';
echo '<div class="clk-card"><div class="clk-tab">Identification</div><div class="clk-card-b">' . clk_kv(array(
    array('Identity Type', clk_v(clk_lbl($dbc, clk_g($esub, 'identificationCode/identificationCodeDesc/identityTypeDesc'), 'M_CLK_DOMAIN_IdentityTypeSubjectType', clk_g($esub, 'identificationCode/identificationCode/identityType')))),
    array('Identity Number', clk_v(clk_g($esub, 'identificationCode/identificationCode/identityNumber'))),
    array('NPWP / Tax Registration Number', clk_v(clk_g($esub, 'id/npwp')))
), 1) . '</div></div>';
echo '<div class="clk-card"><div class="clk-tab">Contacts</div><div class="clk-card-b">' . clk_kv(array(
    array('Phone Number', clk_v(clk_g($esub, 'contact/phoneNumber'))),
    array('Cell Phone Number', clk_v(clk_g($esub, 'contact/cellphoneNumber'))),
    array('Email Address', clk_v(clk_g($esub, 'contact/emailAddress')))
), 1) . '</div></div>';
echo '</div></div>';
		}
?>
</div>
</div>
</div>
</div>