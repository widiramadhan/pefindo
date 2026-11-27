<?php
require_once("config/configuration.php");
require_once("config/connection.php");

/* Stored procedure call */
$callsp1 = "{CALL SP_DACOR_RAK_ACTIVITY()}";
$exec1   = sqlsrv_query($conn_afa_prod, $callsp1);

if ($exec1 === false) {
    die(print_r(sqlsrv_errors(), true));
}

/* Fetch all rows */
$data_afa = array();
while ($row = sqlsrv_fetch_array($exec1, SQLSRV_FETCH_ASSOC)) {
    $data_afa[] = $row;
}

/* GET param */
$user = isset($_GET['USERNAME']) ? $_GET['USERNAME'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $dakorid   = isset($_POST['dakorid']) ? $_POST['dakorid'] : null;
    $reffno    = isset($_POST['reffno']) ? $_POST['reffno'] : null;
    $app_no    = isset($_POST['app_no']) ? $_POST['app_no'] : null;
    $notes     = isset($_POST['notes']) ? $_POST['notes'] : null;
    $namadakor = isset($_POST['nama_dakor']) ? $_POST['nama_dakor'] : null;
    $source    = 'RAK';

    $params = array(
        $user,
        $reffno,
        $notes,
        $dakorid,
        $namadakor,
        $source
    );

    $sql = "{CALL SP_INSERT_DACOR_VERIF(?,?,?,?,?,?)}";
    $execInsert = sqlsrv_query($conn_afa_prod, $sql, $params);

    if ($execInsert === false) {
        $errorMessage = "Gagal menyimpan data: " . print_r(sqlsrv_errors(), true);
    } else {

        $datates = array();
        while ($row = sqlsrv_fetch_array($execInsert, SQLSRV_FETCH_ASSOC)) {
            $datates = $row;
        }

        $afa_id = isset($datates['TR_AFA_ID']) ? $datates['TR_AFA_ID'] : null;
        $successMessage = "Data berhasil disimpan!";

        echo "<script>
            window.location='https://access.sfi.co.id//afa/dacor/form_mos_verif/"
            . $user . "/" . $reffno . "/" . $dakorid . "/" . $afa_id .
        "'
        </script>";
        exit;
    }

    
}
?>

<style>
.btn-primary[disabled] {
    opacity: 1;
    background-color: #337ab7;
    border-color: #2e6da4;
    color: #fff;
}
</style>


<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

<link href="assets/css/bootstrap.min.css" rel="stylesheet" />

<body style="background:#f8f9fa;">

<div class="container-fluid" style="margin-top:40px;">
    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-body">

                    <h4 style="margin-bottom:20px;">Dakor RAK & Confins</h4>

                    <?php if (!empty($successMessage)) { ?>
                        <div class="alert alert-success">
                            <?php echo $successMessage; ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty($errorMessage)) { ?>
                        <div class="alert alert-danger">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php } ?>

                    <form method="post">

                        <div class="form-group">
                            <label for="dakor1">Pilih Dakor</label>
                            <select class="form-control" id="dakor1" name="dakorid">
                                <option value="">-- Pilih Dakor --</option>
                                <?php foreach ($data_afa as $row) { ?>
                                    <option
                                        value="<?php echo $row['M_AKTIVITAS_ID']; ?>"
                                        data-nama="<?php echo $row['NAMA_AKTIVITAS']; ?>">
                                        <?php echo $row['NAMA_AKTIVITAS']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="nama_dakor" id="nama_dakor" />
                        </div>

                        <div id="trigger-orderno" class="form-group" style="display:none;">
                            <label>Order No</label>
                            <input id="reff-orderno" type="text" class="form-control">
                        </div>

                        <div id="trigger-appno" class="form-group" style="display:none;">
                            <label>Nomor Aplikasi</label>
                            <input id="reff-appno" type="text" class="form-control">
                        </div>

                        <div id="trigger-nokon" class="form-group" style="display:none;">
                            <label>Nomor Kontrak</label>
                            <input id="reff-nokon" type="text" class="form-control">
                        </div>

                        <div id="customer-no" class="form-group" style="display:none;">
                            <label>Nomor Customer</label>
                            <input id="reff-custno" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Catatan:</label>
                            <textarea name="notes" class="form-control"></textarea>
                        </div>

                        <button
                            class="btn btn-primary"
                            style="margin-top:20px;"
                            disabled
                            id="submit-btn"
                            type="submit">
                            Submit Dakor
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>




<script>
    const dakor = document.getElementById('dakor1');
    const submitBtn = document.getElementById('submit-btn');  

    const fields = {
        order: document.getElementById('trigger-orderno'),
        app: document.getElementById('trigger-appno'),
        nokon: document.getElementById('trigger-nokon'),
        cust: document.getElementById('customer-no'),
    };

    const inputs = {
        order: document.getElementById('reff-orderno'),
        app: document.getElementById('reff-appno'),
        nokon: document.getElementById('reff-nokon'),
        cust: document.getElementById('reff-custno'),
    };

    function reset() {
        Object.values(fields).forEach(f => f.style.display = 'none');
        Object.values(inputs).forEach(i => {
            i.removeAttribute('name');
            i.value = '';
        });
    }

    dakor.addEventListener('change', function () {
        reset();

        if (['713','380','617','372','366'].includes(this.value)) {
            fields.order.style.display = 'block';
            inputs.order.name = 'reffno';
            submitBtn.disabled = false;
        }
        else if (['531','99','537'].includes(this.value)) {
            fields.app.style.display = 'block';
            inputs.app.name = 'reffno';
            submitBtn.disabled = false;
        }
        else if (this.value === '572') {
            fields.cust.style.display = 'block';
            inputs.cust.name = 'reffno';
            submitBtn.disabled = false;
        }
        else if (['620','530','53','54','112','85','592','90','621','610'].includes(this.value)) {
            fields.nokon.style.display = 'block';
            inputs.nokon.name = 'reffno';
            submitBtn.disabled = false;
        }
        // else{
        //     submitBtn.disabled = true;
        // }

        const selectedOption = this.options[this.selectedIndex]; 
        const nama = selectedOption.getAttribute('data-nama') || ''; 
        document.getElementById('nama_dakor').value = nama; 
    });

    
 </script>


</body>
