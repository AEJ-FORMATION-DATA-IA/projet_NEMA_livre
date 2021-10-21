<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>GESTION DE LIVRES</title>
</head>
<body>
    <div class="container site">
        <h1 class="text-logo"> <span class="glyphicon glyphicon-"></span> GESTION DE LIVRES <span class="glyphicon glyphicon-"></span> </h1>
       <?php
        require 'connexion.php';
        echo '<nav>
        <ul class="nav nav-pills">';
        $db = Database::connect();
        $statement = $db->query("SELECT * FROM livre order by id_livre");
        $categories = $statement->fetchAll();
        foreach($categories as $category)
        {
            if($category['id_livre'])
                echo '<li role="presentation" class=""><a href="#' .  $category['id_livre'] . '" data-toggle="tab"></a></li>';
            else
            echo '<li role="presentation"><a href="#' .  $category['id_livre'] . '" data-toggle="tab">' .$category['titre']. '</a></li>';
        }
        echo '</ul>
        </nav>';

        echo '<div class="tab-content">';
        foreach($categories as $category)
        {
                if($category['id_livre'])
                    echo '<div class="tab-pane active" id="' . $category['id_livre'] . '">';
                else
                echo '<div class="tab-pane" id="' . $category['id_livre'] . '">';
        

                echo '<div class="row">';

                $statement = $db->prepare('SELECT * FROM livre WHERE id_livre = ? order by id_livre');
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
</body>
</html>