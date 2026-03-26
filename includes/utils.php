<?php

include "config/pdo.php";


 function getDestinationInfo($destination) { 
    $destionationList = getAllDestinations();
    if (isset($destionationList[$destination])) { 
        return $destionationList[$destination]; 
    } else { 
        return null;
    }
 }

function getAllDestinations() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM voyages");
    $stmt->execute();
    $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $destinations = [];

    foreach ($fetch as $row) {
        $destinations[$row['nom']] = $row;
    }

    return $destinations;
}

function getPanierCount() {
     global $pdo;
     $stmt = $pdo->prepare("SELECT * FROM reservation WHERE user_id=");
}

?>