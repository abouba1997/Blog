<?php 
    require '../db/connexion_db.php';

    $errors = "";
    $msg = '';
    $okay = false;

    if(isset($_POST['pseudo']) AND isset($_POST['password']) AND isset($_POST['re_password']) AND isset($_POST['email'])) {
        if(!empty($_POST['pseudo']) && !empty($_POST['password']) && !empty($_POST['re_password']) && !empty($_POST['email'])) {
            
            if(preg_match("/^[a-zA-Z-]*$/", strip_tags(html_entity_decode($_POST['pseudo'])))) {
                $pseudo = strip_tags(html_entity_decode($_POST['pseudo']));

                $sql_check_pseudo = "SELECT COUNT(*) AS nbre_pseudo FROM members WHERE pseudo = :pseudo";
                $req_check_pseudo = $db->prepare($sql_check_pseudo);
                $req_check_pseudo->execute(array('pseudo' => $pseudo));
                $result_check_pseudo = $req_check_pseudo->fetch();

                if($result_check_pseudo['nbre_pseudo'] == 0) {
                    if($_POST['password'] == $_POST['re_password']) {
                        $password = strip_tags(html_entity_decode($_POST['password']));
                    
                        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                            $email = $_POST['email'];

                            $sql_check_email = "SELECT COUNT(*) AS nbre_email FROM members WHERE email = :email";
                            $req_check_email = $db->prepare($sql_check_email);
                            $req_check_email->execute(array('email' => $email));
                            $result_check_email = $req_check_email->fetch();

                            if($result_check_email['nbre_email'] == 0) {
                                $okay = true;
                                
                                if($okay) {
                                    $pass_hash = password_hash($password, PASSWORD_DEFAULT);
                                    $sql = "INSERT INTO members(pseudo, password, email, image_profile, date_inscription) VALUES(:pseudo, :password, :email, 'default.png', CURDATE())";
                                    $req = $db->prepare($sql);
        
                                    $tabs_entry = array(
                                        'pseudo' => $pseudo,
                                        'password' => $pass_hash,
                                        'email' => $email
                                    );
                                    
                                    $req->execute($tabs_entry);
        
                                    header('Location: inscription.php?signup=success');
                                }
                            }else {
                                $errors = "Email déja utilisé.";
                            }
                        }else {
                            $errors = 'Votre email est incorrect.';
                        }
                    }else {
                        $errors = "Les mots de passe ne correspondent pas.";
                    }
                } else {
                    $errors = "Ce pseudo est déja utilisé.";
                }
            }else {
                $errors = 'Votre pseudo est incorrect.';
            }
        } else {
            $errors = "Les champs sont vides, veuillez les remplir correctement!.";
        }
    }

    if($_GET['signup'] == "success") {
        $msg = "Vous avez été bien inscrit sur notre blog.";
    }

    require '../part/header.php';

?>

    <div class="inscription">
        <div class="inscription-dev">
            <div>
                <?php if($errors): ?>
                    <p class="errors"><?= $errors; ?></p>
                <?php elseif($msg): ?>
                    <p class="success"><?= $msg; ?></p>
                <?php endif; ?>
            </div>
            <form action="" method="post">
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
                        <label for="re_password">Retapez le mot de passe :</label>
                    </div>
                    <div class="col-75">
                        <input type="password" name="re_password" id="re-password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="email">E-mail: </label>
                    </div>
                    <div class="col-75">
                        <input type="email" name="email" id="email">
                    </div>
                </div>
                <div class="row">
                    <div class="row-submit">
                        <input type="submit" value="Inscrire">
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php require '../part/footer.php'; ?>