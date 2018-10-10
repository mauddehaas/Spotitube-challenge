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

// echo "<pre>";
// print_r($_SESSION['img']);
// exit;
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
<div class="container bg-1 text-center">

    <?php
    $albums = "SELECT * FROM album where gebruiker_id IS NULL";
    $query = $conn->query($albums);

    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    foreach ($result as $album) {

        $id = $album['album_id'];
        $image = $album['album_image'];
        $name = $album['album_name'];
        $genre = $album['album_genre'];

        echo "<a class='col-sm-4 img-responsive' style='color:black;' href='index.php?vid=$id'><strong><h3>$name</h3></strong><br><small>$genre</small><img src='$image' class='img-thumbnail' style='height:200px; width:500px;'></a>";
    }
    $conn->close();
    ?>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>