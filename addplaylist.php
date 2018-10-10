<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spotitube</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <div class="jumbotron text-center" id="tekstjumbotron" style="background-color:lightgrey;">
        <h1>Spotitube</h1>
        <p>This is a website were you can find and play music!!</p>
    </div>
</header>
<div class="container">

    <div class="row">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image_link = $_POST['image_link'];
            $playlist_naam = $_POST['playlist_name'];
            $playlist_genre = $_POST['playlist_genre'];
            $color = $_POST['color'];


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

            $gebruiker_id = $_SESSION['gebruiker_id'];

            $sql = "INSERT INTO album(album_name, album_image, album_genre, color, gebruiker_id)
VALUES ('$playlist_naam', '$image_link', '$playlist_genre', '$color', '$gebruiker_id')";

            if ($conn->query($sql) === TRUE) {
                echo "Je playlist is aangemaakt <strong><a href='index.php'>Terug naar de start pagina</strong></a>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();

        }

        ?>
    </div>
</div>