<?php 
    session_start();
    require '../db/connexion_db.php';
    require '../part/profile_header.php';

    $pseudo = '';
    $email = '';
    $date = '';
    $img = '';
    $basename = '';

    if($_SESSION) {
        $sql_session = "SELECT pseudo, email, date_inscription FROM members WHERE id = :id";
        $req_session = $db->prepare($sql_session);
        $req_session->execute(array('id' => $_SESSION['id']));

        $result = $req_session->fetch();

        if($result) {
            $pseudo = $result['pseudo'];
            $email = $result['email'];
            $date = $result['date_inscription'];
            $img = $result['image_profile'];
        }
    } else {
        header("Location: ../index.php");
    }

    if(!empty(isset($_FILES['file_profil'])) AND $_FILES['file_profil']['error'] == 0) {
        if($_FILES['file_profil']['size'] <= 1000000) {
            $infosfichier = pathinfo($_FILES['file_profil']['name']);
            $extension_upload = $infosfichier['extension'];
            $extension_autorisee = array('jpg', 'jpeg', 'gif', 'png');

            if(in_array($extension_upload, $extension_autorisee)) {
                mkdir("../uploads/$pseudo");
                $basename = basename($_FILES['file_profil']['name']);
                $path_img = "../uploads/$pseudo/".$basename;
                move_uploaded_file($_FILES['file_profil']['tmp_name'], $path_img);

                $sql_img = "UPDATE members SET image_profile=:image_profile";
                $req_img = $db->prepare($sql_img);
                $req_img->execute(array('image_profile' => $basename));
            }
        }
    }
?>

    <div class="profile-container">
        <div class="profiles">
            <div class="photo">
                <div>
                    <?php 
                        $sql_image = "SELECT image_profile FROM members WHERE pseudo = :pseudo";
                        $req_image = $db->prepare($sql_image);
                        $req_image->execute(array('pseudo' => $pseudo));

                        $result_image = $req_image->fetch();

                        $img_correct = '';
                        if($result_image['image_profile'] == 'default.png') {
                            $img_correct = "../img/default.png";
                        } else {
                            $img_correct = "../uploads/".$pseudo."/".$result_image['image_profile'];
                        }
                    ?>
                    <img src="<?= $img_correct; ?>" onclick="imageCorrespond()" id="image_set" alt="">
                    <div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="file" name="file_profil" id="file_profil" style="display:none;">
                            <li><input class="bton" type="submit" value="Modifier mon photo"></li>
                        </form>
                    </div>
                </div>
            </div>
            <div class="vl"></div>
            <div class="informations">
                <div class="informations-content">
                    <p>Pseudo: <strong><?= $pseudo; ?></strong></p>
                    <p>Email: <strong><?= $email; ?></strong></p>
                    <p>Date d'inscription: <strong><?= $date; ?></strong>
                </div>
                <div class="informations-buttons">
                    <li><a href="">Modifier ou Compléter mon profil</a></li>
                </div>
            </div>
        </div>

        <div class="posts">
            <div class="Redaction-article">
                <h1>Poster un article</h1>
            </div>

            <div class="comments_articles">
                <h1>Commenter un article</h1>
            </div>
        </div>
    </div>

    <script>
        function imageCorrespond() {
            document.getElementById('file_profil').click();
        }

        // function displayImage(e) {
        //     if(e.files[0]) {
        //         var reader = new FileReader();
        //         reader.onload = function(e) {
        //             document.getElementById('image_set').setAttribute('src', e.target.result);
        //         }
        //         reader.readAsDataURL(e.files[0]);
        //     }
        // }
    </script>

<?php require '../part/footer.php'; ?>