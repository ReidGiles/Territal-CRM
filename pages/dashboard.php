<div class="card container mt-5">
    <div class="card-body">
        <h1 class="mb-3">Dashboard</h1>
        <?php 
        //Include users class
        require_once('classes/users.classes.php');
        $userObj = new users($DBH); //Lets pass through our DB connection
        $userProfile = $userObj->getUser($_SESSION['userData']['UserID']); //Call the getUser function
        // If the user has set their forename then greet them, else encourage them to update their profile.
        if ($userProfile['UserForename'])
        {
            echo "Welcome" . " " . $userProfile['UserForename'] . ".";
        }
        else
        {
            echo "Welcome. Your user details are incomplete, please use 'Edit Profile' to update them.";
        }
        ?>
    </div>
</div>