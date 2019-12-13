<?php
ini_set('max_execution_time', 900); //300 seconds 
if (isset($_POST)) {
    $host = $_POST["host"];
    $dbuser = $_POST["dbuser"];
    $dbpassword = $_POST["dbpassword"];
    $dbname = $_POST["dbname"];

    //check required fields
    if (!($host && $dbuser && $dbname)) {
        echo json_encode(array("success" => false, "message" => "Please input all fields correctly."));
        exit();
    }

    //check for valid database connection

    $mysqli = @new mysqli($host, $dbuser, $dbpassword, $dbname);
    if (mysqli_connect_errno()) {
        echo json_encode(array("success" => false, "message" => $mysqli->connect_error));
        exit();
    }


    $sql = file_get_contents("update.sql");

    $mysqli->multi_query($sql);
    do {

    } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
    $mysqli->close();

    echo json_encode(array("success" => true, "message" => "Installation successfull."));
    exit();
}

