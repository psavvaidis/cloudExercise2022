<?php
session_start();
$data = [];
include("dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM users WHERE username = ? and userpassword= ?;";
  $sqlu = "SELECT * FROM users WHERE username = ?;";
  $sqlp = "SELECT * FROM users WHERE userpassword =?;";
  if ($stmt = $mysqli->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
    $param_username = $username;
    $param_password = $password;

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
      /* store result */// Note: change to $result->...!
      $stmt->store_result();
      $stmt->bind_result($id, $surname, $name, $upassword, $uname, $email, $role, $confirmed); // number of arguments must match columns in SELECT

    }

    if ($stmt1 = $mysqli->prepare($sqlu)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt1, "s", $param_username1);
      $param_username1 = $username;


      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt1)) {
        /* store result */
        mysqli_stmt_store_result($stmt1);
      }
    }
    if ($stmt2 = $mysqli->prepare($sqlp)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt2, "s", $param_password2);
      $param_password2 = $password;

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt2)) {
        /* store result */
        mysqli_stmt_store_result($stmt2);
      }
    }

    if (mysqli_stmt_num_rows($stmt1) > 0 && mysqli_stmt_num_rows($stmt2) == 0) {
      var_dump(http_response_code(403));
      echo "Wrong password";
    } elseif (mysqli_stmt_num_rows($stmt) > 0) {
      $stmt->fetch();
      $_SESSION['id'] = $id;
      $_SESSION['username'] = $uname;
      $_SESSION['surname'] = $surname;
      $_SESSION['role'] = $role;
      $_SESSION['email'] = $email;
      $_SESSION['confirmed'] = $confirmed;
      //print_r($_SESSION);
      if ($_SESSION['confirmed'] == "0") {
        echo "{\"errorm\":\"User Not Yet Confirmed\"}";
        exit();
      }
      echo "{\"message\":\"User exists\"}";
    } else {
      echo "{\"errormsg\":\"Invalid Username or Password\"}";
    }

    // Close statement
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
  } else {
    var_dump(http_response_code(401));
    $data['message'] = "METHOD NOT UNDERSTOOD";
    echo json_encode($data);
  }
  // mysqli_close($mysqli);
}

?>