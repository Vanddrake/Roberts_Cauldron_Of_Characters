<?php
/*
  Author:   Robert Zaranek
  Date:     December 10, 2020

  Purpose:  Updates a specified Character in the database, changing it to either used or unused.
            Then returns an updated list of Characters.
*/

session_start();

if (isset($_SESSION["user"])) {
    include "connect.php";

    $char_id = filter_input(INPUT_GET, "char_id", FILTER_VALIDATE_INT);
    $used = filter_input(INPUT_GET, "used", FILTER_VALIDATE_INT);

    if (
        $char_id !== null && $char_id !== false && $char_id >= 0 &&
        $used !== null && $used !== false && ($used === 0 || $used === 1)
    ) {
        $command = "UPDATE characters SET used = ? WHERE char_id = ?";
        $stmt = $dbh->prepare($command);
        $params = [$used, $char_id];
        $success = $stmt->execute($params);

        if ($success) {
            include "get_list.php";
        } else {
            echo json_encode(-3);    // SQL execution failure
        }
    } else {
        echo json_encode(-4);    // Invalid parameters
    }
} else {
    echo json_encode(-2);    // No session found (No such user found)
}
