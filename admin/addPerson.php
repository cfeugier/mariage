<?php
include 'config.php';


$requests = "INSERT INTO `mariage`(`idFamily`, `come`, `name`, `firstname`, `age`, `meal`, `diet`, `allergies`, `sleeps`, `brunch`) VALUES ('".$_GET['idFamily']."','".$_GET['come']."','".$_GET['name']."','".$_GET['firstname']."','".$_GET['age']."','".$_GET['meal']."','".$_GET['diet']."','".$_GET['allergies']."','".$_GET['sleeps']."','".$_GET['brunch']."');";
if ($requests !== ''){
    $stmt = $pdo->prepare($requests);
    $stmt->execute();
}
header('Location: ' . '/', true, 301);
die();
?>