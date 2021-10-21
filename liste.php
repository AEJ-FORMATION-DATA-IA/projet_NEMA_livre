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
            <div>
                <?php require 'connexion.php';
                    $db = Database::connect();
                    $statement = $db->query("SELECT * FROM livre");
                    $categories = $statement->fetchAll();

                    foreach($categories as $category)
                    {
                            if($category['id_livre'])
                                echo '<div class="tab-pane" id="' . $category['id_livre'] . '">';

                            echo '<div class="row">';

                            $statement = $db->prepare('SELECT * FROM livre WHERE id_livre = ?');
                            $statement->execute(array($category['id_livre']));
                            while($item = $statement->fetch())
                            {
                                echo '<div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <img src="images/' .$item['image'] . '" alt="...">
                                            <div class="price">' . $item['titre']. '</div>
                                            <div class="caption">
                                                <h4>' . $item['auteur'] . '</h4>
                                                <p>' . $item['description'] . '</p>
                                                <p>' . $item['date_parution'] . '</p>
                                                <a href="update.php?id=' . $item['id_livre'] . '" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>
                                                <a href="delete.php?id=' . $item['id_livre'] . '" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>
                                            </div>
                                        </div>
                                        </div>';
                                }
                                echo '</div>
                                </div>';
                    } 
                    Database::disconnect();    
                    echo '</div>';   
                
                ?>
            </div>

        </div>
    </div>


    </body>
</html>