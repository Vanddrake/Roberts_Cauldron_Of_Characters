/*
  Author:   Robert Zaranek
  Date:     December 13, 2020

  Purpose:  The javascript portion of 'Robert's Cauldron of Characters' once
            the user has logged in.
*/

/**
 * The 'Main' method, activates upon DOM load completion.
 */
$(document).ready(function () {

    let currentIndex = 0; // Stores the current index for the editCharacterEvent function
    let currentCharacterArray = []; // Stores the current character array for the editCharacterEvent function
    let intro = false; // Stores a flag for if the intro animation has already played
    let chainSound = new Sound("sound/chain.wav");

    // Displays the list from the database upon webpage loading
    let loadURL = "php/get_list.php";
    //console.log(loadURL); // debug
    fetch(loadURL, {
            credentials: 'include'
        })
        .then(response => response.json())
        .then(success)


    // Event listener for adding a character
    $("#main_form").on("submit", addCharacterEvent);

    /**
     * Function for adding a new character into the database.
     * 
     * @param {*} event - The incoming event
     */
    function addCharacterEvent(event) {
        event.preventDefault();
        let characterName = $("#char_name").val();
        let characterRace = $("#char_race").val();
        let characterClass = $("#char_class").val();
        let characterNotes = $("#char_notes").val();
        $("#char_name").val("");
        $("#char_race").val("");
        $("#char_class").val("");
        $("#char_notes").val("");

        let insertURL = "php/insert_character.php?char_name=" + characterName + "&char_race=" + characterRace +
            "&char_class=" + characterClass + "&char_notes=" + characterNotes;
        //console.log(insertURL); // debug
        fetch(insertURL, {
                credentials: 'include'
            })
            .then(response => response.json())
            .then(success)
    }

    /**
     * Function for editting a character on the list
     * 
     * @param {*} event - The incoming event
     */
    function editCharacterEvent(event) {
        event.preventDefault();
        let characterName = $("#char_name").val();
        let characterRace = $("#char_race").val();
        let characterClass = $("#char_class").val();
        let characterNotes = $("#char_notes").val();

        let updateURL = "php/update_character.php?char_id=" + currentCharacterArray[currentIndex][0] +
            "&char_name=" + characterName + "&char_race=" + characterRace +
            "&char_class=" + characterClass + "&char_notes=" + characterNotes;
        //console.log(updateURL); // debug
        fetch(updateURL, {
                credentials: 'include'
            })
            .then(response => response.json())
            .then(success)

        resetForm();
    }

    /**
     * Function for clicking the cancel button that appears after clicking the edit button
     */
    $("#cancel_edit_button").on("click", function () {
        resetForm();
    });

    /**
     * Function for resetting the form back to its original state for adding new characters
     */
    function resetForm() {
        $("#main_form").off("submit", editCharacterEvent);
        $("#cancel_edit_button").css("display", "none");
        $("#char_name").val("");
        $("#char_race").val("");
        $("#char_class").val("");
        $("#char_notes").val("");
        $("#submit_button").val("Add Character");
        $("#main_form").on("submit", addCharacterEvent);
    }

    /**
     * A function that decodes an HTML encoded string for user input.
     * 
     * @param {string} html - HTML encoded string to decode
     */
    function decodeHtml(html) {
        let txt = document.createElement("textarea");
        txt.innerHTML = html;
        return txt.value;
    }

    /**
     * This function should be called when the AJAX call is complete
     * and the text has been extracted from the response.
     * @param {String} characterArray 
     */
    function success(characterArray) {

        currentCharacterArray = characterArray;

        //console.log(characterArray); // debug
        let mainList = document.getElementById("main_list");
        mainList.querySelectorAll('*').forEach(node => node.remove());

        // Adds HTML Element for each Character in list
        for (let i = 0; i < characterArray.length; i++) {

            // Create Text Contents
            let listItem = $("<li>").html(characterArray[i][1] + " (" + characterArray[i][2] + ", " +
                characterArray[i][3] + ")");
            let listItem2 = $("<li>").html(characterArray[i][4])
                .css("padding-left", "100px");

            // Create 'Used' Checkbox
            let checkBox = $("<input>").attr("type", "checkbox");
            let isDoneInverse = 1;
            if (characterArray[i][5] === true) {
                $(checkBox).prop("checked", true);
                isDoneInverse = 0;
            }
            $(listItem).prepend(checkBox);
            /**
             * Event listener for clicking this checkbox
             */
            $(checkBox).on("click", function () {
                let checkItemURL = "php/check_character.php?char_id=" + characterArray[i][0] + "&used=" + isDoneInverse;
                //console.log(checkItemURL); // debug
                fetch(checkItemURL, {
                        credentials: 'include'
                    })
                    .then(response => response.json())
                    .then(success)

                resetForm();
            });

            // Create Edit Button
            let editButton = $("<img>").attr("src", "img/pencil.png").addClass("edit_button");
            $(listItem).prepend(editButton);
            /**
             * Event listener for clicking this edit button
             */
            $(editButton).on("click", function () {
                currentIndex = i;
                isChecked = 0;
                $("#main_form").off("submit", editCharacterEvent);
                $("#main_form").off("submit", addCharacterEvent);

                $("#char_name").val(decodeHtml(characterArray[i][1]));
                $("#char_race").val(decodeHtml(characterArray[i][2]));
                $("#char_class").val(decodeHtml(characterArray[i][3]));
                $("#char_notes").val(decodeHtml(characterArray[i][4]));
                $("#submit_button").val("Edit Character");
                $("#cancel_edit_button").css("display", "inline");

                $("#main_form").on("submit", editCharacterEvent);

            });

            // Create Delete Button
            let deleteButton = $("<img>").attr("src", "img/remove.png").addClass("delete_button");
            $(listItem).prepend(deleteButton);
            /**
             * Event listener for clicking this delete button
             */
            $(deleteButton).on("click", function () {
                let deleteURL = "php/delete_character.php?char_id=" + characterArray[i][0];
                //console.log(deleteURL); // debug
                fetch(deleteURL, {
                        credentials: 'include'
                    })
                    .then(response => response.json())
                    .then(success)

                resetForm();
            });

            // Add Elements to DOM
            $("#main_list").append($("<hr>"));
            $("#main_list").append(listItem);
            $("#main_list").append(listItem2);

        }
        if (!intro) { // Plays intro animation and sound upon login
            chainSound.play();
            let introTopMargin = (characterArray.length * -80) - 400;
            $("main").css("marginTop", introTopMargin + "px")
                .css("display", "block");
            $("main").animate({
                marginTop: "180px"
            }, 2100, function () {
                intro = true;
            });
        }
    }

    /**
     * Function for clicking the log out button
     */
    $("#logout_button").click(function () {
        let logoutURL = "php/logout.php";
        //console.log(logoutURL); // debug
        fetch(logoutURL, {
                credentials: 'include'
            })
            .then(response => response.json())
            .then(logout)

        function logout(success) {
            if (success) {
                chainSound.play(); // Plays exit animation and sound
                let introTopMargin = (currentCharacterArray.length * -80) - 400;
                $("main").css("marginTop", "180px")
                    .css("display", "block");
                $("main").animate({
                    marginTop: introTopMargin + "px"
                }, 2100, function () {
                    window.location.replace("index.php");
                });
            } else {
                $("#error_message").html("Something Went Wrong");
            }
        }
    });
});