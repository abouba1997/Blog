<?php 
    require '../db/connexion_db.php';

    $checked = false;
    $errors = array();

    if(isset($_POST['pseudo']) AND isset($_POST['password'])) {
        if(!empty($_POST['pseudo']) && !empty($_POST['password'])) {
            if(preg_match("/^[a-zA-Z-]*$/", strip_tags(html_entity_decode($_POST['pseudo'])))) {
                $pseudo = strip_tags(html_entity_decode($_POST['pseudo']));

                $sql = "SELECT id, password FROM members WHERE pseudo = :pseudo";
                $req = $db->prepare($sql);
                $req->execute(array('pseudo' => $pseudo));
                $result = $req->fetch();
                
                if($result) {
                    $password = strip_tags(html_entity_decode($_POST['password']));
                    $isPasswordCorrect = password_verify(strip_tags(html_entity_decode($_POST['password'])), $result['password']);

                    $checked = $_POST['connexion_auto'];
                
                    if($isPasswordCorrect) {
                        session_start();
                        $_SESSION['id'] = $result['id'];

                        if($checked == true) {
                            setcookie('pseudo', $pseudo, time() + (86400 * 30), null, null, false, true);
                            setcookie('password', $password, time() + (86400 * 30), null, null, false, true);
                        }
                        
                        header("Location: ../index.php");
                    } else {
                        array_push($errors, "Mauvais identifiant ou mot de passe.");
                    }
                } else {    
                    array_push($errors, "Mauvais identifiant ou mot de passe.");
                }
            } else {
                array_push($errors, 'Pseudo incorrect.');
            }
        }else {
            array_push($errors, 'Pseudo incorrect', 'Mot de passe incorrect');
        }
    }

    require '../part/header.php';
?>

<div class="connexion">
        <div class="connexion-dev">
            <div class="errors">
                <ul>
                <?php foreach($errors as $error): ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
            <form method="post">
                <div class="row">
                    <div class="col-25">
                        <label for="pseudo">Pseudo: </label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="pseudo" id="pseudo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="password">Mot de passe: </label>
                    </div>
                    <div class="col-75">
                        <input type="password" name="password" id="password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="connexion_auto">Connexion automatique : </label>
                    </div>
                    <div class="col-75">
                        <input type="checkbox" name="connexion_auto" id="connexion_auto">
                    </div>
                </div>
                
                <div class="row">
                    <div class="row-submit">
                        <input type="submit" value="Connecter">
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php require '../part/footer.php'; ?>