<?php

include("dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = "UPDATE users SET CONFIRMED = 1 WHERE ID = " . $id . ";";
        $res = mysqli_query($mysqli, $query);
        if ($res) {
            $data["message"] = "success";
            echo json_encode($data);
            exit();
        }
        echo mysqli_error($mysqli);
        exit(1);
    }
    $error["error"] = "No id passed";
    echo json_encode($error);
    exit(1);
}
echo "Something went wrong";
?>