<?php
require __DIR__ . "/vendor/autoload.php";

## ETAPE 0

## CONNECTEZ VOUS A VOTRE BASE DE DONNEE

$pdo = new PDO('mysql:host=localhost;dbname=bddrendus3php', "root", "root");

## ETAPE 1

## POUVOIR SELECTIONER UN PERSONNE DANS LE PREMIER SELECTEUR

## ETAPE 2

## POUVOIR SELECTIONER UN PERSONNE DANS LE DEUXIEME SELECTEUR

## ETAPE 3

## LORSQUE LON APPPUIE SUR LE BOUTON FIGHT, RETIRER LES PV DE CHAQUE PERSONNAGE PAR RAPPORT A LATK DU PERSONNAGE QUIL COMBAT

## ETAPE 4

## UNE FOIS LE COMBAT LANCER (QUAND ON APPPUIE SUR LE BTN FIGHT) AFFICHER en dessous du formulaire
# pour le premier perso PERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)
# pour le second persoPERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)

## ETAPE 5

## N'AFFICHER DANS LES SELECTEUR QUE LES PERSONNAGES QUI ONT PLUS DE 10 PV


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
<h1>Combats</h1>
<div class="w-100 mt-5">
    <?php
    $query = $pdo->prepare("SELECT * FROM personnages");
    $query->execute();
    if(!empty($_POST)){
        $perso1 = $_POST['perso1'];
        $perso2 = $_POST['perso2'];
        $dbPerso1 = getPerso($perso1, $pdo);
        $dbPerso2 = getPerso($perso2, $pdo);
        $pvPerso1 = $dbPerso1->pv - $dbPerso2->atk;
        $pvPerso2 = $dbPerso2->pv - $dbPerso1->atk;

        $newPerso1 = updatePerso($perso1, $pvPerso1, $pdo);
        $newPerso2 = updatePerso($perso2, $pvPerso2, $pdo);

    }
    function updatePerso($idPerso, $pvPerson, $pdo)
    {
        $query = $pdo->prepare("UPDATE personnages SET pv = :newPv WHERE id = :id");
        $query->execute(["id" => $idPerso, 'newPv' => $pvPerson]);
        $a = $query->fetch(PDO::FETCH_OBJ);
        $perso = getPerso($idPerso, $pdo);

        return $perso;
    }
    function getPerso($id, $pdo)
    {
        $query = $pdo->prepare("SELECT * FROM personnages WHERE id = :id");
        $query->execute(["id" => $id]);
        $a = $query->fetch(PDO::FETCH_OBJ);

        return $a;
    }
    ?>
    <form action="" method="POST">
        <div class="form-group">
            <select name="perso1" id="">
                <?php
                $query = $pdo->query('SELECT * FROM `personnages` WHERE pv > 10');
                while ($type = $query->fetch()) {?>
                        <option value="<?= $type['id']; ?>"> <?= $type['name']; ?></option>
                    <?php
                }?>
            </select>
        </div>
        <div class="form-group">
            <select name="perso2" id="">
                <?php
                $query = $pdo->query('SELECT * FROM `personnages` WHERE pv > 10');
                while ($type = $query->fetch()) {?>
                        <option value="<?= $type['id']; ?>"> <?= $type['name']; ?></option>
                    <?php
                }?>
            </select>
        </div>

        <button class="btn">Fight</button>
        <br>
        <?php
        if (!empty($newPerso1 && $newPerso2)){
            echo $newPerso2->name . " a perdu " . $dbPerso1->atk . " pv, il a donc actuellement " . $newPerso2->pv . "PV <br>";
            echo $newPerso1->name . " a perdu " . $dbPerso2->atk . " pv, il a donc actuellement " . $newPerso1->pv . "PV <br>";
        };
        ?>
    </form>

</div>

</body>
</html>
