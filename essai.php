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
          
        <?php require 'connexion.php';
                    $db = Database::connect();
                    $statement = $db->query("SELECT * FROM livre");
                    $categories = $statement->fetchAll();
                    foreach($categories)
                    {
                    if($categories['id_livre'])
                    ?>
                        <?php
                        echo '<div class="tab-pane" id="' . $categories['id_livre'] . '">';
                    
                        ?>
                    }

        </div>
    </div>
    </body>
</html>