<?php

/*
  Author:   Robert Zaranek
  Date:     December 10, 2020

  Purpose:  The main page for the 'Robert's Cauldron of Characters' web application.
*/

session_start();

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Robert's Cauldron of Characters</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='js/jquery-3.5.1.min.js'></script>
    <script src='js/sound.js'></script>
    <script src='js/cauldron.js'></script>
    <link href="css/cauldronstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
    <main>
        <div id="left_chain"></div>
        <div id="right_chain"></div>
        <?php
        if (isset($_SESSION["user"])) {
            echo "<h1>" . (string)$_SESSION["user"] . "'s Cauldron of Characters</h1>";
        ?>
            <h3>Your characters await!</h3>
            <div id='main'>
                <form id="main_form">
                    <input type="text" id="char_name" placeholder="Name" size='15' maxlength="60" required>
                    <input type="text" id="char_race" placeholder="Race" size='15' maxlength="40" required>
                    <input type="text" id="char_class" placeholder="Class" size='15' maxlength="40" required>
                    <textarea id="char_notes" placeholder="Character Notes" rows="4" cols="35"></textarea>
                    <br>
                    <input type="submit" id='submit_button' value="Add Character">
                    <img src='img/remove.png' id='cancel_edit_button'>
                </form>
                <h3 id="error_message"></h3>
                <ul id='main_list'></ul>
            </div>
        <?php
        } else {
        ?>
            <script>
                window.location.replace("index.php");
            </script>
        <?php } ?>
    </main>
    <input type="button" id="logout_button" value="Log Out">
</body>

</html>