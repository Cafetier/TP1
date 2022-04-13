<?php 
$PageTitle = 'Connection';
require "../template/header.php";
require "../template/nav.php";

// if logged redirect to index
if($user->IsLoggedIn()){
    header("Location: Index");  //redirect to the main page
    exit();
}
?>

<section class="container" id="connection_page">
    <h1>Connection</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="container">
        <div class="form-group">
            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="Email" value="<?php echo $_POST['email'] ?? '' ?>">
                <label for="floatingInput">Email</label>
            </div>
            <!-- Password -->
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Mot de passe">
                <label for="floatingPassword">Mot de passe</label>
            </div>
        </div>

        <!-- Submit btn -->
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

// async stuff
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