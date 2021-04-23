<?php
/*
  Author:   Robert Zaranek
  Date:     December 10, 2020

  Purpose:  A class for a single Character object.
*/
class Character
{
    private $id;            // The database ID of this Character
    private $char_name;     // This Character's name
    private $char_race;     // This Character's race
    private $char_class;    // This Character's class
    private $char_notes;    // Additional notes for this character
    private $used;          // Whether this Character has been used (0 = not used, 1 = used)

    /**
     * Constructor for a Character object
     * 
     * @peram {$id} The database ID of this Character
     * @peram {$char_name} This Character's name
     * @peram {$char_race} This Character's race
     * @peram {$char_class} This Character's class
     * @peram {$char_notes} Additional notes for this character
     * @peram {$used} Whether this Character has been used (0 = not used, 1 = used)
     */
    function __construct($id, $char_name, $char_race, $char_class, $char_notes, $used)
    {
        $this->id = (int)$id;
        $this->char_name = $char_name;
        $this->char_race = $char_race;
        $this->char_class = $char_class;
        $this->char_notes = $char_notes;
        $this->used = (int)$used;
    }

    /**
     * Returns a boolean of whether this character has been used or not
     * 
     * @returns Boolean of whether this character has been used or not
     */
    function isUsed()
    {
        if ($this->used === 1) return true;
        else if ($this->used === 0) return false;
    }

    /**
     * Returns the database ID of this Character
     * 
     * @returns The database ID of this Character
     */
    function getID()
    {
        return $this->id;
    }

    /**
     * Returns the name of this Character
     * 
     * @returns The name of this Character
     */
    function getName()
    {
        return $this->char_name;
    }

    /**
     * Returns the race of this Character
     * 
     * @returns The race of this Character
     */
    function getRace()
    {
        return $this->char_race;
    }

    /**
     * Returns the class of this Character
     * 
     * @returns The class of this Character
     */
    function getClass()
    {
        return $this->char_class;
    }

    /**
     * Returns the additional notes for this Character
     * 
     * @returns The additional notes for this Character
     */
    function getNotes()
    {
        return $this->char_notes;
    }
}
