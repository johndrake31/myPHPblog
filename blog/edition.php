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
    <div class="row">
      <h1 class="my-5">EDIT ARTICLE</h1>
      <?php
      foreach ($leResultatDeMaRequeteArticleUnique as $value) { ?>



        <img style="max-width: 20rem" src="./photos/posts/<?php echo $value["image"] ?>" alt="">
        <h6>Change avatar image:</h6>

        <form method="POST" enctype="multipart/form-data">
          <div class="input-group">
            <input type="file" name="fileToSend3" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
            <input name="inputTest3" value="<?php echo $value['id'] ?>" type="hidden" class="form-control" id="" aria-describedby="" aria-label="">
            <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Submit</button>
          </div>
        </form>

        <form action="" method="POST">
          <input type="hidden" name="idAModifier" value="<?php echo $value['id'] ?>">
          <input type="hidden" name="postId" value="<?php echo $value['id'] ?>">

          <input class="form-control mt-3" type="text" name="titreEdite" id="" value="<?php echo $value['title'] ?>" placeholder="votre titre">
          <textarea class="form-control mt-3" name="texteEdite" id="" cols="30" rows="10" placeholder="votre texte"><?php echo $value['content'] ?></textarea>
          <input class="form-control btn btn-success mt-2" style="width: 225px" type="submit" value="Enregistrer les modifications">
        </form>
      <?php } ?>


      <form action="" method="POST">
        <input type="hidden" name="idSuppression" value="<?php echo $value['id'] ?>">
        <input type="submit" style="width: 225px" class="btn btn-danger" value="Supprimer cet Article">
      </form>


    </div>
  </div>

</body>

</html>