<?php

include('../inc/init.inc.php');

if(!empty($_POST)) {
    $demandeur = $_POST['demandeur'];
    $type = $_POST['type'];
    $ville = $_POST['ville'];
    $budget = $_POST['budget'];
    $superficie = $_POST['superficie'];
    $categorie = $_POST['categorie'];

    $result2 = $pdo->query("INSERT INTO demande (idPersonne, genre, ville, budget, superficie, categorie) 
    VALUES ('$demandeur','$type', '$ville',$budget,$superficie,'$categorie')");
     
}

?>

<a href="../index.php">Retour</a>