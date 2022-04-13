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
<section class="container" id="register_page">
    <h1>S'enregister</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <div class="form-group">
            <!-- First + last name -->
            <div class="row">
                <div class="col">
                    <!-- First name -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="FirstName" placeholder="john" value="<?php echo $_POST['FirstName'] ?? '' ?>">
                        <label>First name</label>
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="LastName" placeholder="Doe" value="<?php echo $_POST['LastName'] ?? '' ?>">
                        <label>Email</label>
                    </div>
                </div>
            </div>
            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="Email" placeholder="name@example.com" value="<?php echo $_POST['Email'] ?? '' ?>">
                <label for="floatingInput">Email</label>
            </div>
            <!-- Password -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" placeholder="********" name="Password">
                <label>Mot de passe</label>
            </div>
            <!-- Conf password -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" placeholder="********" name="ConfirmPassword">
                <label>Confirmation mot de passe</label>
            </div>
            <!-- Birth date -->
            <div class="form-floating mb-3">
                <input type="date" class="form-control" placeholder="BirthDate" name="BirthDate" value="<?php echo $_POST['BirthDate'] ?? date('Y-m-d') ?>">
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

            <!-- Submit +reset -->
            <div class="row">
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <button type="reset" class="btn btn-outline-secondary btn-sm">Reset</button>
                </div>
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
    $user->Register($FirstName, $LastName, $Email, $Password, $BirthDate, $Gender);
    header("Location: Login");  //redirect to the login page
    exit();
} catch (Error $e) {
    echo $e;
}