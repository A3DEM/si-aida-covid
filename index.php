<?php
function processConnexion() {
    if ($_POST["username"] === '' || $_POST["password"] === '' || !isset($_POST["username"]) || !isset($_POST["password"])) {
        $message = "Veuillez remplir les deux champs";
        return $message;
    }
    
    $database = new mysqli("localhost", "root", "", "si_gestion_publi");
    
    if ($database->connect_error) {
        $message = "Veuillez remplir les deux champs";
        return $message;
    }
    
    $request = $database->prepare("SELECT idMembre, nom, prenom, idDomaine FROM membres WHERE username=? AND password=?");
    $request->bind_param('ss', $_POST['username'], $_POST['password']);
    
    $request->execute();
    $request->bind_result($userId, $nom, $prenom, $idDomaine);
    $request->fetch();

    if (isset($userId)) {
        session_start();
        $_SESSION['connectedId'] = $userId;
        header("Location: membre/index.php");
    } else {
        $message = "Identifiants incorrects";
        return $message;
    }
}

$message = processConnexion();
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
    <title>Connexion</title>
</head>

<body>
    <form class="login" method="post">
        <h1>Se connecter</h1>
        <div>
            <label for="username">Nom d'utilisateur</label>
            <input name="username" id="username" type="text">
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input name="password" id="password" type="password">
        </div>
        <p class="inscription">Pas encore de compte ? <a href="inscription.php">Inscrivez vous !</a></p>
        <p class="message" <?php if (isset($message)) echo 'style="display: initial !important"'?>><?php if (isset($message)) echo $message; ?></p>
        <input type="submit" id="connect" value="Se connecter"/>
    </form>
</body>

</html>