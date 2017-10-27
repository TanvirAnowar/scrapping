<?php
require_once 'src/Boot.php';

/**
 * @return bool
 */

$pageController = new \Scraping\PageController();

$pageController->Logout();
$showNotice = $pageController->Login();

?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
</head>
<body>

<div class="container h-100 d-flex justify-content-center">

    <div class="col-md-4">
        <div class="alert alert-danger" <?php echo empty($showNotice)?'style="display:none;"':'style="display:block;"'?>>
            <strong>Invalid password! </strong> Please provide valid password.
        </div>
    <form method="post" action="" class="form-signin">
        <h2 class="form-signin-heading">Please Login</h2>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <input type="submit" value="Sign In" class="btn btn-lg btn-primary btn-block" type="submit" />
    </form>
</div>
</div>


</body>
</html>
