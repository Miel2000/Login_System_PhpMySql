
<?php require 'inc/header.php' ; ?>

<?php 



if(!empty($_POST)) {
   $errors = array();
   require_once 'inc/db.php';
   if(empty($_POST['username'])  || !preg_match('/^[a-zA-Z0-9_]+$/',$_POST['username'])){
       $errors['username'] = "Votre pseudo n'est pas valide";
   } else {
       $req = $pdo->prepare('SELECT id 
                             FROM users 
                             WHERE username = ?');
       $req->execute([$_POST['username']]);
       $user = $req->fetch();
       if($user) {
           $errors['username'] = "Ce pseudo est déjà pris";
       }
   }
   if(empty($_POST['email']) || !filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Votre Email n'est pas valide";  
   } else {
    $req = $pdo->prepare('SELECT id 
                          FROM users 
                          WHERE email = ?');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();

        if($user) {
            $errors['mail'] = "Cet Email est déjà pris";
        }   
   }
   if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm'] ){
       $errors['password'] = " Votre password est vide";
   }
   if(empty($errors)){

      $req = $pdo->prepare("INSERT INTO users
                            SET username = ?,
                            password = ?,
                            email = ?,
                            confirmation_token = ?");
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      $token = str_random(60);
      $req->execute([$_POST['username'],$password, $_POST['email'], $token]);
      $user_id = $pdo->lastInsertId();
   
      mail($_POST['email'], "Confirmation de votre compte", "Afin de valide votre compte, merci de cliquer sur ce lien :\n\n http://localhost/Registration_Membre/confirm.php?id=" . $user_id . "&token=" . $token );
   
      header('Location: login.php?username='.$_POST['username']);
      exit();
    }
}

?>

<h1>Inscription</h1>
<?php if(!empty($errors)): ?>

<div class="alert alert-danger">
    <p>Vous n'avez pas rempli le formulaire correctement</p>
    <ul>
    <?php foreach($errors as $error): ?>
        <li><?= $error;  ?>
    <?php endforeach ?>
    </ul>
</div>


<?php endif; ?>

<form action="" method="POST">

    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Email</label>
        <input type="text" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="">Confirmez votre mot de passe</label>
        <input type="password" name="password_confirm" class="form-control" required>
    </div>
<button type="submit" class="btn btn-primary">M'inscrire</button>

<a href="login.php?username=Dupont">Dis-moi bonjour !</a>
</form>



<?php require 'inc/footer.php' ; ?>