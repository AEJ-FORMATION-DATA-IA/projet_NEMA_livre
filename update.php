<?php
    require 'connexion.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }
    
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
           $isImageUpdated = false;
        }    
        else{
            $isImageUpdated = true;
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

        if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))

        {
            $db = Database::connect();
            if($isImageUpdated)
            {
                $statement = $db->prepare("UPDATE livre SET titre = ?, description = ?, auteur = ?, date_parution = ?, image = ? WHERE id_livre = ?");
                $statement->execute(array($titre,$description,$auteur,$parution,$image,$id));

            }
            else
            {
                $statement = $db->prepare("UPDATE livre SET titre = ?, description = ?, auteur = ?, date_parution = ? WHERE id_livre = ?");
                $statement->execute(array($titre,$description,$auteur,$parution,$id));        
            }

            Database::disconnect();
            header("Location: acceuil.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("SELECT image FROM livre WHERE id_livre = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image = $item['image'];
            Database::disconnect();
        }

    }
    else
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM livre WHERE id_livre = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $titre            = $item['titre'];
        $description      = $item['description'];
        $auteur           = $item['auteur'];
        $parution         = $item['date_parution'];
        $image            = $item['image'];
        $image            = $item['image'];
        Database::disconnect();
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>GESTION DES LIVRES</title>
</head>
    <body>

    <h1 class="text-logo"> <span class="glyphicon glyphicon-"></span> GESTION DES LIVRES <span class="glyphicon glyphicon-"></span> </h1>
    <div class="container admin">
            <div class="row">
                <div class="col-sm-6">
                    <h1><strong>Modifier un livre</strong></h1>
                        <br>
                        <form action="<?php echo 'update.php?id=' .$id; ?>" role="form" method="post" class="form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="titre">Titre : </label>
                                        <input type="text" class="form-control" name="titre" id="titre" placeholder="Nom" value="<?php echo $titre; ?>"> 
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
                                        <label for="">Image:</label>
                                        <p><?php echo $image; ?></p>
                                        <label for="image">Selectionner une image : </label>
                                        <input type="file" name="image" id="image">
                                        <span class="help-inline"><?php echo $imageError;?></span>
                                        <br>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Modifier</span></button>
                                        <a class="btn btn-primary" href="acceuil.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                                    </div>
                        </form>
                </div>
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo 'images/' . $image; ?>" alt="...">
                        </div>
                    </div>
                </div>
        
        </div>
    </div>

    </body>
</html>