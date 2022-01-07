<?php
session_start();
include_once('connexion.php');
$req = "SELECT * FROM plat 
 INNER JOIN photo WHERE plat.id_plat = photo.id_plat";
$query = $mysqli->query($req);


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/starter.css">
    <link rel="stylesheet" type="text/css" href="css/design.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
        integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="jquery-3.1.0.js"></script>
    <title> Los poyos Hermanos </title>
</head>

<body>
    <div>
        <?php
        if (isset($_SESSION['auth']['nom'])) {
            echo " Bienvenue" . $_SESSION['auth']['nom'];
        }

        ?>
    </div>
    <div class="motion">
        <video poster="medias/resto.jpg" id="bgvid" playsinline intrinsicsize autoplay muted loop width="1500">
            <source src="medias/resto.mp4" type="video/mp4">
        </video>
    </div>

    <div class="main ">
        <?php
        echo "
                <h1> Tous nos plats </h1>
                <nav class=\"navbar navbar-inverse bg-inverse fixed-right bg-faded\">
    <div class=\"row\">
        <div class=\"col\">
          <button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#cart\">Cart (<span class=\"total-count\"></span>)</button><button class=\"clear-cart btn btn-danger\">Clear Cart</button></div>
    </div>
</nav>

                <div class=\"cards-container\">";
        while ($row = $query->fetch_array()) {
            echo "
                        <div  id=\"card\" >
                        <h2>" . $row["nom_plat"] . "</h2>";
            if (empty($row["nom_photo"])) {
                echo "<p>
                    <img src =\"medias/nophoto.jpg\" alt=\"Pas de visuel \" class=\"card-img-top\">
                    </p>";
            } else {
                echo "
                    <img src=\"medias/" . $row["nom_photo"] . "\" alt=\"Plat : " . $row["nom_plat"] . "\">
                    ";
            }

            echo "
            <div class=\"card-body\">
                <p class=\"card-text\">Quantité restante :  " . $row["quantite_plat"] . "</p>
                <p class=\"card-text\">Prix : " . number_format($row["prix_plat"], 2, ',', '.') . "€</p>
                <p class=\"card-text\"><a data-name=\"" . $row["nom_plat"] . "\" data-price=\"" . $row["prix_plat"] . "\" . class=\"add-to-cart btn btn-primary\">Ajouter au panier</a>
                </p>           
                ";
            if (isset($_SESSION['auth']['id'])) {
                echo "<button class='btn btn-danger white' > <a href='supprimer-plat.php?id=\"" . $row["id_plat"] . "\"' id=\"white\"> Supprimer</a> </button>
                <button class='btn btn-primary white' > <a href='modifier-plat.php?id=\"" . $row["id_plat"] . "\"' id=\"white\">Modifier</a> </button>";
            }
            echo"
                </div>   
            </div>
           ";
        }
        echo " </div>
        </div>"
        ?>

    </div>
    <div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Panier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="show-cart table">

                    </table>
                    <div>Total price: $<span class="total-cart"></span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary">Commander</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="cart.js"> </script>

</body>

</html>