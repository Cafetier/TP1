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

<section class="container" id="account_page">
    <h1>Votre compte</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        
        <div class="form-group">
            <!-- First + last name -->
            <div class="row">
                <div class="col">
                    <!-- First name -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="FirstName" placeholder="First name" value="<?php echo $_POST['FirstName'] ?? '' ?>">
                        <label>First name</label>
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="LastName" placeholder="Last Name" value="<?php echo $_POST['LastName'] ?? '' ?>">
                        <label>Last Name</label>
                    </div>
                </div>
            </div>
            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="Email" placeholder="Email" value="<?php echo $_POST['Email'] ?? '' ?>">
                <label for="floatingInput">Email</label>
            </div>
            <!-- Password -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" placeholder="Mot de passe" name="Password">
                <label>Mot de passe</label>
            </div>
            <!-- Conf password -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" placeholder="Confirmation mot de passe" name="ConfirmPassword">
                <label>Confirmation mot de passe</label>
            </div>

            <!-- Birth date -->
            <div class="form-floating mb-3">
                <input type="date" class="form-control" placeholder="Birth date" name="BirthDate" value="<?php echo $_POST['BirthDate'] ?? date('Y-m-d') ?>">
                <label>Birth date</label>
            </div>
            <!-- Gender -->
            <div class="mb-3">
                <select class="form-select" name="Gender">
                    <option value="" selected hidden>Gender</option>
                    <?php foreach($genders as $k=>$v): ?>
                        <option value="<?php echo $k ?>"><?php echo $v["GenderName"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <!-- Submit btn -->
        <div class="row">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary col ">Update</button>
            </div>
        </div>
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
    $user->UpdateInformations($FirstName, $LastName, $Email, $Password, $BirthDate, $Gender);
} catch (Error $e) {
    if (__DEBUG__) echo $e;
}