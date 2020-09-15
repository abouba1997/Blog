<?php 
    $link = basename($_SERVER['PHP_SELF'], '.php');
    $css_link = '../css/style.css';

    require '../db/connexion_db.php';

    $sql_image = "SELECT image_profile FROM members WHERE pseudo = :pseudo";
    $req_image = $db->prepare($sql_image);
    $req_image->execute(array('pseudo' => $pseudo));

    $result_image = $req_image->fetch();

    $img_correct = '';
    if($result_image['image_profile'] == 'default.png') {
        $img_correct = "../img/default.png";
    } else {
        $img_correct = "../uploads/".$result_image['image_profile'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Espace membre</title>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $css_link ?>">
    <link rel="shortcut icon" href="../img/phpMyAdmin.png" type="image/x-icon">
</head>
<body>
    <header>
        <div class="logo"><a href="../index.php" class="a-titre">BLOG</a></div>
        <div class="profil-list">
            <img class="img-profil" src="<?=$img_correct;?>" alt="">
            <p><a class="active-link" href="../pages/logout.php">Déconnecter</a></p>
        </div>
    </header>