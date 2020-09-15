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
                $basename = basename($_FILES['file_profil']['name']);
                $filename = $pseudo.".".$basename;
                $path_img = "../uploads/".$pseudo.".".$basename;

                $sql_check_img = "SELECT image_profile FROM members WHERE id=:id";
                $req_check_img = $db->prepare($sql_check_img);
                $req_check_img->execute(array('id'=> $_SESSION['id']));
                $result_check_img = $req_check_img->fetch();

                if($result_check_img['image_profile'] !== $filename) {
                    move_uploaded_file($_FILES['file_profil']['tmp_name'], $path_img);
                    $sql_img = "UPDATE members SET image_profile=:image_profile WHERE id=:id";
                    $req_img = $db->prepare($sql_img);
                    $req_img->execute(array('image_profile' => $filename, 'id'=> $_SESSION['id']));
                }
            }
        }
    }

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

    <div class="profile-container">
        <div class="informations-buttons">
            <li><a href="">Modifier ou Compléter mon profil</a></li>
        </div>
        <div class="profiles">
            <div class="photo">
                <div>
                    <img src="<?= $img_correct; ?>" onclick="imageCorrespond()" id="image_set" alt="">
                    <p class="disp-photo" id="dispPhoto">Veuillez appuyer sur modifier pour garder la photo.</p>
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
                    <p>Nom: <strong>... (<?= $pseudo; ?>)</strong></p>
                    <p>Prenom: <strong>... (<?= $pseudo; ?>)</strong></p>
                    <p>Pseudo: <strong><?= $pseudo; ?></strong></p>
                    <p>Email: <strong><?= $email; ?></strong></p>
                    <p>Date de naissance: <strong>... (<?= $date; ?>)</strong>
                    <p>Date d'inscription: <strong><?= $date; ?></strong>
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

        var imageSet = document.getElementById('image_set');
        var fileInp = document.getElementById('file_profil');
        var dispPhoto = document.getElementById('dispPhoto');

        fileInp.addEventListener("change", function(){
            const file = this.files[0];
            if(file) {
                var reader = new FileReader();
                reader.onload = function() {
                    imageSet.setAttribute('src', this.result);
                }
                reader.readAsDataURL(file);
                dispPhoto.style.display = "block";
            }else {
                dispPhoto.style.display = null;
            }
        });
    </script>

<?php require '../part/footer.php'; ?>