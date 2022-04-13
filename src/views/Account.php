<?php 
$PageTitle = 'Votre compte';
require "../template/header.php";
require "../template/nav.php";

// if not logged redirect to register
if(!$user->IsLoggedIn()){
    header("Location: Register");  //redirect to the main page
    exit();
}

// get all genders
$genders = $user->GetAllGenders();
?>

<section class="container">
    <h1>Votre compte</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <h4>Vos informations</h4>
        <input type="text" placeholder="First name">
        <input type="text" placeholder="Last Name">
        <input type="email" placeholder="Email">
        <input type="email" placeholder="Confirmation Email">
        <input type="password" placeholder="Password">
        <input type="password" placeholder="Confirm Password">
        <select name="Gender">
            <?php foreach($genders as $k=>$v): ?>
                <option value="<?php echo $k ?>"><?php echo $v["GenderName"] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="date" placeholder="Brith date">
        <button type="submit">Envoyer</button>
    </form>
</section>

<?php require_once('../template/footer.php'); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") exit();

$FirstName  = $_POST['FirstName'];
$LastName   = $_POST['LastName'];
$Email      = $_POST['Email'];
$Password   = $_POST['Password'];
$ConfPwd    = $_POST['ConfirmPassword'];
$BirthDate  = $_POST['BirthDate'];
$Gender     = $_POST['Gender'];

if ($Password !== $ConfPwd) exit('password must match');

try {
    $user->Register($FirstName, $LastName, $Email, $Password, $BirthDate, $Gender);
} catch (Error $e) {
    if (__DEBUG__) echo $e;
}