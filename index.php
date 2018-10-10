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


if ((isset($_GET['vid']) == NULL) && (isset($_GET['playlist']) == FALSE)) {
    $_SESSION['bgcolor'] = "background-image: url(img/jumbotron.jpg)";
} else {
    if (isset($_GET['playlist'])) {
        $_SESSION ['album_id'] = $_GET['playlist'];
    } else {
        $_SESSION ['album_id'] = $_GET['vid'];
    }
    $albums = "SELECT color from album where album_id= " . $_SESSION ['album_id'] . "";
    $query = $conn->query($albums);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

    foreach ($result as $album) {
        $_SESSION['bgcolor'] = "background-color:" . $album['color'] . ";";
    }
}

// echo "<pre>";print_r('yo');exit;
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
    <div class="jumbotron text-center" id="tekstjumbotron" style="color:white; <?php echo $_SESSION['bgcolor'] ?>">
        <h1>Spotitube</h1>
        <h1 class="fa fa-music"></h1>
        <p>This is a website were you can find and play music!!</p>
    </div>
</header>
<div class="container">
    <div class="minheight">

        <div class="row">
            <?php

            if ((isset($_GET['vid']) == false) && (isset($_GET['playlist']) == FALSE) && (isset($_GET['add']) == FALSE) && (isset($_GET['addsong']) == FALSE) && (isset($_GET['inlog']) == FALSE)) {
                echo "<h3 style='margin-top: 2%; margin-bottom: 2%;'>Playlists</h3><br>";
                // $albums = "SELECT * from album where album_id is not null";
                //  echo "<pre>";print_r($_SESSION['hebingelogd']);exit; 
                if (isset($_SESSION['hebingelogd']) && !empty($_SESSION['hebingelogd'])) {
                    if ($_SESSION['hebingelogd'] == 1) {
                        $gebruiker_id = $_SESSION['gebruiker_id'];
                        $albums = "SELECT * FROM album AS A INNER JOIN inloggen AS S ON A.gebruiker_id = S.gebruiker_id where S.gebruiker_id = $gebruiker_id";
                        $query = $conn->query($albums);

                        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
                        foreach ($result as $album) {

                            $id = $album['album_id'];
                            $image = $album['album_image'];
                            $name = $album['album_name'];
                            $genre = $album['album_genre'];

                            echo "<a class='col-sm-4 img-responsive' style='color:black;' href='index.php?vid=$id'><strong><h3>$name</h3></strong><br><small>$genre</small><img src='$image' class='img-thumbnail' style='height:200px; width:500px;'></a>";


                        }
                    }
                } else {
                    echo "<h3 style='margin-top: 2%; margin-bottom: 2%;'>wil jij jou eigen playlist maken en afspelen?Maak een account aan! of log in</h3><br>";
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
                }
                ?>
                <a class='col-sm-4 img-responsive' style="color:black; text-align:center"
                   href='index.php?add=1'><strong>
                        <h3>Voeg een nieuwe lijst toe</h3></strong><br>
                    <small>klik hier</small>
                    <div style='height:200px; width:500px;' class="img-thumbnail">
                        <div id="plusimg" class='fa fa-plus'></div>
                    </div>
                </a>

                <?php
            } elseif (isset($_GET['vid']) == TRUE) {
                $iets = "SELECT * FROM playlist AS A INNER JOIN album AS S ON A.album_id = S.album_id where S.album_id = " . $_GET['vid'] . "";
                $query = $conn->query($iets);
                $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

                $title = true;
                foreach ($result as $album_nmmr) {
                    $song_id = $album_nmmr['song_id'];
                    $song_title = $album_nmmr['song_title'];
                    $album_title = $album_nmmr['album_name'];

                    if ($title) {
                        echo "<h2>Your $album_title songs</h2>";
                        $title = false;
                    }

                    echo "<table class='table'><thead><tr><th><a href='index.php?playlist=$song_id'>$song_title</a></th></tr></thead></table>";

                }

                $getvid = $_GET['vid'];
                echo "<table class='table'><thead><tr><th><a href='index.php?addsong=1&id=$getvid'>Add a song</a></th></tr></thead></table>";
            }

            if (isset($_GET['add']) == 1) {
                ?>
                <div class="container">
                    <form class="form-signin" action="addplaylist.php" method="POST">
                        <h1 class="h3 mb-3 font-weight-normal">Playlist toevoegen</h1>
                        <p>hoe krijg ik en wat is een google image?
                        <li>ga naar goolge en type google images</li>
                        <li>zoek een plaatje op die jij leuk vind</li>
                        <li>klik op je rechter muisknop en dan op copy image adress</li>
                        <li>plak het plaatje dan in het tekst vak</li>
                        <li>En klaar!</li>

                        <label class="">Google image link</label>
                        <input onchange="test()" type="text" name="image_link" id="image_link" class="form-control"
                               placeholder="https://www.example.com/wp-content/uploads/example.jpg" required autofocus>
                        <img style="display: none" id="image" onerror="errorCallback()" onload="loadCallback()"/><br>
                        <div style="display:none;" class="alert alert-danger" id="demo"></div>
                        <label class="">Name</label>
                        <input type="text" id="playlist_name" name="playlist_name" class="form-control"
                               placeholder="Name" required>
                        <label class="">Genre</label>
                        <input type="text" id="playlist_genre" name="playlist_genre" class="form-control"
                               placeholder="Genre" required>
                        <div class="checkbox mb-3">
                        </div>
                        <select class="form-control custom-select d-block w-100" id="color" name="color" required>
                            <option name="" id="" value="">Choose...</option>
                            <option type="text" name="orange" id="orange" style="background-color:orange;">orange
                            </option>
                            <option type="text" name="green" id="green" style="background-color:green;">green</option>
                            <option type="text" name="grey" id="grey" style="background-color:grey;">grey</option>
                            <option type="text" name="white" id="white" style="background-color:white;">white</option>
                            <option type="text" name="blue" id="blue" style="background-color:blue;">blue</option>
                            <option type="text" name="skyblue" id="skyblue" style="background-color:skyblue;">sky blue
                            </option>
                            <option type="text" name="purple" id="purple" style="background-color:purple;">purple
                            </option>
                            <option type="text" name="red" id="red" style="background-color:red;">red</option>
                            <option type="text" name="darkcyan" id="darkcyan" style="background-color:darkcyan;">
                                darkcyan
                            </option>
                            <option type="text" name="darkturqoise" id="darkturqoise"
                                    style="background-color:darkturqoise;">darkturqoise
                            </option>
                            <option type="text" name="pink" id="pink" style="background-color:pink;">pink</option>
                            <option type="text" name="yellow" id="yellow" style="background-color:yellow;">yellow
                            </option>
                        </select>
                        <button class="btn btn-lg btn-primary btn-block" id="btn" type="submit">Add</button>
                    </form>
                </div>
                <?php
            }

            if (isset($_GET['addsong']) == 1) {
                $ids = $_GET['id'];
                ?>
                <div class="container">
                    <?php
                    echo "<form class='form-signin' action='addsong.php?id=$ids' method='POST'>";


                    $iets = "SELECT album_name FROM album where album_id = " . $_GET['id'] . "";
                    $query = $conn->query($iets);
                    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

                    $title = true;
                    foreach ($result as $album_nmmr) {
                        $album_title = $album_nmmr['album_name'];

                        if ($title) {
                            echo "<h1 class='h3 mb-3 font-weight-normal'>Song toevoegen aan $album_title</h1>";
                            $title = false;
                        }
                    }
                    ?>
                    <label class="">Youtube embed link</label>
                    <input type="text" name="youtube_link" id="youtube_link" class="form-control"
                           placeholder="https://www.example.com/wp-content/uploads/example.jpg" required autofocus>
                    <label class="">Name</label>
                    <input type="text" id="song_title" name="song_title" class="form-control" placeholder="Name"
                           required>
                    <div class="checkbox mb-3">
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Add</button>
                    </form>
                </div>
                <?php
            }

            if (isset($_GET['playlist']) == TRUE) {
                $sql = "SELECT * from playlist where song_id=" . $_GET['playlist'] . "";
                //echo $sql;
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $song_id = $row['song_id'];
                        $song_title = $row['song_title'];
                        $youtube_link = $row['youtube_link'];
                        ?>
                        <iframe width="560" height="315" src="<?php echo $youtube_link ?>" frameborder="0"
                                allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        <?php
                    }
                } else {
                    echo "0 results";
                }
            }


            $conn->close();

            ?>

        </div><!--row-->
    </div>
</div><!--container-->

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    var test = function () {
        document.getElementById('image').src = document.getElementById('image_link').value;
    }

    var errorCallback = function () {
        document.getElementById("demo").style.display = "block";
        document.getElementById('btn').setAttribute("disabled", "disabled");
        document.getElementById("demo").innerHTML = "Dit plaatje bestaat niet...";
    }

    var loadCallback = function () {
        document.getElementById('btn').removeAttribute("disabled");
        document.getElementById("demo").style.display = "none";

    }
</script>
</body>
</html>