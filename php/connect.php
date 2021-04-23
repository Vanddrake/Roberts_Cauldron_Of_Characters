<?php
try {
    $dbh = new PDO(
        "mysql:host=localhost;dbname=myDb",
        "root",
        ""
    );
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
