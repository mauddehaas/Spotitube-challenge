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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image_link = $_POST['image_link'];
    $gebruiker_id = $_SESSION['gebruiker_id'];

    $sql = "UPDATE inloggen SET profile_img = '$image_link' WHERE gebruiker_id='$gebruiker_id'";
    $query = $conn->query($sql);

    if ($conn->query($sql) === TRUE) {
        $_SESSION['hasimg'] = 1;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
//     echo "<pre>";
// print_r($_SESSION['img']);
// exit;
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
<div class="container bg-1 text-center">
    <?php

    if (isset($_GET['foto']) == 1){
        ?>
        <form method="POST" action="profile.php?addimg=1">

            <label class="">Google image link</label>
            <input onchange="test()" type="text" name="image_link" id="image_link" class="form-control"
                   placeholder="https://www.example.com/wp-content/uploads/example.jpg" required autofocus>
            <img style="display: none" id="image" onerror="errorCallback()" onload="loadCallback()"/><br>
            <div style="display:none;" class="alert alert-danger" id="demo"></div>
            <input class="form-control" type="submit" name="btn" value="Upload" id="btn">
        </form>
        <?php
    }else{
    $gebruiker_id = $_SESSION['gebruiker_id'];
    $sql = "SELECT profile_img FROM inloggen WHERE gebruiker_id='$gebruiker_id'";
    $query = $conn->query($sql);
    $results = mysqli_fetch_all($query, MYSQLI_ASSOC);

    if ($results != Null) {
        foreach ($results as $result) {
            $_SESSION['img'] = $result['profile_img'];

        }

    } else {
        $_SESSION['img'] = "img/plus.png";
    }
    ?>
    <h3 class="margin"><?php echo "Hallo " . $_SESSION['inlognaam'] . " welkom bij je profiel!" ?></h3>

    <a href="profile.php?foto=1"><img src="<?php echo $_SESSION['img'] ?>" class="img-responsive img-circle margin"
                                      style="display:inline" alt="voeg een foto toe!!" width="350" height="350"></a>
    <p>Email adress: <?php echo $_SESSION['email']; ?> </p>
</div>

<?php

}
?>
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
<?php
$conn->close();
?>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>