<?php
include 'config.php';


$requetes = "DELETE FROM `wedding` WHERE `id`=".$_GET['id'].";";
if ($requetes !== ''){
    $stmt = $pdo->prepare($requetes);
    $stmt->execute();
}
header('Location: ' . '/', true, 301);
die();
?>