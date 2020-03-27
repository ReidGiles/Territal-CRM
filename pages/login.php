<?php
    if(isset($_POST['email']) || isset($_POST['password'])){
        if(!$_POST['email'] || !$_POST['password'])
        {
            $error = "Please enter an email and password";
        }

        if(!isset($error)){
            require_once('classes/users.classes.php');

            $usersObj = new users($DBH);
            $checkUser = $usersObj->checkUser($_POST['email'], $_POST['password']);

            if($checkUser){
                //User found
                $_SESSION['loggedin'] = true;
                $_SESSION['userData'] = $checkUser;

                echo "<script> window.location.assign('index.php?p=dashboard'); </script>";
            }
            else
            {
                $error = "Username/Password Incorrect";
            }
        }
    }
?>

<div class="card container mt-5">
    <div class="card-body">
        <h1 class="mb-3">Login to your account</h1>
        <form action="index.php?p=login" method="post">
            <?php
            if (isset($error))
            {
                if($error){
                    echo '<div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    '.$error.'
                    </div>';
                }
            } ?>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password">
            </div>
            <button type="submit" class="btn btn-default">Login</button>
        </form>
    </div>
</div>