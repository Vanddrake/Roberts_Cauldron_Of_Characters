<?php
/*
  Author:   Robert Zaranek
  Date:     December 10, 2020

  Purpose:  Creates a new user if a user with the same username
            does not currently exist.
*/

include "verify_user.php";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

if ($errorCode === -2) {
  $command = "INSERT into users (username, password) VALUES (?, ?)";
  $stmt = $dbh->prepare($command);
  $params = [$username, $hashedPassword];
  $success = $stmt->execute($params);
}
