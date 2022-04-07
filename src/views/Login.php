<?php 
$PageTitle = 'Connection';
require "../template/header.php";
require "../template/nav.php";
?>

<section class="container">
    <h1>Connection</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="container">
        <div class="form-group">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
                <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Mot de passe" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>">
                <label for="floatingPassword">Mot de passe</label>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</section>


<?php require_once('../template/footer.php'); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") exit();
$json = $db->isJson(file_get_contents('php://input'));
if (!empty($json)){
    $_POST['email'] = $json['email'];
    $_POST['password'] = $json['password'];
}

$email = $_POST['email'];
$pw = $_POST['password'];

try{
    $user->Login($email, $pw);  //login the user
    header("Location: Index");  //redirect to the main page
    exit();
}
catch(Error $e){
    // find a way to append get value to url without refresh
    echo $e->getMessage();
}
?>