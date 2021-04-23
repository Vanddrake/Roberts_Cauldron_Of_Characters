<?php
/*
  Author:   Robert Zaranek
  Date:     December 10, 2020

  Purpose:  Returns the list of Characters that the current
            user has in the database.
*/

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["user"])) {
    include "connect.php";
    include "character.php";

    $characters = [];
    $command = "SELECT char_id, char_name, char_race, char_class, char_notes, used FROM characters WHERE user = ? ORDER BY used, char_id DESC";
    $stmt = $dbh->prepare($command);
    $params = [$_SESSION["user"]];
    $success = $stmt->execute($params);

    if ($success) {
        while ($row = $stmt->fetch()) {
            $character = new Character(
                $row["char_id"],
                $row["char_name"],
                $row["char_race"],
                $row["char_class"],
                $row["char_notes"],
                $row["used"]
            );
            $idArray = [
                $character->getID(), $character->getName(), $character->getRace(),
                $character->getClass(), $character->getNotes(), $character->isUsed()
            ];
            array_push($characters, $idArray);
        }
        echo json_encode($characters);
    } else {
        echo json_encode(-3);    // SQL execution failure
    }
} else {
    echo json_encode(-2);    // No session found (No such user found)
}
