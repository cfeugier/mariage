<?php
include 'config.php';
include 'encryptDecrypt.php';

if (isset($_GET['registered'])){
    include 'notif.php';
}
// Check if the family ID is passed as a parameter
if (isset($_GET['idFamily'])) {
    if(!isset($_COOKIE["idFamily"])) {setcookie("idFamily", $_GET['idFamily'], array('expires' => time() + (86400 * 400), 'path' => '/', 'samesite' => 'Strict'));};
    $idFamilyCrypt = $_GET['idFamily'];
    $idFamily = decrypt($idFamilyCrypt);

    // Préparer et exécuter la requête SQL
    $stmt = $pdo->prepare('SELECT idFamily, meal, name, mail FROM family WHERE idFamily = :idFamily');
    $stmt->execute(['idFamily' => $idFamily]);
    $family = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare('SELECT id,name,firstname,age,meal,diet,allergies,sleeps,brunch,come FROM mariage WHERE idFamily = :idFamily');
    $stmt->execute(['idFamily' => $idFamily]);
    $families = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si des données ont été trouvées
    if ($family) {
        ?>
        <!DOCTYPE html>
        <!-- change your language -->
        <html lang="en">
        <head>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link rel="icon" href="assets/ring.png" sizes="32x32" type="image/png">
            <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
            <meta charset="UTF-8">
            <title>Registration form</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
            <style>
                body {
                    background-color: #fff;
                    background-image: url(assets/noisemini.png);
                    background-attachment: fixed;
                }
                .line {
                    padding: 10px;
                    outline-style: solid;
                    border-radius: 15px;
                    margin: 10px;
                    outline-width: 1px;
                    outline-color: #6c757d;
                }
                #buttonToggle {
                    position: absolute;
                    height: fit-content;
                    right: 10px;
                    border-color: #6c757d;
                    border-style: solid;
                    border-width: 2px;
                    border-radius: 5px;
                    padding: 9px;
                    <?php 
                        if (isset($_GET['inscrit'])){
                            echo 'top: 50px;';
                        } else {
                            echo 'top: 10px;';
                        }
                    ?>
                    color: #6c757d;
                }
            </style>
            <script>
                function deleteRow(button) {
                    const row = button.closest('.line');
                    row.remove();
                }
                <?php if ($family['meal'] == '1'){
                    ?>
                    function addRow() {
                        var row = document.createElement('div');
                        row.innerHTML = '<div class="col-sm-5"><input hidden name="id[]" value="0"><label for="firstname">Firstname</label><input class="form-control" id="firstname" type="text" data-sb-validations="required" name="firstname[]"/><div class="invalid-feedback" data-sb-feedback="firstname:required">Required.</div></div><div class="col-sm-5"><label for="name">Name</label><input class="form-control" id="name" type="text" data-sb-validations="required" name="name[]"/><div class="invalid-feedback" data-sb-feedback="name:required">Required.</div></div><div class="col-sm-2"><label for="present">Présent ?</label><select class="form-select" id="present" aria-label="Présent ?" name="come[]"><option value="1">Yes</option><option value="0" selected>No</option></select></div><div class="col-sm-3"><label for="typeOfMeal">Type of meal</label><select class="form-select" id="typeOfMeal" aria-label="Type of meal" name="age[]"><option value="1" selected>Adult</option><option value="0">Child</option></select></div><div class="col-sm-9"><label for="allergies">Allergies (separated by commas)</label><input class="form-control" id="allergies" type="text" data-sb-validations="required" value="non" name="allergies[]"/><div class="invalid-feedback" data-sb-feedback="allergies:required">Required.</div></div><div class="col-sm-4"><label for="diet">Diet</label><select class="form-select" id="diet" aria-label="Diet" name="diet[]"><option value="0" selected>No diet</option><option value="1">Vegetarian</option></select></div><div class="col-sm-3"><label for=""staysSleepi"ng">Stays sleeping?</label><select class="form-select" id="staysSleeping" aria-label="Stays sleeping?" name="sleeps[]"><option value="1">Yes</option><option value="0" selected>No</option></select></div><div class="col-sm-4"><label for="sundayBrunch">Sunday brunch</label><select class="form-select" id="sundayBrunch" aria-label="Sunday brunch" name="brunch[]"><option value="1">Yes</option><option value="0" selected>No</option></select></div><div class="col-sm-1" style="margin-top: 24px;"><button class="btn btn-light btn-outline-secondary delete-btn" type="button" onclick="deleteRow(this);"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"><path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/></svg><span class="visually-hidden">Button</span></button></div>';
                        row.classList.add("line");
                        row.classList.add("row");
                        document.getElementById('userTable').appendChild(row);    
                    }
                    <?php
                } else {
                    ?>
                    function addRow() {
                        var row = document.createElement('div');
                        row.innerHTML = '<div class="col-sm-5"><input hidden name="id[]" value="0"><label for="firstname">Firstname</label><input class="form-control" id="firstname" type="text" data-sb-validations="required" name="firstname[]"/><div class="invalid-feedback" data-sb-feedback="firstname:required">Required.</div></div><div class="col-sm-5"><label for="name">Name</label><input class="form-control" id="name" type="text" data-sb-validations="required" name="name[]"/><div class="invalid-feedback" data-sb-feedback="name:required">Required.</div></div><div class="col-sm-2"><label for="present">Présent ?</label><select class="form-select" id="present" aria-label="Présent ?" name="come[]"><option value="1">Yes</option><option value="0" selected>No</option></select></div><div class="col-sm-1" style="margin-top: 24px;"><button class="btn btn-light btn-outline-secondary delete-btn" type="button" onclick="deleteRow(this);"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"><path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/></svg><span class="visually-hidden">Button</span></button></div>';
                        row.classList.add("line");
                        row.classList.add("row");
                        document.getElementById('userTable').appendChild(row);
                    }
                    <?php
                }?>
             </script>
        </head>
        <body style="min-height:100vh;">
        <button class="navbar-toggler" type="button" id="buttonToggle" onclick="window.open('/',  '_self');">
            <span class="bi bi-house-fill" onclick="window.open('/',  '_self');" style="font-size: larger;"></span>
        </button>
        <div class="nav">
            <div class="col-md-2"></div>
                <div class="col-md row align-items-center">
                    <div class="col-md-12" style="height: 15px"></div>
                    <div class="col-md-12 col-12 row">
                        <div class="col-sm-1 col-1"></div>
                        <div class="col-sm-10 col-10 col-md-12"><h1 style="text-align:center; font-family: 'Cormorant Garamond', serif;">Bonjour, <?php echo htmlspecialchars($family['name']); ?>,</h1></div>
                        <div class="col-sm-1 col-1"></div>
                    </div>
                    <?php if ($family['meal'] == '1'){
                        ?>
                        <div class="row" style="margin: auto;">
                        <div class="col-md-2 d-none d-xxl-block"></div>
                        <div class="col">
                        <div class="card" style="border-radius: 15px;border-color: #6c757d;"><div class="card-body" style="text-align:center; font-family: 'Cormorant Garamond', serif;">You can add infos here for the people coming at the reception. Don't forget to explain that to delete someone, they need to delete the row and then submit.</div>
                        </div>
                        <div class="col-md-2 d-none d-xxl-block"></div>
                        </div>
                        <?php
                    } else {
                        ?> <div class="row" style="margin: auto;">
                        <div class="col-md-2 d-none d-xxl-block"></div>
                        <div class="col">
                        <div class="card" style="border-radius: 15px;border-color: #6c757d;"><div class="card-body" style="text-align:center; font-family: 'Cormorant Garamond', serif;">You can add infos here for the people coming at the wine of honor. Don't forget to explain that to delete someone, they need to delete the row and then submit.</div></div>
                        </div>
                        <div class="col-md-2 d-none d-xxl-block"></div>
                        </div>
                        <?php
                    }?>
                    <div class="row" style="margin: auto;">
                        <div class="col-md-2 d-none d-xxl-block"></div>
                        <form id="userForm" method="POST" action="addPersons.php" class="col">
                        <?php echo '<input hidden type="text" name="idFamilyCrypt" value="' . htmlspecialchars($idFamilyCrypt).'">'?>
                        <div <?php if ($family['mail']!=""){echo "hidden ";}else{echo "";} ?>class="card" style="border-radius: 15px; border-color:#6c757d;margin-top: 10px;"><div class="col-sm-12 card-body"><label for="mail">Please enter your email so we can contact you if needed :</label><input class="form-control" id="mail" type="email" data-sb-validations="required" name="mail" placeholder="email@example.com" value="<?php echo htmlspecialchars($family['mail'])?>"></input><div class="invalid-feedback" data-sb-feedback="mail:required">Required.</div></div></div>
                        <div id="userTable">
                            <?php
                            // Vérifier si des données ont été trouvées
                            if ($families) {
                                // Parcourir et afficher chaque enregistrement
                                foreach ($families as $family) {
                                    echo '<div class="line row">';
                                    echo '<div class="col-sm-5"><input hidden name="id[]" value="' . htmlspecialchars($family['id']) . '"><label for="firstname">Firstname</label><input class="form-control" id="firstname" type="text" data-sb-validations="required" name="firstname[]" value="' . htmlspecialchars($family['firstname']) . '"/><div class="invalid-feedback" data-sb-feedback="firstname:required">Required.</div></div>';
                                    echo '<div class="col-sm-5"><label for="name">Name</label><input class="form-control" id="name" type="text" data-sb-validations="required" name="name[]" value="' . htmlspecialchars($family['name']) . '"/><div class="invalid-feedback" data-sb-feedback="name:required">Required.</div></div>';
                                    echo '<div class="col-sm-2"><label for="present">Présent ?</label><select class="form-select" id="present" aria-label="Présent ?" name="come[]">';
                                    if ($family['come'] == '0') {
                                        echo '<option value="1">Yes</option><option value="0" selected>No</option>';
                                    } else {
                                        echo '<option value="1" selected>Yes</option><option value="0">No</option>';
                                    }
                                    echo '</select></div>';
                                    if ($family['meal'] == '1'){
                                        echo '<div class="col-sm-3"><label for="typeOfMeal">Type of meal</label><select class="form-select" id="typeOfMeal" aria-label="Type of meal" name="age[]">';
                                        if ($family['age'] == 0) {
                                            echo '<option value="1">Adult</option><option value="0" selected>Child</option>';
                                        } else {
                                            echo '<option value="1" selected>Adult</option><option value="0">Child</option>';
                                        }
                                        echo '</select></div>';
                                        echo '<div class="col-sm-9"><label for="allergies">Allergies (séparés par des virgules)</label><input class="form-control" id="allergies" type="text" data-sb-validations="required" value="' . htmlspecialchars($family['allergies']) . '" name="allergies[]"/><div class="invalid-feedback" data-sb-feedback="allergies:required">Required.</div></div>';
                                        echo '<div class="col-sm-4"><label for="diet">Diet</label><select class="form-select" id="diet" aria-label="Diet" name="diet[]">';
                                        if ($family['diet'] == 0) {
                                            echo '<option value="0" selected>No diet</option><option value="1">Vegetarian</option>';
                                        } else {
                                            echo '<option value="0">No diet</option><option value="1" selected>Vegetarian</option>';
                                        }
                                        echo '</select></div>';
                                        echo '<div class="col-sm-3"><label for="staysSleeping">Stays sleeping?</label><select class="form-select" id="staysSleeping" aria-label="Stays sleeping?" name="sleeps[]">';
                                        if ($family['sleeps'] == 0) {
                                            echo '<option value="1">Yes</option><option value="0" selected>No</option>';
                                        } else {
                                            echo '<option value="1" selected>Yes</option><option value="0">No</option>';
                                        }
                                        echo '</select></div>';
                                        echo '<div class="col-sm-4"><label for="sundayBrunch">Sunday brunch</label><select class="form-select" id="sundayBrunch" aria-label="Sunday brunch" name="brunch[]">';
                                        if ($family['brunch'] == 0) {
                                            echo '<option value="1">Yes</option><option value="0" selected>No</option>';
                                        } else {
                                            echo '<option value="1" selected>Yes</option><option value="0">No</option>';
                                        }
                                        echo '</select></div>';
                                    }
                                    echo '<div class="col-sm-1" style="margin-top: 24px;"><button class="btn btn-light btn-outline-secondary delete-btn" type="button" onclick="deleteRow(this);"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"><path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/></svg><span class="visually-hidden">Button</span></button></div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="line row"><div class="col-sm-5"><input hidden name="id[]" value="0"><label for="firstname">Firstname</label><input class="form-control" id="firstname" type="text" data-sb-validations="required" name="firstname[]"/><div class="invalid-feedback" data-sb-feedback="firstname:required">Required.</div></div><div class="col-sm-5"><label for="name">Name</label><input class="form-control" id="name" type="text" data-sb-validations="required" name="name[]"/><div class="invalid-feedback" data-sb-feedback="name:required">Required.</div></div><div class="col-sm-2"><label for="present">Présent ?</label><select class="form-select" id="present" aria-label="Présent ?" name="come[]"><option value="1">Yes</option><option value="0" selected>No</option></select></div>';
                                if ($family['meal'] == '1'){
                                    echo '<div class="col-sm-3"><label for="typeOfMeal">Type of meal</label><select class="form-select" id="typeOfMeal" aria-label="Type of meal" name="age[]"><option value="1" selected>Adult</option><option value="0">Child</option></select></div><div class="col-sm-9"><label for="allergies">Allergies (separated by commas)</label><input class="form-control" id="allergies" type="text" data-sb-validations="required" value="non" name="allergies[]"/><div class="invalid-feedback" data-sb-feedback="allergies:required">Required.</div></div><div class="col-sm-4"><label for="diet">Diet</label><select class="form-select" id="diet" aria-label="Diet" name="diet[]"><option value="0" selected>No diet</option><option value="1">Vegetarian</option></select></div><div class="col-sm-3"><label for="staysSleeping">Stays sleeping?</label><select class="form-select" id="staysSleeping" aria-label="Stays sleeping?" name="sleeps[]"><option value="1">Yes</option><option value="0" selected>No</option></select></div><div class="col-sm-4"><label for="sundayBrunch">Sunday brunch</label><select class="form-select" id="sundayBrunch" aria-label="Sunday brunch" name="brunch[]"><option value="1">Yes</option><option value="0" selected>No</option></select></div>';
                                };
                                echo '<div class="col-sm-1" style="margin-top: 24px;"><button class="btn btn-light btn-outline-secondary delete-btn" type="button" onclick="deleteRow(this);"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"><path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/></svg><span class="visually-hidden">Button</span></button></div></div>';
                            }
                            ?>
                        </div>
                        <div style="padding: 0 10px 0 10px; margin-bottom=10px;">
                            <button class="btn btn-light btn-outline-secondary" type="button" onclick="addRow()">Add person</button>
                            <button class="btn btn-light btn-outline-secondary" type="submit">Submit</button>
                        </div>
                        </form>
                    <div class="col-md-2 d-none d-xxl-block"></div>
                    </div>
                </div>
            <div class="col-md-2"></div>
        </div>
        <div style="text-align: center; position:sticky; top:97vh;">
            <p>Made with ❤️ by <a href="https://github.com/cfeugier">Clement</a>.</p>
        </div>
        </body>
        </html>
        <?php
    } else {
        if(!isset($_COOKIE["idFamily"])) {
            include 'landingerror.php';
        } else {
            include 'landing.php';
        }
    }
} else {
    if(!isset($_COOKIE["idFamily"])) {
        include 'landingerror.php';
    } else {
        include 'landing.php';
    }
}
?>