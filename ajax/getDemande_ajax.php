<?php

include('../inc/init.inc.php');

if(!empty($_POST)) {
    $result = $pdo->query("SELECT * FROM demande WHERE idDemande = " . $_POST['idDemande']);
    $demande = $result->fetch(PDO::FETCH_ASSOC);
    echo json_encode($demande);
}

?>

