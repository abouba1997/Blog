<?php 
    $link = basename($_SERVER['PHP_SELF'], '.php');
    $css_link = '';
    $index = $inscription = $connexion = $contact = $about = 'active';
    $index_l = "index.php";
    
    if($link == 'index') {
        $index = 'active-link';
        $css_link = 'css/style.css';
    } elseif ($link == 'inscription') {
        $inscription = 'active-link';
        $css_link = '../css/style.css';
        $index_l = "../index.php";
    } elseif ($link == 'connexion') {
        $connexion = 'active-link';
        $css_link = '../css/style.css';
        $index_l = "../index.php";
    } elseif ($link == 'contact') {
        $contact = 'active-link';
        $css_link = '../css/style.css';
        $index_l = "../index.php";
    } elseif ($link == 'about') {
        $about = 'active-link';
        $css_link = '../css/style.css';
        $index_l = "../index.php";
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
</head>
<body>
    <header>
        <div class="logo"><a href="index.php">BLOG</a></div>
        <ul class="list">
            <li><a class=<?= $index; ?> href="<?= $index_l; ?>">Accueil</a></li>
            <li><a class=<?= $inscription; ?> href="../pages/inscription.php">Inscrire</a></li>
            <li><a class=<?= $connexion; ?> href="../pages/connexion.php">Connecter</a></li>
            <li><a class=<?= $contact; ?> href="../pages/contact.php">Contact</a></li>
            <li><a class=<?= $about; ?> href="../pages/about.php">Informations</a></li>
        </ul>
    </header>