<?php
session_start();
if (!isset($_SESSION['connectedId'])) {
    header("Location: ../index.php");
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
            <li class="logo">
                <p>TousAntiCOVID<sub>LISTE</sub></p>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <defs>
                        <style>
                            .a {
                                fill: #5b17da;
                            }
                        </style>
                    </defs>
                    <path class="a" d="M46.5,19A1.49977,1.49977,0,0,0,45,20.5V22H40.87225a16.9,16.9,0,0,0-3.53-8.51367l2.92121-2.92139,1.17582.99561a1.49993,1.49993,0,1,0,2.12134-2.1211l-4.99991-5a1.4999,1.4999,0,0,0-2.12127,2.1211l.99565,1.17578-2.92139,2.92138A16.90205,16.90205,0,0,0,26,7.12793V3h1.5a1.5,1.5,0,0,0,0-3h-7a1.5,1.5,0,0,0,0,3H22V7.12793a16.90205,16.90205,0,0,0-8.51367,3.52978L10.56494,7.73633l.99565-1.17578a1.4999,1.4999,0,0,0-2.12127-2.1211l-4.88475,5a1.49993,1.49993,0,0,0,2.12133,2.1211l1.06067-.99561,2.92121,2.92139A16.9,16.9,0,0,0,7.12775,22H3V20.5a1.5,1.5,0,0,0-3,0v7a1.5,1.5,0,0,0,3,0V26H7.12775a16.9,16.9,0,0,0,3.53,8.51367L7.73657,37.43506l-1.17582-.99561a1.49993,1.49993,0,0,0-2.12134,2.1211l4.99991,5a1.4999,1.4999,0,1,0,2.12127-2.1211l-.99565-1.17578,2.92127-2.92138A16.902,16.902,0,0,0,22,40.87207V45H20.5a1.5,1.5,0,0,0,0,3h7a1.5,1.5,0,0,0,0-3H26V40.87207a16.902,16.902,0,0,0,8.51379-3.52978l2.92127,2.92138-.99565,1.17578a1.4999,1.4999,0,0,0,2.12127,2.1211l4.99991-5a1.49993,1.49993,0,1,0-2.12134-2.1211l-1.17582.99561-2.92121-2.92139A16.9,16.9,0,0,0,40.87225,26H45v1.5a1.5,1.5,0,0,0,3,0v-7A1.49977,1.49977,0,0,0,46.5,19Zm-28,1A3.5,3.5,0,1,1,22,16.5,3.49994,3.49994,0,0,1,18.5,20ZM30,33a2,2,0,1,1,2-2A2.00006,2.00006,0,0,1,30,33Z" />
                </svg>
            </li>
            <li class="disconnect">
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
                $secondFilters = "";

                if (isset($_GET) && !empty($_GET) && (!empty($_GET["age"]) || !empty($_GET["maladies"]) || !empty($_GET["doses"]) || $_GET['maladies'] === '0' || $_GET['doses'] === '0')) {

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

                    if (isset($_GET["age"]) && $_GET["age"] !== "") {
                        $queryFilter = " WHERE ";
                        switch ($_GET["age"]) {
                            case "less20": {
                                    $queryFilter .= "dateNaissance>='"  . date('Y-m-d', strtotime('-20 years')) . "'";
                                    break;
                                }
                            case "20to35": {
                                    $queryFilter .= "dateNaissance<='"  . date('Y-m-d', strtotime('-20 years')) . "' AND dateNaissance>='" . date('Y-m-d', strtotime('-35 years')) . "'";
                                    break;
                                }
                            case "35to50": {
                                    $queryFilter .= "dateNaissance<='"  . date('Y-m-d', strtotime('-35 years')) . "' AND dateNaissance>'" . date('Y-m-d', strtotime('-50 years')) . "'";
                                    break;
                                }
                            case "more50": {
                                    $queryFilter .= "dateNaissance<='"  . date('Y-m-d', strtotime('-50 years')) . "'";
                                    break;
                                }
                        }
                    }
                    if (!empty($_GET["maladies"]) || !empty($_GET["doses"])  || $_GET['maladies'] === '0' || $_GET['doses'] === '0')
                        $secondFilters = "HAVING ";
                    if (isset($_GET["maladies"]) && ($_GET["maladies"] !== "" || $_GET['maladies'] === '0')) {
                        $secondFilters .= "COUNT(DISTINCT possède.idMaladie)=" . $_GET["maladies"] . " ";
                        if (isset($_GET["doses"]) && ($_GET["doses"] !== "" || $_GET['doses'] === '0')) $secondFilters .= "AND ";
                    }
                    (isset($_GET["doses"]) && ($_GET["doses"] !== "" || $_GET['doses'] === '0')) ? $secondFilters .= "MAX(vaccination.numDose)=" . $_GET["doses"] : "";
                }



                $query = "SELECT nom, prenom, dateNaissance, personne.idPersonne, COUNT(DISTINCT possède.idMaladie) as nombreMaladies, MAX(vaccination.numDose) as nombreDoses FROM personne LEFT JOIN possède ON personne.idPersonne = possède.idPersonne LEFT JOIN vaccination ON personne.idPersonne = vaccination.idPersonne $queryFilter GROUP BY personne.idPersonne $secondFilters";
                $numberOfPostsQuery = $database->query($query);
                $numberOfPosts = $numberOfPostsQuery->num_rows;
                $numberOfPages = (int)ceil($numberOfPosts / $postsPerPage);
                $currentPage = (int)($_GET['page'] ?? 1);
                ($currentPage < 1 || $currentPage > $numberOfPages) ? $currentPage = 1 : "";
                $offset = $postsPerPage * ($currentPage - 1);

                $query = "SELECT nom, prenom, dateNaissance, personne.idPersonne, COUNT(DISTINCT possède.idMaladie) as nombreMaladies, MAX(vaccination.numDose) as nombreDoses FROM personne LEFT JOIN possède ON personne.idPersonne = possède.idPersonne LEFT JOIN vaccination ON personne.idPersonne = vaccination.idPersonne $queryFilter GROUP BY personne.idPersonne $secondFilters ORDER BY nom ASC LIMIT $postsPerPage OFFSET $offset";
                $requestPost = $database->query($query);

                if ($requestPost->num_rows !== 0) {

                    foreach ($requestPost as $row) {

                ?>
                        <a href=<?php echo "../membre/index.php?specificId=" . $row['idPersonne']; ?>>
                            <div class="personne">
                                <h3 class="name"><?php echo $row['nom'] . " " . $row['prenom']; ?></h3>
                                <hr>
                                <div class="infos">
                                    <?php
                                    $diff = date_diff(date_create($row['dateNaissance']), date_create(date("Y-m-d")));
                                    echo "<b>Date de naissance : </b>  " . $row['dateNaissance'] .  " (" . $diff->format('%y') . " ans)";
                                    echo "<b>Nombre de maladies : </b> " . $row['nombreMaladies'] . "";
                                    echo "<b>Nombre de doses : </b> " . ($row['nombreDoses'] !== null ? $row['nombreDoses'] : '0');
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