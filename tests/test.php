<?php 

$data  = [
    'name' => "name",
    'password' => "password",
    'username' => "username"
];

$query = "";

$data = array_keys($data);

foreach($data as $d){
    $query .= $d . "= :$d ,";
}

 $query = substr($query , 0, strlen($query) - 1);


 $testVariable = [
     'haritiana' => 'kely'
 ];

extract($testVariable);

$number = 81;


function carre( int $number){
    return $number * $number;
}

// haritiana randria utiliser cette manier de travailler dans son examen 

var_dump(carre(8));