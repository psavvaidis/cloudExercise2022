<?php
session_start();
include("dbconnect.php");

$query = "SELECT p.ID as pId, p.NAME AS pName, PRODUCTCODE, PRICE, CATEGORY, DATE(DATEOFWITHDRAWAL) AS DATEOFWITHDRAWAL
            FROM cloud.products p 
            WHERE p.SELLERID = ".$_SESSION['id'].";";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $res = mysqli_query($mysqli, $query);

    while ($row = mysqli_fetch_array($res)) {
        $products[] = $row;
    }
    echo json_encode($products);
} else {
    echo "{\"message\":\"Problem\"}";
}
?>