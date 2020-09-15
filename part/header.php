<?php 
    session_start();

    $link = basename($_SERVER['PHP_SELF'], '.php');
    $css_link = '';
    $index = $inscription = $connexion = $contact = $about = 'active';
    $index_l = "index.php";
    
    if($link == 'index') {
        $index = 'active-link';
        $css_link = 'css/style.css';
        require 'db/connexion_db.php';
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

    
    $img_profile = '';
    if($_SESSION) {
        $id_user = $_SESSION['id'];
        $sql_img_prof = "SELECT image_profile FROM members WHERE id=:id";
        $req_img_prof = $db->prepare($sql_img_prof);
        $req_img_prof->execute(array('id'=>$id_user));

        $result_img_prof = $req_img_prof->fetch();
        $img_profile = "uploads/".$result_img_prof['image_profile'];
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
            <?php if(!$_SESSION):?>
            <li><a class=<?= $inscription; ?> href="../pages/inscription.php">Inscrire</a></li>
            <li><a class=<?= $connexion; ?> href="../pages/connexion.php">Connecter</a></li>
            <?php endif; ?>
            <li><a class=<?= $contact; ?> href="../pages/contact.php">Contact</a></li>
            <li><a class=<?= $about; ?> href="../pages/about.php">Informations</a></li>
        </ul>
        <?php if($_SESSION): ?>
        <div class="session-user">
            <a href="../pages/profile.php"><img src="<?= $img_profile; ?>" alt=""></a>
        </div>
        <?php endif; ?>
    </header>