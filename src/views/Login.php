<?php 
$PageTitle = 'Login';
require "../template/header.php";
?>

<h1>Login</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <input type="email" placeholder="Email" name="email">
    <input type="password" placeholder="Password" name="password">
    <button type="submit">Submit</button>
</form>

<?php require_once('../template/footer.php'); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") exit();
$email = $_POST['email'];
$pw = $_POST['password'];

try{
    $user->Login($email, $pw);  //login the user
}
catch(Error $e){
    echo($e->getMessage());
}