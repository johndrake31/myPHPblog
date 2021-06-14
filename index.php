<?php

require "blog/logique.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
              <form method="POST">
                <input type="submit" class="btn btn-info me-2" name="mesArticles" value="Mes Articles">
              </form>
            </li>

            <li class="nav-item">
              <a class="btn btn-info mx-2" href="blog/creation.php">Nouveau post</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-info" href="blog/userProfile.php?authProfile=<?php echo $_SESSION['userId'] ?>"> My Profile </a>
            </li>


          <?php } ?>

        </ul>
        <?php if (!$isLoggedIn && !$modeInscription) { ?>
          <form method="POST" class="d-flex align-items-center">

            <div class="form-group me-2">
              <label for="username">Username</label>
              <input type="text" class="form-control mr-2" name="username" required>
            </div>
            <div class="form-group me-2">
              <label for="password">password</label>

              <input type="password" class="form-control mr-2" name="password" required>
            </div>

            <div class="form-group mr-2">
              <input type="submit" value="Log in" class="btn btn-success mr-2">
            </div>
          </form>


          <hr>
        <?php } ?>



        <?php if ($isLoggedIn) { ?>
          <form method="POST" class="d-flex">
            <ul style="list-style: none" class="d-flex align-items-center text-white">
              <li>
                <h6 class="me-2">Welcome: <?php echo $_SESSION['displayName'] ?> </h6>
              </li>
              <li>
                <button type="submit" name="logOut" class="btn btn-secondary my-2 my-sm-0">Deconnexion</button>
              </li>
            </ul>
          </form>
        <?php } ?>


        <?php if (!$modeInscription && !$isLoggedIn) { ?>
          <form method="POST" class="d-flex">

            <button type="submit" name="modeInscription" value="on" class="btn btn-secondary  m-2 my-sm-0" type="submit">Inscription</button>
          </form>
        <?php } ?>
      </div>
    </div>
  </nav>

  <?php if (isset($_GET['info']) && $_GET['info'] == "registered") { ?>

    <div class="alert alert-success" role="alert">
      Successfully registered !
    </div>


  <?php } ?>
  <?php if (isset($_GET['info']) && $_GET['info'] == 'added') { ?>

    <div class="alert alert-dismissible alert-success">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <strong>Well done!</strong> You successfully created <a href="#" class="alert-link">a new article. Go to "MES ARTICLES" to publish</a>.
    </div>
  <?php } ?>
  <?php if (isset($_GET['info']) && $_GET['info'] == 'deleted') { ?>

    <div class="alert alert-dismissible alert-danger">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <strong>Well done!</strong> You successfully deleted <a href="#" class="alert-link">this article</a>.
    </div>
  <?php } ?>

  <div class="container">


    <div class="row mt-5">
      <?php if ($modeInscription) { ?>
        <form method="post">

          <div class="form-group">
            <label for="username">Username</label>

            <input type="text" class="form-control" name="usernameSignUp">
          </div>
          <div class="form-group">
            <label for="password">password</label>

            <input type="password" class="form-control" name="passwordSignUp">
          </div>
          <div class="form-group">
            <label for="passwordRetype">Re-type password</label>

            <input type="password" class="form-control" name="passwordRetypeSignUp">
          </div>

          <div class="form-group">
            <input type="hidden" name="modeInscription" value="on">
            <input type="submit" value="Sign up" class="btn btn-success">
          </div>

        </form>
        <form method="POST">
          <button class="btn btn-primary" name="modeInscription" value="off">Se connecter</button>
        </form>
        <hr>
      <?php } else { ?>


        <?php //debut de la boucle   
        foreach ($leResultatDeMaRequete as $post) {
        ?>

          <div class="col-4">
            <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
              <img style="max-width: 20rem" src="./blog/photos/posts/<?php echo $post["postimage"] ?>" alt="">
              <div class="card-header"><?php echo $post["title"]; ?></div>


              <?php if ($isLoggedIn && $post["author_id"] == $_SESSION['userId']) { ?>
                <p class="m-2"><span class="badge rounded-pill bg-secondary">Status: <?php echo ($post["published"] != 0) ? "published" : "unpublished" ?></span></p>
              <?php } ?>

              <div class="card-body">
                <h5 class="card-title"><a style=" color:white;" href="blog/userProfile.php?authProfile=<?php echo $post["author_id"] ?>"> Auteur : <?php echo ($post["displayName"] != "") ? $post["displayName"] : $post["userName"]  ?></a></h5>
                <p class="card-text"><em> <?php echo substr($post["content"], 0, 100); ?>...</em></p>
                <p class="card-text"><em>posted on: <?php echo substr($post["currentDate"], 0, 10); ?></em> </p>
              </div>

              <a href="blog/postUnique.php?postId=<?php echo $post['id'] ?>" class="btn btn-primary">Voir l'article</a>
            </div>
          </div>
        <?php //fin de la boucle
        } ?>


      <?php } ?>

    </div>




  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>

</html>