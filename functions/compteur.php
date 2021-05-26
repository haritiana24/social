<?php


/**
 * ajouter_vues
 *
 * @return void
 */
function ajouter_vues(): void
{
    $fichier = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur';
    $fichier_journalier = $fichier . '-' . date('Y-m-d');
    increment_compteur($fichier);
    increment_compteur($fichier_journalier);
}

/**
 * incementer le nombre de vues a chaque request
 *
 * @param  mixed $fichier
 * @return void
 */
function increment_compteur($fichier):void
{
    $compteur = 1;
    if (file_exists($fichier))
    {
        $compteur = file_get_contents($fichier);
        $compteur++;
    }
    file_put_contents($fichier, $compteur);
}

/**
 * Nombre total de la visite qui fait par l'utilisateur
 *
 * @return string { ex : nombres_vues = 32}
 */
function nombre_vues(): string
{
    $fichier = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur';
    return file_get_contents($fichier);
}

/**
 * Nombre de visiteur de site par mois
 *
 * @param  int $annee l'annee en cours
 * @param  int $mois le mois
 * @return int  le nomnbre de visite dans une mois {ex nombre_vue_mois = 23}
 */
function nombre_vues_mois(int $annee, int $mois):int
{
    $mois = str_pad($mois, 2, '0', STR_PAD_LEFT);
    $fichier = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur'.'-'.$annee.'-'.$mois .'-'.'*';
    $fichiers = glob($fichier);
    $total = 0;
    foreach ($fichiers as $fichier)
    {
        $total += (int)file_get_contents($fichier);
    }

    return $total;
}

/**
 *  detail sur le nombre de vues par mois
 *
 * @param  int  $annee
 * @param  int $mois
 * @return array
 */
function nombre_vues_detail_mois(int $annee, int $mois): array {

    $mois = str_pad($mois, 2, '0', STR_PAD_LEFT);
    $fichier = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur'.'-'.$annee.'-'.$mois .'-'.'*';
    $fichiers = glob($fichier);
    $visites = [];
    foreach ($fichiers as $fichier)
    {
        $parties = explode('-', basename($fichier));
        $visites[]=[
            'annee' => $parties[1],
            'mois' => $parties[2],
            'jour' => $parties[3],
            'visites' => file_get_contents($fichier)
        ];
    }
    return $visites;
}