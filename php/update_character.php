<?php
/*
  Author:   Robert Zaranek
  Date:     December 13, 2020

  Purpose:  Updates a specified Character within the database 
            and returns an updated list of Characters.
*/

session_start();

if (isset($_SESSION["user"])) {
    include "connect.php";

    $char_id = filter_input(INPUT_GET, "char_id", FILTER_VALIDATE_INT);
    $char_name = filter_input(INPUT_GET, "char_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $char_race = filter_input(INPUT_GET, "char_race", FILTER_SANITIZE_SPECIAL_CHARS);
    $char_class = filter_input(INPUT_GET, "char_class", FILTER_SANITIZE_SPECIAL_CHARS);
    $char_notes = filter_input(INPUT_GET, "char_notes", FILTER_SANITIZE_SPECIAL_CHARS);

    if (
        $char_id !== null && $char_id !== false && $char_id >= 0 &&
        $char_name !== null && $char_name !== "" && strlen($char_name) <= 60 &&
        $char_race !== null && $char_race !== "" && strlen($char_race) <= 40 &&
        $char_class !== null && $char_name !== "" && strlen($char_class) <= 40 &&
        $char_notes !== null
    ) {
        $command = "UPDATE characters SET char_name = ?, char_race = ?, char_class = ?, char_notes = ? WHERE char_id = ?";
        $stmt = $dbh->prepare($command);
        $params = [$char_name, $char_race, $char_class, $char_notes, $char_id];
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
