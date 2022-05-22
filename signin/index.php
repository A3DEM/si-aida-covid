<?php

    $database = new mysqli("localhost", "root", "", "si_aida_covid");
    
    if ($database->connect_error) {
        die("Connection failed: " . $database->connect_error);
    }

    
    if(isset($_POST) && !empty($_POST)) {
        
        if($_POST['prenom'] && $_POST['nom'] && $_POST['day'] && $_POST['month'] && $_POST['year'] && $_POST['adresse'] && $_POST['identifiant'] && $_POST['motdepasse'] && $_POST['vaccin']) {
                    
            $queryInsert = "";
            
            $queryInsert["nom"] = $_POST["nom"];
            $queryInsert["prenom"] = $_POST["prenom"];
            $queryInsert["dateNaissance"] = $_POST["year"]."-".$_POST["month"]."-".$_POST["day"];
            $queryInsert["adresse"] = $_POST["adresse"];
            $queryInsert["role"] = 1;
            $queryInsert["identifiant"] = $_POST["identifiant"];
            $queryInsert["motdepasse"] = $_POST["motdepasse"];
            $queryInsert["vaccin"] = intval($_POST["vaccin"]);
                         
            $query = "INSERT INTO `personne`(`nom`, `prenom`, `dateNaissance`, `adresse`, `role`, `identifiant`, `motdepasse`, `idVaccin`) VALUES (?,?,?,?,?,?,?,?)";
            $requestInsert = $database->prepare($query);
            $requestInsert->bind_param('ssssissi', $queryInsert["nom"], $queryInsert["prenom"], $queryInsert["dateNaissance"], $queryInsert["adresse"], $queryInsert["role"], $queryInsert["identifiant"], $queryInsert["motdepasse"], $queryInsert["vaccin"]);
            // $result = $request->execute();

            if ($requestInsert->execute()) {
                $hasError = false;
            }


        
        } else {
            $hasError = true;
        }
    }
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
    <title>Inscription</title>
</head>
<body>

    <header>
        <p>TousAntiCOVID<sub>LISTE</sub></p>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><defs><style>.a{fill:#5b17da;}</style></defs><path class="a" d="M46.5,19A1.49977,1.49977,0,0,0,45,20.5V22H40.87225a16.9,16.9,0,0,0-3.53-8.51367l2.92121-2.92139,1.17582.99561a1.49993,1.49993,0,1,0,2.12134-2.1211l-4.99991-5a1.4999,1.4999,0,0,0-2.12127,2.1211l.99565,1.17578-2.92139,2.92138A16.90205,16.90205,0,0,0,26,7.12793V3h1.5a1.5,1.5,0,0,0,0-3h-7a1.5,1.5,0,0,0,0,3H22V7.12793a16.90205,16.90205,0,0,0-8.51367,3.52978L10.56494,7.73633l.99565-1.17578a1.4999,1.4999,0,0,0-2.12127-2.1211l-4.88475,5a1.49993,1.49993,0,0,0,2.12133,2.1211l1.06067-.99561,2.92121,2.92139A16.9,16.9,0,0,0,7.12775,22H3V20.5a1.5,1.5,0,0,0-3,0v7a1.5,1.5,0,0,0,3,0V26H7.12775a16.9,16.9,0,0,0,3.53,8.51367L7.73657,37.43506l-1.17582-.99561a1.49993,1.49993,0,0,0-2.12134,2.1211l4.99991,5a1.4999,1.4999,0,1,0,2.12127-2.1211l-.99565-1.17578,2.92127-2.92138A16.902,16.902,0,0,0,22,40.87207V45H20.5a1.5,1.5,0,0,0,0,3h7a1.5,1.5,0,0,0,0-3H26V40.87207a16.902,16.902,0,0,0,8.51379-3.52978l2.92127,2.92138-.99565,1.17578a1.4999,1.4999,0,0,0,2.12127,2.1211l4.99991-5a1.49993,1.49993,0,1,0-2.12134-2.1211l-1.17582.99561-2.92121-2.92139A16.9,16.9,0,0,0,40.87225,26H45v1.5a1.5,1.5,0,0,0,3,0v-7A1.49977,1.49977,0,0,0,46.5,19Zm-28,1A3.5,3.5,0,1,1,22,16.5,3.49994,3.49994,0,0,1,18.5,20ZM30,33a2,2,0,1,1,2-2A2.00006,2.00006,0,0,1,30,33Z"/></svg>
    </header>

    <main>   
        <form class="login" method="post">
            <h1>Inscription</h1>
            <div>
                <label for="username">Prénom<sup class="redstar">*</sup></label>
                <input name="prenom" id="prenom" type="text">
            </div>
            <div>
                <label for="username">Nom<sup class="redstar">*</sup></label>
                <input name="nom" id="nom" type="text">
            </div>
            <div>
                <label for="username">Date<sup class="redstar">*</sup></label>
                <div class="selects">
                    <select name="day" id="day">
                        <option value="01">1</option>
                        <option value="02">2</option>
                        <option value="03">3</option>
                        <option value="04">4</option>
                        <option value="05">5</option>
                        <option value="06">6</option>
                        <option value="07">7</option>
                        <option value="08">8</option>
                        <option value="09">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select>
                    <select name="month" id="month">
                        <option value="01">janvier</option>
                        <option value="02">février</option>
                        <option value="03">mars</option>
                        <option value="04">avril</option>
                        <option value="05">mai</option>
                        <option value="06">juin</option>
                        <option value="07">juillet</option>
                        <option value="08">août</option>
                        <option value="09">septembre</option>
                        <option value="10">octobre</option>
                        <option value="11">novembre</option>
                        <option value="12">décembre</option>
                    </select>
                    <select name="year" id="year">
                        <option value="1910">1910</option>
                        <option value="1911">1911</option>
                        <option value="1912">1912</option>
                        <option value="1913">1913</option>
                        <option value="1914">1914</option>
                        <option value="1915">1915</option>
                        <option value="1916">1916</option>
                        <option value="1917">1917</option>
                        <option value="1918">1918</option>
                        <option value="1919">1919</option>
                        <option value="1920">1920</option>
                        <option value="1921">1921</option>
                        <option value="1922">1922</option>
                        <option value="1923">1923</option>
                        <option value="1924">1924</option>
                        <option value="1925">1925</option>
                        <option value="1926">1926</option>
                        <option value="1927">1927</option>
                        <option value="1928">1928</option>
                        <option value="1929">1929</option>
                        <option value="1930">1930</option>
                        <option value="1931">1931</option>
                        <option value="1932">1932</option>
                        <option value="1933">1933</option>
                        <option value="1934">1934</option>
                        <option value="1935">1935</option>
                        <option value="1936">1936</option>
                        <option value="1937">1937</option>
                        <option value="1938">1938</option>
                        <option value="1939">1939</option>
                        <option value="1940">1940</option>
                        <option value="1941">1941</option>
                        <option value="1942">1942</option>
                        <option value="1943">1943</option>
                        <option value="1944">1944</option>
                        <option value="1945">1945</option>
                        <option value="1946">1946</option>
                        <option value="1947">1947</option>
                        <option value="1948">1948</option>
                        <option value="1949">1949</option>
                        <option value="1950">1950</option>
                        <option value="1951">1951</option>
                        <option value="1952">1952</option>
                        <option value="1953">1953</option>
                        <option value="1954">1954</option>
                        <option value="1955">1955</option>
                        <option value="1956">1956</option>
                        <option value="1957">1957</option>
                        <option value="1958">1958</option>
                        <option value="1959">1959</option>
                        <option value="1960">1960</option>
                        <option value="1961">1961</option>
                        <option value="1962">1962</option>
                        <option value="1963">1963</option>
                        <option value="1964">1964</option>
                        <option value="1965">1965</option>
                        <option value="1966">1966</option>
                        <option value="1967">1967</option>
                        <option value="1968">1968</option>
                        <option value="1969">1969</option>
                        <option value="1970">1970</option>
                        <option value="1971">1971</option>
                        <option value="1972">1972</option>
                        <option value="1973">1973</option>
                        <option value="1974">1974</option>
                        <option value="1975">1975</option>
                        <option value="1976">1976</option>
                        <option value="1977">1977</option>
                        <option value="1978">1978</option>
                        <option value="1979">1979</option>
                        <option value="1980">1980</option>
                        <option value="1981">1981</option>
                        <option value="1982">1982</option>
                        <option value="1983">1983</option>
                        <option value="1984">1984</option>
                        <option value="1985">1985</option>
                        <option value="1986">1986</option>
                        <option value="1987">1987</option>
                        <option value="1988">1988</option>
                        <option value="1989">1989</option>
                        <option value="1990">1990</option>
                        <option value="1991">1991</option>
                        <option value="1992">1992</option>
                        <option value="1993">1993</option>
                        <option value="1994">1994</option>
                        <option value="1995">1995</option>
                        <option value="1996">1996</option>
                        <option value="1997">1997</option>
                        <option value="1998">1998</option>
                        <option value="1999">1999</option>
                        <option value="2000">2000</option>
                        <option value="2001">2001</option>
                        <option value="2002">2002</option>
                        <option value="2003">2003</option>
                        <option value="2004">2004</option>
                        <option value="2005">2005</option>
                        <option value="2006">2006</option>
                        <option value="2007">2007</option>
                        <option value="2008">2008</option>
                        <option value="2009">2009</option>
                        <option value="2010">2010</option>
                        <option value="2011">2011</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="adresse">Adresse<sup class="redstar">*</sup></label>
                <input name="adresse" id="adresse" type="text">
            </div>
            <div>
                <label for="identifiant">Identifiant<sup class="redstar">*</sup></label>
                <input name="identifiant" id="identifiant" type="text">
            </div>
            <div>
                <label for="motdepasse">Mot de passe<sup class="redstar">*</sup></label>
                <input name="motdepasse" id="motdepasse" type="password">
            </div>
            <div>
                <label for="vaccin">Vaccin<sup class="redstar">*</sup></label>
                <select name="vaccin" id="vaccin">
                    <option value="1">Pfizer</option>
                    <option value="2">Moderna</option>
                    <option value="3">AstraZeneca</option>
                    <option value="4">Janssen</option>
                </select>
            </div>
            <p class="message active"><sup class="redstar">*</sup> : Champs obligatoires</p>
            <?php
                if(isset($hasError)) {
            ?>
            <p class="message <?php if($hasError) {echo "active error";} else { echo "active valid";} ?>"><?php if($hasError) {echo "Veuillez remplir tous les champs";} else { echo "Inscription réussie";} ?></p>
            <?php
                }
            ?>
            <input type="submit" value="Se connecter" id="connect">
            <p class="message active">Déjà un compte ? <a href="../index.php">Connectez-vous</a>.</p>
        </form>
    </main>


    <script src="js/script.js"></script>
</body>
</html>