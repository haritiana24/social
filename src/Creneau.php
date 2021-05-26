<?php


namespace App;

class Creneau {

    public $debut;
    public $fin;
    public function __construct($debut,$fin)
    {
        $this->debut = $debut;
        $this->fin = $fin;
    }


    /**
     * @return string
     */
    public function toHtml(): string
    {
        return "<strong>{$this->debut}h</strong> à <strong>{$this->fin}h</strong>";
    }

    /**
     * @param int $heure
     * @return bool
     */
    public function incluHeure( int $heure):bool
    {
        return $heure >= $this->debut && $heure <= $this->fin;
    }

    /**
     * @param Creneau $creneau
     * @return bool
     */
    public function intersect( Creneau $creneau): bool
    {
        return $this->incluHeure($creneau->debut) ||
            $this->incluHeure($creneau->fin) ||
            ($this->debut > $creneau->debut && $this->fin < $creneau->fin);
    }
}