<?php 
$PageTitle = "S'enregister";
require "../template/header.php";
require "../template/nav.php";

// if logged redirect to index
if($user->IsLoggedIn()){
    header("Location: Index");  //redirect to the main page
    exit();
}

// get all genders
$genders = $user->GetAllGenders();
?>
<section class="container">
    <h1>S'enregister</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <input type="text" placeholder="First Name" name="FirstName" value="<?php echo $_POST['FirstName'] ?? ''; ?>">
        <input type="text" placeholder="Last Name" name="LastName" value="<?php echo $_POST['LastName'] ?? ''; ?>">
        <input type="email" placeholder="Email" name="Email" value="<?php echo $_POST['Email'] ?? ''; ?>">
        <input type="password" placeholder="Password" name="Password">
        <input type="password" placeholder="Confirm password" name="ConfirmPassword">
        <input type="date" placeholder="BirthDate" name="BirthDate" value="<?php echo $_POST['BirthDate'] ?? ''; ?>">
        <select name="Gender">
            <?php foreach($genders as $k=>$v): ?>
                <option value="<?php echo $k ?>"><?php echo $v["GenderName"] ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
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
    header("Location: Login");  //redirect to the login page
    exit();
} catch (Error $e) {
    echo $e;
}