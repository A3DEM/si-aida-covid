<?php

    $id = 9;

    $database = new mysqli("localhost", "root", "", "si_aida_covid");
    
    if ($database->connect_error) {
        die("Connection failed: " . $database->connect_error);
    }

    $database->set_charset("UTF8");
    header('Content-type: text/html; charset=utf-8');

    if(isset($_POST) && !empty($_POST)) {

        if(isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year']) && isset($_POST['adresse']) && isset($_POST['identifiant']) && isset($_POST['motdepasse']) && isset($_POST['vaccin'])) {
                    
            $hasError = true;

            $queryUpdate = "";
            
            $queryUpdate["nom"] = $_POST["nom"];
            $queryUpdate["prenom"] = $_POST["prenom"];
            $queryUpdate["dateNaissance"] = $_POST["year"]."-".$_POST["month"]."-".$_POST["day"];
            $queryUpdate["adresse"] = $_POST["adresse"];
            $queryUpdate["role"] = 1;
            $queryUpdate["identifiant"] = $_POST["identifiant"];
            $queryUpdate["motdepasse"] = $_POST["motdepasse"];
            $queryUpdate["vaccin"] = intval($_POST["vaccin"]);
                         
            $query = "UPDATE `personne` SET `nom`=?,`prenom`=?,`dateNaissance`=?,`adresse`=?,`role`=?,`identifiant`=?,`motdepasse`=?,`idVaccin`=? WHERE idPersonne = $id";
            $requestUpdate = $database->prepare($query);
            $requestUpdate->bind_param('ssssissi', $queryUpdate["nom"], $queryUpdate["prenom"], $queryUpdate["dateNaissance"], $queryUpdate["adresse"], $queryUpdate["role"], $queryUpdate["identifiant"], $queryUpdate["motdepasse"], $queryUpdate["vaccin"]);

            if ($requestUpdate->execute()) {
                $hasError = false;
            }

            $requestUpdate->close();

            if(isset($_POST["maladie"]) && !empty($_POST["maladie"])) {
                foreach($_POST["maladie"] as $maladie) {
                    $queryInsert["maladie"][] = intval($maladie);
                }
            } else {
                $queryInsert["maladie"][] = 0;
            }

            $requestDeleteMaladie = $database->prepare("DELETE FROM `possède` WHERE idPersonne = $id");
            $requestDeleteMaladie->execute();

            foreach($queryInsert["maladie"] as $maladie) {
                
                $query = "INSERT INTO `possède`(`idPersonne`, `idMaladie`) VALUES (9,?)";

                $requestInsertMaladie = $database->prepare($query);
                $requestInsertMaladie->bind_param('i', $maladie);
                $requestInsertMaladie->execute();
                $requestInsertMaladie->close();

            }
        }

        if(isset($_POST["rdv"])) {

            if($_POST["rdv"] == 1) {
                $requestInsertVaccination = $database->prepare("INSERT INTO `vaccination`(`numDose`, `estVaccine`, `idPersonne`) VALUES (1, 0, $id)");
                $requestInsertVaccination->execute();
                $requestInsertVaccination->close();
            } elseif ($_POST["rdv"] == 2) {
                $requestInsertVaccination = $database->prepare("INSERT INTO `vaccination`(`numDose`, `estVaccine`, `idPersonne`) VALUES (2, 0, $id)");
                $requestInsertVaccination->execute();
                $requestInsertVaccination->close();
            }
        }
    }



    $requestInfoMembre = $database->prepare("SELECT nom, prenom, dateNaissance, adresse, identifiant, motdepasse, idVaccin FROM `personne` WHERE idPersonne = $id");        
    $requestInfoMembre->execute();
    $requestInfoMembre->bind_result($infoMembre["nom"], $infoMembre["prenom"], $infoMembre["dateNaissance"], $infoMembre["adresse"], $infoMembre["identifiant"], $infoMembre["motdepasse"], $infoMembre["vaccin"]);
    $requestInfoMembre->fetch();
    $requestInfoMembre->close();

    $infoMembre["dateNaissance"] = explode("-", $infoMembre["dateNaissance"]);

    // var_dump($infoMembre);

    $months = [
        "1" => "janvier",
        "2" => "février",
        "3" => "mars",
        "4" => "avril",
        "5" => "mai",
        "6" => "juin",
        "7" => "juillet",
        "8" => "août",
        "9" => "septembre",
        "10" => "octobre",
        "11" => "novembre",
        "12" => "décembre"
    ];
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Page membre</title>
</head>
<body>

    <header>
        <p>TousAntiCOVID<sub>LISTE</sub></p>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><defs><style>.a{fill:#5b17da;}</style></defs><path class="a" d="M46.5,19A1.49977,1.49977,0,0,0,45,20.5V22H40.87225a16.9,16.9,0,0,0-3.53-8.51367l2.92121-2.92139,1.17582.99561a1.49993,1.49993,0,1,0,2.12134-2.1211l-4.99991-5a1.4999,1.4999,0,0,0-2.12127,2.1211l.99565,1.17578-2.92139,2.92138A16.90205,16.90205,0,0,0,26,7.12793V3h1.5a1.5,1.5,0,0,0,0-3h-7a1.5,1.5,0,0,0,0,3H22V7.12793a16.90205,16.90205,0,0,0-8.51367,3.52978L10.56494,7.73633l.99565-1.17578a1.4999,1.4999,0,0,0-2.12127-2.1211l-4.88475,5a1.49993,1.49993,0,0,0,2.12133,2.1211l1.06067-.99561,2.92121,2.92139A16.9,16.9,0,0,0,7.12775,22H3V20.5a1.5,1.5,0,0,0-3,0v7a1.5,1.5,0,0,0,3,0V26H7.12775a16.9,16.9,0,0,0,3.53,8.51367L7.73657,37.43506l-1.17582-.99561a1.49993,1.49993,0,0,0-2.12134,2.1211l4.99991,5a1.4999,1.4999,0,1,0,2.12127-2.1211l-.99565-1.17578,2.92127-2.92138A16.902,16.902,0,0,0,22,40.87207V45H20.5a1.5,1.5,0,0,0,0,3h7a1.5,1.5,0,0,0,0-3H26V40.87207a16.902,16.902,0,0,0,8.51379-3.52978l2.92127,2.92138-.99565,1.17578a1.4999,1.4999,0,0,0,2.12127,2.1211l4.99991-5a1.49993,1.49993,0,1,0-2.12134-2.1211l-1.17582.99561-2.92121-2.92139A16.9,16.9,0,0,0,40.87225,26H45v1.5a1.5,1.5,0,0,0,3,0v-7A1.49977,1.49977,0,0,0,46.5,19Zm-28,1A3.5,3.5,0,1,1,22,16.5,3.49994,3.49994,0,0,1,18.5,20ZM30,33a2,2,0,1,1,2-2A2.00006,2.00006,0,0,1,30,33Z"/></svg>
    </header>

    <main>
        <div class="informations">
            <h2>Vos informations</h2>
            <form class="login" method="post">
                <div>
                    <label for="username">Prénom<sup class="redstar">*</sup></label>
                    <input name="prenom" id="prenom" type="text" value="<?php echo $infoMembre["prenom"] ?>">
                </div>
                <div>
                    <label for="username">Nom<sup class="redstar">*</sup></label>
                    <input name="nom" id="nom" type="text" value="<?php echo $infoMembre["nom"] ?>">
                </div>
                <div>
                    <label for="username">Date<sup class="redstar">*</sup></label>
                    <div class="selects">
                        <select name="day" id="day" value="<?php echo $infoMembre["prenom"] ?>">

                        <?php
                            for($i=1;$i<=31;$i++) {
                        ?>
                        
                            <option value="<?php if($i<10) {echo "0";} echo $i; ?>" <?php if($infoMembre["dateNaissance"][2] == $i) {echo "selected"; } ?> ><?php echo $i; ?></option>
                        
                        <?php
                            }
                        ?>
                        </select>
                        <select name="month" id="month" value="<?php echo $infoMembre["prenom"] ?>">

                        <?php
                            for($i=1;$i<=12;$i++) {
                        ?>
                        
                            <option value="<?php if($i<10) {echo "0";} echo $i; ?>" <?php if($infoMembre["dateNaissance"][1] == $i) {echo "selected"; } ?> ><?php echo $months[$i]; ?></option>
                        
                        <?php
                            }
                        ?>
                        </select>
                        <select name="year" id="year" value="<?php echo $infoMembre["prenom"] ?>">

                        <?php
                            for($i=1910;$i<=2022;$i++) {
                        ?>
                        
                            <option value="<?php echo $i; ?>" <?php if($infoMembre["dateNaissance"][0] == $i) {echo "selected"; } ?> ><?php echo $i; ?></option>
                        
                        <?php
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="adresse">Adresse<sup class="redstar">*</sup></label>
                    <input name="adresse" id="adresse" type="text" value="<?php echo $infoMembre["adresse"] ?>">
                </div>
                <div>
                    <label for="identifiant">Identifiant<sup class="redstar">*</sup></label>
                    <input name="identifiant" id="identifiant" type="text" value="<?php echo $infoMembre["identifiant"] ?>">
                </div>
                <div>
                    <label for="motdepasse">Mot de passe<sup class="redstar">*</sup></label>
                    <input name="motdepasse" id="motdepasse" type="password" value="<?php echo $infoMembre["motdepasse"] ?>">
                </div>
                <div>
                    <label for="vaccin">Vaccin<sup class="redstar">*</sup></label>
                    <select name="vaccin" id="vaccin">

                    <?php
                        $requestVaccin = $database->prepare("SELECT * FROM `typevaccin`");     
                        $requestVaccin->execute();
                        $requestVaccin->bind_result($idVaccin, $nom);
                        while($requestVaccin->fetch()) {
                    ?>
                    
                        <option value="<?php echo $idVaccin; ?>" <?php if($infoMembre["vaccin"] == $idVaccin) {echo "selected"; }?>><?php echo $nom; ?></option>
                    
                    <?php
                        }
                        $requestVaccin->close();
                    ?>
                    </select>
                </div>
                <div>
                    <label for="maladie">Maladie</label>
                    <select name="maladie[]" id="maladie" multiple>

                        <?php
                            $requestListMaladie = $database->prepare("SELECT idMaladie FROM `possède` WHERE idPersonne = $id ");     
                            $requestListMaladie->execute();
                            $requestListMaladie->bind_result($idMaladie);
                            while($requestListMaladie->fetch()) {
                                $listMaladie[] = $idMaladie;
                            }


                            $requestMaladie = $database->prepare("SELECT * FROM `maladie`");     
                            $requestMaladie->execute();
                            $requestMaladie->bind_result($idMaladie, $nom);
                            // Permet de ne pas afficher le "Aucune" maladie
                            $requestMaladie->fetch();
                            while($requestMaladie->fetch()) {
                        ?>
                        
                            <option value="<?php echo $idMaladie; ?>" <?php if(in_array($idMaladie, $listMaladie)) { echo "selected"; } ?> ><?php echo $nom; ?></option>
                        
                        <?php
                            }
                            $requestVaccin->close();
                        ?>
                    </select>
                </div>
                <?php
                    if(isset($hasError)) {
                ?>
                <p class="message <?php if($hasError) {echo "active error";} else { echo "active valid";} ?>"><?php if($hasError) {echo "Veuillez remplir tous les champs.";} else { echo "Modifications enregistrées.";} ?></p>
                <?php
                    }
                ?>
                <input type="submit" value="Enregistrer mes informations" class="connect">
            </form>
        </div>
        <div class="rang">
            <h2>Votre rang</h2>

            <?php
                $requestNumDose = $database->prepare("SELECT numDose, estVaccine FROM `vaccination` WHERE idPersonne = $id");     
                $requestNumDose->execute();
                $requestNumDose->bind_result($numDose, $estVaccine);
                while($requestNumDose->fetch()) {
                    $vaccination[$numDose] = $estVaccine;
                }

                if(isset($vaccination)) {

                    foreach($vaccination as $dose => $state) {
                        
                        ($state == true) ? $message = "est injectée": $message = "n'est pas injectée";
                        echo "<p>Votre dose numéro $dose $message.</p>";
                        
                    }

                    if ($dose == 1 && $state == true ) {
                        ?>

                        <form class="rdv" method="post">
                            <p>Vous n'avez pas pris de rendez-vous pour votre deuxème dose.</p>
                            <input type="hidden" name="rdv" value="2">
                            <input type="submit" value="Prendre un rendez-vous" class="connect">
                        </form>

                        <?php
                    } elseif ((($dose == 1 || $dose == 2) && $state == false )) {

                        $requestRank = $database->prepare("SET @rank = 0");     
                        $requestRank->execute();
                        $requestRank = $database->prepare("SELECT @rank:=@rank+1 AS rank, idPersonne FROM vaccination WHERE estVaccine = 0");     
                        $requestRank->execute();
                        $requestRank->bind_result($rank, $idPersonne);
                        while($requestRank->fetch()) {
                            
                            if($idPersonne == $id) {
                                $rankValue = $rank;
                                break;
                            }
                        }
                    
                        if(isset($rankValue)) {
                            ?>
                                <p>Vous êtes en position <?php echo $rankValue; ?>.</p>
                            <?php
                        } else {
                            ?>
                                <p>Vous êtes en position <?php echo $rankValue; ?>.</p>
                            <?php
                        }
                    }

                }
            else {
                ?>
                <form class="rdv" method="post">
                    <p>Vous n'avez pas pris de rendez-vous. Vous pouvez en prendre un pour le créneau le plus tôt disponible.</p>
                    <input type="hidden" name="rdv" value="1">
                    <input type="submit" value="Prendre un rendez-vous" class="connect">
                </form>
                <?php
            }
            ?>

            
        </div>
        <div class="actualites">
            <h2>Actualités</h2>
            <hr>
            <p><strong class="message alert active">Dernière minute !</strong> La proportion de vaccinés a dépassé les 65% à Mulhouse.</p>
            <hr>
            <p><strong class="message valid active">La situation s'améliore !</strong> Les cas de COVID-19 diminuent en flèche depuis 1 semaine.</p>
            <hr>
            <p><strong class="message error active">Attention !</strong> Les réservations sont complètes pour les 3 prochains jours.</p>
        </div>
    </main>    
    <script src="js/script.js"></script>
</body>
</html>