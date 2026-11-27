<?php
// Path file JSON
require_once("config/connection.php");
$prospect_no = $_GET['prospect_no'];
$id_no = $_GET['id_no'];

$callCust = "{call SP_GET_CLICK_DATA_JSON(?,?)}";
$paramsCust = array(array($prospect_no, SQLSRV_PARAM_IN), array($id_no, SQLSRV_PARAM_IN));

$execCust = sqlsrv_query($conn, $callCust, $paramsCust) or die(print_r(sqlsrv_defaults(), true));
$dataCust = sqlsrv_fetch_array($execCust);



$filePath = $dataCust['JSON_FILE'];

// Cek apakah file ada
// Baca konten JSON

$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

$jsoncontent = file_get_contents(
    $filePath,
    false,
    stream_context_create($arrContextOptions)
);

// Decode JSON menjadi array
$jsonData = json_decode($jsoncontent, true);


function renderJson($data)
{
    echo "<ul class='json-list'>";
    foreach ($data as $key => $value) {
        if (is_array($value) || is_object($value)) {
            echo "<li><button class='collapsible'>" . htmlspecialchars($key) . "</button>";
            echo "<div class='content1'>";
            renderJson($value);
            echo "</div></li>";
        } else {
            echo "<li><strong>" . htmlspecialchars($key) . ":</strong> <span class='json-value'>" . htmlspecialchars($value) . "</span></li>";
        }
    }
    echo "</ul>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        ul.json-list {
            list-style-type: none;
            padding-left: 20px;
            margin: 0;
        }

        li {
            margin-bottom: 10px;
        }

        .collapsible {
            background-color: #ddd;
            color: black;
            padding: 8px;
            width: 100%;
            border: none;
            text-align: left;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .active,
        .collapsible:hover {
            background-color: #ccc;
        }

        .content1 {
            display: none;
            padding-left: 20px;
            background-color: #f9f9f9;
            margin-bottom: 5px;
        }

        .json-value {
            display: inline-block;
            margin-left: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <?php renderJson($jsonData); ?>
    </div>

    <script>
        var coll = document.getElementsByClassName("collapsible");

        for (var i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content1 = this.nextElementSibling;
                // Toggle display of the content1 div

                if (content1.style.display === "block") {
                    content1.style.display = "none";
                } else {
                    content1.style.display = "block";
                }
            });
        }
    </script>

</body>

</html>