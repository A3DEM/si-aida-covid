<?php
session_start();
if (!isset($_SESSION['connectedId'])) {
    header("Location: ../index.html");
    exit();
}

$database = new mysqli("localhost", "root", "", "si_aida_covid");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

$database->set_charset("UTF8");
header('Content-type: text/html; charset=utf-8');

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
    <title>Blog</title>
</head>

<body>
    <header>
        <ul>
            <li>Bienvenue sur votre blog</li>
            <li>
                <svg onclick="disconnect()" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#5b17da" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                    <line x1="12" y1="2" x2="12" y2="12"></line>
                </svg>
            </li>
        </ul>
    </header>

    <main>
        <div class="content">
            <h2>Filtres</h2>
            <div class="search">

                <form action="./index.php" method="get">

                    <div class="filtres">
                        <div class="age">
                            <h3>Âge</h3>
                            <select name="age" id="age">
                                <option value="" <?php if (!isset($_GET["age"])) echo "selected"; ?>>Tous</option>
                                <option value="less20" <?php if (isset($_GET["age"]) && $_GET["age"] == "less20") echo "selected"; ?>>Moins de 20 ans</option>
                                <option value="20to35" <?php if (isset($_GET["age"]) && $_GET["age"] == "20to35") echo "selected"; ?>>Entre 20 et 35 ans</option>
                                <option value="35to50" <?php if (isset($_GET["age"]) && $_GET["age"] == "35to50") echo "selected"; ?>>Entre 35 et 50 ans</option>
                                <option value="more50" <?php if (isset($_GET["age"]) && $_GET["age"] == "more50") echo "selected"; ?>>Plus de 50 ans</option>
                            </select>
                        </div>

                        <div class="maladies">
                            <h3>Nombre de maladies</h3>

                            <input type="number" name="maladies" id="maladies" <?php if (isset($_GET["maladies"])) echo "value=\"" . $_GET["maladies"] . "\""; ?>>
                            </input>
                        </div>

                        <div class="doses">
                            <h3>Nombre de doses</h3>

                            <input type="number" name="doses" id="doses" <?php if (isset($_GET["doses"])) echo "value=\"" . $_GET["doses"] . "\""; ?>>
                            </input>
                        </div>

                        <input type="submit" value="Filtrer">
                    </div>
                </form>
            </div>

        </div>
        <div class="content">
            <h2>Membres</h2>
            <div class="personnes">

                <?php

                $postsPerPage = 6;

                $queryFilter = "";

                if (isset($_GET) && !empty($_GET) && (!empty($_GET["age"]) || !empty($_GET["maladies"]) || !empty($_GET["doses"]))) {

                    // var_dump($_GET);
                    if (isset($_GET["age"]) && $_GET["age"] == "") {
                        unset($_GET["age"]);
                    }
                    if (isset($_GET["maladies"]) && $_GET["maladies"] == "") {
                        unset($_GET["maladies"]);
                    }
                    if (isset($_GET["doses"]) && $_GET["doses"] == "") {
                        unset($_GET["doses"]);
                    }
                    // var_dump($_GET);                    

                    $queryFilter = "WHERE ";
                    if (isset($_GET["age"]) && $_GET["age"] !== "") {
                        switch ($_GET["age"]) {
                            case "less20": {
                                    $queryFilter .= "dateNaissance>='"  . date('Y-m-d', strtotime('-20 years')) . "'";
                                    break;
                                }
                                case "20to35": {
                                    $queryFilter .= "dateNaissance<='"  . date('Y-m-d', strtotime('-20 years')) . "' AND dateNaissance>='". date('Y-m-d', strtotime('-35 years')) . "'";
                                    break;
                                }
                                case "35to50": {
                                    $queryFilter .= "dateNaissance<='"  . date('Y-m-d', strtotime('-35 years')) . "' AND dateNaissance>'". date('Y-m-d', strtotime('-50 years')) . "'";
                                    break;
                                }
                                case "more50": {
                                    $queryFilter .= "dateNaissance<='"  . date('Y-m-d', strtotime('-50 years')) . "'";
                                    break;
                                }
                        }
                        // (sizeof($_GET) > 1) ? $queryFilter .= " AND " : "";
                    }
                    // if (isset($_GET["maladies"]) && $_GET["maladies"] !== "") {
                    //     $queryFilter .= "nombreMaladies=" . $_GET["maladies"];
                    //     (sizeof($_GET) > 1 && end($_GET) !== $_GET["maladies"]) ? $queryFilter .= " AND " : "";
                    // }
                    // (isset($_GET["doses"]) && $_GET["doses"] !== "") ? $queryFilter .= "nombreDoses=" . $_GET["doses"] : "";
                }

                $requestNumberOfPosts = $database->query("SELECT COUNT(idPersonne) FROM `personne`");
                foreach ($requestNumberOfPosts as $response) {
                    $numberOfPosts = $response["COUNT(idPersonne)"];
                }
                $numberOfPages = (int)ceil($numberOfPosts / $postsPerPage);
                $currentPage = (int)($_GET['page'] ?? 1);
                ($currentPage < 1 || $currentPage > $numberOfPages) ? $currentPage = 1 : "";
                $offset = $postsPerPage * ($currentPage - 1);
                $query = "SELECT personne.idPersonne, nom, prenom, dateNaissance FROM `personne`" . $queryFilter . " ORDER BY nom ASC LIMIT 6 OFFSET 0";
                // $requestPost = $database->query("SELECT personne.idPersonne, nom, prenom, dateNaissance, COUNT(DISTINCT possede.idPersonne) as nombreMaladies FROM `personne`" . $queryFilter . "LEFT JOIN possede ON personne.idPersonne = possede.idPersonne ORDER BY nom ASC LIMIT 6 OFFSET 0");
                // var_dump($query);
                $requestPost = $database->query($query);

                if ($requestPost->num_rows !== 0) {

                    foreach ($requestPost as $row) {

                ?>
                        <a href="../membre/index.php">
                            <div class="personne">
                                <h3 class="name"><?php echo $row['nom'] . " " . $row['prenom']; ?></h3>
                                <hr>
                                <div class="infos">
                                    <?php
                                    $diff = date_diff(date_create($row['dateNaissance']), date_create(date("Y-m-d")));
                                    echo "<b>Date de naissance : </b>  " . $row['dateNaissance'] .  " (" . $diff->format('%y') . " ans)";
                                    $requestNumberOfDiseases = $database->query("SELECT COUNT(idPersonne) FROM `possède` WHERE ");

                                    $query  = "SELECT publication.idPublication, titre, YEAR(publishedAt), type.nom as nomDomaine FROM `publication`
                    INNER JOIN type ON publication.idType = type.idType
                    INNER JOIN publie ON publication.idPublication = publie.idPublication "
                                    ?>

                                </div>
                                <div class="info">
                                </div>
                            </div>
                        </a>

                <?php
                    }
                } else {
                    echo "<h3>Il n'y a pas de personne correspondant à votre recherche</h3>";
                }
                ?>
            </div>
            <div class="pagination">
                <?php

                for ($i = 1; $i <= $numberOfPages; $i++) {

                    $getFilters = "";
                    if (isset($_GET)) {
                        if (isset($_GET['age'])) {
                            $getFilters .= "&age=" . $_GET['age'];
                        }
                        if (isset($_GET['maladies'])) {
                            $getFilters .= "&maladies=" . $_GET['maladies'];
                        }
                        if (isset($_GET['doses'])) {
                            $getFilters .= "&doses=" . $_GET['doses'];
                        }
                    }
                ?>
                    <a href="<?php echo "./index.php?page=$i$getFilters"; ?>" <?php if ($currentPage == $i) {
                                                                                    echo "class='active'";
                                                                                } ?>><?php echo $i; ?></a>
                <?php
                }

                ?>
                <!-- <a class="active" href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a> -->
            </div>
        </div>
    </main>

    <script src="js/script.js"></script>
</body>

</html>