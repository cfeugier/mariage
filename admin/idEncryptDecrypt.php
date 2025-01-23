<?php
include 'config.php';
include 'encryptDecrypt.php';

function whatIs($value){
    if ($value == 1){
        return 'Yes';
    } elseif ($value == 0) {
        return 'No';
    } elseif ($value == 2) {
        return 'No meal';
    } else {
        return 'error';
    }
}

$stmt = $pdo->prepare('SELECT idFamily, meal, name, mail FROM famille ORDER BY idFamily');
$stmt->execute();
$families = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>List of families</title>
</head>
<body>
    <h1>Liste des Familles</h1>
    <button onclick="window.open('./', target='_self');">Liste des Invités</button>
    <table border="1">
        <tr>
            <th>ID Family</th>
            <th>Encrypted ID Family</th>
            <th>Name</th>
            <th>Meal</th>
            <th>Mail</th>
        </tr>
        <?php
        // Vérifier si des données ont été trouvées
        if ($families) {
            // Parcourir et afficher chaque enregistrement
            foreach ($families as $famille) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($famille['idFamily']) . '</td>';
                echo '<td>' . htmlspecialchars(encrypt($famille['idFamily'])) . '</td>';
                echo '<td>' . htmlspecialchars($famille['name']) . '</td>';
                echo '<td>' . htmlspecialchars(whatIs($famille['meal'])) . '</td>';
                echo '<td>' . htmlspecialchars($famille['mail']) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="3">No families found.</td></tr>';
        }
        ?>
    </table>
</body>
</html>