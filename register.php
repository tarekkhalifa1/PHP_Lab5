<!-- Start PHP code -->
<?php
require_once('auth/guest.php'); // guest users only can access this page

if (isset($_POST['register'])) {
    // print_r($_POST);die;
    $form_errors = [];
    // get form fields
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    }
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    // First validation check on fields key and empty values:
    if (!isset($first_name) || empty($first_name)) {
        $form_errors['first_name_field'] = "<div> First name required </div>";
    } // first name field

    if (!isset($last_name) || empty($last_name)) {
        $form_errors['last_name_field'] = "<div> Last name required </div>";
    } // last name field

    if (!isset($email) || empty($email)) {
        $form_errors['email_field'] = "<div> Email required </div>";
    } // email field

    if (!isset($password) || empty($password)) {
        $form_errors['password_field'] = "<div> Password required </div>";
    } // password field

    if (!isset($confirm_password) || empty($confirm_password)) {
        $form_errors['confirm_password_field'] = "<div> Confirm password required </div>";
    } // confirm password field


    if (!isset($_POST['gender']) || empty($_POST['gender'])) {
        $form_errors['gender_field'] = "<div>Gender required</div>";
    } // gender field


    // Second validation check on inputs regex:
    if (empty($form_errors)) {
        $name_regex = "/^([a-zA-Z ]){3,30}$/";
        $email_regex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
        $password_regex = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/";

        if (!preg_match($name_regex, $first_name)) {
            $form_errors['first_name_field'] = "<div>Invalid name</div>";
        } // first name regex validate

        if (!preg_match($name_regex, $last_name)) {
            $form_errors['last_name_field'] = "<div>Invalid name</div>";
        } // last name regex validate

        if (!preg_match($email_regex, $email)) {
            $form_errors['email_field'] = "<div>Invalid email</div>";
        } // email regex validate

        if (!preg_match($password_regex, $password)) {
            $form_errors['password_field'] = "<div>
            Password shouldn't be less than 8 characters and should contain small, capital letters, numbers and special character
            </div>";
        } // password regex validate

        if ($gender !== "m" && $gender !== "f") {
            $form_errors['gender_field'] = "<div>Invalid gender</div>";
        } // gender value validate

        
        // check if password and confirm password doesn't match
        if ($password !== $confirm_password) {
            $form_errors['password_field'] = "<div>Password and confirm password doesn't match</div>";
        }


    } // end of second validation

    // final insert user data into database:
    if (empty($form_errors)) {
        // check if email already exists or not
        $email_exists = checkEmailExists($email);
        if ($email_exists) {
            $form_errors['email_field'] = "<div>Sorry this email already exists</div>";
        }

        if (empty($form_errors)) {
            //connect db
            require("config.php");
            $sql = "INSERT INTO users VALUES ('', '$first_name', '$last_name', '$email', '$password', '$gender')";
            $result = mysqli_query($conn, $sql); // insert user into database
            if ($result) {
                $successMsg = "<div class='alert alert-success text-center'> Registration Success</div>";
                header("refresh:1.5;url=index.php");
            } else {
                $errorMsg = "<div class='alert alert-danger text-center'> Registration Failed</div>";
            }
            mysqli_close($conn);
        }
    }
} // end of register 

function checkEmailExists($email)
{

    //connect db
    require_once("config.php");
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        mysqli_close($conn);
        return true;
    } else {
        mysqli_close($conn);
        return false;
    }
} // end function of check if email already exists in database

require_once('components/header.php'); ?>
<!-- End PHP code -->


<!-- Register Content -->
<section class="registeration">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-1">
                <div class="col-12 text-center text-uppercase">
                    <h2 class="text-primary my-5">Register Now</h2>
                </div>
            </div>

            <main class="row">
                <div id="registerErrors" class="col-lg-4 col-md-6 col-sm-8 mx-auto mb-4">
                    <div class="col-12">
                        <form id="registeration" method="POST" action="<?php $_PHP_SELF ?>">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div>
                                        <label for="first_name" class="form-label">First Name</label> <span class="text-danger">*</span>
                                        <input type="text" name="first_name" id="first_name" class="form-control 
                                                <?php
                                                echo (isset($form_errors['first_name_field'])) ? "is-invalid" : "";
                                                ?>
                                            " value="<?php echo isset($first_name) ? $first_name : "" ?>">
                                        <div class="invalid-feedback">
                                            <?php
                                            echo (isset($form_errors['first_name_field'])) ? $form_errors['first_name_field'] : "";
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <label for="last_name" class="form-label">Last Name</label> <span class="text-danger">*</span>
                                        <input type="text" name="last_name" id="last_name" class="form-control
                                        <?php
                                        echo (isset($form_errors['last_name_field'])) ? "is-invalid" : "";
                                        ?>
                                        " value="<?php echo isset($last_name) ? $last_name : "" ?>">

                                        <div class="invalid-feedback">
                                            <?php
                                            echo (isset($form_errors['last_name_field'])) ? $form_errors['last_name_field'] : "";
                                            ?>
                                        </div>
                                    </div>
                                </div>

                            </div>


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
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label> <span class="text-danger">*</span>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control
                                        <?php
                                        echo (isset($form_errors['confirm_password_field'])) ? "is-invalid" : "";
                                        ?>">

                                <div class="invalid-feedback">
                                    <?php
                                    echo (isset($form_errors['confirm_password_field'])) ? $form_errors['confirm_password_field'] : "";
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 d-flex">
                                    <label for="gender" class="form-label">Gender:</label> <span class="text-danger">*</span>
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" type="radio" value="m" name="gender" id="male" <?php if (isset($gender) && $gender === "m") echo "checked" ?>>
                                        <label class="form-check-label" for="male">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="f" name="gender" id="female" <?php if (isset($gender) && $gender === "f") echo "checked" ?>>
                                        <label class="form-check-label" for="female">
                                            Female
                                        </label>
                                    </div>
                                    <div class="text-sm text-danger ms-5">
                                        <?php
                                        echo (isset($form_errors['gender_field'])) ? $form_errors['gender_field'] : "";
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <button name="register" id="register" type="submit" class="btn btn-outline-primary">Register</button>
                            </div>
                        </form>
                        <p>Already have an account? <a class="text-decoration-none" href="login.php"> Login here</a></p>
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