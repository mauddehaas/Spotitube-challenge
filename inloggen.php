<?php
session_start();

$servername = "localhost";
$user = "newuser";
$pass = "root";
$dbname = "spotitube";

//Create connection
$conn = new mysqli($servername, $user, $pass, $dbname);
//Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['login']) == 2 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];

    $sql = "SELECT * FROM inloggen where naam = '$naam' and wachtwoord= '$wachtwoord'";
    $query = $conn->query($sql);
    $results = mysqli_fetch_all($query, MYSQLI_ASSOC);

    if ($results != Null) {
        $_SESSION['nav_link'] = "<a href='inloggen.php?logout=1'>uitloggen</a>";
        $_SESSION['hebingelogd'] = 1;

        foreach ($results as $result) {
            $_SESSION['inlognaam'] = $result['naam'];
            $_SESSION['logged_in'] = 1;
            $_SESSION['gebruiker_id'] = $result['gebruiker_id'];
            $_SESSION['profile_img'] = $result['profile_img'];
            $_SESSION['email'] = $result['email'];
            // echo "<pre>";
            // print_r( $_SESSION['email']);
            // exit;


            $_SESSION['msg'] = "U bent ingelogd als: " . $_SESSION['inlognaam'] .
                "<br><a href='profile.php?profiel=1'>Ga naar je profiel &raquo;</a>";
        }

    } else {
        $_SESSION['msg'] = "Foutieve username/wachtwoord";
        $_SESSION['logged_in'] = 0;
        $_SESSION['nav_link'] = "<a href='inloggen.php?'>inloggen</a>";
    }


} else {
    $_SESSION['logged_in'] = 0;
    $_SESSION['msg'] = '';
    if (isset($_GET["logout"])) {
        if ($_GET["logout"] == 1) {
            $_SESSION['logged_in'] = 0;
            session_destroy();
            $_SESSION['nav_link'] = "<a href='inloggen.php?login=1'>inloggen</a>";


        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spotitube</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<header>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Spotitube</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="home.php">Home</a></li>
                    <li class="active"><a href="index.php">Playlists</a></li>
                    <li class="active"><a href="defaultplaylist.php">default playlists</a></li>
                    <li class="active"><a href="registreren.php">registreren</a></li>
                    <?php
                    if (isset($_SESSION['nav_link'])) {
                        echo " <li class='active float-right'>" . $_SESSION['nav_link'] . "</li>";
                        if ($_SESSION['nav_link'] == "<a href='inloggen.php?logout=1'>uitloggen</a>") {
                            echo "<li class='active float-right'><a href='profile.php?profiel=1'>Mijn profiel</a></li>";
                        }
                    } else {
                        echo "<li class='active'><a href='inloggen.php?login=1'>inloggen</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="jumbotron text-center" id="tekstjumbotron" style="color:white;">
        <h1>Spotitube</h1>
        <h1 class="fa fa-music"></h1>
        <p>This is a website were you can find and play music!!</p>
    </div>
</header>
<div class="minheight">

    <?php

    if ($_SESSION['logged_in'] == 0){


    ?>
    <div class="container">
        <form action="inloggen.php?login=2" method="POST">
            <h2>Inloggen:</h2>
            <?php
            echo "<p>" . $_SESSION['msg'];
            ?>
            <p>
                <label>Naam:</label>
                <input class="form-control" type="text" id="naam" name="naam" value="">
            </p>
            <p>
                <label>wachtwoord:</label>
                <input class="form-control" type="password" id="wachtwoord" name="wachtwoord" value="">
            </p>
            <input class="btn btn-default" type="submit" id="btn" name="knop" value="verstuur"><br>
        </form>
        <small><a href="registreren.php">Nog geen account? registreer hier</a></small>
    </div>
</div>
</div>
<?php
} else if ($_SESSION['logged_in'] == 1) {
    ?>
    <div class="container">
        <div class="row">
            <?php
            echo "<div class='alert alert-success'> " . $_SESSION['msg'] . "</div>";
            ?>
        </div>
    </div>
    </div>
    <?php
}

$conn->close();
?>


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>