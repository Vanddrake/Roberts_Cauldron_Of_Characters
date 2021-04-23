/*
  Author:   Robert Zaranek
  Date:     December 10, 2020

  Purpose:  A class that creates a sound object in the DOM.
*/

   /**
    * A Sound class to that adds a sound player to the DOM and
    * contains a method to play the sound.
    */
   function Sound(src) {
       this.sound = document.createElement("audio");
       this.sound.src = src;
       this.sound.setAttribute("preload", "auto");
       this.sound.setAttribute("controls", "none");
       this.sound.style.display = "none";
       document.body.appendChild(this.sound);
       /**
        * Plays the current sound of this Sound object.
        */
       this.play = function () {
           this.sound.play();
       }
   }