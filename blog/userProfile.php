<?php
require "logique.php";
// require_once dirname(__FILE__) . "/../authentification/login.php";
// if (isset($_SESSION['userId'])) {
//     $userId = $_SESSION['userId'];
//     $userName = $_SESSION['userName'];
//     $displayName = $_SESSION['displayName'];
//     $userEmail = $_SESSION['userEmail'];
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/journal/bootstrap.css">
</head>


<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/blog4">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-tarPOST="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/blog4">Home
                            <span class="visually-hidden">(current)</span>
                        </a>
                    </li>
                    <?php if ($isLoggedIn) { ?>

                        <li class="nav-item">
                            <a class="btn btn-info me-2" href="creation.php">Nouveau post</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-info me-2" href="userProfile.php?authProfile=<?php echo $_SESSION['userId'] ?>"> My Profile </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php if ($isLoggedIn) { ?>



                <form method="POST" class="d-flex">

                    <button type="submit" name="logOut" class="btn btn-secondary my-2 my-sm-0">Deconnexion</button>
                </form>
            <?php } ?>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- update alert -->
    <?php if (isset($_GET['info']) && $_GET['info'] == 'profileEdited') { ?>
        <div class="alert alert-dismissible alert-info">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Well done!</strong> You successfully edited <a href="#" class="alert-link">your profile</a>.
        </div>
    <?php } ?>

    <div class="container">
        <div class="row">
            <br>
            <h1> Author Profile Page:</h1>
            <?php foreach ($leResultatDeAuthProfile as $value) {

            ?>
                <?php if ($_SESSION['userId'] == $value['id']) { ?>
                    <br>
                    <h2>Welcome to your profile page: <?php echo $value['userName'] ?></h2>
                    <img style="width: 80px; height: 80px" src="./photos/users/<?php echo $value['image'] ?>" alt="">

                    <br>
                    <br>
                    <h6>Change avatar image:</h6>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="input-group">
                            <input type="file" name="fileToSend" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">

                            <input name="inputTest" value="valueTest" type="hidden" class="form-control" id="" aria-describedby="" aria-label="">

                            <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Submit</button>
                        </div>

                    </form>
                    <form action="logique.php" method="POST">
                        <fieldset disabled="">
                            <label class="form-label" for="disabledInput">User Name</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?php echo $value['userName'] ?>" disabled="">
                        </fieldset>

                        <div class="mb-3">
                            <label for="displayName" class="form-label">Display Name</label>
                            <input name="displayName" type="text" value="<?php echo $value['displayName'] ?>" class="form-control" id="displayName" aria-describedby="userDisplayName">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input name="userEmail" type="email" value="<?php echo $value['userEmail'] ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <!-- displayName, userEmail  -->
                    </form>


                <?php } else { ?>
                    <br>
                    <br>
                    <hr>
                    <img style="width: 80px; height: 80px" src="./photos/users/<?php echo $value['image'] ?>" alt="">
                    <h2>Author Handle:
                        <?php
                        if ($value['displayName'] != "") {
                            echo $value['displayName'];
                        } else {
                            echo $value['userName'];
                        } ?></h4>
                        <br>
                        <h3>Email: <?php echo $value['userEmail'] ?></h3>
                    <?php } ?>
                <?php } ?>
        </div>
    </div>
</body>

</html>