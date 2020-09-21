<?php
include 'connexion.php';
$uploadOk = 1;
if(isset($_POST["submit"])) {
    //Récupération les données de formulaire
    $prenom = $_POST['prenom'];
    $nom  = $_POST['nom'];
    $civilite  = $_POST['civilite'];
    $email  = $_POST['email'];
    $cne  = $_POST['cne_apogee'];
    $cin  = $_POST['numero_cin'];
    $telephone  = $_POST['telephone'];
    $ville  = $_POST['ville'];
    //chemin de stockage des fichiers
    $target_dir = "../Storage" ."/". strtoupper($cin);
    if (!is_dir($target_dir))
    {
        mkdir($target_dir);
    }
//récuperation des fichiers pdf
    $rand_cv = mt_rand();
    $rand_cin= mt_rand();
    $rand_bac= mt_rand();
    $rand_diplome= mt_rand();


    $target_cv = $target_dir ."/". basename("$rand_cv".".pdf");
    $target_cin = $target_dir ."/". basename("$rand_cin".".pdf");
    $target_bac = $target_dir ."/". basename("$rand_bac".".pdf");
    $target_diplome = $target_dir ."/". basename("$rand_diplome".".pdf");

    $target_cv_sql = strtoupper($cin) ."/". basename("$rand_cv".".pdf");
    $target_cin_sql = strtoupper($cin) ."/". basename("$rand_cin".".pdf");
    $target_bac_sql = strtoupper($cin) ."/". basename("$rand_bac".".pdf");
    $target_diplome_sql = strtoupper($cin) ."/". basename("$rand_diplome".".pdf");

    $target_cv_tmp = $_FILES["file_cv"]["tmp_name"];
    $target_cin_tmp = $_FILES["file_cin"]["tmp_name"];
    $target_bac_tmp = $_FILES["file_bac"]["tmp_name"];
    $target_diplome_tmp = $_FILES["file_diplome"]["tmp_name"];


//Ajout des fichiers pdf dans un tableau pour la vérification
    $targget_files = array($target_cv,$target_cin,$target_bac,$target_diplome);
    $targget_files_tmp = array($target_cv_tmp,$target_cin_tmp,$target_bac_tmp,$target_diplome_tmp);
    foreach ($targget_files as $target_file)
    {
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Allow certain file formats
        if ($imageFileType != "pdf") {
            echo "Désolé, seuls les fichiers PDF sont autorisés.";
            $uploadOk = 0;
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }
    }
$sql = "INSERT INTO preinscriptions (prenom, nom, civilite, email, cne, cin, telephone, ville, file_cv, file_cin, file_bac, file_diplome) 
        VALUES ('$prenom','$nom','$civilite','$email','$cne','$cin','$telephone','$ville','$target_cv_sql','$target_cin_sql','$target_bac_sql','$target_diplome_sql')";
$conn->exec($sql);

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été uploader.";
// if everything is ok, try to upload file
    } else {
            for($i=0;$i<4;$i++)
            {
                if (move_uploaded_file($targget_files_tmp[$i], $targget_files[$i])) {
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
    }

    header("Location: ../remerciement.html");
}
