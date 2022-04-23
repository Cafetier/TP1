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


// check if there is a post call
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $FirstName  = $_POST['FirstName'] ?? '';
    $LastName   = $_POST['LastName'] ?? '';
    $Email      = $_POST['Email'] ?? '';
    $Password   = $_POST['Password'] ?? '';
    $ConfPwd    = $_POST['ConfirmPassword'] ?? '';
    $BirthDate  = $_POST['BirthDate'] ?? '';
    $Gender     = $_POST['Gender'] ?? '';
    
    if ($Password != $ConfPwd) $error = 'Password must match';
    
    try {
        $user->UpdateInformations($FirstName, $LastName, $Email, $Password, $BirthDate, $Gender);
        $success = 'Your informations was successfully updated';
    } catch (Error $e) {
        $error = $e->getMessage();
    }
}

// fetch data from bd
$user_info = $user->UserExist($_SESSION['Email']);

include_once "../template/alert.php";
?>

<section class="container small-container">
    <h1>Votre compte</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
        
        <div class="form-group">
            <!-- First + last name -->
            <div class="row">
                <div class="col">
                    <!-- First name -->
                    <div class="form-floating mb-3">
                        <input required type="text" class="form-control" name="FirstName" placeholder="First name" value="<?php echo $_POST['FirstName'] ?? $user_info['FirstName'] ?? '' ?>">
                        <label>First name</label>
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="form-floating mb-3">
                        <input required type="text" class="form-control" name="LastName" placeholder="Last Name" value="<?php echo $_POST['LastName'] ?? $user_info['LastName'] ?? '' ?>">
                        <label>Last Name</label>
                    </div>
                </div>
            </div>
            <!-- Email -->
            <div class="form-floating mb-3">
                <input required type="email" class="form-control" name="Email" placeholder="Email" value="<?php echo $_POST['Email'] ?? $user_info['Email'] ?? '' ?>">
                <label for="floatingInput">Email</label>
            </div>
            <!-- Password -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" placeholder="Nouveau mot de passe" name="Password">
                <label>Nouveau mot de passe</label>
            </div>
            <!-- Conf password -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" placeholder="Confirmation mot de passe" name="ConfirmPassword">
                <label>Confirmation mot de passe</label>
            </div>

            <!-- Birth date -->
            <div class="form-floating mb-3">
                <input required type="date" class="form-control" placeholder="Birth date" name="BirthDate" value="<?php echo $_POST['BirthDate'] ?? $user_info['BirthDate'] ?? '' ?>">
                <label>Birth date</label>
            </div>
            <!-- Gender -->
            <div class="mb-3">
                <select required class="form-select" name="Gender">
                    <option value="" hidden>Gender</option>
                    <?php foreach($genders as $k=>$v): ?>
                        <option value="<?php echo $v['GENDERID'] ?>" <?php if (isset($_POST['Gender']) && $_POST['Gender']==$k || $user_info['GENDERID'] == $k) echo "selected" ?>><?php echo $v["gName"] ?? '' ?></option>
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