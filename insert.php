<?php
    require 'connexion.php';
    
    $titreError = $descriptionError = $auteurError =  $parutionError = $imageError = $titre = $description = $auteur = $parution =  $image = "";
   
    if(!empty($_POST))
    {
        $titre           = checkInput($_POST['titre']);
        $description     = checkInput($_POST['description']);
        $auteur          = checkInput($_POST['auteur']);
        $parution        = checkInput($_POST['parution']);
        $image           = checkInput($_FILES['image']['name']);
        $imagePath       = 'images/' .basename($image);
        $imageExtension  = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess       = true;
        $isUploadSuccess = false;

        if(empty($titre))
            {
                $titreError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }
        if(empty($description))
        {
            $descriptionError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($auteur))
        {
            $auteurError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($parution))
            {
                $parutionError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }      
        if(empty($image))
        {
            $imageError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }    
        else{
            $isUploadSuccess = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
            {
                $imageError = "Les fichiers autorises sont : .jpg, .jpeg, .png, .gif";
                $isSuccess = false;
            }
            if(file_exists($imagePath))
            {
                $imageError = "Le fichier existe deja";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000)
            {
                $imageError = "Le fichier ne dois pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess)
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
                {
                    $imageError = "Il y a une erreur lors de l'upload";
                    $isUploadSuccess = false;
                }
            }
        }    

        if($isSuccess && $isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO livre (titre,description,auteur,date_parution,image) values(?, ?, ?, ?, ?)");
            $statement->execute(array($titre,$description,$auteur,$parution,$image));
            Database::disconnect();
            header("Location: acceuil.php");
        }

    }


    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>GESTION DE LIVRES</title>
</head>
    <body>

    <h1 class="text-logo"> <span class="glyphicon glyphicon"></span> GESTION DE LIVRES <span class="glyphicon glyphicon"></span> </h1>
    <div class="container admin">
            <div class="row">
                <h1><strong>Ajouter un livre</strong></h1>
                <br>
                    <form action="insert.php" role="form" method="post" class="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="titre">Titre : </label>
                                <input type="text" class="form-control" name="titre" id="titre" placeholder="titre" value="<?php echo $titre; ?>"> 
                                <span class="help-inline"><?php echo $titreError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="description">Description : </label>
                                <input type="text" class="form-control" name="description" id="description" placeholder="description" value="<?php echo $description; ?>"> 
                                <span class="help-inline"><?php echo $descriptionError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="auteur">Auteur : </label>
                                <input type="text" class="form-control" name="auteur" id="auteur" placeholder="auteur" value="<?php echo $auteur; ?>"> 
                                <span class="help-inline"><?php echo $auteurError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="parution">Date de parution : </label>
                                <input type="date" class="form-control" name="parution" id="parution" placeholder="parution" value="<?php echo $parution; ?>"> 
                                <span class="help-inline"><?php echo $parutionError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="image">Image DU LIVRE : </label>
                                <input type="file" name="image" id="image">
                                <span class="help-inline"><?php echo $imageError;?></span>
                            </div>
                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Ajouter</span></button>
                    <a class="btn btn-primary" href="accueil.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                </div>
            </form>
        </div>
    </div>

    </body>
</html>