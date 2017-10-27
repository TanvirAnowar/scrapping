<?php
require_once 'src/Boot.php';

/**
 * @param $data
 */


$pageController = new \Scraping\PageController();

$data = $pageController->Dashboard();

$data['CSRF_TOKEN'] = \Scraping\Helper::csrfTokeGenerator();


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
        <div class="alert alert-danger" <?php echo ($data['status'] == 201) ? 'style="display:block;"' : 'style="display:none;"' ?>>
            <strong>Invalid Information! </strong> Please provide valid information.
        </div>
        <div class="alert alert-success" <?php echo $data['status'] == 202 ? 'style="display:block;"' : 'style="display:none;"' ?>>
            <strong>Saved! </strong> Information saved successfully.
        </div>

        <form method="post" action="" class="form-signin">
            <h2 class="form-signin-heading">Basic Information</h2>
            <input type="text" name="url" id="inputPassword" value="<?php echo $data['data']['url'] ?>"
                   class="form-control" placeholder="URL" required>
            <input type="text" name="emails" id="inputPassword" value="<?php echo $data['data']['emails'] ?>"
                   class="form-control" placeholder="Emails" required>
            <div class="checkbox">
                <label><input type="checkbox" name="process" value="" <?php echo $data['data']['process'] ?>> Run
                    Process</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" name="mail-status" value="" <?php echo $data['data']['mail-status'] ?>>
                    Mail Only When The Item Is Available</label>
            </div>
            <input type="password" name="password" id="inputPassword" value="<?php echo $data['data']['password'] ?>"
                   class="form-control" placeholder="Password"
                   required>

            <input type="hidden" name="CSRF_TOKEN" value="<?php echo $data['CSRF_TOKEN'] ?>">

            <input type="submit" value="Save" class="btn btn-lg btn-primary btn-block" type="submit"/>
            <a href="login.php" class="btn btn-lg btn-danger btn-block">Logout</a>
        </form>
    </div>
</div>


</body>
</html>
