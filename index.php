<!-- Start PHP code -->
<?php
require_once('auth/auth.php'); // auth users only can access this page
require_once('components/header.php'); 
?>
<!-- End PHP code -->

<h1 class="text-center mt-5">Welcome <?= $_SESSION['user']->first_name?> to our site</h1>

<?php require_once('components/footer.php'); ?>