<?php
require __DIR__ . "/vendor/autoload.php";

## ETAPE 0

## CONNECTEZ VOUS A VOTRE BASE DE DONNEE

$pdo = new PDO('mysql:host=localhost;dbname=bddrendus3php', "root", "root");

## ETAPE 1

## RECUPERER TOUT LES PERSONNAGES CONTENU DANS LA TABLE personnages

## ETAPE 2

## LES AFFICHERS DANS LE HTML
## AFFICHER SON NOM, SON ATK, SES PV, SES STARS

## ETAPE 3

## DANS CHAQUE PERSONNAGE JE VEUX POUVOIR APPUYER SUR UN BUTTON OU IL EST ECRIT "STARS"

## LORSQUE L'ON APPUIE SUR LE BOUTTON "STARS"

## ON SOUMET UN FORMULAIRE QUI METS A JOURS LE PERSONNAGE CORRESPONDANT (CELUI SUR LEQUEL ON A CLIQUER) EN INCREMENTANT LA COLUMN STARS DU PERSONNAGE DANS LA BASE DE DONNEE

#######################
## ETAPE 4
# AFFICHER LE MSG "PERSONNAGE ($name) A GAGNER UNE ETOILES"

?>
<?php
$query = $pdo->prepare("SELECT * FROM `personnages`");
$query->execute();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rendu Php</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="nav mb-3">
    <a href="./rendu.php" class="nav-link">Acceuil</a>
    <a href="./personnage.php" class="nav-link">Mes Personnages</a>
    <a href="./combat.php" class="nav-link">Combats</a>
</nav>
<h1>Mes personnages</h1>

<div class="w-100 mt-5">
    <p>Nom ATK PV type_id Etoiles</p><br>
    <?php
    while ($type = $query->fetch()) {?>
        <?php
        if(isset($_POST['star'.$type['id']])){

            $type['stars']++;
            $queryUpdate = $pdo->prepare("UPDATE `personnages` SET stars = :stars WHERE `name` = :`name`");
            $queryUpdate->execute(["stars"=>$type["stars"], "name"=>$type["name"]]);
            echo $type["name"]." a gagné 1 étoile";

        }
        ?>
    <p> <?= $type['name']; ?> <?= $type['atk']; ?> <?= $type['pv']; ?> <?= $type['type_id']; ?> <?= $type['stars']; ?>

        <form action="" method="POST">
            <button name="star<?=$type['id']?>">Stars</button>
        </form></p>

    <?php
    }?>
</div>

</body>
</html>
