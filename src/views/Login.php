<?php 
$PageTitle = 'Login';
require "../template/header.php";
?>

<h1>Login</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <input type="text" placeholder="First Name">
    <input type="text" placeholder="Last Name">
    <input type="email" placeholder="Email">
    <input type="password" placeholder="Password">
    <div>
        Genre
        <label for="">
            Man
            <input type="radio" checked name="" id="">
        </label>
        <label for="">
            Woman
            <input type="radio" name="" id="">
        </label>
        <label for="">
            Other
            <input type="radio" name="" id="">
        </label>
    </div>

    <button type="submit">Submit</button>
    <button type="reset">Reset</button>
</form>

<?php require_once('../template/footer.php'); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") exit();
$name = $_POST['Username'];
$pw = $_POST['Password'];

$user->Login($name, $pw);  //login the user