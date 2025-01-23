<?php
include 'config.php';

$stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS `wedding` (`id` int(11) NOT NULL, `idFamily` text NOT NULL, `come` int(1) NOT NULL, `name` text NOT NULL, `firstname` text NOT NULL, `age` int(1) NOT NULL, `meal` int(1) NOT NULL, `diet` int(1) NOT NULL, `allergies` text NOT NULL, `sleeps` int(1) NOT NULL, `brunch` int(1) NOT NULL)");
$stmt->execute();
$stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS `famille` (`idFamille` varchar(32) NOT NULL, `repas` int(4) NOT NULL, `nom` varchar(64) NOT NULL, `mail` varchar(64) NOT NULL)");
$stmt->execute();