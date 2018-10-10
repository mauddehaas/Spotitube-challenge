<?php
session_start();
$servername = "localhost";
$username = "newuser";
$password = "root";
$dbname = "spotitube";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$_SESSION['aangemaakt'] = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['regist']) == 1) {
    $naam = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];
    $email = $_POST['email'];

    $sql = "INSERT INTO inloggen(naam, wachtwoord, email, admin)
    VALUES ('$naam', '$wachtwoord', '$email', 0)";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['msggebruiker'] = "gebruiker is aangemaakt";
        $_SESSION['aangemaakt'] = 1;
    } else {
        $_SESSION['aangemaakt'] = 0;
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

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
    <div class="container">
        <?php
        if ($_SESSION['aangemaakt'] == 1) {
            echo "<p class='alert alert-success'>" . $_SESSION['msggebruiker'] . "</p>";
            echo "<a href='inloggen.php'>inloggen</a>";
        } else {
            ?>
            <form action="registreren.php?regist=1" method="POST">
                <p>
                    <label>Naam:</label>
                    <input class="form-control" type="text" id="naam" name="naam" value="">
                </p>
                <p>
                    <label>email:</label>
                    <input class="form-control" type="email" id="email" name="email" value="">
                </p>
                <p>
                    <label>wachtwoord:</label>
                    <input class="form-control" type="password" id="wachtwoord" name="wachtwoord" value="">
                </p>
                <input class="btn btn-default" type="submit" id="btn" name="knop" value="verstuur"><br>
            </form>
            <?php
        }
        ?>
    </div>
</div>
</div>


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>