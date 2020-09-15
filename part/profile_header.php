<?php 
    $link = basename($_SERVER['PHP_SELF'], '.php');
    $css_link = '../css/style.css';
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
            <img class="img-profil" src="../img/Elephpant.png" alt="">
            <p><a class="active-link" href="../pages/logout.php">Déconnecter</a></p>
        </div>
    </header>