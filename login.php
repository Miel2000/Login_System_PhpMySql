
<?php require 'inc/header.php' ; ?>



<h1>Inscription Reussie</h1>


<div class="alert alert-success" role="alert">
<?php require_once 'inc/db.php' ; ?>

 

    <?php
    $name = $_GET['username'];
    $req = $pdo->prepare('SELECT ? FROM `users`');
    $req->execute(array($name));
    //$pelo = $req->fetchAll();
    $pelo = $req->fetch(PDO::FETCH_ASSOC);

    echo 'Bonjour ' .$name. ', tu es bien inscrit sur notre registre<br>';


     ;?>
   
</div>





<?php require 'inc/footer.php' ; ?>
