<?php 
$PageTitle = 'Connection';
require "../template/header.php";
?>

<h1>Connection</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="container">
    <div class="form-group">
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Mot de passe">
            <label for="floatingPassword">Mot de passe</label>
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>


<?php require_once('../template/footer.php'); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") exit();
$email = $_POST['email'];
$pw = $_POST['password'];

try{
    $user->Login($email, $pw);  //login the user
    header("Location: Index");  //redirect to the main page
    exit();
}
catch(Error $e){
    header("Location: ?error=".$e->getMessage());  //show error in url
}