<?php
/*
  Author:   Robert Zaranek
  Date:     December 10, 2020

  Purpose:  Verifies that the current user exists in the database.
*/

session_start();
include "connect.php";

$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$login = filter_input(INPUT_GET, 'login', FILTER_VALIDATE_BOOLEAN);

$errorCode = -1;
$command = "SELECT username, password FROM users WHERE username = ?";
$stmt = $dbh->prepare($command);
$params = [$username];
$success = $stmt->execute($params);

if (
    $username !== null && $username !== "" && strlen($username) <= 40 &&
    $password !== null && $password !== "" && strlen($password) <= 60
) {
    if ($success) {
        $row = $stmt->fetch();
        if ($row !== false) {
            if (password_verify($password, $row['password'])) {
                if ($login === true) {
                    $_SESSION["user"] = $username;
                }
                $errorCode = 0;     // Success
                echo json_encode($errorCode);
            } else {
                $errorCode = -1;    // Wrong Password
                echo json_encode($errorCode);
            }
        } else {
            $errorCode = -2;    // No such user found
            echo json_encode($errorCode);
        }
    } else {
        $errorCode = -3;        // SQL execution failure
        echo json_encode($errorCode);
    }
} else {
    $errorCode = -4;        // Invalid parameters
    echo json_encode($errorCode);
}
