<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="twitter:card" content="summary"/>
        <meta name="twitter:site" content="https://yokai-pizza.000webhostapp.com">
        <meta name="twitter:title" content="Cuisson à la Vapeur Douce"/>
        <meta name="twitter:description" content="Je sais tout, demandez moi : cuisson vapeur douce"/>
        <meta name="twitter:image" content="logo.png"/>

        <meta property="og:title" content="Cuisson à la Vapeur Douce"/>
        <meta property="og:url" content="https://yokai-pizza.000webhostapp.com/">
        <meta property="og:description" content="Je sais tout, demandez moi : cuisson vapeur douce"/>
        <meta property="og:image" content="logo.png"/>
        <link rel="stylesheet" href="style.css"> 
        <title>Cuisson douce</title>
    </head>
    <body>
        <h1>CUISSON VAPEUR</h1>
        <div class="formulaire">
            <form action="" method="post">
                <label for="recherche">Votre recherche</label>
                <input type="text" id="recherche" name="recherche"/>
                <input type="submit" value="OK">
            </form>
        </div>
        <div class="fondDestock">
            <img src="fondDestock3.jpg" alt="une casserole avec vapeur" height="500px">
        </div>
        <div class="fondMobile">
            <img src="fondMobile.jpg" alt="vapeur d'eau" height="200px">
        </div>
<?php
    $search = htmlspecialchars($_POST['recherche'], ENT_QUOTES);// Sécurisation des lignes de caractères
    $search = str_replace(' ','+',$search);
    $search = str_replace('-','+',$search);                     // Remplace 
    $search = strtolower($search);                              // Tout en minuscules
    $search = ucwords($search);                                 // Majuscule 1ère lettre

        // 1) On ouvre session curl
    $curl = curl_init();   
        curl_setopt($curl, CURLOPT_URL,'https://api.hmz.tf/?id=' . $search);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Sauvegarde le résultat dans la variable $data grâce à la fonction curl_exec qui est dans cete variable
        curl_setopt($curl,CURLOPT_TIMEOUT, 1); // accorde 1 seconde pour afficher le résultat

        // 2) Pour exécuter la requête (dans la variable $curl) et donc afficher le résultat, on utilise la fonction curl_exec
    $data = curl_exec($curl); //Renvois false en cas de pb et true si tt est ok
        // 4) On utlise un curl_close pour fermer la session curl et libérer la mémoire utilisée.On ferme TJS une session curl que l'on a initié.
        curl_close($curl);

    $data = json_decode($data, true); //Utilisation d'un json_decode pour décoder le format json de l'api. True pour dire que l'on souhaite un tableau associatif. 
    

        echo "<div class='echoReponse'";                                  // création div pour css réponse
    if(array_key_exists('nom', $data['message'])){                      // condition d'affichage pour le nom et la cuisson
        echo "L'Aliment recherché :" . ' ' . htmlentities($data['message']['nom'], ENT_QUOTES);
        echo "</br>Son temps de cuisson est de " . htmlentities($data['message']['vapeur']['cuisson'], ENT_QUOTES);
    }else{
        echo "Désolée je ne connaît pas cet aliment";
    }

    if(array_key_exists('trempage', $data['message']['vapeur'])){           // condition d'affichage pour le trempage et le niveau d'eau
        echo "</br>Cet aliment nécessite" . ' ' . htmlentities($data['message']['vapeur']['trempage'], ENT_QUOTES) . ' ' . "de trempage";
        echo "</br>Le niveau d'eau doit être de " . htmlentities($data['message']['vapeur']["niveau d'eau"], ENT_QUOTES);
    }
        echo "</div>";
      
?>
</body>
</html>