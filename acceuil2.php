<?php require 'connexion.php';
                    $db = Database::connect();
                    $statement = $db->query("SELECT * FROM livre order by id_livre DESC");
                    
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
        <h1><strong>Liste des livres</strong><a href="insert.php" class="btn btn-succcess btn-lg"> <span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
            
            <?php while($item = $statement->fetch())
                            {
                    echo '<div class="row border p-2 m-2">';
                    echo '<div class="col-md-6 border p-3">'; 
                    echo '<img src="images/' .$item['image'] . '" alt="..." width="200px" height="200px"></div>';
                    echo '<div class="col-md-6"><h5>TITRE : </h5> <p>' . $item['titre']. '</p>';
                    echo '<h5>AUTEUR : </h5> <p>' . $item['auteur'] . '</p>';
                    echo '<h5>DESCRIPTION : </h5><p>' . $item['description'] . '</p>';
                    echo '<h5>DATE DE PARUTION : </h5><p>' . $item['date_parution'] . '</p>';
                    echo '<a href="update.php?id=' . $item['id_livre'] . '" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>
                    <a href="delete.php?id=' . $item['id_livre'] . '" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Supprimer</a></div>';
        echo '</div>';
        echo '</div>';
                            }?>


 


    </body>
</html>