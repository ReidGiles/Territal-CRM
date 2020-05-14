<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" href='//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href='scss/style.css'>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="js/dashboardController.js"></script>

    <title>Territal-CRM</title>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Territal-CRM</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if(isset($_SESSION['loggedin'])) { if($_SESSION['loggedin']){ ?>
                <li class="nav-item active">
                    <a class="nav-link" href="index.php?p=dashboard">Dashboard<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=addProperty">New Property</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=addTenant">New Tenant</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=editprofile">Edit Profile</a>
                </li>
            <?php } }else{ ?>
                <li class="nav-item active">
                    <a class="nav-link" href="index.php?p=home">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=ourservices">Our Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=faqs">FAQs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=contactus">Contact Us</a>
                </li>
            <?php } ?>
        </ul>
        <ul class="navbar-nav navbar-right">
            <?php if(isset($_SESSION['loggedin'])) { if($_SESSION['loggedin']){ ?>
                <li class="nav-item"><a class="nav-link" href="index.php?p=logout">Logout</a></li>
            <?php } }else{ ?>
                <li class="nav-item"><a class="nav-link" href="index.php?p=login">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?p=register">Register</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>