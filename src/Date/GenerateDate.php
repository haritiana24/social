<?php

namespace App\Date;

class GenerateDate
{
        
    /**
     * now
     *
     * @return string
     */
    public static function now() : string
    {
        $jour = date('d');
        $mois = date('m');
        $annee = date('Y');
        $heure = date('H');
        $minute = date('i');
        $seconde = date('s');
        return $annee . '-' . $mois . '-' . $jour .' '.$heure . ':'. $minute .':'.$seconde;
    }
    
}