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
function whatIsAge($value){
    if ($value == 1){
        return 'Adult';
    } elseif ($value == 0) {
        return 'Child';
    } elseif ($value == 2) {
        return 'No meal';
    } else {
        return 'error';
    }
}
function whatIsRegime($value){
    if ($value == 1){
        return 'Vegetarian';
    } elseif ($value == 0) {
        return 'No diet';
    } elseif ($value == 2) {
        return 'No meal';
    } else {
        return 'error';
    }
}

$stmt = $pdo->prepare('SELECT id, idFamily, meal, name, firstname, come, age, diet, allergies, sleeps, brunch FROM mariage');
$stmt->execute();
$families = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>List of guests</title>
    <script>
        function deletePerson(button) {
            const id = button.parentElement.parentElement.firstChild.innerHTML;
            window.open("./suppPerson.php?id="+id, target="_self");
        }
        function ajouterPersonne(){
            idFamily = document.getElementById('idfamily').value.replace(/ /g, '').toLowerCase();
            name = document.getElementById('name').value.replace(/ /g, '');
            firstname = document.getElementById('firstname').value.replace(/ /g, '');
            come = document.getElementById('come').value;
            age = document.getElementById('age').value;
            meal = document.getElementById('meal').value;
            diet = document.getElementById('diet').value;
            allergies = document.getElementById('allergies').value;
            sleeps = document.getElementById('sleeps').value;
            brunch = document.getElementById('brunch').value;
            if (name!="" && firstname!="" && idFamily!=""){
                window.open("./addPerson.php?idFamily="+idFamily+"&name="+name+"&firstname="+firstname+"&come="+come+"&age="+age+"&meal="+meal+"&diet="+diet+"&allergies="+allergies+"&sleeps="+sleeps+"&brunch="+brunch, target="_self");
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            detail = document.getElementById('yolobite').innerHTML;
            document.getElementById('nbrInvites').innerHTML = detail;
            document.getElementById('yolobite').remove();
        }, false);
    </script>
</head>
<body>
    <h1>Liste des Invités</h1>
    <p id="nbrInvites"></p>
    <button onclick="window.open('./idEncryptDecrypt.php', target='_self');">List of IDs</button>
    <table border="1">
        <tr>
            <th hidden>id</th>
            <th>ID Family</th>
            <th>Name</th>
            <th>Firstname</th>
            <th>Come</th>
            <th>Age</th>
            <th>Meal</th>
            <th>Diet</th>
            <th>Allergies</th>
            <th>Sleeps</th>
            <th>Brunch</th>
            <th></th>
        </tr>
        <?php
        // Vérifier si des données ont été trouvées
        if ($families) {
            $come = $age = $meal = $sleeps = $brunch = $diet = 0;
            // Parcourir et afficher chaque enregistrement
            foreach ($families as $family) {
                if ($family['come'] == 1){
                    $come = ++$come;
                    if ($family['age'] == 0){
                        $age = ++$age;
                    }
                    if ($family['meal'] == 1){
                        $meal = ++$meal;
                    }
                    if ($family['sleeps'] == 1){
                        $sleeps = ++$sleeps;
                    }
                    if ($family['brunch'] == 1){
                        $brunch = ++$brunch; 
                    }
                    if ($family['diet'] == 1){
                        $diet = ++$diet;
                    }
                }
                echo '<tr>';
                echo '<td class="idPerson" hidden>' . htmlspecialchars($family['id']) . '</td>';
                echo '<td>' . htmlspecialchars($family['idFamily']) . '</td>';
                echo '<td>' . htmlspecialchars($family['name']) . '</td>';
                echo '<td>' . htmlspecialchars($family['firstname']) . '</td>';
                echo '<td>' . whatIs(htmlspecialchars($family['come'])) . '</td>';
                echo '<td>' . whatIsAge(htmlspecialchars($family['age'])) . '</td>';
                echo '<td>' . whatIs(htmlspecialchars($family['meal'])) . '</td>';
                echo '<td>' . whatIsRegime(htmlspecialchars($family['diet'])) . '</td>';
                echo '<td>' . htmlspecialchars($family['allergies']) . '</td>';
                echo '<td>' . whatIs(htmlspecialchars($family['sleeps'])) . '</td>';
                echo '<td>' . whatIs(htmlspecialchars($family['brunch'])) . '</td>';
                echo '<td><button onclick="deletePerson(this);">delete</button></tr>';
            }
            echo '<tr><td hidden>0</td><td><input id="idfamily" type="text" name="idfamily" style="max-width: 100px;"/></td><td><input id="name" type="text" name="name" style="max-width: 100px;"/></td><td><input id="firstname" type="text" name="firstname" style="max-width: 100px;"/></td><td><select id="come" type="text" name="come" style="max-width: 100px;"><option value="1" selected>Yes</option><option value="0">No</option></select></td><td><select id="age" type="text" name="age" style="max-width: 70px;"><option value="0" selected>Adult</option><option value="1">Child</option><option value="2">No meal</option></select></td><td><select id="meal" type="text" name="meal" style="max-width: 100px;"><option value="1" selected>Yes</option><option value="0">No</option></select></td><td><select id="diet" type="text" name="diet" style="max-width: 100px;"><option value="0" selected>No diet</option><option value="1">Vegetarian</option><option value="2">No meal</option></select></td><td><input id="allergies" type="text" name="allergies" value="non" style="max-width: 60px;"/></td><td><select id="sleeps" type="text" name="sleeps" style="max-width: 60px;"><option value="0" selected>No</option><option value="1">Yes</option><option value="2">No meal</option></select></td><td><select id="brunch" type="text" name="brunch" style="max-width: 60px;"><option value="0" selected>No</option><option value="1">Yes</option><option value="2">No meal</option></select></td><td><button onclick="ajouterPersonne();">Ajouter</button></td></tr>';
            echo '<div id="yolobite">There is '.$come.' guests, '.$age.' children, '.$meal.' persons for the meal, of which '.$diet.' vegetarians, '.$sleeps.' persons staying to sleep and '.$brunch.' persons at the sunday brunch.</div>';
        } else {
            echo '<tr><td colspan="3">No family found.</td></tr>';
        }
        ?>
    </table>
</body>
</html>