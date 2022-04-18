<?php 
$PageTitle = "S'enregister";
require "../template/header.php";
require "../template/nav.php";

// if logged redirect to index
if($user->IsLoggedIn()){
    header("Location: Index");  //redirect to the main page
    exit();
}

// reset post array if there is a submit = reset call
$reset = $_POST['submit'] ?? 0;
if($reset === 'Reset') $_POST = [];


// get all genders
$genders = $user->GetAllGenders();


// check if there is a post call
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $FirstName  = $_POST['FirstName'] ?? '';
    $LastName   = $_POST['LastName'] ?? '';
    $Email      = $_POST['Email'] ?? '';
    $Password   = $_POST['Password'] ?? '';
    $ConfPwd    = $_POST['ConfirmPassword'] ?? '';
    $BirthDate  = $_POST['BirthDate'] ?? '';
    $Gender     = $_POST['Gender'] ?? '';
    
    if ($Password !== $ConfPwd) $error = 'Password must match';
    
    try {
        $user->Register($FirstName, $LastName, $Email, $Password, $BirthDate, $Gender);
        header("Location: Login");  //redirect to the login page
        exit();
    } catch (Error $e) {
        $error = $e->getMessage();
    }
}
?>

<?php if(isset($error)): ?>
    <!-- Error -->
    <div class="custom_float_alert alert alert-dismissible alert-primary">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Oh snap!</strong> <?php echo $error ?>
    </div>
<?php endif; ?>

<section class="container" id="register_page">
    <h1>S'enregister</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <div class="form-group">
            <!-- First + last name -->
            <div class="row">
                <div class="col">
                    <!-- First name -->
                    <div class="form-floating mb-3">
                        <input required type="text" class="form-control" name="FirstName" placeholder="First name" value="<?php echo $_POST['FirstName'] ?? '' ?>">
                        <label>First name</label>
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="form-floating mb-3">
                        <input required type="text" class="form-control" name="LastName" placeholder="Last Name" value="<?php echo $_POST['LastName'] ?? '' ?>">
                        <label>Last Name</label>
                    </div>
                </div>
            </div>
            <!-- Email -->
            <div class="form-floating mb-3">
                <input required type="email" class="form-control" name="Email" placeholder="Email" value="<?php echo $_POST['Email'] ?? '' ?>">
                <label for="floatingInput">Email</label>
            </div>
            <!-- Password -->
            <div class="form-floating mb-3">
                <input required type="password" class="form-control" placeholder="Mot de passe" name="Password">
                <label>Mot de passe</label>
            </div>
            <!-- Conf password -->
            <div class="form-floating mb-3">
                <input required type="password" class="form-control" placeholder="Confirmation mot de passe" name="ConfirmPassword">
                <label>Confirmation mot de passe</label>
            </div>
            <!-- Birth date -->
            <div class="form-floating mb-3">
                <input required type="date" class="form-control" placeholder="Birth date" name="BirthDate" value="<?php echo $_POST['BirthDate'] ?? date('Y-m-d') ?>">
                <label>Birth date</label>
            </div>
            <!-- Gender -->
            <div class="mb-3">
                <select required class="form-select" name="Gender">
                    <option value="" hidden>Gender</option>
                    <?php foreach($genders as $k=>$v): ?>
                        <option value="<?php echo $k ?>" <?php if (isset($_POST['Gender']) && $_POST['Gender']==$k) echo "selected" ?>><?php echo $v["GenderName"] ?></option>
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
                    <input class="btn btn-outline-secondary btn-sm" type="submit" name="submit" id="reset_register" value="Reset" />
                </div>
            </div>
        </div>
    </form>
</section>
<?php require_once('../template/footer.php'); ?>
