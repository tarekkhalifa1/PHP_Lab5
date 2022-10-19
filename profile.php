<!-- Start PHP code -->
<?php
require_once('auth/auth.php'); // auth users only can access this page
$user = $_SESSION['user'];
require_once('components/header.php')
?>
<!-- End PHP code -->

    <!-- User Content -->
    <section class="user">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-1">
                    <div class="col-12 text-center text-uppercase">
                        <h2 class="text-primary my-5">Welcome</h2>
                    </div>
                    <div class="col-12 text-center mb-4">
                    <img src="imgs/user.png" width="200" alt="">
                </div>
                </div>

                <main class="row">
                    <div class="col-lg-4 col-md-6 col-sm-8 mx-auto mb-4">
                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div>
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input disabled type="text" name="first_name" id="first_name" class="form-control " value="<?= $user->first_name ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input disabled type="text" name="last_name" id="last_name" class="form-control " value="<?= $user->last_name ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input disabled id="last_name" class="form-control " value="<?= $user->email ?>">
                            </div>

                            <div class="row">
                                    <div class="form-check mb-3">
                                        <?php
                                        if ($user->gender == "m") {
                                        ?>
                                            <label class="form-check-label">
                                                Gender: Male
                                            </label>
                                        <?php } else { ?>
                                            <label class="form-check-label">
                                            Gender: Female
                                            </label>
                                        <?php } ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <a class="btn btn-outline-primary me-3" href="index.php">Back</a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
    <!-- User Content -->

<?php 
    require_once('components/footer.php')
?>