<?php

use Mpdf\Tag\Pre;
use phpDocumentor\Reflection\Element;

function sanitizeInput($input)
{
	# hanya mengizinkan alphanumeric, titik, underscore, strip dan spasi.
	return preg_replace("/[^a-zA-Z0-9._,\s-]+/", "", trim($input));
}

$prospect_no = sanitizeInput($_POST['prospect_no']);
$order_no    = sanitizeInput($_POST['order_no']);
$user        = sanitizeInput($_GET['USERNAME']);

# Data Company dan Pengurus

// // $call = "{call CPY_PEFINDO_GETDATA_PEMEGANG_SAHAM(?,?)}";
// // $param = array(array($prospect_no, SQLSRV_PARAM_IN), array('1', SQLSRV_PARAM_IN));

$call = "{call CPY_PEFINDO_GETDATA_PEMEGANG_SAHAM_BY_ORDER(?)}";
$param = array(array($order_no, SQLSRV_PARAM_IN));
$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));


if (isset($_POST['db_action']) && $_POST['db_action'] == 'DELETE_STAKEHOLDER') {
    // // $cust_id = sanitizeInput($_POST['cust_id']);
    $nik     = sanitizeInput($_POST['nik']);

    // // $callDeleteStakeholder  = "{call CPY_PEFINDO_DELETE_PENGURUS(?, ?, ?, ?)}";
    $callDeleteStakeholder  = "{call CPY_PEFINDO_DELETE_PENGURUS_BY_ORDER(?, ?, ?)}";
    $paramDeleteStakeholder = array(
        array($order_no, SQLSRV_PARAM_IN),
        // // array($cust_id, SQLSRV_PARAM_IN),
        array($nik, SQLSRV_PARAM_IN),
        array($user, SQLSRV_PARAM_IN)
    );

    $execDeleteStakeholder = sqlsrv_query($conn, $callDeleteStakeholder, $paramDeleteStakeholder) or die(print_r(sqlsrv_errors(), true));

    if ($execDeleteStakeholder) {
        echo "<script>alert('Data Berhasil Dihapus');</script>";

        # delete existing file
        $dir = "assets/ktp/"; // karena yang dapat dihapus hanya stakeholder / pemegang saham
        while ($unusedFiles = sqlsrv_fetch_array($execDeleteStakeholder)) {
            unlink($dir . $unusedFiles['FILE_SRC']);
        }

        # refresh data 
        $exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));

        # set menjadi edit state
        $_POST['action'] = 'ACTION_EDIT';
    } else {
        echo "<script>alert('Data Gagal Dihapus');history.back();</script>";
    }
}

# ACTION_CHECK | ACTION_EDIT #
$action = (isset($_POST['action']) && $_POST['action'] == 'ACTION_EDIT') ? 'ACTION_EDIT' : 'ACTION_CHECK';

# ENABLE BUTTON DOWNLOAD
$show_dukcapil_result = 0;

# HIDE COMPANY
$is_company_visible = (isset($_POST['company_visible']) && $_POST['company_visible'] == '0') ? false : true;

?>
<style>
    .th-custom {
        text-align: center;
        vertical-align: middle;
        font-weight: bold;
        background-color: #035c7a;
    }

    .td-custom {
        text-align: center;
        vertical-align: middle;
    }

    td {
        padding-right: 10px;
    }

    ​
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title"><b><?php echo $order_no; ?></b></h4>
                <p class="category">Data Order berdasarkan nomor yang dipilih</p>
            </div>
            <hr>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <b>DATA PERUSAHAAN :</b>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">NOMOR IDENTITAS</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA PT & PENGURUS</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL PENDIRIAN & LAHIR</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">TEMPAT PENDIRIAN & LAHIR</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">TIPE</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    while ($data = sqlsrv_fetch_array($exec)) :
                                        if ($data['IS_DELETE'] == 0) :
                                            $i++;
                                    ?>
                                            <?php if ($data['STAKEHOLDER_TYPE'] == 'C' && $is_company_visible) : ?>

                                                <tr>
                                                    <td class="td-custom"><?php echo $i; ?></td>
                                                    <td class="td-custom"><?php echo htmlentities($data['ID_NO'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td class="td-custom"><?php echo htmlentities($data['STAKEHOLDER_NAME'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td class="td-custom">
                                                        <?php if ($data['ACK_DT'] <> '') {
                                                            $est = $data['ACK_DT']->format('d-m-Y');
                                                        } else {
                                                            $est = "-";
                                                        }
                                                        echo $est; ?>
                                                    </td>
                                                    <td class="td-custom"><?php echo $data['ACK_PLACE']; ?></td>
                                                    <td class="td-custom"><?php echo 'PERUSAHAAN'; ?></td>
                                                    <td class="td-custom">
                                                        <table align="center">
                                                            <tr>
                                                                <?php if ($action == 'ACTION_EDIT') : ?>
                                                                    <td>
                                                                        <form action="index.php?page=company-edit&USERNAME=<?php echo $user; ?>" method="post">
                                                                            <input type="hidden" name="prospect_no" value="<?php echo $prospect_no; ?>">
                                                                            <input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
                                                                            <input type="hidden" name="action" value="<?php echo $action; ?>">
                                                                            <button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-pencil-square-o"></i> EDIT</button>
                                                                        </form>
                                                                    </td>
                                                                <?php elseif ($action == 'ACTION_CHECK') : ?>
                                                                    <td>
                                                                        <form action="index.php?page=company-edit&USERNAME=<?php echo $user; ?>" method="post">
                                                                            <input type="hidden" name="prospect_no" value="<?php echo $prospect_no; ?>">
                                                                            <input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
                                                                            <input type="hidden" name="action" value="<?php echo $action; ?>">
                                                                            <button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-search"></i> CEK DATA</button>
                                                                        </form>
                                                                    </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                            <?php elseif ($data['STAKEHOLDER_TYPE'] == 'P') : ?>
                                                
                                                <tr>
                                                    <td class="td-custom"><?php echo $i; ?></td>
                                                    <td class="td-custom"><?php echo htmlentities($data['ID_NO'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td class="td-custom"><?php echo htmlentities($data['STAKEHOLDER_NAME'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td class="td-custom">
                                                        <?php if ($data['ACK_DT'] <> '') {
                                                            $est = $data['ACK_DT']->format('d-m-Y');
                                                        } else {
                                                            $est = "-";
                                                        }
                                                        echo $est; ?>
                                                    </td>
                                                    <td class="td-custom"><?php echo $data['ACK_PLACE']; ?></td>
                                                    <td class="td-custom">
                                                        <?php echo (!is_null($data['SEQ_ID']) && $data['SEQ_ID'] != "0") ? 'PENGURUS ' . $data['SEQ_ID'] : 'PENGURUS'; ?>
                                                    </td>
                                                    <td class="td-custom">
                                                        <table align="center">
                                                            <tr>
                                                                <?php if ($action == 'ACTION_EDIT') : ?>
                                                                    <td>
                                                                        <form action="index.php?page=input-company-pengurus&USERNAME=<?php echo $user; ?>" method="post">
                                                                            <input type="hidden" name="prospect_no" value="<?php echo $prospect_no; ?>">
                                                                            <input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
                                                                            <input type="hidden" name="nik" value="<?php echo htmlentities($data['ID_NO'], ENT_QUOTES, 'UTF-8'); ?>">
                                                                            <button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-pencil-square-o"></i> EDIT</button>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <form action="" method="post">
                                                                            <input type="hidden" name="prospect_no" value="<?php echo $prospect_no; ?>">
                                                                            <input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
                                                                            <input type="hidden" name="nik" value="<?php echo htmlentities($data['ID_NO'], ENT_QUOTES, 'UTF-8'); ?>">
                                                                            <input type="hidden" name="db_action" value="DELETE_STAKEHOLDER">
                                                                            <button type="submit" class="btn btn-custom btn-xs" onclick="return confirm('Apakah anda yakin? data yang sudah dihapus tidak bisa dikembalikan.')"><i class="fa fa-trash"></i> DELETE</button>
                                                                        </form>
                                                                    </td>
                                                                <?php endif; ?>

                                                                <?php if ($action == 'ACTION_CHECK') : ?>
                                                                    <?php if ($data['HAS_FILE'] == 1) : ?>
                                                                        <td>
                                                                            <form action="index.php?page=company-stakeholder-check&USERNAME=<?php echo $user; ?>" method="post">
                                                                                <input type="hidden" name="prospect_no" value="<?php echo $order_no; // <- Menggunakan nomor order ?>">
                                                                                <input type="hidden" name="cust_id" value="<?php echo $data['CUST_ID']; ?>">
                                                                                <input type="hidden" name="no_ktp" value="<?php echo htmlentities($data['ID_NO'], ENT_QUOTES, 'UTF-8'); ?>">
                                                                                <input type="hidden" name="name" value="<?php echo htmlentities($data['STAKEHOLDER_NAME'], ENT_QUOTES, 'UTF-8'); ?>">
                                                                                <input type="hidden" name="date" value="<?php echo $est; ?>">
                                                                                <input type="hidden" name="birth_place" value="<?php echo $data['ACK_PLACE']; ?>">
                                                                                <input type="hidden" name="alamat" value="<?php echo $data['CURRENT_ADDRESS']; ?>">
                                                                                <button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-search"></i> CEK DATA</button>
                                                                            </form>
                                                                        </td>
                                                                    <?php else : ?>
                                                                        <td>
                                                                            <form action="index.php?page=input-company-pengurus&USERNAME=<?php echo $user; ?>" method="post">
                                                                                <input type="hidden" name="prospect_no" value="<?php echo $prospect_no; ?>">
                                                                                <input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
                                                                                <input type="hidden" name="nik" value="<?php echo htmlentities($data['ID_NO'], ENT_QUOTES, 'UTF-8'); ?>">
                                                                                <input type="hidden" name="action" value="ACTION_CHECK">
                                                                                <button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-pencil-square-o"></i> UPLOAD KTP</button>
                                                                            </form>
                                                                        </td>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                            <?php endif; ?>
                                    <?php endif;

                                        # FOR BUTTON DOWNLOAD
                                        $show_dukcapil_result = ($data['IS_ALL_CHECKED'] == 1);

                                        # FOR BUTTON ADD STAKEHOLDER
                                        $show_add_stakeholder = true; // ($data['IS_FILE_COMPLETE'] == 0);
                                        endwhile;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">

                        <?php if ($i > 0) : ?>
                            <table>
                                <tr>
                                    <?php if ($action == 'ACTION_EDIT') : ?>
                                        <?php if ($show_add_stakeholder) : ?>
                                            <td>
                                                <form action="index.php?page=input-company-pengurus&USERNAME=<?php echo $user; ?>" method="post">
                                                    <input type="hidden" name="prospect_no" value="<?php echo $prospect_no; ?>">
                                                    <input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
                                                    <button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-pencil-square-o"></i> ADD DATA</button>
                                                </form>
                                            </td>
                                        <?php else : ?>
                                            <td>
                                                <form action="javascript:void(0);">
                                                    <button class="btn btn-custom btn-xs disabled"><i class="fa fa-pencil-square-o"></i> ADD DATA</button>
                                                </form>
                                            </td>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if ($action == 'ACTION_CHECK') : ?>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="prospect_no" value="<?php echo $prospect_no; ?>">
                                                <input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
                                                <input type="hidden" name="action" value="ACTION_EDIT">
                                                <button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-pencil-square-o"></i> EDIT DATA</button>
                                            </form>
                                        </td>
                                        
                                        <?php if ($show_dukcapil_result == 1) : ?>
                                            <td>
                                                <form action="cetak-hasil-dukcapil.php?USERNAME=<?php echo $user; ?>" method="post" target="_blank">
                                                    <input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
                                                    <button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-download"></i> HASIL DUKCAPIL</button>
                                                </form>
                                            </td>
                                        <?php else : ?>
                                            <td>
                                                <form action="javascript:void(0);">
                                                    <button class="btn btn-custom btn-xs disabled"><i class="fa fa-download"></i> HASIL DUKCAPIL</button>
                                                </form>
                                            </td>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </tr>
                            </table>
                        <?php endif; ?>

                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-12">
                        <table align="right">
                            <tr>
                                <?php if ($action == 'ACTION_EDIT') : ?>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="prospect_no" value="<?php echo $prospect_no; ?>">
                                            <input type="hidden" name="order_no" value="<?php echo $order_no; ?>">
                                            <input type="hidden" name="action" value="ACTION_CHECK">
                                            <input type="hidden" name="company_visible" value="0">
                                            <button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-check"></i>FINISH EDIT</button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </div>
                </div>

                <br><br>
            </div>
        </div>
    </div>
</div>