/*
  Author:   Robert Zaranek
  Date:     December 10, 2020

  Purpose:  The javascript portion of 'Robert's Cauldron of Characters' before
            the user has logged in.
*/

/**
 * The 'Main' method, activates upon DOM load completion.
 */
$(document).ready(function () {
    let chainSound = new Sound("sound/chain.wav");

    chainSound.play();      // Animation and sound on startup
    $("main").css("marginTop", "-350px")
        .css("display", "block");
    $("main").animate({
        marginTop: "180px"
    }, 2100);

    /**
     * Function for clicking the login button.
     * 
     * @param {*} event 
     */
    $("#main_form").submit(function (event) {
        event.preventDefault();
        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;

        let checkURL = "php/verify_user.php?username=" + username + "&password=" + password + "&login=true";
        //console.log(checkURL); // debug
        fetch(checkURL, {
                credentials: 'include'
            })
            .then(response => response.json())
            .then(success)

        function success(errorCode) {
            if (errorCode === -4) {
                $("#error_message").html("Username or Password are Invalid");
            } else if (errorCode === -3) {
                $("#error_message").html("Something Broke on Our End");
            } else if (errorCode == -2) {
                $("#error_message").html("No Such Username Exists, Please Make an Account");
            } else if (errorCode === -1) {
                $("#error_message").html("Wrong Password, Please Try Again");
            } else if (errorCode === 0) {
                chainSound.play();          // Animation and sound on successful login
                $("#error_message").html("LOGGED IN");
                $("main").animate({
                    marginTop: "-350px"
                }, 2100, function () {
                    window.location.replace("cauldron.php");
                });
            }
        }
    });

    /**
     * Function for clicking the create account button.
     * 
     * @param {*} event 
     */
    $("#create_account_button").click(function () {
        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;

        let createURL = "php/create_user.php?username=" + username + "&password=" + password + "&login=false";
        //console.log(createURL); // debug
        fetch(createURL, {
                credentials: 'include'
            })
            .then(response => response.json())
            .then(success)

        function success(errorCode) {
            if (errorCode === -4) {
                $("#error_message").html("Username or Password are Invalid");
            } else if (errorCode === -3) {
                $("#error_message").html("Something Broke on Our End");
            } else if (errorCode === 0) {
                $("#error_message").html("User Already Exists, Please Try Again");
            } else if (errorCode === -2) {
                $("#error_message").html("ACCOUNT CREATED");
            }
        }
    });
});