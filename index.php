<?php
    
    include('inc/init.inc.php');

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

  </head>

  <body>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <ul class="nav navbar-nav">
        <li><a href="#">Agence</a></li>
        <li class="active"><a href="#">Demande</a></li>
        <li><a href="#">Logement</a></li>
        <li><a href="#">Personne</a></li>
    </ul>
  </div>
</nav>

    <div class="container" style="margin-top:10%">
 
      <div style="float: right;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#md_save" onclick="clear_modal();">Ajouter</button></div><br><br>

      <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Demandeur</th>
                <th scope="col">Type</th>
                <th scope="col">Ville</th>
                <th scope="col">Budget</th>
                <th scope="col">Superficie</th>
                <th scope="col">Categorie</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="myTable">

            <?php
            $result = $pdo->query("SELECT * FROM vue_demande_personne");

            while($demande = $result->fetch(PDO::FETCH_OBJ))
            {
                ?>
                    <tr>
                        <td><?php echo $demande->prenom ?></td>
                        <td><?php echo $demande->type ?></td>
                        <td><?php echo $demande->ville ?></td>
                        <td><?php echo $demande->budget ?></td>
                        <td><?php echo $demande->superficie ?></td>
                        <td><?php echo $demande->categorie ?></td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="deleteDemande('<?php echo $demande->idDemande ?>')"><i class="fas fa-trash-alt"></i></button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#md_save" onclick="getDemande('<?php echo $demande->idDemande ?>')"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                <?php
            } ?>

        </tbody>
    </table>


    <!-- Modal -->
    <div class="modal fade" id="md_save" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" id="myform" action="ajax/adddemande_ajax.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter demande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Demandeur</label>
                        <select class="form-control" id="demandeur" name="demandeur">
                            <option value="-1" selected>...</option>

                            <?php
                                $result = $pdo->query("SELECT * FROM personne");

                                while($personne = $result->fetch(PDO::FETCH_ASSOC))
                                {
                                    ?>
                                        <option value="<?php echo $personne["idPersonne"] ?>"><?php echo $personne["prenom"] ?></option>
                                    <?php
                                }
                                ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <input type="text" class="form-control" id="type" name="type" placeholder="Type">
                    </div>

                    <div class="form-group">
                        <label for="ville">Ville</label>
                        <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville">
                    </div>

                    <div class="form-group">
                        <label for="budget">Budget</label>
                        <input type="number" class="form-control" id="budget" name="budget" placeholder="Budget">
                    </div>

                    <div class="form-group">
                        <label for="superficie">Superficie</label>
                        <input type="number" class="form-control" id="superficie" name="superficie" placeholder="Superficie">
                    </div>

                    <div class="form-group">
                        <label for="categorie">Categorie</label>
                        <input type="text" class="form-control" id="categorie" name="categorie" placeholder="Categorie">
                    </div>

                    <div class="form-group">
                        <label for="myimg">Image</label>
                        <input type="file" class="form-control" id="myimg" name="myimg" placeholder="Image">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <input type="submit" class="btn btn-primary" value="Enregistrer" />
                </div>
            </form>
        </div>
    </div>
    </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">

        //*********************************************** */
        //Fonction déclenché lorsque l'utilisateur click sur modifier
        //Elle reécupére les données de la demande et les asignes aux input de la modal
        //*********************************************** */
        function getDemande(idDemande) {

            let request = $.ajax({
                'url' : 'ajax/getDemande_ajax.php',
                'type': 'POST',
                'data': {'idDemande': idDemande}
            });

            request.done(function(result) {
                let obj = jQuery.parseJSON(result);

                $("#demandeur option[value='" + obj.idPersonne + "']").prop('selected', true);
                $('#type').val(obj.genre);
                $('#ville').val(obj.ville);
                $('#budget').val(obj.budget);
                $('#superficie').val(obj.superficie);
                $('#categorie').val(obj.categorie);

            })

            request.fail(function() {
                console.log('PB');
            });


        };

        

        
    

        

        



    </script>

  </body>
</html>
