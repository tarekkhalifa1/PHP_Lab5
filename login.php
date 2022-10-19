<!-- Start PHP code -->
<?php
require_once('auth/guest.php'); // guest users only can access this page

if (isset($_POST['login'])) {
    // print_r($_POST);die;
    $form_errors = [];
    // get form fields
    $email = $_POST['email'];
    $password = $_POST['password'];


    // First validation check on fields key and empty values:
    if (!isset($email) || empty($email)) {
        $form_errors['email_field'] = "<div> Email required </div>";
    } // email field

    if (!isset($password) || empty($password)) {
        $form_errors['password_field'] = "<div> Password required </div>";
    } // password field


    // Second validation check on inputs regex:
    if (empty($form_errors)) {
        $email_regex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";

        if (!preg_match($email_regex, $email)) {
            $form_errors['email_field'] = "<div>Invalid email</div>";
        } // email regex validate

    } // end of second validation

    // final check if user exists in database:
    if (empty($form_errors)) {
        // check if email already exists or not
        $user_exists = getUserInfo($email, $password);
        if (!$user_exists) {
            $form_errors['email_found'] = "<div>Wrong email or password</div>";
        } else {
            $_SESSION['user'] = $user_exists;
            $successMsg = "<div class='alert alert-success text-center'> Login Success</div>";
            header("refresh:1.5;url=index.php");
        }
    }
} // end of login 

function getUserInfo($email, $password)
{
    //connect db
    require_once("config.php");
    $sql = "SELECT * FROM users WHERE email = '$email'&& password = '$password' ";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        mysqli_close($conn);
        return $result->fetch_object();
    } else {
        mysqli_close($conn);
        return false;
    }
} // end function of check if user exists in database

?>

<?php require_once('components/header.php'); ?>
<!-- End PHP code -->

<!-- Register Content -->
<section class="registeration">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-1">
                <div class="col-12 text-center text-uppercase">
                    <h2 class="text-success my-5">Login</h2>
                </div>
            </div>

            <main class="row">
                <div id="registerErrors" class="col-lg-4 col-md-6 col-sm-8 mx-auto mb-4">
                    <div class="col-12">
                        <form id="registeration" method="POST" action="<?php $_PHP_SELF ?>">
                            <div class="row mb-3">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label> <span class="text-danger">*</span>
                                <input type="text" name="email" id="email" class="form-control
                                        <?php
                                        echo (isset($form_errors['email_field'])) ? "is-invalid" : "";
                                        ?>
                                        " value="<?php echo isset($email) ? $email : "" ?>">

                                <div class="invalid-feedback">
                                    <?php
                                    echo (isset($form_errors['email_field'])) ? $form_errors['email_field'] : "";
                                    ?>
                                </div>

                                <div class="text-danger">
                                    <?php
                                    echo (isset($form_errors['email_found'])) ? $form_errors['email_found'] : "";
                                    ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label> <span class="text-danger">*</span>
                                <input type="password" name="password" id="password" class="form-control
                                        <?php
                                        echo (isset($form_errors['password_field'])) ? "is-invalid" : "";
                                        ?>">

                                <div class="invalid-feedback">
                                    <?php
                                    echo (isset($form_errors['password_field'])) ? $form_errors['password_field'] : "";
                                    ?>
                                </div>
                            </div>

                                <div class="form-group mb-2">
                                    <button name="login" id="login" type="submit" class="btn btn-outline-success">Login</button>
                                </div>
                                <p>Don't have an account? <a class="text-decoration-none" href="register.php">Sign up now</a></p>

                        </form>
                    </div>
                    <?php
                    echo isset($successMsg) ? $successMsg : "";
                    echo isset($errorMsg) ? $errorMsg : "";
                    ?>
                </div>
            </main>
        </div>
    </div>
</section>
<!-- Register Content -->
<?php require_once('components/footer.php'); ?>