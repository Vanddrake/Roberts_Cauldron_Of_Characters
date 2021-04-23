<?php
/*
  Author:   Robert Zaranek
  Date:     December 10, 2020

  Purpose:  Logs the user out and returns true if successful.
*/

session_start();
session_unset();
session_destroy();

if (isset($_SESSION["user"])) {
  echo json_encode(false);
} else {
  echo json_encode(true);
}
