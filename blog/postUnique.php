<?php include "logique.php" ?>

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

  <?php if (isset($_GET['info']) && $_GET['info'] == 'edited') { ?>

    <div class="alert alert-dismissible alert-info">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <strong>Well done!</strong> You successfully edited <a href="#" class="alert-link">this article</a>.
    </div>
  <?php } ?>

  <?php if (isset($_GET['info']) && ($_GET['info'] == 'published' || $_GET['info'] == 'unpublished')) { ?>

    <div class="alert alert-dismissible alert-info">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <strong>Well done!</strong> You successfully <?php echo $_GET['info'] ?> <a href="#" class="alert-link">this article</a>.
    </div>
  <?php } ?>

  <div class="container mt-5">
    <div class="container">
      <?php
      foreach ($leResultatDeMaRequeteArticleUnique as $value) { ?>

        <div class="row text-center">
          <img class="rounded mx-auto d-block" style="max-width: 20rem" src="photos/posts/<?php echo $value['postimage']; ?>" alt="">
          <h2><?php echo $value["title"]; ?></h2>
        </div>

        <div class="text-center">
          <p><?php echo $value['content']; ?></p>
        </div>
        <div class="text-center">
          <h4>Author: <?php echo $value['displayName']; ?></h4>
        </div>

    </div>
  </div>
  <div class="row d-flex flex-column">
    <!-- conditional button -->


    <?php
        require_once dirname(__FILE__) . "/../authentification/login.php";
        if ($value['author_id'] === $_SESSION['userId']) { ?>

      <form action="edition.php" method="post">
        <button type="submit" style="width: 225px" name="postId" value="<?php echo $value['id'] ?>" class="btn btn-primary ms-5">Edit Article <?php echo $value['id'] ?></button>
      </form>
      <!-- publish unpublish -->
      <form action="edition.php" method="post">
        <input type="hidden" name="myPostID" value="<?php echo $value['id'] ?>">
        <button type="submit" style="width: 225px" name="isPublishPost" value="<?php echo ($value["published"] != 1) ? "1" : "0" ?>" class="btn btn-primary ms-5"><?php echo ($value["published"] != 1) ? "Publish" : "Unpublish" ?></button>
      </form>

    <?php } ?>
    <!-- go back button -->
    <form action="">
      <a href="/blog4" style="width: 225px" class="btn btn-danger ms-5">Retour a l'accueil</a>
    </form>
  </div>

<?php } ?>




<div class="container">
  <div class="row d-flex flex-wrap">
    <?php if ($isLoggedIn) { ?>

      <h3>Leave a comment:</h3>
      <div class="card m-1" style="width: 18rem;">
        <div class="card-body">

          <form method="post">
            <input class="form-control mt-3" type="hidden" name="commentAuthor" value="<?php echo $_SESSION['userId'] ?>">
            <input class="form-control mt-3" type="hidden" name="commentPostId" value="<?php echo $_GET['postId'] ?>">
            <input class="form-control mt-3" type="text" name="commentToPost" value="" placeholder="Your comment">
            <button class="btn btn-success my-2" type="submit">Submit Comment</button>
          </form>
        </div>
      </div>
    <?php } ?>

    <p></p>
    <?php
    foreach ($myArrayOfComments as $value) {
    ?>
      <div class="card m-1" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title"><?php echo $value['displayName']; ?></h5>
          <p class="card-text"><?php echo $value['comment']; ?></p>
          <h6><span class="badge bg-secondary"><?php echo $value['date_added']; ?></h6>
        </div>
      </div>
    <?php } ?>
  </div>
</div>


</body>

</html>