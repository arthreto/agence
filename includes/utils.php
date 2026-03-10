<?php

$destionationList = [ 
 "DETROIT" => [ 
    "description" => "Découvrez Detroit, une ville dynamique mêlant histoire industrielle et culture vibrante. Explorez ses musées, sa scène musicale légendaire et son architecture unique.", 
    "image" => "rsc/detroit.png",
    "prix" => "850€",
    "duree" => "5 jours",
    "note" => 4.2,
    "periode" => "Mai - Septembre",
    "points_interet" => [
        "Musée Motown",
        "Detroit Institute of Arts",
        "Belle Isle Park",
        "Eastern Market"
    ],
    "activites" => "Culture, Musées, Gastronomie"
 ],
 "ARNAC-LA-POSTE" => [ 
    "description" => "Bienvenue à Arnac-la-Poste, un charmant village français où le temps semble s'être arrêté. Profitez de son ambiance paisible, de ses paysages pittoresques et de son riche patrimoine culturel.", 
    "image" => "rsc/arnaclaposte.jpg",
    "prix" => "320€",
    "duree" => "3 jours",
    "note" => 4.5,
    "periode" => "Avril - Octobre",
    "points_interet" => [
        "Église Saint-Maurice",
        "Lac de Vassivière",
        "Sentiers de randonnée",
        "Marchés locaux"
    ],
    "activites" => "Nature, Randonnée, Détente"
 ], 
 "BOURRÉ" => [ 
    "description" => "Découvrez Bourré, un village médiéval niché dans la vallée de la Loire. Explorez ses ruelles pavées, son château historique et profitez de la beauté naturelle environnante.", 
    "image" => "rsc/bourre.jpg",
    "prix" => "450€",
    "duree" => "4 jours",
    "note" => 4.7,
    "periode" => "Mars - Novembre",
    "points_interet" => [
        "Caves troglodytes",
        "Château de Chenonceau",
        "Vignobles de la Loire",
        "Village médiéval"
    ],
    "activites" => "Histoire, Œnotourisme, Architecture"
 ] 
 ];

 function getDestinationInfo($destination) { 
    global $destionationList; 
    if (isset($destionationList[$destination])) { 
        return $destionationList[$destination]; 
    } else { 
        return null;
    }
 } 

 function getAllDestinations() { 
    global $destionationList; 
    return array_keys($destionationList); 
} 

?>