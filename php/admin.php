<?php

include("dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $res = mysqli_query($mysqli, "SELECT * FROM cloud.users;");
    while ($obj = mysqli_fetch_array($res)) {
        $res_array[] = $obj;
    }
    echo json_encode($res_array);
} else {
    echo "{\"message\":\"Problem\"}";
}





?>