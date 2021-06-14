<?php require "logique.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Créer un nouveau post</title>
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

  <div class="container">
    <h1 class="text-info mt-3">Créer un nouveau post</h1>
    <form action="logique.php" method="POST" enctype="multipart/form-data">
      <br>
      <input type="file" name="fileToSend2" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">

      <input name="inputTest2" value="valueTest2" type="hidden" class="form-control" id="" aria-describedby="" aria-label="">

      <br>

      <input class="form-control mt-5" type="text" name="nouveauTitre" id="" placeholder="votre titre">
      <textarea class="form-control mt-2" name="nouveauTexte" id="" cols="30" rows="10" placeholder="votre texte"></textarea>
      <input class="form-control btn btn-info mt-2" style="width: 225px" type="submit" value="Poster">



    </form>



  </div>


</body>

</html>