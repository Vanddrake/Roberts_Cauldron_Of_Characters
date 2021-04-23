<?php

/*
  Author:   Robert Zaranek
  Date:     December 10, 2020

  Purpose:  The login page for the 'Robert's Cauldron of Characters' web application.
*/

session_start();

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Login - Robert's Cauldron of Characters</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='js/jquery-3.5.1.min.js'></script>
    <script src='js/sound.js'></script>
    <script src='js/cauldronlogin.js'></script>
    <link href="css/cauldronstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
    <main>
        <div id="left_chain"></div>
        <div id="right_chain"></div>
        <?php
        if (isset($_SESSION["user"])) {
        ?>
            <script>
                window.location.replace("cauldron.php");
            </script>
        <?php
        } else {
        ?>
            <h1>Welcome to Robert's Cauldron of Characters</h1>
            <h3>Please log-in or create a new account</h3>
            <div id='main'>
                <form id="main_form">
                    <input type="text" id="username" placeholder="Username" size='15' maxlength="40" required>
                    <input type="password" id="password" placeholder="Password" size='15' maxlength="60" required>
                    <br>
                    <input type="submit" id='submit_button' value="Login">
                    <input type="button" id="create_account_button" value="Create Account">
                </form>
                <h3 id="error_message"></h3>
            </div>
        <?php } ?>
    </main>
</body>

</html>