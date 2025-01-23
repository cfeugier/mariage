<?php
include 'config.php';
include 'encryptDecrypt.php';

function flatten($doubleArray){
    $flattenArray = array();
    foreach ($doubleArray as $singleArray){
        array_push($flattenArray, $singleArray['id']);
    }
    return $flattenArray;
}

$requests = '';
$idFamily = decrypt($_POST['idFamilyCrypt']);
$stmt = $pdo->prepare('SELECT meal, mail FROM family WHERE idFamily = :idFamily');
$stmt->execute(['idFamily' => $idFamily]);
$mailAndMeal = $stmt->fetch(PDO::FETCH_ASSOC);
$meal = $mailAndMeal['meal'];
$mail = $mailAndMeal['mail'];
$stmt = $pdo->prepare('SELECT id FROM wedding WHERE idFamily = :idFamily');
$stmt->execute(['idFamily' => $idFamily]);
$idOld = flatten($stmt->fetchAll(PDO::FETCH_ASSOC));

if (isset($_POST['id'])){
    if ($mail == "" and $_POST['mail'] != ""){
        $requests .= "UPDATE `family` SET `mail` = '".$_POST['mail']."' WHERE `idFamily` = '".$idFamily."';";
    }
    if (sizeof($_POST['id']) == 0){
        $idNew = array_filter([], function($a) { return ($a !== 0); });
    } else {
        $idNew = array_filter($_POST['id'], function($a) { return ($a !== 0); });
    }
    $idDiff = array_diff($idOld,$idNew);

    foreach ($idDiff as $id){
        $requests .= "DELETE FROM `mariage` WHERE `id`=".$id.";";
    }
    for ($i=0; $i < sizeof($_POST['id']); $i++) { 
        $idTmp = $_POST['id'][$i];
        if ($idTmp == 0 ){
            if ($_POST['name'][$i] != '' and $_POST['firstname'][$i] != ''){
                $come = $_POST['come'][$i];
                $name = $_POST['name'][$i];
                $firstname = $_POST['firstname'][$i];
                if ($meal == '0'){
                    $age = $diet = $sleeps = $brunch = '2';
                    $allergies = 'non';
                } else {
                    $age = $_POST['age'][$i];
                    $diet = $_POST['diet'][$i];
                    $allergies = $_POST['allergies'][$i];
                    $sleeps = $_POST['sleeps'][$i];
                    $brunch = $_POST['brunch'][$i];
                }
                
                $requests .= "INSERT INTO `mariage`(`idFamily`, `come`, `name`, `firstname`, `age`, `meal`, `diet`, `allergies`, `sleeps`, `brunch`) VALUES ('$idFamily','$come','$name','$firstname','$age','$meal','$diet','$allergies','$sleeps','$brunch');"; 
            }
        } else {
            $come = $_POST['come'][$i];
            $name = $_POST['name'][$i];
            $firstname = $_POST['firstname'][$i];
            if ($meal == '0'){
                $age = $diet = $sleeps = $brunch = '2';
                $allergies = 'non';
            } else {
                $age = $_POST['age'][$i];
                $diet = $_POST['diet'][$i];
                $allergies = $_POST['allergies'][$i];
                $sleeps = $_POST['sleeps'][$i];
                $brunch = $_POST['brunch'][$i];
            }
            
            $requests .= "UPDATE `mariage` SET `come` = '$come', `name` = '$name', `firstname` = '$firstname', `age` = '$age', `diet` = '$diet', `allergies` = '$allergies', `sleeps` = '$sleeps', `brunch` = '$brunch' WHERE `mariage`.`id` = '$idTmp';";
        }
    }
} else {
    $idNew = array_filter([], function($a) { return ($a !== 0); });
    $idDiff = array_diff($idOld,$idNew);
    if (sizeof($idDiff)>0){
        foreach ($idDiff as $id){
            $requests .= "DELETE FROM `mariage` WHERE `id`=".$id.";";
        }
    }
}
if ($requests !== ''){
    $stmt = $pdo->prepare($requests);
    $stmt->execute();
}
header('Location: ' . '/?registered=1&idFamily='.$_POST['idFamilyCrypt'], true, 301);
die();
?>