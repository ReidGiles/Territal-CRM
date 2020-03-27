<?php
	if(isset($_POST['email']) || isset($_POST['password'])){
        if(!$_POST['email'] || !$_POST['password'])
        {
            $error = "Please enter an email and password";
        }
        if (strlen($_POST['password']) < 9)
        {
            $error = "Password must be 9 characters or greater";
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $error = "Please enter a valid email";
        }
        if(!$error){
            //No errors - let’s create the account
            //Encrypt the password with a salt
            $encryptedPass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            //Insert DB
            $query = "INSERT INTO users (userEmail, userPassword) VALUES (:email, :password)";
            $result = $DBH->prepare($query);
            $result->bindParam(':email', $_POST['email']);
            $result->bindParam(':password', $encryptedPass);
            $result->execute();

            $to = $_POST['email'];
            $subject = "Welcome to Territal-CRM";

            $message = "
            <html>
            <head>
            <title>Welcome to Territal-CRM</title>
            </head>
            <body>
            <p>Welcome to Territal-CRM, thank you for registering.</p>
            </body>
            </html>";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <gilr1_17@student.worc.ac.uk>' . "\r\n";

            mail($to,$subject,$message,$headers);
        
            echo "<script> window.location.assign('index.php?p=registersuccess'); </script>";
        }       
    }
?>

<div class="card container mt-5">
    <div class="card-body">
        <h1 class="mb-3">Register</h1>
        <form action="index.php?p=register" method="post">

            <?php 
            if(isset($error))
            {
                if ($error)
                {
                    echo '<div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    '.$error.'
                    </div>'; 
                }
            } 
            ?>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password">
            </div>
            <button type="submit" class="btn btn-default">Register</button>
        </form>
    </div>
</div>